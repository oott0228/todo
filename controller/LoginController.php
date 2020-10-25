<?php
require_once './../../model/Todo.php';
require_once './../../model/User.php';
require_once './../../validation/TodoValidation.php';

class LoginController {

public function login() {
    $user_id = $_GET['user_id'];
    $password = $_GET['password'];

    $is_exist = User::isExistByUserId($user_id);
    if (!$is_exist) {
        session_start();
        $_SESSION['error_msgs'] = [
            sprintf("user_id=%sに該当するユーザーが存在しません", $user_id)
        ];
    } else {
        session_start();
        $_SESSION['user_id'] = $user_id;
    }
}


}