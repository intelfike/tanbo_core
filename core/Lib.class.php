<?php

class Lib extends Object {
	function load($class) {
		require_once dirname(__FILE__)."/libs/".$class.".class.php";
	}

	function load_all($class_array) {
		foreach ($class_array as $class) {
			$this->load($class);
		}
	}
}

?>
