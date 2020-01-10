<?php
require_once './model/function.php';
require_once './conf/const.php';

session_start();
if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}else{
    header('Location:login.php');
    exit;
}

try {
    $dbh = get_db_connect();
    $rough_type_id = get_get_data('rough_type_id');
    
    $user_name = after_login_get_name($dbh,$user_id);
    
    check_item_type($rough_type_id);
    
    if (count($err_msg) === 0) {

        
        $sql = 'SELECT
                EC_items.item_id,
                EC_items.item_name,
                EC_items.price,
                EC_items.img,
                EC_rough_type.rough_type
                FROM EC_items
                INNER JOIN EC_rough_type
                ON EC_items.rough_type_id = EC_rough_type.rough_type_id
                WHERE EC_items.status = 1 AND EC_items.stock > 0 AND EC_rough_type.rough_type_id = ?';
                
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $rough_type_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows_list = entity_assoc_array($rows_list);
    }
} catch(PDOException $e) {
    $err_msg[] = 'エラーが発生しました。：' .$e->getMessage();
}

include_once './view/item_list_view.php';