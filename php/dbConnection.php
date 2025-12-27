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
		
		if (mysqli_connect_errno()) {
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
}


?>