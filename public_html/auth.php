<?php

require_once ".." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'accedi.html');

$messaggiPerForm = '';
$erroreLogin = '';

class Auth{

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate( string $username, string $password) {
        $user = $this->db->getUser($username);
        if ($user === false) {
            return false;
        }

        $verify = password_verify($password, $user['Password']);
        if( $verify == true) {
            return $user['ID'];
        }
        
        return false;
    }

    public function log_user_in( int $user_ID) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["logged_in_user"] = $user_ID;
    }

    public function logged_in_user() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["logged_in_user"])) {
            return false;
        }

        return intval($_SESSION["logged_in_user"]);
    }
}

function pulisciInput($value){
 	$value = trim($value);
  	$value = strip_tags($value);
  	return $value;
}

if (isset($_POST['submit'])) {

    $username = pulisciInput($_POST['username']);
    if (strlen($username) == 0) {
		$messaggiPerForm .= "<li>Inserire username</li>";
	} else {
        if (!preg_match('/^\S+$/', $username)) {
            $messaggiPerForm .= "<li>Lo username non deve contenere spazi</li>";
        }
	}

    $password = pulisciInput($_POST['password']);
    if (strlen($password) == 0) {
        $messaggiPerForm .= "<li>Inserire password</li>";
    } else {
        if (!preg_match('/^\S+$/', $password)) { //da rivedere
        $messaggiPerForm .= "<li>La password non deve contenere spazi</li>";
        }
    }

    if ($messaggiPerForm == "") {
		$connessione = new DBAccess();
		$connessioneOK = $connessione->openDBConnection();


		if ($connessioneOK) {
			$auth = new Auth($connessione);
            $userID = $auth->authenticate($username, $password);
            if ($userID) {
                $auth->log_user_in($userID);
            }
            else {
                $erroreLogin = '<p class="req">Username o password non corretti.</p>';
            }
		}
		else {
            $erroreLogin = '<p class="req">I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
		}
	} else {
		$messaggiPerForm = "<div id=\"errorMessage\"><ul>" . $messaggiPerForm . "</ul></div>";
	}

}

$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[erroreLogin]', $erroreLogin, $paginaHTML);

echo $paginaHTML;

?>