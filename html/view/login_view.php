<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログイン画面</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/login.css">
    </head>
    <body>
        <main>
            <div class="store_name">
                <h1>SELECT SHOP EMO</h1>
            </div>
            <div class="log_in">
                <h2>会員ログイン</h2>
<?php if(count($err_msg)>0){
    foreach($err_msg as $value){
        print $value;
    }
} ?>
                <form method="post" action="./login.php">
                    <div class="user_name">
                        <label for="user_name">ユーザー名</label>
                        <input type="text" name="user_name" placeholder="ユーザー名" id="user_name">
                    </div>
                    <div class="passwd">
                        <label for="passwd">パスワード</label>
                        <input type="password" name="passwd" placeholder="6文字以上の半角英数字" id="passwd">
                    </div>
                    <div class="login">
                        <input type="submit" value="ログイン">
                    </div>
                </form>
                <div class="sign_up">
                    <a href="sign_up.php">新規登録はこちら</a>
                </div>
            </div>
        </main>
    </body>
</html>