<?php
require('Config.php');
require('Router.php');
require('Controller.php');
require('View.php');

spl_autoload_register('autoloadClass');

function autoloadClass($class) {
	if(Controller::Load($class)) {
		return true;
	}
}

?>