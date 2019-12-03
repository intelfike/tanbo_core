<?php

class Web extends Object {
	private $default_class  = "Top";
	private $default_method = "index";

	var $DB = null;
	var $IS_SP;
	var $IS_SSL;
	var $HOST;
	var $URI;
	var $GET;
	var $POST;

	function __construct() {
		$config = new Config();
		$lib = new Lib();
		$lib->load("DB");
		// 設定ファイルを読み取り、ライブラリをロードする
		$db_conf = $config->load_json1("DB");
		$con = $db_conf["connection"];
		$this->DB = new DB($con["host"], $con["database"], $con["user"], $con["passwd"]);
	}

	function __destruct() {
		$this->DB->close();
	}

	function parse_params_from_web() {
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$isSmartPhone = false;
		if (stripos($ua, 'iphone') !== false || // iphone
			stripos($ua, 'ipod') !== false || // ipod
			(stripos($ua, 'android') !== false && stripos($ua, 'mobile') !== false) || // android
			(stripos($ua, 'windows') !== false && stripos($ua, 'mobile') !== false) || // windows phone
			(stripos($ua, 'firefox') !== false && stripos($ua, 'mobile') !== false) || // firefox phone
			(stripos($ua, 'bb10') !== false && stripos($ua, 'mobile') !== false) || // blackberry 10
			(stripos($ua, 'blackberry') !== false) // blackberry
		) {
			$isSmartPhone = false;
		}
		$this->parse_params($IS_SP, empty($_SERVER['HTTPS']), $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $_GET, $_POST);
	}
	// テスト実装時に、パラメーターを偽装できるようにメソッドを切り分けています。
	function parse_params($IS_SP, $IS_SSL, $HOST, $URI, $GET=null, $POST=null) {
		$this->IS_SP  = $IS_SP;
		$this->IS_SSL = $IS_SSL;
		$this->HOST   = $HOST;
		$this->URI    = $URI;
		$this->GET    = $GET;
		$this->POST   = $POST;
	}

	// URIから、呼び出すクラス・メソッド名を抽出する
	static function get_class_method($URI) {
		$uri = explode("/", $URI);
		$class = "Top";
		$method = "index";
		if (!empty($uri[1])) {
		        $class = $uri[1];
		}
		if (!empty($uri[2])) {
		        $method = $uri[2];
		}
		$result = [
			"class"       => $class,
			"method"      => $method,
		];
		if (!empty($uri[3])) {
			$result["after_params"] = array_slice($uri, 3);
		}
		return $result;
	}
}
?>
