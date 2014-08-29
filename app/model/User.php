<?php

class User extends AppModel {
    public $table = 'users';
    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'message' => 'Please fill in the username.'
            ),
            'minLength' => array(
                'message' => 'Username should be atleast 6 characters',
                'value' => 6
            ),
            'unique' => array(
                'message' => 'This username already exists in the database'
            )
        ),
        'email' => array(
            'notEmpty' => array(
                'message' => 'Please fill the email.'
            ),
            'isEmail' => array(
                'message' => 'Please enter a valid email.'
            ),
            'unique' => array(
                'message' => 'This email address already exists in the database'
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
