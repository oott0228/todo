<?php
require_once './../../controller/TodoController.php';

class TodoValidation {
    private $data;
    private $error_msgs = array();

    public function getData() {
        return $this->data;
    }
    
    public function setData($data) {
        $this->data = $data;
    }

    public function check() {
        $title = $this->data['title'];
        $detail = $this->data['detail'];
        $user_id = 1;

        if(is_null($title)) {
            $this->error_msgs[] = 'タイトルが空です。';
        }
        if(is_null($detail)) {
            $this->error_msgs[] = '詳細が空です。';
        }
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



