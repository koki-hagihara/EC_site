<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TOPページ</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/after_login.css">
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
                <?php if ($user[0]['type'] === 0) { ?>
                    <a href = "admin.php">管理ページ</a>
                <?php } ?>
                <a href="logout.php">LOG OUT</a>
            </div>
        </header>
        <img class="main_img" src="./front_img/REEEclark-street-mercantile-P3pI6xzovu0-unsplash.jpg">
        <div class="main">
            <div class="type_menu">
                <ul>
                    <li><a href="item_list.php?rough_type_id=7">トップス</a></li>
                    <li><a href="item_list.php?rough_type_id=12">ボトムス</a></li>
                    <li><a href="item_list.php?rough_type_id=8">アウター</a></li>
                </ul>
            </div>
            <!--新入荷3点の情報を横並びで表示-->
            <div class="new_arrival">
                <div class="new_arrival_title">
                    <h1>NEW&nbsp;ARRIVAL</h1>
                </div>
                <div class="new_arrival_contents">
                    <div class="new_arrival_block">
<?php foreach($rows_new_arrival as $value){ ?>
                        <a href="product_details.php?item_id=<?php print $value['item_id'];?>" class="new">
                            <figure>
                                <img src="<?php print $img_dir.$value['img'];?>">
                                <figcaption class="item_name"><?php print $value['item_name'];?></figcaption>
                                <figcaption class="price"><?php print $value['price'];?>円</figcaption>
                            </figure>
                        </a>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>
