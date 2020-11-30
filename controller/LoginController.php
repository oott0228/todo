<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/TodoValidation.php';

class LoginController {

    public function login() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
           return;
        }

        $user_id = $_POST['user_id'];
        $password = $_POST['password'];

        $is_exist = User::isExistByPassword($user_id,$password);

        if (!$is_exist) {
            session_start();
            $_SESSION['error_msgs'] =
                sprintf("user_id=%sに該当するユーザーが存在しないかパスワードが違います", $user_id);
                echo $_SESSION['error_msgs'];
                unset($_SESSION['user_id']);
        } else {
            session_start();
            $_SESSION['user_id'] = $user_id;
            echo $_SESSION['user_id'] . "でログイン中<br>";
            unset($_SESSION['user_id']);
        }
        
    }   


}
