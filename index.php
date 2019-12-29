<?php

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require_once ROOT.DS."vendor/autoload.php";
require_once ROOT.DS.'functions.php';

use Core\Session;

Session::start();

$app = new Core\Application();




