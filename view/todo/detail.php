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
    <meta http-equiv="X=UA=Compatible" content="ie=edge">
    <title>詳細画面</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>タイトル</th>
                <th>詳細</th>
                <th>締め切り</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row"><?php echo $todo['title']; ?></td>
                <td><?php echo $todo['detail']; ?></td>
                <td><?php echo $todo['completed_at']; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>