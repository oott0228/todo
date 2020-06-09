<?php
require_once './../../config/database.php';
require_once './../../controller/TodoController.php';

$controller = new TodoController;
$todo_list = $controller->index();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODOリスト</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <a href="./new.php">新規作成</a>
    </div>
    <div>
        <?php if($todo_list): ?>
        <ul>
            <?php foreach($todo_list as $todo):?>
            <li>
                <a href="./detail.php?id=<?php echo $todo['id']; ?>">
                    <?php echo $todo['title']; ?>
                </a>:<?php echo $todo['display_status']; ?>
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
$(".delete_btn").on('click', function() {
    alert($(this).data('id'));
    const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
});
</script>