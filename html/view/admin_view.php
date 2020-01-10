<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品管理ページ</title>
        <link rel="stylesheet" href="./view/css/html5reset-1.6.1.css">
        <link rel="stylesheet" href="./view/css/admin.css">
    </head>
    <body>
        <?php if(count($err_msg)>0){
            foreach($err_msg as $value){
                print $value;
            }
        } ?>
        <?php if($addition_item_msg!==''){
            print $addition_item_msg;
        } ?>
        <div class="head_container">
            <h1>管理ページ</h1>
            <a href="admin_user.php">ユーザー管理ページへ</a>
            <a href="after_login.php">SHOPページへ</a>
        </div>
        <div class="middle_container">
            <h2>商品の登録</h1>
            <form method="post" action="./admin.php" enctype="multipart/form-data">
                <div><label>商品名：<input type="text" name="item_name"></label></div>
                <div><label><span class="mgr10">値</span>段：<input type="text" name="price"></label></div>
                <div><label>在庫数：<input type="text" name="stock"></label></div>
                <div>商品画像：<input type="file" name="img"></div>
                <div>商品タイプ1：<select name="rough_type">
                    <option value="">選択してください</option>
                    <?php foreach($rows1 as $key=>$value){ ?>
                        <option value="<?php print $value['rough_type_id'];?>"><?php print $value['rough_type'];?></option>
                    <?php } ?>
                </select></div>
                <div>商品タイプ2：<select name="details_type">
                    <option value="">選択してください</option>
                    <?php foreach($rows2 as $key=>$value){ ?>
                        <option value="<?php print $value['details_type_id'];?>"><?php print $value['details_type'];?></option>
                    <?php } ?>
                </select></div>
                <a href="./admin_type_addition.php">商品タイプ追加ページへ</a>
                <div>ステータス：<select name="status">
                    <option value="0">非公開</option>
                    <option value="1">公開</option>
                </select></div>
                <div><label>商品詳細：<input type="text" name="comment"></label></div>
                <input type="submit" name="insert" value="商品を登録する">
            </form>
        </div>
        <div class="foot_container">
            <h2>商品情報の一覧・変更</h2>
            <table>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>商品タイプ1</th>
                    <th>商品タイプ2</th>
                    <th>商品詳細</th>
                    <th>ステータス</th>
                    <th>操作</th>
                </tr>
                <?php foreach($rows3 as $value){ ?>
                    <tr>
                        <td><img src="<?php print $img_dir.$value['img'];?>"></td>
                        <td><?php print $value['item_name'];?></td>
                        <td><?php print $value['price'];?>円</td>
                        <td>
                            <form method="post" action="./admin.php">
                                <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>">
                                <input type="text" class="change_stock" size=2 name="change_stock" value="<?php print $value['stock'];?>">個
                                <input type="submit" name="update_stock" value="変更する">
                            </form>
                        </td>
                        <td><?php print $value['rough_type'];?></td>
                        <td><?php print $value['details_type'];?></td>
                        <td><?php print $value['comment'];?></td>
                        <td>
                            <form method="post" action="./admin.php">
                                <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>">
                                <?php if($value['status']==='0'){ ?>
                                    <input type="hidden" name="update_status" value="1">
                                    <input type="submit" name="change_status" value="非公開→公開">
                                <?php } else if($value['status']==='1'){ ?>
                                    <input type="hidden" name="update_status" value="0">
                                    <input type="submit" name="change_status" value="公開→非公開">
                                <?php } ?>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="./admin.php">
                                <input type="hidden" name="item_id" value="<?php print $value['item_id'];?>">
                                <input type="submit" name="delete_item" value="削除する">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>