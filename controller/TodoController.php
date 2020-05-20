<?php
require_once './../../model/Todo.php';

class TodoController {
    public function index() {
        $todo_list = Todo::findAll();
        return $todo_list;
    }

    public function detail() {
        $todo_id = $_GET['todo_id'];
        $todo_list = Todo::findById($todo_id);
        return $todo_list;
    }
}