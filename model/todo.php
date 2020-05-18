<?php
require("../view/todo/config/database.php");

class Todo {

  public static function findAll() {
    try{
      $dbh = new PDO(DSN, USER, PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM todos WHERE user_id = 1";
      $stmt = $dbh->query($sql);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      var_dump($result);
      $dbh = null;
     
     }catch(Exception $e){
      echo"接続失敗：". htmlspecialchars($e->getMessage(),ENT_QUOTES, 'UTF-8') . "<br>";
      die();
   }
  }

}

