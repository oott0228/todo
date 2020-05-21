<?php
require_once './../../controller/TodoController.php';

$controller = new TodoController;
$todo = $controller->detail();

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
                <th>ステータス</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row"><?php echo $todo['title']; ?></td>
                <td><?php echo $todo['detail']; ?></td>
                <td><?php echo $todo['completed_at']; ?></td>
                <td><?php echo $todo['display_status']; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>