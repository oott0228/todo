<?php
require_once './../../config/database.php';
require_once './../../controller/TodoController.php';

try {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません!' . $e->getMessage();
    exit;
}

session_start();
// obtenir des information de session
$error_msgs = $_SESSION['error_msgs'];

// supprimer des information de session
unset($_SESSION['error_msgs']);


$action = new TodoController;
$todo_list = $action->completed_list();


if (isset($_GET['action']) && $_GET['action'] === 'incomplete') {
    $action = new TodoController;
    $todo_list = $action->incomplete();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $action = new TodoController;
    $todo_list = $action->delete();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>完了リスト</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <a href="./index.php">TODOリスト一覧</a>
    </div>
    <div>
        <?php if($todo_list): ?>
        <ul>
            <?php foreach($todo_list as $todo):?>
            <li>
                <a href="./detail.php?id=<?php echo $todo['id']; ?>">
                    <?php echo $todo['title']; ?>
                </a>:<?php echo $todo['display_status']; ?>
                :締め切り:<?php echo $todo['deadline_date']; ?>

                <button class="show-incomplete">未完了</button>
                    <div class="popup-incomplete">
                        <p>未完了にしますか？</p>
                            <button class="incomplete_btn" data-id="<?php echo $todo['id']; ?>"> はい </button>
                            <button class="close-incomplete">いいえ</button>
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
</body>
</html>
<script>
$(".show-incomplete").click(function(e) {
    const todo_id = $(this).data('id');
    $('.popup-incomplete').show();
});

$(".close-incomplete").click(function(e) {
    $('.popup-incomplete').hide();
});

$(".show-delete").click(function(e) {
    const todo_id = $(this).data('id');
    $('.popup-delete').show();
});

$(".close-delete").click(function(e) {
    $('.popup-delete').hide();
});

$(".incomplete_btn").on('click', function() {
    // const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=incomplete&id=" + todo_id;
});

$(".delete_btn").on('click', function() {
    // const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=delete&id=" + todo_id;
});
</script>
   
</body>
</html>