<?php
require_once './conf/const.php';
require_once './model/function.php';

try{
    $dbh=get_db_connect();
    $sql='SELECT user_name,create_date FROM EC_users';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rows_user=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_user=entity_assoc_array($rows_user);
    
}catch(PDOException $e){
    $err_msg[]='接続エラーです。理由：'.$e->getMessage();
}



include_once './view/admin_user_view.php';