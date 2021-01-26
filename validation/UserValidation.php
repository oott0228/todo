<?php
require_once './../../controller/UserController.php';

class UserValidation {
    private $data;
    private $error_msgs = array();
    

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getErrorMessages() {
        return $this->error_msgs;
    }

    public function check() {
        $name = $this->data['name'];
        $password = $this->data['password'];
        $email = $this->data['email'];
        $is_exist = $this->data['is_exist'];

        if($is_exist) {
            $this->error_msgs[] = 'すでに存在するユーザー名です。';
        }

        if($name === "") {
            $this->error_msgs[] = 'ユーザー名が空です。';
        }

        if($password === "") {
            $this->error_msgs[] = 'パスワードが空です。';
        }
        if($email === "") {
            $this->error_msgs[] = 'メールアドレスが空です。';
        }
        
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



