<?php
class Web extends Object {
	private $class;
	private $method;

	protected $layout = "default";
	protected $page = "index";

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

		$config = new Config(CONFIGS_ROOT);
		$lib = new Lib(LIBS_ROOT);
		$lib->load_all(["DB", "Smarty"]);
		// DB設定
		$db_conf = $config->load_json_ver1("DB");
		$con = $db_conf["connection"];
		$this->DB = new DB($con["host"], $con["database"], $con["user"], $con["passwd"]);
		// SMARTY設定
		$smarty_conf = $config->load_json_ver1("smarty");
		$this->SMARTY = new Smarty();
		$this->SMARTY->setTemplateDir(SRC_ROOT."/".$smarty_conf["template_dir"]);
		$this->SMARTY->setCompileDir(SRC_ROOT."/".$smarty_conf["compile_dir"]);
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

	function render() {
		// テンプレートを描画する
		$page_path = PAGES_ROOT ."/". $this->class ."/". $this->page.".tpl";
		$this->SMARTY->assign("PAGE_NAME", $page_path);

		$layout_path = TPL_ROOT."/layout/".$this->layout.".tpl";
		$this->SMARTY->display($layout_path);
	}

	function __destruct() {
		// DBの接続を切断する
		$this->DB->close();
	}
}
?>
