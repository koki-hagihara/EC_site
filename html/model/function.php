<?php

function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key])) {
        $str = trim($_POST[$key]);
    }
    return $str;
}


function get_get_data($key) {
    $str = '';
    if(isset($_GET[$key])) {
        $str=trim($_GET[$key]);
    }
    return $str;
}

function get_db_connect() {
    try{             //'mysql:dbname=codecamp28789;host=localhost;charset=utf8'
        $dbh = new PDO(DSN,DB_USER,DB_PASSWD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>DB_CHARSET));
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    }catch(PDOException $e) {
        throw $e;
    }
    return $dbh;
}

function entity_str($str) {
    return htmlspecialchars($str,ENT_QUOTES,HTML_CHARACTER_SET);
}

function entity_assoc_array($assoc_array) {
    foreach($assoc_array as $key=>$value) {
        foreach($value as $keys=>$values) {
            $assoc_array[$key][$keys] = entity_str($values);
        }
    }
    return $assoc_array;
}

function db_fetchAll($dbh, $sql) {
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows = entity_assoc_array($rows);
    return $rows;
}

function check_item_id($item_id) {
    //ローカルではなくグローバルな変数$err_msgであると宣言
    global $err_msg;
    if ($item_id === '') {
        $err_msg[] = '商品を選択してください';
    } else if (preg_match('/^[1-9][0-9]*$/', $item_id) !== 1) {
        $err_msg[] = '商品が正しくありません';
    }
}

function check_carts_id($carts_id) {
    global $err_msg;
    if ($carts_id === '') {
        $err_msg[] = '正しく選択してください';
    } else if (preg_match('/^[1-9][0-9]*$/', $carts_id) !== 1) {
        $err_msg[] = '不正な入力です';
    }
}

function check_amount($amount) {
    global $err_msg;
    if ($amount === '') {
        $err_msg[] = '個数を入力してください';
    } else if (preg_match('/^[1-9][0-9]*$/' , $amount) !== 1) {
        $err_msg[] = '個数が正しくありません';
    }
}

function check_item_type($rough_type_id) {
    global $err_msg;
    if ($rough_type_id === '') {
        $err_msg[] = '選択が正しくありません';
    } else if (preg_match('/^[1-9][0-9]*$/' , $rough_type_id) !== 1) {
        $err_msg[] = '不正な選択です';
    }
}

//ログイン後のページでユーザー名を表示するための関数
function after_login_get_name($dbh,$user_id) {
    try{
        $sql='SELECT user_name FROM EC_users WHERE user_id=?';
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(1,$user_id,PDO::PARAM_INT);
        $stmt->execute();
        $rows_user_name=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows_user_name=entity_assoc_array($rows_user_name);
        
        if(isset($rows_user_name[0]['user_name'])){
            $user_name=$rows_user_name[0]['user_name'];
        }else{
            header('Location:login.php');
            exit;
        }
    }catch(PDOException $e){
        throw $e;
    }
    return $user_name;
}

function total_price($rows){
    $sub_total = array();
    foreach ($rows as $value) {
        $sub_total[] =$value['price'] * $value['amount'];
    }
    $total_price = 0;
    foreach ($sub_total as $value) {
        $total_price += $value;
    }
    return $total_price;
}



function is_logined() {
    return get_session('user_id') !== '';
}

function get_session($name) {
    if (isset($_SESSION[$name]) === true) {
        return $_SESSION[$name] ;
    }
    return '';
}

function redirect_to($url) {
    header('Location:'.$url);
    exit;
}

function get_login_user($dbh, $user_id) {   
    try {
        $sql = "
                SELECT user_id, user_name, type
                FROM EC_users
                WHERE user_id = ?
                LIMIT 1
                ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user = entity_assoc_array($user);
    } catch (PDOException $e){
        throw $e;
    }
    return $user;
}

function get_all_history($dbh) {
    $sql = "
            SELECT 
            EC_history.history_id, 
            DATE_FORMAT(EC_history.datetime, \"%Y-%m-%d\") AS order_date, 
            SUM(EC_history_details.price * EC_history_details.amount) AS total_price
            FROM EC_history JOIN EC_history_details
            ON EC_history.history_id = EC_history_details.history_id
            GROUP BY EC_history_details.history_id
            ORDER BY EC_history.datetime desc
            ";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $history = entity_assoc_array($history);

    return $history;
}

function get_private_history_list($dbh, $user_id) {
    $sql = "
            SELECT 
            EC_history.history_id, 
            DATE_FORMAT(EC_history.datetime, \"%Y-%m-%d\") AS order_date, 
            SUM(EC_history_details.price * EC_history_details.amount) AS total_price
            FROM EC_history JOIN EC_history_details
            ON EC_history.history_id = EC_history_details.history_id
            WHERE EC_history.user_id = ?
            GROUP BY EC_history_details.history_id
            ORDER BY EC_history.datetime desc
            ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $history = entity_assoc_array($history);

    return $history;
}

function get_history_details($dbh, $history_id) {
    $sql = "
            SELECT 
            EC_items.item_name,
            EC_history_details.price,
            EC_history_details.amount,
            EC_history.user_id,
            EC_history_details.price * EC_history_details.amount AS sub_total_price
            FROM EC_items JOIN EC_history_details
            ON EC_items.item_id = EC_history_details.item_id JOIN EC_history
            ON EC_history_details.history_id = EC_history.history_id
            WHERE 
            EC_history_details.history_id = ?
            ";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $history_id, PDO::PARAM_INT);
    $stmt->execute();
    $history_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $history_details = entity_assoc_array($history_details);

    return $history_details;
}

function get_new_arrival($dbh) {
    $sql = "
            SELECT 
            item_id, item_name, img, price 
            FROM 
            EC_items 
            WHERE status = 1 
            ORDER BY 
            create_date desc 
            LIMIT 3
            ";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rows_new_arrival = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_new_arrival = entity_assoc_array($rows_new_arrival);

    return $rows_new_arrival;
}

function get_ranking($dbh) {
    $sql = "
            SELECT
            EC_items.img,
            EC_items.item_name,
            EC_items.price,
            EC_history_details.item_id,
            SUM(EC_history_details.amount) AS total_amount
            FROM
            EC_items JOIN EC_history_details
            ON EC_items.item_id = EC_history_details.item_id
            GROUP BY
            EC_history_details.item_id
            ORDER BY
            total_amount desc
            LIMIT 3
            ";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ranking = entity_assoc_array($ranking);

    return $ranking;
}