<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/LoginValidation.php';

class LoginController {

    public function login() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
           return;
        }

        $data = array(
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        );

        $validation = new LoginValidation;
        $validation->setData($data);


        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            header( "Location: ./login.php");
            return;
        } else {
            session_start();
            $_SESSION['name'] = $_POST['name'];
            echo $_SESSION['name'] . "でログイン中<br>";
            unset($_SESSION['name']);
        }
        
    }   


}
