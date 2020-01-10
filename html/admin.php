<?php
require_once './model/function.php';
require_once './conf/const.php';

try{
    $dbh = get_db_connect();
    $sql = 'SELECT rough_type_id, rough_type 
            FROM EC_rough_type';
    $rows1 = db_fetchAll($dbh, $sql);
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $rows1 = entity_assoc_array($rows1);
    
    $sql = 'SELECT details_type_id, details_type 
            FROM EC_details_type';
    $rows2 = db_fetchAll($dbh, $sql);
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $rows2 = entity_assoc_array($rows2);

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['insert'])){
            $item_name=get_post_data('item_name');
            $price=get_post_data('price');
            $stock=get_post_data('stock');
            $type1=get_post_data('rough_type');
            $type2=get_post_data('details_type');
            $status=get_post_data('status');
            $comment=get_post_data('comment');
            
            if($item_name===''){
                $err_msg[]='商品名を入力してください';
            }
            if($price===''){
                $err_msg[]='値段を入力してください';
            }else if(preg_match($num_regex,$price)!==1){
                $err_msg[]='値段は半角数字で入力してください';
            }
            if($stock===''){
                $err_msg[]='在庫数を入力してください';
            }else if(preg_match($num_regex,$stock)!==1){
                $err_msg[]='在庫数は半角数字で入力してください';
            }
            if($type1===''){
                $err_msg[]='商品タイプ1を選択してください';
            }else if(preg_match($num_regex,$type1)!==1){
                $err_msg[]='商品タイプ1を正しく入力してください';
            }
            if($type2===''){
                $err_msg[]='商品タイプ2を選択してください';
            }else if(preg_match($num_regex,$type2)!==1){
                $err_msg[]='商品タイプ2を正しく入力してください';
            }
            if(preg_match($status_regex,$status)!==1){
                $err_msg[]='ステータス値が不正です';
            }
            
            if(is_uploaded_file($_FILES['img']['tmp_name'])){
                $extension=pathinfo($_FILES['img']['name'],PATHINFO_EXTENSION);
                if($extension==='jpg'||$extension==='jpeg'||$extension==='png'){
                    $new_img_filename=sha1(uniqid(mt_rand(),true)).'.'.$extension;
                    if(is_file($img_dir.$new_img_filename)!==TRUE){
                        if(move_uploaded_file($_FILES['img']['tmp_name'],$img_dir.$new_img_filename)!==TRUE){
                            $err_msg[]='ファイルアップロードに失敗しました';
                        }
                    }else{
                        $err_msg[]='ファイルアップロードに失敗しました。再度お試しください';
                    }
                }else{
                    $err_msg[]='ファイル形式が異なります。画像ファイルはJPEG、PNGのみアップロード可能です。';
                }
            }else{
                $err_msg[]='画像ファイルを選択してください';
            }
            if(count($err_msg)===0){
                $sql='INSERT INTO EC_items
                    (item_name,price,img,status,stock,rough_type_id,details_type_id,comment,create_date,update_date)
                    VALUES (?,?,?,?,?,?,?,?,now(),now())';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$item_name,PDO::PARAM_STR);
                $stmt->bindValue(2,$price,PDO::PARAM_INT);
                $stmt->bindValue(3,$new_img_filename,PDO::PARAM_STR);
                $stmt->bindValue(4,$status,PDO::PARAM_INT);
                $stmt->bindValue(5,$stock,PDO::PARAM_INT);
                $stmt->bindValue(6,$type1,PDO::PARAM_INT);
                $stmt->bindValue(7,$type2,PDO::PARAM_INT);
                $stmt->bindValue(8,$comment,PDO::PARAM_STR);
                $stmt->execute();
                $addition_item_msg='商品の登録ができました';
            }
        }else if(isset($_POST['update_stock'])){
            $item_id=get_post_data('item_id');
            $stock=get_post_data('change_stock');
            if(preg_match($num_regex,$stock)!==1){
                $err_msg[]='在庫数は半角数字で入力してください';
            }
            if(count($err_msg)===0){
                $sql='UPDATE EC_items SET stock=?,update_date=now() WHERE item_id=?';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$stock,PDO::PARAM_INT);
                $stmt->bindValue(2,$item_id,PDO::PARAM_INT);
                $stmt->execute();
                $addition_item_msg='在庫数の変更ができました';
            }
        }else if(isset($_POST['change_status'])){
            $item_id=get_post_data('item_id');
            $status=get_post_data('update_status');
            if(preg_match($status_regex,$status)!==1){
                $err_msg[]='ステータス値が不正です';
            }
            if(count($err_msg)===0){
                $sql='UPDATE EC_items SET status=?,update_date=now() WHERE item_id=?';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$status,PDO::PARAM_INT);
                $stmt->bindValue(2,$item_id,PDO::PARAM_INT);
                $stmt->execute();
                $addition_item_msg='ステータス変更ができました';
            }
        }else if(isset($_POST['delete_item'])){
            $item_id=get_post_data('item_id');
            $sql='DELETE FROM EC_items WHERE item_id=?';
            $stmt=$dbh->prepare($sql);
            $stmt->bindValue(1,$item_id,PDO::PARAM_INT);
            $stmt->execute();
            $addition_item_msg='商品データを1件削除しました';
        }
    }
    $sql = 'SELECT
            EC_items.item_id,
            EC_items.img,
            EC_items.item_name,
            EC_items.price,
            EC_items.stock,
            EC_rough_type.rough_type,
            EC_details_type.details_type,
            EC_items.comment,
            EC_items.status
            FROM EC_items INNER JOIN EC_rough_type 
            ON EC_items.rough_type_id=EC_rough_type.rough_type_id
            INNER JOIN EC_details_type 
            ON EC_items.details_type_id=EC_details_type.details_type_id
            order by EC_items.create_date desc';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rows3=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows3=entity_assoc_array($rows3);
}catch(PDOException $e){
    $err_msg[]='エラーが発生しました。理由：'.$e->getMessage();
}


include_once './view/admin_view.php';

?>