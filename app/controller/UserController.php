<?php

class UserController extends AppController {
    public function __construct($route, $view) {
        parent::__construct($route, $view);        
    }
    
    function register() {        
        $this->set('timezones', $this->generateTimezoneList());
        if ($this->request->isPost()) {
            $response = $this->User->save($this->request->data);
            if ($response === ErrorType::NONE) {
                
            } else {
               
            }
        }
    }

}
