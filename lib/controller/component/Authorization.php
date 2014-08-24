<?php

class Authorization {

    private static $authObj;
    private $access;
    private $allow;
    private $deny;

    private function __construct($userType) {
        $this->allow = NULL;
        $this->deny = NULL;
        $accessJson = file_get_contents(ROOT_PATH . 'access.json');
        $this->access = json_decode($accessJson);
        if (isset($this->access->$userType)) {
            if (isset($this->access->{$userType}->{'deny'})) {
                $this->deny = $this->access->userType->{'deny'};
            } else if (isset($this->access->{$userType}->{'allow'})) {
                $this->allow = $this->access->{$userType}->{'allow'};
            }
        }
    }

    function isAuthorized($controller, $action) {
        if (empty($this->allow) && empty($this->deny)) {
            return false;
        }
        if (empty($this->allow)) {
            if (isset($this->deny->{$controller}) && isset($this->deny->{$controller}[$action])) {
                return false;
            }
            return true;
        }
        if (empty($this->deny)) {
            if (isset($this->allow->{$controller}) && in_array($action, $this->allow->{$controller})) {
                return true;
            }
            return false;
        }
    }

    static function getAuthObj($userType) {
        if (empty(self::$authObj)) {
            self::$authObj = new Authorization($userType);
        }
        return self::$authObj;
    }

}

?>