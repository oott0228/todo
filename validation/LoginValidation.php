<?php
require_once './../../controller/LoginController.php';

class LoginValidation {
    private $data;
    private $is_exist;
    private $error_msgs = array();
    

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getIsExist() {
        return $this->is_exist;
    }

    public function setIsExist($is_exist) {
        $this->is_exist = $is_exist;
    }


    public function getErrorMessages() {
        return $this->error_msgs;
    }

    public function check() {

        $user_id = $this->data['user_id'];
        $password = $this->data['password'];
        
        if($user_id === "") {
            $this->error_msgs[] = 'ユーザーIDが入力されていません。';
        }
        if($password === "") {
            $this->error_msgs[] = 'パスワードが入力されていません。';
        }
        if (!$this->is_exist) {
            $this->error_msgs[] = sprintf("user_id=%sに該当するユーザーが存在しないかパスワードが違います", $user_id);
        }
       
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



