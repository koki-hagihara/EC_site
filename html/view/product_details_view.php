<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品詳細ページ</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/product_details.css">
    </head>
    <body>
        <header>
            <div class="header_logo">
                <a class="logo" href="after_login.php">SELECT SHOP EMO</a>
            </div>
            <div class="header_link">
<?php if (isset($_SESSION['user_id'])) { ?>
                <p class="welcome_msg">ようこそ！<?php print $user[0]['user_name'];?>様</p>    
<?php } ?>
                <a href="after_login.php">TOP</a>
                <a href="history.php">購入履歴</a>
                <a href="cart.php">CART</a>
                <?php if ($user[0]['type'] === '0') { ?>
                    <a href = "admin.php">管理ページ</a>
                <?php } ?>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <div class="product_details">
<?php if (count($err_msg) === 0) { ?>
            <div class="product_img"><img  src="<?php print $img_dir.$rows_product_details[0]['img'];?>"></div>
            <div class="product_text">
                <h2><?php print $rows_product_details[0]['item_name'];?></h2>
    <?php if($non_stock_msg === '') { ?>
                <p>¥&nbsp;<?php print $rows_product_details[0]['price'];?></p>
                <form method="post" action="./cart.php">
                    <input type="hidden" name="item_id" value="<?php print $item_id;?>">
                    個数<input class="amount" type="text" name="amount" value="1"><input class="submit" type="submit" name="add_cart" value="カートに入れる">
                </form>
        <?php if (!empty($_SERVER['HTTP_REFERER'])) { ?>
                <div class="return_link"><a href="<?php print $_SERVER['HTTP_REFERER']; ?>">前のページに戻る</a></div>
        <?php } ?>
    <?php } else { ?>
                <p><?php print $non_stock_msg ;?></p>
        <?php if (!empty($_SERVER['HTTP_REFERER'])) { ?>
                <div class="return_link"><a href="<?php print $_SERVER['HTTP_REFERER']; ?>">前のページに戻る</a></div>
        <?php } 
    } 
} ?>
            </div>
        </div>
    </body>
</html>