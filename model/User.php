<?php
require_once './../../config/database.php';

class User {
    const STATUS_INCOMPLETE = 0;
    const STATUS_COMPLETED = 1;

    const STATUS_INCOMPLETE_TXT = "未完了";
    const STATUS_COMPLETED_TXT = "完了";

    public $todo_id;
    public $title;
    public $detail;
    public $status;
    public $user_id;
    public $deadline_date;


    public function getTodoid() {
        return $this->todo_id;
    }

    public function setTodoid($todo_id) {
        $this->todo_id = $todo_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getStatus() {
      return $this->status;
    }

    public function setStatus($status) {
      $this->status = $status;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getDeadlineDate() {
        return $this->deadline_date;
    }

    public function setDeadlineDate($deadline_date) {
        $this->deadline_date = $deadline_date;
    }

    public static function isExistByPassword($user_id,$password) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `users` WHERE id = %s and password = %s', $user_id,$password);
        $stmh = $dbh->query($query);
        if($stmh) {
            $login = $stmh->fetch(PDO::FETCH_ASSOC);
            if(!$login) {
                return false;
            } else {
                return true;
            }
        }
    }
    
}
