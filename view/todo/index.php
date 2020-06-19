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
    <link rel="stylesheet" href="style.css">
    <title>TODOリスト</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <a href="./new.php">新規作成</a>
    </div>
    <div>
        <a href="./done.php">完了済み</a>
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

                <input type="button" id="show" value="完了">
                <div id="layer"></div>
                <div id="popup">
                    <div>完了しますか？</div>
                    <input type="button" class="complete_btn" data-id="<?php echo $todo['id']; ?>">はい </input>
                    <input type="button" class="close_btn" id="close">いいえ </input>
                </div>

                <!-- <div class="complete-popup" title="complete">
                    <p>完了しますか?</p></div>
                <button class="complete_btn" data-id="<?php echo $todo['id']; ?>">完了 </button>
                <div class="complete-popup" title="complete">
                <p>完了しますか?</p>
                <div><button></button></div></div>
                <button id="complete_btn" data-id="<?php echo $todo['id']; ?>">完了 </button>
                 -->
 
                <button class="delete_btn" data-id="<?php echo $todo['id']; ?>">削除</button>
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
$(function() {

    $("#show").click(function(e) {
        $('#show, #layer').show();
    });

    $(".complete_btn").on('click', function() {
        // alert('complete: ' + $(this).data('id'));
        const todo_id = $(this).data('id');
        window.location.href = "./index.php?action=complete&id=" + todo_id;
    });

    $('#close, #layer').click(function(e) {
        $('#popup, #layer').hide();
    });

    $("#delete_btn").on('click', function() {
    // alert('delete: '+ $(this).data('id'));
    const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=delete&id=" + todo_id;
    });

});

</script>