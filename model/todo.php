<?php

require_once getcwd() . '/../../config/database.php';

class Todo
{
    public static function findByQuery($query)
    {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmt = $dbh->prepare($query);
        $stmt->execute();

        $todo_list = [];

        if ($stmt) {
            $todo_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $todo_list;
    }

    public static function findAll()
    {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = "SELECT * FROM todos";
        $stmh = $dbh->query($query);

        if ($stmh) {
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $todo_list = [];
        }
        return $todo_list;
    }

    public static function findById($todo_id)
    {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $dbh->query(sprintf('SELECT * FROM todos WHERE id = %s;', $todo_id));
        if ($stmh) {
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
        } else {
            $todo = [];
        }

        return $todo;
    }

}

