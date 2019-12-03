<?php

class Web extends Object {
	var $DB = null;

	function __construct() {
		$config = new Config();
		$lib = new Lib();
		$lib->load("DB");
		// 設定ファイルを読み取り、ライブラリをロードする
		$db_conf = $config->load_json1("DB");
		$con = $db_conf["connection"];
		$this->DB = new DB($con["host"], $con["database"], $con["user"], $con["passwd"]);
	}
}

?>
