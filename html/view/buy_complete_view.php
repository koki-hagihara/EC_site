<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>購入完了</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/buy_complete.css">
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
                <?php if ($user[0]['type'] === '0') { ?>
                    <a href = "admin.php">管理ページ</a>
                <?php } ?>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <main>
            <div class="main_msg">
<?php if (count($err_msg) > 0) { ?>
                <h1>以下の商品がご購入いただけません</h1>
    <?php foreach ($err_msg as $value) {
        print $value;
    } ?>
                <a href="cart.php">カートに戻る</a>
<?php } ?>
<?php if (count($err_msg) === 0) { ?>
                <h1>ご購入ありがとうございました！</h1>
            </div>
            <div class="main_table">
                <table>
                    <tr>
                        <th>商品写真</th>
                        <th>商品名</th>
                        <th>単価</th>
                        <th>個数</th>
                        <th>小計</th>
                    </tr>
    <?php foreach ($rows_buy as $value) { ?>
                    <tr>
                        <td><img src="<?php print $img_dir.$value['img'] ;?>"></td>
                        <td><?php print $value['item_name'] ;?></td>
                        <td><?php print $value['price'] ;?></td>
                        <td><?php print $value['amount'] ;?></td>
                        <td><?php print $value['price'] * $value['amount'] ;?>円</td>
                    </tr>
    <?php } ?>
                    <tr>
                        <th class="caption_total_price" colspan="4">合計</th>
                        <th class="total_price"><?php print $total_price ;?>円</th>
                    </tr>
<?php } ?>
                </table>
            </div>
        </main>
    </body>
</html>