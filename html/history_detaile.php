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

try {
    $dbh = get_db_connect();

    $user = get_login_user($dbh, $user_id);

    $history_id = get_get_data('history_id');
    $order_date = get_get_data('order_date');
    $total_price = get_get_data('total_price');

    $history_details = get_history_details($dbh, $history_id);
} catch(PDOException $e) {
    $err_msg[] = 'エラーが発生しました。原因：'.$e->getMessege;
}

if (($user[0]['type'] !== '0') && ($user[0]['user_id'] !== $history_details[0]['user_id'])) {
    $err_msg[] = 'ページを表示できません';
}


include_once './view/history_detaile_view.php';