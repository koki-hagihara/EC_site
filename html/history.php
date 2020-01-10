<?php
require_once './model/function.php';
require_once './conf/const.php';

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location:login.php');
    exit;
}
$data = array();

try {
    $dbh = get_db_connect();
    
    $sql = 'SELECT 
            EC_history_details.price,
            EC_history_details.amount,
            DATE_FORMAT(EC_history.datetime, \'%Y-%m-%d\'),
            EC_items.item_name,
            EC_items.img
            FROM EC_history_details INNER JOIN EC_history
            ON EC_history_details.history_id = EC_history.history_id
            INNER JOIN EC_items
            ON EC_items.item_id = EC_history_details.item_id
            WHERE EC_history.user_id = ?
            ORDER BY datetime desc';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $rows_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_history = entity_assoc_array($rows_history);
    

    
} catch(PDOException $e) {
    $err_msg[] = 'エラーが発生しました。原因：' .$e->getMessage();
}


include_once './view/history_view.php';