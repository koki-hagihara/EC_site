<?php 
require_once './model/function.php';
require_once './conf/const.php';

session_start();

if (is_logined() === false){
    header('Location:login.php');
    exit;
} else {
    $user_id = get_session('user_id');
}

//GETで取得した商品IDを使ってデータベース参照、商品詳細画面をつくる
try{
    $dbh = get_db_connect();
    $item_id = get_get_data('item_id');
    
    $user = get_login_user($dbh, $user_id);
    
    //取得したGETが正しいものかチェック
    check_item_id($item_id);

    if (count($err_msg) === 0) {
        $sql = 'SELECT item_name, price, img, stock, rough_type_id 
                FROM EC_items 
                WHERE item_id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $item_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows_product_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows_product_details = entity_assoc_array($rows_product_details);
        if($rows_product_details[0]['stock']<=0) {
            $non_stock_msg = '在庫切れ';
        }
    }
    
    
}catch(PDOException $e){
    $err_msg[] = 'エラーが発生しました。理由：'.$e->getMessage();
}

include_once './view/product_details_view.php';