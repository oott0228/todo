<?php
require_once './../../config/database.php';
require_once './../../controller/TodoController.php';


session_start();
// session情報の追加 ajouter les informations de session
$error_msgs = $_SESSION['error_msgs'];

// セッション削除 supprimer les informations de session
unset($_SESSION['error_msgs']);

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new TodoController;
    $action->new();
}

$title = '';
// test data
$user_id = 1;
$detail = '';
$deadline_date = '';
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
    if(isset($_GET['deadline_date'])) {
        $deadline_date = $_GET['deadline_date'];
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

    <?php if($error_msgs):?>
        <div>
            <ul>
            <?php foreach($error_msgs as $error_msg):?>
                <li><?php echo $error_msg; ?></li>
            <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>

        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="<?php echo $title;?>">
            </div>
        </div>
        <div>
            <div>ユーザーID</div>
            <div>
                <input type="text" name="user_id" value="1">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail"><?php echo $detail;?></textarea>
            </div>
        </div>
        <div>
            <div>締め切り</div>
            <div>
                <input type="datetime-local" name="deadline_date" value="<?php echo $deadline_date;?>">
            </div>
        </div>
        <button type="submit">登録</button>
        </form>
   
</body>
</html>