<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規会員登録画面</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/sign_up.css">
    </head>
    <body>
<?php if(count($err_msg)>0){
    foreach($err_msg as $value){
        print $value;
    }
} ?>
        <main>
            <div class="store_name">
                <h1>SELECT SHOP EMO</h1>
            </div>
            <div class="sign_up">
                <h2>新規会員登録</h2>
                <form method="post" action="./sign_up.php">
                    <div class="user_name">ユーザー名：<input type="text" name="user_name" placeholder="6文字以上18文字以下の半角英数字"></div>
                    <div class="passwd">パスワード：<input type="password" name="passwd" placeholder="6文字以上18文字以下の半角英数字"></div>
                    <div class="mail">メールアドレス：<input type="text" name="email" placeholder="sample@store.jp"></div>
                    <div class="gender">性別：<input type="radio" name="gender" value="男">男性
                        <input type="radio" name="gender" value="女">女性</div>
                    <div class="submit"><input type="submit" value="新規登録する"></div>
                </form>
<?php if (!empty($_SERVER['HTTP_REFERER'])) { ?>
                <div class="back"><a href="<?php print $_SERVER['HTTP_REFERER']; ?>">ログイン画面に戻る</a></div>
<?php } ?>
            </div>
        </main>
    </body>
</html>