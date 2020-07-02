<?php
require_once './../../config/database.php';
require_once './../../controller/TodoController.php';

session_start();
// session情報の追加 ajouter les informations de session
$error_msgs = $_SESSION['error_msgs'];
// セッション削除 supprimer les informations de session
unset($_SESSION['error_msgs']);

try {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません!' . $e->getMessage();
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'complete') {
    $action = new TodoController;
    $todo_list = $action->complete();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $action = new TodoController;
    $todo_list = $action->delete();
}

$controller = new TodoController;
$todo_list = $controller->index();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>TODOリスト</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>

</head>
<body>
    <div>
        <a href="./new.php">新規作成</a>
    </div>
    <div>
        <a href="./done.php">完了済み</a>
    </div>
    <div><h1>TODOリスト一覧</h1></div>
    <div>
        <?php if($todo_list): ?>
        <ul>
            <?php foreach($todo_list as $todo):?>
            <li>
                <a href="./detail.php?id=<?php echo $todo['id']; ?>">
                    <?php echo $todo['title']; ?>
                </a>:<?php echo $todo['display_status']; ?>
                :締め切り:<?php echo $todo['deadline_date']; ?>

                <button class="show-complete">完了</button>
                    <div class="popup-complete">
                        <p>完了しますか？</p>
                            <button class="complete_btn" data-id="<?php echo $todo['id']; ?>"> はい </button>
                            <button class="close-complete">いいえ</button>
                    </div>

                <button class="show-delete">削除</button>
                    <div class="popup-delete">
                        <p>削除しますか？</p>
                            <button class="delete_btn" data-id="<?php echo $todo['id']; ?>"> はい </button>
                            <button class="close-delete">いいえ</button>
                    </div>

            </li>  
            <?php endforeach;?>
        </ul>
        <?php else:?>
        <div>データなし</div>
        <?php endif;?>
    </div>
</body>
</html>
<script>
$(".show-complete").click(function(e) {
    $('.popup-complete').show();
    
});

$(".close-complete").click(function(e) {
    $('.popup-complete').hide();
});

$(".show-delete").click(function(e) {
    $('.popup-delete').show();
    
});

$(".close-delete").click(function(e) {
    $('.popup-delete').hide();
});

$(".complete_btn").on('click', function() {
    const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=complete&id=" + todo_id;
});

$(".delete_btn").on('click', function() {
const todo_id = $(this).data('id');
window.location.href = "./index.php?action=delete&id=" + todo_id;
});

</script>