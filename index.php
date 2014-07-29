<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(realpath(__FILE__)) . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('INDEX_URL', dirname($_SERVER['SCRIPT_NAME']) . '/');

require('lib/Bootstrap.php');

//die(Router::getURL('res'));
$router = new Router();
$router->route();