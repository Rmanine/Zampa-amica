<?php

class Login {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
    PRE: username, email e password già sanificati
    POST: true se l’utente viene inserito, false se username già esistente
     */
    public function add_user(string $username, string $email, string $password): bool {
        if ($this->db->usernameExists($username)) {
            return false;
        }

        $hashedPassword = hash('sha256', $password);
        return $this->db->addUser($username, $email, $hashedPassword);
    }

    /*
    PRE: l'utente non è autenticato nel sistema
    POST: l'utente è autenticato nel sistema
    */
    public function authenticate(string $username, string $password) {
        $user = $this->db->getUser($username);
        if ($user === false) {
            return false;
        }

        $hashedPassword = hash('sha256', $password);

        return ($hashedPassword === $user['Password']) ? $user['ID'] : false;
    }

    /*
    PRE: l'utente con ID $user_ID non è loggato al sistema
    POST: l'utente con ID $user_ID è loggato al sistema
    */
    public function log_user_in($user_ID) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["logged_in_user"] = intval($user_ID);
    }

    /*
    PRE:
    POST: Restituisce l'ID dell'utente autenticato se presente
         false se nessun utente risulta autenticato
    */
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

?>