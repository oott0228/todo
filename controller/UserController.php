<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/UserValidation.php';

class UserController {

    public function new() {

    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        return;
    }
        
    $data = array(
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "password" => $_POST['password'],
        
    );

    $validation = new UserValidation;
    $validation->setData($data);
        
    if ($validation->check() === false) {
        $error_msgs = $validation->getErrorMessages();
        session_start();
        $_SESSION['error_msgs'] = $error_msgs;
        header( "Location: ./new.php");
        return;
    }

    $user = new User;
    //$user->setUserId($user_id);
    $user->setName($name);
    $user->setPassword($password);
    $user->setEmail($email);
    $result = $user->save();
    if ($result === false) {
        $params = sprintf("?name=%s&password=%s&email=%s", $name, $password,$email);
        header( "Location: ./new.php" . $params);
    } else {
        header( "Location: ../login/login.php" );
    }
    
} 
    
}   
