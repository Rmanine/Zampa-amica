<?php
namespace DB;

use mysqli;

class DBAccess {

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "my_techwebzampaamica";
	private const USERNAME = "techwebzampaamica";
	private const PASSWORD = "";

	private $connection;

	public function openDBConnection() {
		
		mysqli_report(MYSQLI_REPORT_ERROR);
		
		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
		
		if (mysqli_connect_errno()) {
			return false;
		} else {
			return true;
		}
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}

	public function getList($filtri) {
		$conditions = [];
		$query = "SELECT * FROM Animale";

		if ($filtri['tipo'] !== 'all') {
			if ($filtri['tipo'] === 'cane') {
				$conditions[] = "Specie = 'Cane'";
			} elseif ($filtri['tipo'] === 'gatto') {
				$conditions[] = "Specie = 'Gatto'";
			}
		}
		if ($filtri['sesso'] !== 'all') {
			if ($filtri['sesso'] === 'maschio') {
				$conditions[] = "Genere = 'Maschio'";
			} elseif ($filtri['sesso'] === 'femmina') {
				$conditions[] = "Genere = 'Femmina'";
			}
		}
		if ($filtri['taglia'] !== 'all') {
			switch($filtri['taglia']) {
				case 'piccola':
					$conditions[] = "Taglia = 'Piccolo'";
					break;
				case 'media':
					$conditions[] = "Taglia = 'Medio'";
					break;
				case 'grande':
					$conditions[] = "Taglia = 'Grande'";
					break;
			}
		}

		if ($filtri['eta'] !== 'all') {
			switch ($filtri['eta']) {
				case '0-12':
					$conditions[] = "EtaMesi BETWEEN 0 AND 12";
					break;
				case '1-3':
					$conditions[] = "EtaMesi BETWEEN 13 AND 36";
					break;
				case '4-8':
					$conditions[] = "EtaMesi BETWEEN 37 AND 96";
					break;
				case '8+':
					$conditions[] = "EtaMesi > 96";
					break;
			}
		}
		if (!empty($conditions)) {
			$query .= " WHERE " . implode(" AND ", $conditions);
		}

		$query .= " ORDER BY ID ASC";

		$queryResult = mysqli_query($this->connection, $query) or die("Errorre in dbConnection: " . mysqli_error($this->connection));
		
		if(mysqli_num_rows($queryResult) != 0) {
			$result = array();
			while ($row = mysqli_fetch_assoc($queryResult)) { 
				array_push($result, $row);
			}
			$queryResult->free();
			return $result;
		} else {
			return false;
		}
	}

	public function getAnimale($id) {
		$query = "SELECT * FROM Animale WHERE ID = '$id'";

		$queryResult = mysqli_query($this->connection, $query) or die("Errore in dbConnection: " . mysqli_error($this->connection));

		if (mysqli_num_rows($queryResult) != 0) {
			$row = mysqli_fetch_assoc($queryResult);
			$queryResult->free();
			return $row;
		} else {
			return false;
		}
	}
	/*
	PRE: accetta un nome utente
	POST: ritorna un array con le info dell'utente t.c. $row['Username'] == $username
			false se non ha trovato l'utente con Username == $username
	*/
	public function getUser($username) {
		$query = "SELECT ID, Password FROM Utente WHERE Username = ?";

		$stmt = mysqli_prepare($this->connection, $query);
		if ($stmt === false) {
			return false;
		}

		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if ($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			mysqli_stmt_close($stmt);
			return $row;
		}
		mysqli_stmt_close($stmt);
		return false;
	}
	
	/* 
	PRE: accetta una stringa 
	POST: true se esiste un utente con Username == $username 
			false se non esiste
	*/
	public function usernameExists($username) {
		$query = "SELECT 1 FROM Utente WHERE Username = ? LIMIT 1";

		$stmt = mysqli_prepare($this->connection, $query);
		if ($stmt === false) {
			return false;
		}

		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);

		if (mysqli_stmt_num_rows($stmt) > 0) {
			return true;
		} else {
			return false;
		}
		mysqli_stmt_close($stmt);
	}
	
	public function addUser($username, $email, $hashedPassword) {
		$queryInsert = "INSERT INTO Utente(Username, Email, Password) VALUES(?, ?, ?)";

		$stmt = mysqli_prepare($this->connection, $queryInsert);

		if($stmt === false)
		{
			return false;
		}

		mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

		$result = mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);

		return $result;
	}

	// Aggiunge un volontario
	public function addVolontario($email, $nome, $cognome, $telefono) {
		$query = "INSERT INTO Richiesta_volontariato (Email, Nome, Cognome, Telefono) VALUES (?, ?, ?, ?)";

		$stmt = mysqli_prepare($this->connection, $query);

		if (!$stmt) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "ssss", $email, $nome, $cognome, $telefono)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$affected_rows = mysqli_stmt_affected_rows($stmt);

		mysqli_stmt_close($stmt);

		return ($affected_rows > 0);
	}

	// Ritorna la lista delle prenotazioni, dato un id utente
	public function getListaPrenotazioni($id_user)
	{
		$query = "SELECT * FROM Prenotazione WHERE UtenteID = ?";

		$stmt = mysqli_prepare($this->connection, $query);
		if ($stmt === false) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "i", $id_user)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$result = mysqli_stmt_get_result($stmt);
		if ($result === false) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$prenotazioni = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$prenotazioni[] = $row;
		}

		mysqli_free_result($result);
		mysqli_stmt_close($stmt);

		return $prenotazioni;
	}

	// Ritorna le informazioni della prenotazione con id = $id
	public function getPrenotazione($id)
	{
		$query = "SELECT p.ID, p.UtenteID, p.AnimaleID, p.DataOra, p.Note, a.Nome, a.Immagine 
              		FROM Prenotazione p 
              		JOIN Animale a ON p.AnimaleID = a.ID 
              		WHERE p.ID = ?";
		$stmt = mysqli_prepare($this->connection, $query);

		if ($stmt === false) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "i", $id)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}
		mysqli_stmt_bind_result($stmt, $id, $userID, $animaleID, $dataora, $note, $nomeAnimale, $immagineAnimale);

		$prenotazione = null;

		// Recupero la riga (una sola in questo caso)
		if (mysqli_stmt_fetch($stmt)) {
			$prenotazione = array(
				"ID" => $id,
				"UtenteID" => $userID,
				"AnimaleID" => $animaleID,
				"DataOra" => $dataora,
				"Note" => $note,
				"NomeAnimale" => $nomeAnimale,
				"ImmagineAnimale" => $immagineAnimale
			);
		}

		mysqli_stmt_close($stmt);

		return $prenotazione;
	}


	// Aggiunge una prenotazione
	public function addPrenotazione($id_user, $id_animale, $dataora, $note)
	{
		$query = "INSERT INTO Prenotazione (UtenteID, AnimaleID, DataOra, Note) VALUES (?, ?, ?, ?)";
		$stmt = mysqli_prepare($this->connection, $query);

		if (!$stmt) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "iiss", $id_user, $id_animale, $dataora, $note)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$affected_rows = mysqli_stmt_affected_rows($stmt);

		mysqli_stmt_close($stmt);

		return ($affected_rows > 0);
	}


	// Modifica una prenotazione già esistente
	public function updatePrenotazione($id, $dataora, $note)
	{
		$query = "UPDATE Prenotazione 
              SET DataOra = ?, Note = ? 
              WHERE ID = ?";

		$stmt = mysqli_prepare($this->connection, $query);
		if (!$stmt) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "ssi", $dataora, $note, $id)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$affected_rows = mysqli_stmt_affected_rows($stmt);
		mysqli_stmt_close($stmt);

		return ($affected_rows > 0);
	}

	// Elimina una prenotazione dato l'id
	public function deletePrenotazione($id)
	{
		$query = "DELETE FROM Prenotazione WHERE ID = ?";

		$stmt = mysqli_prepare($this->connection, $query);
		if (!$stmt) {
			return false;
		}

		if (!mysqli_stmt_bind_param($stmt, "i", $id)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		if (!mysqli_stmt_execute($stmt)) {
			mysqli_stmt_close($stmt);
			return false;
		}

		$affected_rows = mysqli_stmt_affected_rows($stmt);

		mysqli_stmt_close($stmt);

		return ($affected_rows > 0);
	}


}

?>