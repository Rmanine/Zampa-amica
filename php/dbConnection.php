<?php
namespace DB;

class DBAccess {

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "my_techwebzampaamica";
	private const USERNAME = "techwebzampaamica";
	private const PASSWORD = "";

	private $connection;

	public function openDBConnection() {
		
		mysqli_report(MYSQLI_REPORT_ERROR);
		
		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
		
		if (mysqli_connect_errono()) {
			return false;
		} else {
			return true;
		}
		
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}


	public function getList() {

		$query = "SELECT * FROM Animale ORDER BY ID ASC";
		
		$queryResult = mysqli_query($this->connection, $query) or die("Errorre in dbConnection: " . mysqli_error($this->connection)); #controllo di errori per il debug, questo non è l'errore che deve essere mostrato all'utente
		
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

	/* public function insertNewElement($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti, $riconoscimenti, $note, $genere) {
		$queryInsert = "INSERT INTO atleti(nome, capitano, dataNascita, luogo, squadra, ruolo, altrezza, maglia, magliaNqzionale, punti, riconosccimenti, note, genere) VALUES(\"$nome\", \"$capitano\", \"$dataNascita\", \"$luogo\", \"$squadra\", \"$ruolo\", \"$altrezza\", \"$maglia\", \"$magliaNqzionale\", \"$punti\", \"$riconosccimenti\", \"$note\", \"$genere\")";

		$queryResult = mysqli_query($this->connection, $query) or die("Errorre in dbConnection: " . mysqli_error($this->connection)); #controllo di errori per il debug, questo non è l'errore che deve essere mostrato all'utente
		
		if(mysqli_affected_rows($this->connection) > 0) {
			return true;
		} else {

			return false;
		}
		
	} */

	
}


?>