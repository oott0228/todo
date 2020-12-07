<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/LoginValidation.php';

class LoginController {

    public function login() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
           return;
        }

        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        $is_exist = User::isExistByPassword($user_id,$password);

        $data = array(
            "user_id" => $_POST['user_id'],
            "password" => $_POST['password'],
        );

        $validation = new LoginValidation;
        $validation->setData($data);
        $validation->setIsExist($is_exist);

        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            var_dump($error_msgs);
            unset($_SESSION['error_msgs']);
            return;
        } else {
            session_start();
            $_SESSION['user_id'] = $user_id;
            echo $_SESSION['user_id'] . "でログイン中<br>";
            unset($_SESSION['user_id']);
        }
        
    }   


}
