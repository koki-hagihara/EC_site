<?php
require_once './model/function.php';
require_once './conf/const.php';

session_start();
if(isset($_SESSION['user_id']) ){
    $user_id=$_SESSION['user_id'];
}else{
    header('Location:login.php');
    exit;
}
try {
    $dbh = get_db_connect();
    
    //ログイン後ページで$user_nameを表示するための関数呼び出し
    $user_name=after_login_get_name($dbh,$user_id);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //カートに入れるボタンが押されたら
        if(isset($_POST['add_cart'])) {
            //ユーザーがカートに追加した商品IDと数量を取得
            $item_id = get_post_data('item_id');
            $amount = get_post_data('amount');
            
            check_item_id($item_id);
            check_amount($amount);
            
            if (count($err_msg) === 0) {        
            //同じユーザーが同じ商品をすでにカートに追加していないか調べる
                $sql = 'SELECT item_id
                        FROM EC_carts
                        WHERE user_id = ? AND item_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
                $stmt->bindValue(2, $item_id, PDO::PARAM_INT);
                $stmt->execute();
                $rows_cart_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //もし該当のデータが存在すれば数量を更新
                if (isset($rows_cart_search[0])){
                    $sql = 'UPDATE EC_carts
                            SET amount = amount + ?, update_date = now()
                            WHERE user_id = ? AND item_id = ?';
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $amount, PDO::PARAM_INT);
                    $stmt->bindValue(2, $user_id, PDO::PARAM_INT);
                    $stmt->bindValue(3, $item_id, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $sql = 'INSERT INTO EC_carts (user_id, item_id, amount, create_date, update_date)
                        VALUES (?, ?, ?, now(), now())';
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
                    $stmt->bindValue(2, $item_id, PDO::PARAM_INT);
                    $stmt->bindValue(3, $amount, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        } else if (isset($_POST['plus'])) {
            $carts_id = get_post_data('carts_id');
            check_carts_id($carts_id);
            if (count($err_msg) === 0) {
                $sql = 'UPDATE EC_carts
                        SET amount = amount + 1, update_date = now()
                        WHERE carts_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $carts_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else if (isset($_POST['minus'])) {
            $carts_id = get_post_data('carts_id');
            $carts_amount = get_post_data('amount');
            check_carts_id($carts_id);
            if (count($err_msg) === 0 && $carts_amount > 1) {
                $sql = 'UPDATE EC_carts
                        SET amount = amount - 1, update_date = now()
                        WHERE carts_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $carts_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }
            //削除ボタンを押されたときの処理
    $carts_id = get_get_data('carts_id');
    //取得したGETが正しいものかチェック
    check_carts_id($carts_id);
    
    if (count($err_msg) === 0) {
        $sql = 'DELETE 
                FROM EC_carts
                WHERE carts_id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $carts_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    $sql = 'SELECT 
            EC_items.img,
            EC_items.item_name,
            EC_items.price,
            EC_carts.carts_id,
            EC_carts.item_id,
            EC_carts.amount
            FROM EC_items INNER JOIN EC_carts
            ON EC_items.item_id = EC_carts.item_id
            WHERE EC_carts.user_id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $rows_cart_page = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows_cart_page = entity_assoc_array($rows_cart_page);

    $total_price = total_price($rows_cart_page);
    

} catch(PDOException $e) {
    $err_msg[] = 'エラーが発生しました。もう一度お試しください。理由：' .$e->getMessage();
}

include_once './view/cart_view.php';