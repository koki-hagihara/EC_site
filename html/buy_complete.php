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


$rows_buy=array();
try {
    $dbh = get_db_connect();
    
    $user = get_login_user($dbh, $user_id);
    
    $sql = 'SELECT 
            EC_items.img,
            EC_items.item_name,
            EC_items.price,
            EC_items.stock,
            EC_items.status,
            EC_carts.item_id,
            EC_carts.amount
            FROM EC_items INNER JOIN EC_carts
            ON EC_items.item_id = EC_carts.item_id
            WHERE EC_carts.user_id = ?'; 
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user[0]['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $rows_buy = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_buy = entity_assoc_array($rows_buy);
    
    foreach ($rows_buy as $value) {
        if($value['status'] !== '1') {
            $err_msg[] = 'この商品は購入できません：' .$value['item_name'].'<br />' ;
        }
        if($value['stock'] < $value['amount']) {
            $err_msg[] = '在庫がありません：' .$value['item_name'].'<br />' ;
        }
    }
    if (count($err_msg) === 0) {
        try {
            //トランザクション開始
            $dbh->beginTransaction();
            
            //購入分だけ在庫を減らす
            foreach ($rows_buy as $value) {
                $sql = 'UPDATE EC_items 
                        SET stock = stock - ?, update_date = now()
                        WHERE item_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $value['amount'],PDO::PARAM_INT);
                $stmt->bindValue(2, $value['item_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
            //購入分をカートから消す
            $sql = 'DELETE FROM EC_carts
                    WHERE user_id = ?';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $user_id,PDO::PARAM_INT);
            $stmt->execute();
            
            //EC_historyに購入履歴残す
            $sql = 'INSERT INTO EC_history (user_id, datetime)
                    VALUES (?, now())';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            //EC_history_detailsに購入履歴の詳細残す
            //history_idがEC_historyの値と違わないように注意
            $history_id = $dbh->lastInsertId();
            foreach ($rows_buy as $value) {
                $sql = 'INSERT INTO EC_history_details (history_id, item_id, price, amount, create_date)
                        VALUES (?, ?, ?, ?, now())';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $history_id, PDO::PARAM_INT);
                $stmt->bindValue(2, $value['item_id'], PDO::PARAM_INT);
                $stmt->bindValue(3, $value['price'], PDO::PARAM_INT);
                $stmt->bindValue(4, $value['amount'], PDO::PARAM_INT);
                $stmt->execute();
            }
            
            $dbh->commit();
        } catch(PDOException $e) {
            $dbh->rollback();
            throw $e;
        }
        $total_price = total_price($rows_buy);
    }
} catch(PDOException $e) {
    $err_msg[]='エラーが発生しました。理由：' .$e->getMessage();
}


include_once './view/buy_complete_view.php';