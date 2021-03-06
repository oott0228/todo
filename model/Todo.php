<?php
require_once './../../config/database.php';

class Todo {
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

    public static function getQuery($params) {
        $query = "";
        foreach($params as $field => $param) { 
            if($param['type'] == 'like') {
                if($param['data'] != '' && $query != '' && $field != end($params)) {
                    $query = $query . "and " . sprintf('%s %s "%%%s%%"',$field,$param['type'],$param['data']);
                } elseif($param['data'] == '') {
                    $query = "";
                } else { 
                    $query = $query . sprintf('%s %s "%%%s%%"',$field,$param['type'],$param['data']);
                }
            } else {
                if($param['data'] != '') {
                    if($query != '' && $field != end($params)) {
                        $query = $query . "and " .sprintf('%s = %s',$field,$param['data']);
                    }else {
                        $query = $query . sprintf('%s = %s',$field,$param['data']);
                    }
                }
            }
        }
        if($query == "") {
            return $query;
        } else {
        $query = sprintf('SELECT * FROM `todos` WHERE %s', $query);
            return $query;
        }
    }

    public static function findByQuery($query) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $dbh->prepare($query);
        $stmh->execute();

        if($stmh) {
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $todo_list = [];
        }

        if($todo_list && count($todo_list) > 0) {
            foreach ($todo_list as $index => $todo) {
                $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
            }
        }
        return $todo_list;
    }

    public static function findAll() {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = "SELECT * FROM todos";
        $stmh = $dbh->query($query);

        if($stmh) {
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $todo_list = [];
        }

        if($todo_list && count($todo_list) > 0) {
            foreach ($todo_list as $index => $todo) {
                $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
            }
        }
        return $todo_list;
    }

    public static function findById($todo_id) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $dbh->query(sprintf('SELECT * FROM todos WHERE id = %s;', $todo_id));
        if($stmh) {
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
        } else {
            $todo = [];
        }
        if($todo) {
            $todo['display_status'] = self::getDisplayStatus($todo['status']);
        }
        return $todo;
    }

    public static function getDisplayStatus($status) {
        if ($status == self::STATUS_INCOMPLETE) {
            return self::STATUS_INCOMPLETE_TXT;
        } else if ($status == self::STATUS_COMPLETED) {
            return self::STATUS_COMPLETED_TXT;
        }
        return "";
    }

    public static function isExistById($todo_id) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `todos` WHERE id = %s', $todo_id);
        $stmh = $dbh->query($query);
        if(!$stmh) {
            return false;
        }
        return true;
    }

    public static function isExistByUserId($user_id) {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf('SELECT * FROM `todos` WHERE id = %s', $user_id);
        $stmh = $dbh->query($query);
        if(!$stmh) {
            return false;
        }
        return true;
    }
  
    public function save() {
        $query = sprintf(
            "INSERT INTO `todos`
                (`user_id`, `title`, `detail`, `status`, `deadline_date`, `created_at`, `updated_at`)
            VALUES ('%s', '%s', '%s', 0, '%s', now(), now());",
            $this->user_id,
            $this->title,
            $this->detail,
            $this->deadline_date
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

    public function update() {
        $query = sprintf(
            "UPDATE `todos` SET title = '%s', detail = '%s', deadline_date = '%s', updated_at = now() WHERE id = '%s';",
            $this->title,
            $this->detail,
            $this->deadline_date,
            $this->todo_id
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

    public function delete() {
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);
            // start transaction
            $dbh->beginTransaction();
            $query = sprintf("DELETE FROM `todos` WHERE id = %s", $this->todo_id);
            $stmh = $dbh->prepare($query);
            $result = $stmh->execute();
            // commit
            $dbh->commit();
        } catch(PDOException $e) {
            // rollback
            $dbh->rollBack();

            // error message
            echo $e->getMessage();
        }
        return $result;
    }
  
    public function complete() {
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);
            // start transaction
            $dbh->beginTransaction();
            $query = sprintf("UPDATE `todos` SET status = %s, completed_at = now() WHERE id = %s", 
            self::STATUS_COMPLETED,
            $this->todo_id
        );
            $stmh = $dbh->prepare($query);
            $result = $stmh->execute();
            // commit
            $dbh->commit();
        } catch(PDOException $e) {
            // rollback
            $dbh->rollBack();
            // error message
            echo $e->getMessage();
        }
        return $result;
    }

    public function incomplete() {
        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);
            // start transaction
            $dbh->beginTransaction();
            $query = sprintf("UPDATE `todos` SET status = %s, completed_at = null WHERE id = %s", 
            self::STATUS_INCOMPLETE,
            $this->todo_id
        );
            $stmh = $dbh->prepare($query);
            $result = $stmh->execute();
            // commit
            $dbh->commit();
        } catch(PDOException $e) {
            // rollback
            $dbh->rollBack();
            // error message
            echo $e->getMessage();
        }
        return $result;
    }
}
