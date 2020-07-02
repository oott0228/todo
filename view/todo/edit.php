<?php
require_once '../../config/database.php';
require_once './../../controller/TodoController.php';

session_start();
// obtenir des information de session
$error_msgs = $_SESSION['error_msgs'];
// supprimer des information de session
unset($_SESSION['error_msgs']);

$controller = new TodoController;
$todo = $controller->edit();

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
    <script>
        $(function() {
            $("#deadline_date").datepicker();
        });
    </script>
    <title>編集</title>
</head>
<body>
    <div>編集</div>
    <form action="./edit.php?id=<?php echo $todo['id']; ?>" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="<?php echo $todo['title']; ?>">
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
                <textarea name="detail"><?php echo $todo['detail']; ?></textarea>
            </div>
        </div>
        <div>
            <div>締め切り</div>
            <div>
            <input type="text" name="deadline_date" id="deadline_date" value="<?php echo $todo['deadline_date'];?>">
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




