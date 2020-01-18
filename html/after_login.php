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

try{
    $dbh=get_db_connect();
    
    $user = get_login_user($dbh, $user_id);
    
    $rows_new_arrival = get_new_arrival($dbh);

    $ranking = get_ranking($dbh);

    $rank_number = 1;

}catch(PDOException $e){
    $err_msg[]='エラーが発生しました。原因：'.$e->getMessage();
}


include_once './view/after_login_view.php';