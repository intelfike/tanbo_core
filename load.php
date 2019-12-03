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
$class_method = Web::get_class_method($_SERVER["REQUEST_URI"]);
$class = $class_method["class"];
$method = $class_method["method"];
$page_path = PAGE_ROOT."/$class/$class.class.php";
require_once $page_path;

$obj = new $class();
$obj->parse_params_from_web();
$obj->$method();


?>
