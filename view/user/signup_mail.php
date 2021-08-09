<?php
require_once '../../config/database.php';
require_once './../../controller/TodoController.php';
require_once './../../controller/LoginController.php';

session_start();
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//DB情報
// $user = 'user';
// $password = 'password';
// $dbName = "sample";
//$host = 
$errors = array();
// $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
// $pdo = new PDO($dsn,$user,$password);
// $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
} catch (PDOException $e) {
    echo 'データベースにアクセスできません!' . $e->getMessage();
    exit;
}

//送信ボタンをクリックした後の処理
if(isset($_POST['submit'])) {
    if(empty($_POST['email'])) {
        $errors['email'] = 'メールアドレスが未入力です。';
    } else {
        //POSTされたデータを変数に入れる
        $email = isset($_POST['email']) ? $_POST['email'] : NULL;

        //メールアドレス構文チェック
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z-0-9\._-]+)+$/",$email)) {
            $errors['email_check'] = "メールアドレスの形式が正しくありません。";
        }

        //DB確認
        $sql = "SELECT id FROM users WHERE email=:email";
        $stmh = $dbh->prepare($sql);
        $stmh->bindValue(':email',$email, PDO::PARAM_STR);

        $stmh->execute();
        $result = $stmh->fetch(PDO::FETCH_ASSOC);

        if(isset($result["id"])) {
            $errors['user_check'] = "このメールアドレスはすでに利用されております。";
        }
    }

    //エラーがなければpre_userテーブルにインサート
    if(count($errors) === 0) {
        $urltoken = hash('sha256',uniqid(rand(),1));
        $url = "http://localhost:8000/view/user/new.php?urltoken=".$urltoken;

        //データベースに登録
        try{
            $sql = "INSERT INTO pre_user (urltoken, email,date,flag) VALUES (:urltoken,:email,now(),'0')";
            $stmh = $dbh->prepare($sql);
            $stmh->bindValue(':urltoken',$urltoken,PDO::PARAM_STR);
            $stmh->bindValue(':email',$email, PDO::PARAM_STR);
            $stmh->execute();
            $dbh = null;
            $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録ください。";
        } catch (PDOException $e) {
            print('Error:'.$e->getMessage());
            die();
        }

        //メール送信処理
        $mailTo = $email;
        $registration_subject = "本登録URLの送付";
        $body = <<< EOM
        この度はご登録いただきありがとうございます。
        24時間以内に下記のURLからご登録ください。
        {$url}
    EOM;
        mb_language('ja');
        mb_internal_encoding('utf-8');

    //     FROMヘッダーを作成
        $header = 'From:oott0228@gmail.com';

        if(mb_send_mail($mailTo,$registration_subject,$body,$header)) {
    //         セッションの変数を全て解除
            $_SESSION = array();
    //         クッキーの削除
            if(isset($_COOKIE["PHPSESSID"])) {
                setcookie("PHPSESSID",'',time() - 1800,'/');
            }
    //         セッションを破棄する
            session_destroy();
            $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録ください。";
        }
    }
}

 ?>
<h1>仮会員登録画面</h1>
<?php if(isset($_POST['submit']) && count($errors) === 0): ?>
    <!-- 登録完了画面 -->
    <p><?=$message?></p>
    <p>TEST用：（後ほど削除）：このURLが記載されたメールが届きます。</p>
    <a href="<?=$url?>"><?=$url?></a>
<?php else: ?>
<!-- 登録画面 -->
    <?php if(count($errors) > 0): ?>
        <?php
        foreach($errors as $value) {
            echo "<p class='error'>".$value."</p>";
        }
        ?>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <p>メールアドレス：<input type="text" name="email" size="50" value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];}?>"></p>
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="submit" name="submit" value="送信">
    </form>
<?php endif; ?>

    



