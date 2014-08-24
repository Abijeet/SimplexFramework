<?php
define('CONTROLLER_FOLDER', 'controller');
define('MODEL_FOLDER', 'model');

require(APP_PATH . 'config/Config.php');
require(APP_PATH . 'config/Database.php');
require(__DIR__ . '/Router.php');
require(__DIR__ . '/Request.php');
require(__DIR__ . '/ErrorType.php');


require(__DIR__ . '/controller/Controller.php');
require(__DIR__ . '/view/View.php');
require(__DIR__ . '/model/Model.php');

spl_autoload_register('autoloadClass');

function autoloadClass($class) {
    if (Controller::Load($class)) {
        return true;
    }
    if (Model::Load($class)) {
        return true;
    }
}

?>
