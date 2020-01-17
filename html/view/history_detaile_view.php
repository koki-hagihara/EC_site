<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>購入明細</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/history_detaile.css">
    </head>
    <body>
        <header>
            <div class="header_logo">
                <a class="logo" href="after_login.php">SELECT SHOP EMO</a>
            </div>
            <div class="header_link">
                <p class="welcome_msg">ようこそ！<?php print $user[0]['user_name'];?>様</p>
                <a href="after_login.php">TOP</a>
                <a href="history.php">購入履歴</a>
                <a href="cart.php">CART</a>
                <?php if ($user[0]['type'] === '0') { ?>
                    <a href = "admin.php">管理ページ</a>
                <?php } ?>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <main>
<?php if (count($err_msg) > 0) { 
    foreach ($err_msg as $value) { ?>
        <p><?php print $value;?></p>
    <?php } ?>
<?php } ?>
            <div class = "main_title">
                <h1>購入明細</h1>
            </div>
<?php if (count($err_msg) === 0) { ?>
            <div class = "main_container">
                <div class ="history">
                    <p class = "order_number">注文番号：<?php print $history_id;?></p>
                    <p class = "buy_date">購入日：<?php print $order_date;?></p>
                    <p class = "total_price">合計金額：<?php print $total_price;?></p>
                </div>
                    <table>
                        <tr>
                            <th>商品名</th>
                            <th>商品価格</th>
                            <th>購入数</th>
                            <th>小計</th>
                        </tr>
    <?php foreach ($history_details as $value) { ?>
                        <tr>
                            <td><?php print $value['item_name'];?></td>
                            <td><?php print $value['price'];?></td>
                            <td><?php print $value['amount'];?></td>
                            <td><?php print $value['sub_total_price'];?></td>
                        </tr>
    <?php } ?> 
                </table>
            </div>
<?php } ?>
        </main>
    </body>
</html>