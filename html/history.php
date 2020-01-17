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

try {
    $dbh = get_db_connect();

    $user = get_login_user($dbh, $user_id);

    if ($user[0]['type'] === '0') {
        $history = get_all_history($dbh);
    } else if($user[0]['type'] === '1') {
        $history = get_private_history_list($dbh, $user_id);
    }

} catch(PDOException $e) {
    $err_msg[] = 'エラーが発生しました:'.$e->getMessage();
}

include_once './view/history_view.php';