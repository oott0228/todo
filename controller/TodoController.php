<?php
require_once './../../model/Todo.php';
require_once './../../validation/TodoValidation.php';

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
        $data = array(
            "title" => $_POST['title'],
            // test data
            "user_id" => 1,
            "detail" => $_POST['detail']
        );
        
        $validation = new TodoValidation;
        $validation->setData($data);
        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();

            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;

            $params = sprintf("?title=%s&user_id=%s&detail=%s", $title, $user_id, $detail);
            header( "Location: ./new.php" . $params);
            return;
        } 
        
        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $user_id = 1;
        $detail = $validate_data['detail'];

        $todo = new Todo;
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $todo->setUserid($user_id);
        $result = $todo->save();
        
        if ($result === false) {
            $params = sprintf("?title=%s&user_id=%s&detail=%s", $title, $user_id, $detail);
            header( "Location: ./new.php" . $params);
        } 
        header( "Location: ./index.php" );

    } 

    public function edit() {
        $todo_id = $_GET['id'];
        $todo = Todo::findById($todo_id);
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            return $todo;    
        }

        $data = array(
            "title" => $_POST['title'],
            "detail" => $_POST['detail'],
            "user_id" => 1
        );

        $validation = new TodoValidation;
        $validation->setData($data);
        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();

            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;

            $params = sprintf("?title=%s&user_id=%s&detail=%s", $title, $user_id, $detail);
            header( "Location: ./edit.php" . $params);
            return;
        } 

        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $user_id = 1;
        $detail = $validate_data['detail'];

        $todo = new Todo;
        $todo->setTodoid($todo_id);
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $todo->setUserid($user_id);
        $todo->update();

        header( "Location: ./index.php" );
    }
}