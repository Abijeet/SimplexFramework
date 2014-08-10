<?php
class UserController extends AppController {	
	function register() {
		if($this->request->isPost()) {
			$response = $this->User->save($this->request->data);
			if($response === ErrorType::NONE) {
				
			} else {
				$this->setErrors($this->User->getErrors());
			}
		}
	}
}