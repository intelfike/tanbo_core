<?php

class Lib extends TanboRoot {
	private $dir = "";

	function __construct($dir = null) {
		if (!empty($dir)) {
			$this->dir = $dir;
		}
	}

	function load($class) {
		require_once $this->dir."/".$class."/".$class.".class.php";
	}

	function load_all($class_array) {
		foreach ($class_array as $class) {
			$this->load($class);
		}
	}
}

?>
