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
            <div class="main_title">
                <h1>購入履歴</h1>
            </div>
            <div class="main_container">
                <table>
                    <tr>
                        <th>注文番号</th>
                        <th>購入日</th>
                        <th>合計金額</th>
                    </tr>
<?php foreach ($history as $value) { ?>
                    <tr>
                        <td><?php print $value['history_id'];?></td>
                        <td><?php print $value['order_date'];?></td>
                        <td>
                            <?php print $value['total_price'];?>円
                            <a href="history_detaile.php?history_id=<?php print $value['history_id'];?>&order_date=<?php print $value['order_date'];?>&total_price=<?php print $value['total_price'];?>">購入明細表示</a>
                        </td>
                    </tr>
<?php } ?>
                </table>
            </div>
        </main>
    </body>
</html>