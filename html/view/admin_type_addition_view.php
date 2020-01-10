<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品タイプ追加ページ</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/admin_type_addition.css">
    </head>
    <body>
        <?php if($addition_type_msg!==''){
            print $addition_type_msg;
        } ?>
        <?php if(count($err_msg)>0){
            foreach($err_msg as $value){
                print $value;
            }
        } ?>
        <div class="first_container">
            <h1>商品タイプ追加ページ</h1>
            <a href="admin.php">管理ページへ</a>
        </div>
        <div class="second_container">
            <form method="post" action="admin_type_addition.php">
                <div>商品タイプ1</div>
                <div>(トップス、ボトムス、アウターなど．．．)</div>
                <div><input type="text" name="type1"></div>
                <div><input type="submit" name="admin1" value="タイプ1を追加する"</div>
            </form>
            <form method="post" action="admin_type_addition.php">
                <div>商品タイプ2</div>
                <div>(Tシャツ、パーカー、デニムなど．．．)</div>
                <div><input type="text" name="type2"></div>
                <div><input type="submit" name="admin2" value="タイプ2を追加する"/div>
            </form>
        </div>
    </body>
</html>