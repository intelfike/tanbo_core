<?php

// フレームワークのルートに移動
chdir(dirname(__FILE__));

// デバッグ出力
ini_set('display_errors', 1);

// 必要なファイルをロード
require_once "core/Object.class.php";
require_once "core/Config.class.php";
require_once "core/Lib.class.php";
require_once "core/Web.class.php";

// 標準の設定をロード
$CONF = new Config("manage/configs");
$tanbo_conf = $CONF->load_json_ver1("tanbo");
require_once $tanbo_conf["src"]["pages_dir"]."/Page.class.php";

define("ROOT", dirname(__FILE__));
define("LIBS_ROOT",    ROOT."/".$tanbo_conf["tanbo"]["libs_dir"]);
define("SRC_ROOT",     ROOT."/".$tanbo_conf["src"]["src_dir"]);
define("PAGES_ROOT",   ROOT."/".$tanbo_conf["src"]["pages_dir"]);
define("CONFIGS_ROOT", ROOT."/".$tanbo_conf["src"]["configs_dir"]);
define("TPL_ROOT",     ROOT."/".$tanbo_conf["src"]["tpl_dir"]);

// ページクラスをロード
$class = "Top";
if (!empty($_GET["CLASS"])) {
	$class = $_GET["CLASS"];
}
$method = "index";
if (!empty($_GET["METHOD"])) {
	$method = $_GET["METHOD"];
}
$page_path = PAGES_ROOT."/$class/$class.class.php";
require_once $page_path;

$obj = new $class($class, $method);
$obj->parse_params_from_web();
$obj->$method(); // srcで定義した関数を呼び出し
$obj->render();

?>
