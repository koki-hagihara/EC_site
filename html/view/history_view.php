<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>購入履歴</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/history.css">
    </head>
    <body>
        <header>
            <div class="header_logo">
                <a class="logo" href="after_login.php">SELECT SHOP EMO</a>
            </div>
            <div class="header_link">
                <p class="welcome_msg">ようこそ！<?php print $user_name;?>様</p>
                <a href="after_login.php">TOP</a>
                <a href="history.php">購入履歴</a>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <main>
            <div class="main_title">
                <h1>購入履歴</h1>
            </div>
            <div class="main_container">
                <table>
                    <tr>
                        <th>購入日</th>
                        <th>商品写真</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>数量</th>
                    </tr>
<?php foreach ($rows_history as $value) { ?>
                    <tr>
                        <td><?php print $value['DATE_FORMAT(EC_history.datetime, \'%Y-%m-%d\')'];?></td>
                        <td><img class="item_img" src="<?php print $img_dir.$value['img'];?>"></td>
                        <td><?php print $value['item_name'];?></td>
                        <td><?php print $value['price'];?></td>
                        <td><?php print $value['amount'];?></td>
                    </tr>
<?php } ?>
                </table>
            </div>
        </main>
    </body>
</html>