<?php
require_once './../../config/database.php';
require_once './../../controller/LoginController.php';
require_once './../../controller/UserController.php';


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
    public $password;
    public $name;
    public $email;


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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public static function isExistByPassword($name,$email,$password) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `users` WHERE (name = "%s" or email = "%s") and password = "%s"', $name,$email,$password);
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

    public static function isExistByName($name) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `users` WHERE name = "%s"',$name);
        $stmh = $dbh->query($query);
        if($stmh) {
            $user = $stmh->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return true;
            }else {
                return false;
            }
        }
    }

    public static function isExistByEmail($email){
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `users` WHERE email = "%s"',$email);
        $stmh = $dbh->query($query);
        if($stmh) {
            $user = $stmh->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return true;
            }else {
            return false;
            }
        }

    }

    public function save() {
        $query = sprintf(
            "INSERT INTO `users`
                (`password`, `name`, `email`,`created_at`, `updated_at`)
            VALUES ('%s', '%s','%s', now(), now());",
            $this->password,
            $this->name,
            $this->email
            );
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);
            // start transaction
            $dbh->beginTransaction();
            $stmh = $dbh->prepare($query);
            $stmh->execute();
            // commit
            $dbh->commit();
        } catch(PDOException $e) {
            // rollback
            $dbh->rollBack();
            // error message
            echo $e->getMessage();
        }
    }
    
}
