<?php
require_once './../../controller/LoginController.php';

class LoginValidation {
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
        $email = $this->data['email'];
        $password = $this->data['password'];
        $is_exist = User::isExistByPassword($name,$email,$password);
        
        if($name === "" && $email === "") {
            $this->error_msgs[] = 'ユーザー名とメールアドレスが入力されていません。どちらかを入力してください。';
        }

        if($password === "") {
            $this->error_msgs[] = 'パスワードが入力されていません。';
        }
        if (!$is_exist) {
            $this->error_msgs[] = sprintf("ユーザー名：%sもしくはメールアドレス：%sに該当するユーザーが存在しないかパスワードが違います", $name,$email);
        }
       
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



