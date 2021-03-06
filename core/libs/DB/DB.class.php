<?php

class DB extends TanboRoot {
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
			case is_bool($param) :
				$type = PDO::PARAM_BOOL;
				break;
			case is_null($param) :
				$type = PDO::PARAM_NULL;
				break;
			case is_int($param) :
				$type = PDO::PARAM_INT;
				break;
			case is_float($param) :
			case is_numeric($param) :
			case is_string($param) :
			default:
				$type = PDO::PARAM_STR;
				break;
			}
			$stmt->bindValue($key, $param, $type);
		}
		$stmt->execute();
		$fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $fetch;
	}

	public function close() {
		$this->connection = null;
	}
}

?>
