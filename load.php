<?php

// フレームワークのルートに移動
define("ROOT", dirname(__FILE__));
define("PAGE_ROOT", ROOT."/src/pages");
chdir(dirname(__FILE__));

// 必要なファイルをロード
require_once "core/Object.class.php";
require_once "core/Config.class.php";
require_once "core/Lib.class.php";
require_once "core/Web.class.php";

require_once "src/pages/Page.class.php";

// ページクラスをロード
$uri = explode("/", $_SERVER["REQUEST_URI"]);
$class = "Top";
$method = "index";
if (!empty($uri[1])) {
	$class = $uri[1];
}
if (!empty($uri[2])) {
	$method = $uri[2];
} 
$page_path = PAGE_ROOT."/$class/$class.class.php";
require_once $page_path;

$obj = new $class();
$obj->$method();



?>
