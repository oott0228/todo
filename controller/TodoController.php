<?php
require_once './../../model/Todo.php';

class TodoController {
    public function index() {
        $todo_list = Todo::findAll();
        return $todo_list;
    }

    public function detail() {
        $todo_id = $_GET['id'];
        $todo = Todo::findById($todo_id);
        return $todo;
    }

    public function new() {
        $title = $_POST['title'];
        $user_id = (int)$_POST['user_id'];
        $detail = $_POST['detail']; 
        
        $todo = new Todo;
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $todo->setUserid($user_id);
        $result = $todo->save();

        if ($result === false) {
            header( "Location: ./new.php" );
        }

        header( "Location: ./index.php" );
    }
}