<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品一覧</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/item_list.css">
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
                <a href="cart.php">CART</a>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <main>
            <div class="main_container">
                <div class="item_type_title">
                    <h1><?php print $rows_list[0]['rough_type'] ;?></h1>
                </div>
                <article>
<?php foreach ($rows_list as $value) { ?>
                    <div class="item_container">
                        <a href="product_details.php?item_id=<?php print $value['item_id'] ;?>">
                        <div class="img"><img src="<?php print $img_dir.$value['img'] ;?>"></div>
                        <div class="item_name"><?php print $value['item_name'] ;?></div>
                        <div class="price"><?php print $value['price'] ;?>円</div>
                        </a>
                    </div>
<?php } ?>
                </article>
                <div class="return_link"><a href="after_login.php">TOPページに戻る</a></div>
            </div>
        </main>
    </body>
</html>