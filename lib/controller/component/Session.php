<?php
class Session {
	private static $sessionObj;
	
	private function __construct() {
		if(!isset($_SESSION)) {
			session_start();	
		}
	}
	
	function getUserType() {
		if(empty($_SESSION['user_type'])) {
			return 'unregistered';			
		}
		return $_SESSION['user_type'];
	}
	
	function setUserType($type) {
		$_SESSION['user_type'] = $type;
	}
	
	static function getSessionObj() {		
		if(empty(self::$sessionObj)) {
			self::$sessionObj = new Session();
		}
		return self::$sessionObj;
	}
}