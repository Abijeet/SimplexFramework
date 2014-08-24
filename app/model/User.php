<?php
class User extends AppModel {
	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'message' => 'Please fill in the username.'
			),
			'minLength' => array(
				'message' => 'Username should be atleast 6 characters',
				'value' => 6
			)
		),
		'email' =>  array(			
			'notEmpty' => array(
				'message' => 'Please fill the email.'
			),
			'isEmail' => array(
				'message' => 'Please enter a valid email.'
			)
		),
		'password' => array(
			'notEmpty' => array(
				'message' => 'Please enter a password'
			),
			'minLength' => array(
				'message' => 'Password should be atleast 8 characters.',
				'value' => 8
			)
		),
		'timezone_id' => array(
			'notEmpty' => array(
				'message' => 'Please select a timezone.'
			)
		)
	);	
}