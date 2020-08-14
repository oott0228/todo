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

if (isset($_GET['action']) && $_GET['action'] === 'incomplete') {
    $action = new TodoController;
    $todo_list = $action->incomplete();
}

if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $controller = new TodoController;
    $searched_list = $controller->search();
    foreach($searched_list as $todo) {
        echo $todo;
    }
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

    <form action="" method="get">
        タイトル検索:<input type="text" name="search" value="<?php echo $search; ?>"><br>
        <input type="submit" value="検索">
    </form>

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

                <?php if($todo['status'] == 0): ?><button class="show-complete" data-id="<?php echo $todo['id']; ?>">完了</button>
                 <?php else : ?>
                <button class="show-incomplete" data-id="<?php echo $todo['id']; ?>">未完了</button>
                <?php endif;?>
                   
                <button class="show-delete" data-id="<?php echo $todo['id']; ?>">削除</button>

            </li>  
            <?php endforeach;?>
        </ul>

        <div class="popup-complete">
            <p>完了にしますか？</p>
                <button class="complete_btn"> はい </button>
                <button class="close-complete">いいえ</button>
        </div>
        <div class="popup-incomplete">
            <p>未完了にしますか？</p>
                <button class="incomplete_btn"> はい </button>
                <button class="close-incomplete">いいえ</button>
        </div>
        <div class="popup-delete">
            <p>削除しますか？</p>
                <button class="delete_btn" > はい </button>
                <button class="close-delete">いいえ</button>
        </div>


        <?php else:?>
        <div>データなし</div>
        <?php endif;?>
    </div>
</body>
</html>
<script>
$(".show-complete").click(function(e) {
    const todo_id = $(this).data('id');
    $('.complete_btn').data('id', todo_id); 
    $('.popup-complete').show();  
});

$('.complete_btn').on('click', function() {
    var todo_id = $('.complete_btn').data('id');
    window.location.href = "./index.php?action=complete&id=" + todo_id;
    });

$(".close-complete").click(function(e) {
    $('.popup-complete').hide();
});


$(".show-delete").click(function(e) {
    const todo_id = $(this).data('id');
    $('.popup-delete').show();
});

$('.delete_btn').on('click', function() {
    var todo_id = $(this).data('id');
    window.location.href = "./index.php?action=delete&id=" + todo_id;
}); 

$('.close-delete').click(function(e) {
    $('.popup-delete').hide();
});

$('.show-incomplete').click(function(e) {
    const todo_id = $(this).data('id');
    $('.incomplete_btn').data('id', todo_id); 
    $('.popup-incomplete').show();  
});

$('.incomplete_btn').on('click', function() {
    var todo_id = $(this).data('id');
    window.location.href = "./index.php?action=incomplete&id=" + todo_id;
});

$('.close-incomplete').click(function(e) {
    $('.popup-incomplete').hide();
});




</script>