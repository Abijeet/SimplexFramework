<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(realpath(__FILE__)) . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('INDEX_URL', dirname($_SERVER['SCRIPT_NAME']) . '/');

require(__DIR__ . '/lib/Bootstrap.php');

$router = new Router();
$router->route();
