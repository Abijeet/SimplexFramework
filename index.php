<?php
define('ROOT_FOLDER', basename(dirname(__FILE__)));
define('ROOT_PATH', dirname(__FILE__));
require('lib/Bootstrap.php');
$router = new Router();
$router->route();