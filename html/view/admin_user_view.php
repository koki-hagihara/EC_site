<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ユーザー管理ページ</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/admin_user.css">
    </head>
    <body>
        <?php if(count($err_msg)>0){
            print $err_msg;
        } ?>
        
        <div class="head_container">
            <h1>管理ページ</h1>
            <a href="admin.php">商品管理ページ</a>
        </div>
        <div class="second_container">
            <h2>ユーザー情報一覧</h2>
            <table>
                <tr>
                    <th>ユーザー名</th>
                    <th>登録日</th>
                </tr>
                <?php foreach($rows_user as $value){ ?>
                    <tr>
                        <td><?php print $value['user_name'];?></td>
                        <td><?php print $value['create_date'];?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>