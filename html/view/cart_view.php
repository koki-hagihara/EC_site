<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>カートの中</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/cart.css">
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
                <?php if ($user[0]['type'] === '0') { ?>
                    <a href = "admin.php">管理ページ</a>
                <?php } ?>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <div class="main">
            <div class="main_container">
                <h1>現在のカートの中</h1>
                <p>商品の合計金額は<span class="total_price"><?php print $total_price ;?>円</span>です。</p>
                <div class="table">
                    <table>
                        <tr>
                            <th>削除</th>
                            <th>商品写真</th>
                            <th>商品名</th>
                            <th>単価</th>
                            <th>個数</th>
                            <th>小計</th>
                        </tr>
<?php foreach ($rows_cart_page as $value) { ?>
                        <tr>
                            <td class="deleat"><a href="cart.php?carts_id=<?php print $value['carts_id'];?>">削除</a></td>
                            <td class="img"><img src="<?php print $img_dir.$value['img'] ;?>"></td>
                            <td class="item_name"><?php print $value['item_name'] ;?></td>
                            <td class="price"><?php print $value['price'] ;?>円</td>
                            <td class="amount">
                                <?php print $value['amount'] ;?>
                                <form method="post" action="./cart.php">
                                    <input type="hidden" name="carts_id" value="<?php print $value['carts_id'] ;?>">
                                    <input type="hidden" name="amount" value="<?php print $value['amount'] ;?>">
                                    <input type="submit" name="plus" value="&plus;">
                                    <input type="submit" name="minus" value="&minus;">
                                </form>
                            </td>
                            <td class="sub_total"><?php print $value['price']*$value['amount'] ;?></td>
                        </tr>
<?php } ?>
                        <tr>
                            <th class="caption_total_price" colspan="5">合計</th>
                            <th class="total_price"><?php print $total_price ;?>円</th>
                        </tr>
                    </table>
                </div>
                <div class="link">
                    <div class="link_top"><a href="after_login.php"><span class="link_border">お買い物を続ける</span></a></div>
                    <div class="link_buy"><a href="buy_complete.php"><span class="link_border">購入する</span></a></div>
                </div>
            </div>
        </div>
    </body>
</html>