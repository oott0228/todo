<?php
require_once './../../controller/TodoController.php';

class TodoValidation {
    private $data;
    private $error_msgs = array();
    
    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function getErrorMessages() {
        return $this->error_msgs;
    }

    public function check() {
        $title = $this->data['title'];
        $detail = $this->data['detail'];
        $user_id = 1;

        if($title === '') {
            $this->error_msgs[] = 'タイトルが空です。';
        }
        if($detail === '') {
            $this->error_msgs[] = '詳細が空です。';
        }
        // if($user_id === '' || $user_id !== 1) {
        //     $this->error_msgs[] = 'user_idが正しくありません。';
        //     var_dump($this->error_msgs);
        // }
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



