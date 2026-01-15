<?php
require_once "DBAccess.php";
require_once "Login.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('../pages/registrati.html');

// variabili
$messaggiPerForm = "";
$username = '';
$email = '';

// PRE: Stringa "sporca"
// POST: Stringa sanificata e sicura per la stampa
function pulisciInput($value)
{
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value);
    return $value;
}


if(isset($_POST['submit']))
{
    // Validazione Username
    $username = pulisciInput($_POST['username']);
    if (!preg_match("/^[a-zA-Z]{4,50}$/", $username)) {
        $messaggiPerForm .= "<li>Lo username deve contenere solo lettere, min 4 e max 50 caratteri.</li>";
    }

    // Validazione Email
    $email = pulisciInput($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $messaggiPerForm .= "<li>Formato email non valido.</li>";
    }

    // Validazione Password
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmed-password'];
    
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!*+%]).{8,}$/", $password))
    {
        $messaggiPerForm .= "<li>La password non rispetta i requisiti di sicurezza.</li>";
    }

    if ($password !== $confirmPassword)
    {
        $messaggiPerForm .= "<li>Le due password non coincidono.</li>";
    }

    // raccolta errori
    if (!empty($messaggiPerForm))
    {
        $messaggiPerForm = "<ul>" . $messaggiPerForm . "</ul>";
    }

    // Inserimento nel database
    if (empty($messaggiPerForm))
    {
        $db = new DBAccess();
        if($db->openDBConnection())
        {
            $loginService = new Login($db);
            $esito = $loginService->add_user($username, $email, $password);
            $db->closeConnection();

            if($esito)
            {
                $messaggiPerForm = '<p class="success">Registrazione completata! <a href="accedi.html">Accedi ora</a></p>';
                $username="";
                $email="";
            }
            else
            {
                $messaggiPerForm = '<p class="error">Username già esistente.</p>';
            }
        }
        else
        {
            $messaggiPerForm = '<p class="error">Errore connessione DB.</p>';
        }
        
    }
}

// Sostituzione placeholders
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valUsername]', $username, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email, $paginaHTML);

echo $paginaHTML;
?>