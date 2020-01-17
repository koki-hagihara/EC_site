<?php 
require_once './model/function.php';
require_once './conf/const.php';

session_start();

if (is_logined() === false) {
    header('Location:login.php');
    exit;
} else {
    $user_id = get_session('user_id');
}

//if (isset($_SESSION['user_id'])) {
//    $user_id = $_SESSION['user_id'];
//} else {
//    header('Location:login.php');
//    exit;
//}


try{
    $dbh=get_db_connect();
    
    $user = get_login_user($dbh, $user_id);
    
        //新しくテーブルに追加された商品3点のデータを取得
    $sql = 'SELECT item_id, item_name, img, price 
            FROM EC_items 
            WHERE status = 1 
            order by create_date desc limit 3';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rows_new_arrival = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_new_arrival = entity_assoc_array($rows_new_arrival);
}catch(PDOException $e){
    $err_msg[]='エラーが発生しました。原因：'.$e->getMessage();
}



include_once './view/after_login_view.php';