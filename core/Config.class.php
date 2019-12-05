<?php

class Config extends TanboRoot {
	private $dir = "";

	function __construct($dir = null) {
		if (!empty($dir)) {
			$this->dir = $dir;
		}
	}

	// 設定ファイルを読み取り、データを返す
	function load_json_ver1($file) {
		$path = $this->dir."/".$file.".json";
		if (!file_exists($path)) {
			throw new Exception("Config file '$path' is not exists.");
		}
		$json = file_get_contents($path);
		// ファイル内容が正しいかチェック
		if (empty($json)) {
			throw new Exception("Config file '$path' is empty.");
		}
		$config = json_decode($json, true);
		if (empty($config)) {
			throw new Exception("Config file '$path' is not JSON.");
		} else if ($config["version"] != "1") {
			throw new Exception("Config file '$path' version is not match.");
		}
		return $config["config"];
	}
}

?>
