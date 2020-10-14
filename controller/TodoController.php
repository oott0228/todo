<?php
require_once './../../model/Todo.php';
require_once './../../validation/TodoValidation.php';

class TodoController {
    public function index() {
        $title = $_GET['title'];
        $status = $_GET['status'];

        $params = array('title' => array(
                                        'type' => 'like',
                                        'data' => $title
                                    ),
                        'status' => array (
                                        'data' => $status
                        ));

        $query = Todo::getQuery($params);
        // var_dump($query);
       
        if($query) {
            $todo_list = Todo::findByQuery($query);
        } else {
            $todo_list = Todo::findAll();
        }
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
            "detail" => $_POST['detail'],
            "deadline_date" => $_POST['deadline_date']
        );
        
        $validation = new TodoValidation;
        $validation->setData($data);

        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();

            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;
            $params = sprintf("?title=%s&user_id=%s&detail=%s&deadline_date=%s", $_POST['title'], $user_id, $_POST['detail'], $_POST['deadline_date']);
            header( "Location: ./new.php" . $params);
            return;
        } 
        
        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $user_id = 1;
        $detail = $validate_data['detail'];
        $deadline_date = $validate_data['deadline_date'];

        $todo = new Todo;
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $todo->setUserid($user_id);
        $todo->setDeadlineDate($deadline_date);
        $result = $todo->save();
        
        if ($result === false) {
            $params = sprintf("?title=%s&user_id=%s&detail=%s&deadline_date=%s", $title, $user_id, $detail, $deadline_date);
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
            // "todo_id" => $_GET["id"],
            "title" => $_POST['title'],
            "detail" => $_POST['detail'],
            "user_id" => 1,
            "deadline_date" => $_POST['deadline_date']
        );


        $validation = new TodoValidation;
        $validation->setData($data);

        if ($validation->check() === false) {
            $error_msgs = $validation->getErrorMessages();

            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = $error_msgs;

            // $params = sprintf("?id=%&title=%s&user_id=%s&detail=%s&deadline_date=%s", $_GET['id'], $_POST['title'], $user_id, $_POST['detail'], $_POST['deadline_date']);
            // header( "Location: ./edit.php" . $params);
            // return;
            
            header( "Location: ./edit.php?id=" . $todo_id);
            return;
        } 

        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $user_id = 1;
        $detail = $validate_data['detail'];
        $deadline_date = $validate_data['deadline_date'];

        $todo = new Todo;
        $todo->setTodoid($todo_id);
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $todo->setUserid($user_id);
        $todo->setDeadlineDate($deadline_date);
        $result = $todo->update();

        // if ($result === false) {
        //     header( "Location: ./edit.php?id=" . $todo_id);
        //     return;
        // } 

        header( "Location: ./index.php" );
    }

    public function delete() {
        $todo_id = $_GET['id'];
        $is_exist = Todo::isExistById($todo_id);
        if (!$is_exist) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("id=%sに該当するレコードが存在しません", $todo_id)
            ];
            header( "Location: ./index.php");
        }
        
        $todo = new Todo;
        $todo->setTodoid($todo_id);
        $result = $todo->delete();
        if ($result === false) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("削除に失敗しました。id=%s", $todo_id)
            ]; 
        }
        header( "Location: ./index.php");
    }

    public function complete() {
        $todo_id = $_GET['id'];
        $is_exist = Todo::isExistById($todo_id);
        if (!$is_exist) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("id=%sに該当するレコードが存在しません", $todo_id)
            ];
            header( "Location: ./index.php");
        }
        
        $todo = new Todo;
        $todo->setTodoid($todo_id);
        $todo->complete();
        if ($result === false) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("完了に失敗しました。id=%s", $todo_id)
            ];
        }
        header( "Location: ./index.php");
    }

    public function incomplete() {
        $todo_id = $_GET['id'];
        $is_exist = Todo::isExistById($todo_id);
        if (!$is_exist) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("id=%sに該当するレコードが存在しません", $todo_id)
            ];
            header( "Location: ./index.php");
        }
        
        $todo = new Todo;
        $todo->setTodoid($todo_id);
        $todo->incomplete();
        if ($result === false) {
            // セッションにエラーメッセージを追加 ajouter de la message erreur à session
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("完了に失敗しました。id=%s", $todo_id)
            ];
        }
        header( "Location: ./index.php");
    }

    
}