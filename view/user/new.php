<?php
require_once './../../config/database.php';
require_once './../../controller/UserController.php';
require_once './../../controller/LoginController.php';


session_start();
// session情報の追加 ajouter les informations de session
$error_msgs = $_SESSION['error_msgs'];
// セッション削除 supprimer les informations de session
unset($_SESSION['error_msgs']);

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new UserController;
    $action->new();
}
$name = '';
$password = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if(isset($_GET['name'])) {
        $name = $_GET['name'];
    }

    if(isset($_GET['email'])) {
        $email = $_GET['email'];
    }

    if(isset($_GET['password'])) {
        $password = $_GET['password'];
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
    
    <title>新規ユーザー登録</title>
</head>
<body>
    <div>新規ユーザー登録</div>
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
            <div>ユーザー名</div>
            <div>
                <input type="text" name="name" value="<?php echo $name;?>">
            </div>
        </div>
        <div>
            <div>メールアドレス</div>
            <div>
                <textarea name="email"><?php echo $email;?></textarea>
            </div>
        </div>
        <div>
            <div>パスワード</div>
            <div>
                <input type="text" name="password" value="<?php echo $password;?>">
            </div>
        </div>
        <button type="submit">登録</button>
        </form>
   
</body>
</html>