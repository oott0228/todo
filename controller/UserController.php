<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/UserValidation.php';

class UserController {

    public function new() {

    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        return;
        }

    $name =$_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $is_exist = User::isExistByUserName($name);
        
    $data = array(
        "name" => $_POST['name'],
        "password" => $_POST['password'],
        "email" => $_POST['email'],
        "is_exist" => $is_exist
    );

    $validation = new UserValidation;
    $validation->setData($data);
        
    if ($validation->check() === false) {
        $error_msgs = $validation->getErrorMessages();
        session_start();
        $_SESSION['error_msgs'] = $error_msgs;
        header( "Location: ./new.php");
        return;
    } else {
        header( "Location: ../login/login.php");
    }

    } 
    
}   
