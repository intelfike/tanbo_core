<?php
include "";

class DB extends Object {
	var $connection = null;

	function __construct($host, $db, $user, $pw) {
		if ($this->connection == null) {
			$this->connection = new PDO("mysql:host=$host;dbname=$db", $user, $pw);
		}
	}

	public function query($sql, $params = []) {
		$stmt = $this->connection->prepare($sql);
		foreach ($params as $key => $param) {
				$type = PDO::PARAM_STR;
			switch(true){
			case is_bool($bind) :
				$type = PDO::PARAM_BOOL;
				break;
			case is_null($bind) :
				$type = PDO::PARAM_NULL;
				break;
			case is_int($bind) :
				$type = PDO::PARAM_INT;
				break;
			case is_float($bind) :
			case is_numeric($bind) :
			case is_string($bind) :
			default:
				$type = PDO::PARAM_STR;
				break;
			}
			$stmt->bindParam($key, "".$param, $type);
		}
		$stmt->execute();
		$fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
	}

	public function close() {
		$this->connection = null;
	}
}

?>
