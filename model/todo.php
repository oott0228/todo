<?php
require_once './../../config/database.php';
// require_once './../../controller/TodoController.php';

class Todo {
  const STATUS_INCOMPLETE = 0;
  const STATUS_COMPLETED = 1;

  const STATUS_INCOMPLETE_TXT = "未完了";
  const STATUS_COMPLETED_TXT = "完了";

  public static function findByQuery($query) {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
    $stmh = $this->dbh->prepare($query);
    $stmt->execute();

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
  
}

