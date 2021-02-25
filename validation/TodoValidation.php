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

    public function getErrorMessages() {
        return $this->error_msgs;
    }

    public function check() {
        $title = $this->data['title'];
        $detail = $this->data['detail'];
        $user_id = 1;
        $deadline_date = $this->data['deadline_date'];

        if($title === "") {
            $this->error_msgs[] = 'タイトルが空です。';
        }
        if($detail === "") {
            $this->error_msgs[] = '詳細が空です。';
        }
        if($deadline_date === "") {
            $this->error_msgs[] = '締め切りが空です。';
        }
        
        if(count($this->error_msgs) > 0) {
            return false;
        }
        return true;
    }

    
    
}



