<?php

// フレームワークのルートに移動
define("ROOT", dirname(__FILE__));
chdir(dirname(__FILE__));

// 必要なファイルをロード
require_once "core/Object.class.php";
require_once "core/Config.class.php";
require_once "core/Lib.class.php";
require_once "core/Web.class.php";

$web = new Web();

?>
