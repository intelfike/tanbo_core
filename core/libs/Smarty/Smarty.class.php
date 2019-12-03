<?php

require_once 'smarty/Smarty.class.php';

class Smarty extends Object {
	var $smarty = null;
	var $layout = "";

	function __construct($template_dir, $compile_dir) {
		$this->smarty = new Smarty();
		$this->smarty->template_dir = $template_dir;
		$this->smarty->compile_dir = $compile_dir;
	}

	function assign($key, $value) {
		$this->smarty->assign($key, $value);
	}

	function fetch() {
		return $this->smarty->fetch();
	}
}

?>
