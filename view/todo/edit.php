<?php
require_once '../../config/database.php';
// require_once '../../model/todo.php';
require_once './../../controller/TodoController.php';

session_start();
// obtenir des information de session
$error_msgs = $_SESSION['error_msgs'];

// supprimer des information de session
unset($_SESSION['error_msgs']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集</title>
</head>
<body>
    <div>編集</div>
    <form action="./edit.php" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail">
                </textarea>
            </div>
        </div>
        <button type="submit">登録</button>
    </form>
    <?php if($error_msgs):?>
        <div>
            <ul>
            <?php foreach($error_msgs as $error_msg):?>
                <li><?php echo $error_msg; ?></li>
            <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
</body>
</html>




