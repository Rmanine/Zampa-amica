<?php

class Template
{

    public function getHeader($pagina)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $home = '';
        $animali = '';
        $volontariato = '';
        $chisiamo = '';
        $accediProfilo = '';

        $header = file_get_contents('header.html');

        if (!isset($_SESSION["logged_in_user"])) {
            $accediProfilo = '<a class="stile-bottone-1" href="./accedi.php">Accedi</a>';
        } else {
            $accediProfilo = '<a class="stile-bottone-1" href="./profilo_utente.php">Profilo</a>';
        }

        switch ($pagina) {
            case 'index':
                $home = "Home";
                $animali = '<a href="./i_nostri_animali.php">I nostri animali</a>';
                $volontariato = '<a href="./volontariato.php">Volontariato</a>';
                $chisiamo = '<a href="./chi_siamo.php">Chi siamo</a>';
                break;
            case 'i_nostri_animali':
                $home = '<a href="./index.php">Home</a>';
                $animali = 'I nostri animali';
                $volontariato = '<a href="./volontariato.php">Volontariato</a>';
                $chisiamo = '<a href="./chi_siamo.php">Chi siamo</a>';
                break;
            case 'volontariato':
                $home = '<a href="./index.php">Home</a>';
                $animali = '<a href="./i_nostri_animali.php">I nostri animali</a>';
                $volontariato = 'Volontariato';
                $chisiamo = '<a href="./chi_siamo.php">Chi siamo</a>';
                break;
            case 'chi_siamo':
                $home = '<a href="./index.php">Home</a>';
                $animali = '<a href="./i_nostri_animali.php">I nostri animali</a>';
                $volontariato = '<a href="./volontariato.php">Volontariato</a>';
                $chisiamo = 'Chi siamo';
                break;
            case 'profilo_utente':
                $home = '<a href="./index.php">Home</a>';
                $animali = '<a href="./i_nostri_animali.php">I nostri animali</a>';
                $volontariato = '<a href="./volontariato.php">Volontariato</a>';
                $chisiamo = '<a href="./chi_siamo.php">Chi siamo</a>';
                $accediProfilo = 'Profilo';
            default:
                $home = '<a href="./index.php">Home</a>';
                $animali = '<a href="./i_nostri_animali.php">I nostri animali</a>';
                $volontariato = '<a href="./volontariato.php">Volontariato</a>';
                $chisiamo = '<a href="./chi_siamo.php">Chi siamo</a>';
                break;
        }

        $header = str_replace("[Home]", $home, $header);
        $header = str_replace("[I nostri animali]", $animali, $header);
        $header = str_replace("[Volontariato]", $volontariato, $header);
        $header = str_replace("[Chi siamo]", $chisiamo, $header);
        $header = str_replace("[AccediProfilo]", $accediProfilo, $header);

        return $header;
    }

    public function getFooter()
    {
        return file_get_contents('footer.html');
    }

}

?>