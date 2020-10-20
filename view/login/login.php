<?php
require_once './../../config/database.php';
require_once './../../controller/TodoController.php';

session_start();
$error_msgs = $_SESSION['error_msgs'];
unset($_SESSION['error_msgs']);

$controller = new TodoController;
$controller->login();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Loginページ</title>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script> -->

</head>
<body>
    <form action="" method="get">
        ユーザーID:<input type="text" name="user_id" value="<?php echo $user_id; ?>"><br>
        <input type="submit" value="ログイン">
    </form>
   
</body>
</html>