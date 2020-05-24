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
        $user_id = (int)$_POST['user_id'];
        $title = $_POST['title'];
        $detail = $_POST['detail'];  
    }
}