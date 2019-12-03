<?php
class Web extends Object {
	const DEFAULT_CLASS  = "Top";
	const DEFAULT_METHOD = "index";
	private $class;
	private $method;

	private $layout_dir;
	private $layout = "default";
	private $page_dir;
	private $page = "index";

	// ライブラリ
	var $DB     = null;
	var $SMARTY = null;

	// リクエストパラメータ
	var $IS_SP;
	var $IS_SSL;
	var $HOST;
	var $URI;
	var $GET;
	var $POST;


	function __construct($class, $method) {
		$this->class =  $class;
		$this->method = $method;
		$this->page =   $method;

		$config = new Config();
		$lib = new Lib();
		$lib->load_all(["DB", "Smarty"]);
		// 設定ファイルを読み取り、ライブラリをロードする
		// DB設定
		$db_conf = $config->load_json_ver1("DB");
		$con = $db_conf["connection"];
		$this->DB = new DB($con["host"], $con["database"], $con["user"], $con["passwd"]);
		// SMARTY設定
		$smarty_conf = $config->load_json_ver1("smarty");
		$this->SMARTY = new Smarty();
		$this->SMARTY->setTemplateDir($smarty_conf["template_dir"]);
		$this->SMARTY->setCompileDir( $smarty_conf["compile_dir"]);
		$this->layout_dir = $smarty_conf["layout_dir"];
		$this->page_dir = $smarty_conf["page_dir"];
	}

	function __destruct() {
		// DBの接続を切断する
		$this->DB->close();
	}

	function render() {
                // テンプレートを描画する
		$page_path = $this->page_dir ."/". $this->class ."/". $this->page.".tpl";
                $this->SMARTY->assign("PAGE_NAME", $page_path);

		$layout_path = ROOT."/".$this->layout_dir."/".$this->layout.".tpl";
                $this->SMARTY->display($layout_path);
	}

	function parse_params_from_web() {
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$IS_SP = false;
		if (stripos($ua, 'iphone') !== false || // iphone
			stripos($ua, 'ipod') !== false || // ipod
			(stripos($ua, 'android') !== false && stripos($ua, 'mobile') !== false) || // android
			(stripos($ua, 'windows') !== false && stripos($ua, 'mobile') !== false) || // windows phone
			(stripos($ua, 'firefox') !== false && stripos($ua, 'mobile') !== false) || // firefox phone
			(stripos($ua, 'bb10') !== false && stripos($ua, 'mobile') !== false) || // blackberry 10
			(stripos($ua, 'blackberry') !== false) // blackberry
		) {
			$IS_SP = false;
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
		$class = Web::DEFAULT_CLASS;
		$method = Web::DEFAULT_METHOD;
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
