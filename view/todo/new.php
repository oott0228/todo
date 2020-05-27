<?php
require_once './../../config/database.php';
require_once './../../model/Todo.php';
require_once './../../controller/TodoController.php';


if($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new TodoController;
    $action->new();
}

$title = '';
// $user_id = '';
$detail = '';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if(isset($_GET['title'])) {
        $title = $_GET['title'];
    }
    // if(isset($_GET['user_id'])) {
    //     $user_id = $_GET['user_id'];
    // }
    if(isset($_GET['detail'])) {
        $detail = $_GET['detail'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規作成</title>
</head>
<body>
    <div>新規作成</div>
    <form action="./new.php" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="<?php echo $title;?>">
            </div>
        </div>
        <!-- <div>
            <div>ユーザーID</div>
            <div>
                <input type="text" name="user_id" value="<?php //echo $user_id;?>">
            </div>
        </div> -->
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail"><?php echo $detail;?></textarea>
            </div>
        </div>
        <button type="submit">登録</button>
        </form>
   
</body>
</html>