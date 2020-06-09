<?php
require_once '../../config/database.php';
require_once './../../controller/TodoController.php';

$controller = new TodoController;
$todo = $controller->detail();

// var_dump($todo);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細画面</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>タイトル</th>
                <th>詳細</th>
                <th>締め切り</th>
                <th>完了日</th>
                <th>ステータス</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row"><?php echo $todo['title']; ?></td>
                <td><?php echo $todo['detail']; ?></td>
                <td><?php echo $todo['deadline_date']; ?></td>
                <td><?php echo $todo['completed_at']; ?></td>
                <td><?php echo $todo['display_status']; ?></td>
            </tr>
        </tbody>
    </table>
    <div>
        <button><a href="./edit.php?id=<?php echo $todo['id']; ?>">編集</a></button>
    </div>
</body>
</html>