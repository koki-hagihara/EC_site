<?php
require_once './model/function.php';
require_once './conf/const.php';

session_start();
if(isset($_SESSION['user_id'])){
    header('Location:after_login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_name=get_post_data('user_name');
    $passwd=get_post_data('passwd');
    if($user_name===''){
        $err_msg[]='ユーザー名を入力してください<br />';
    }else if(preg_match($user_name_regex,$user_name)!==1){
        $err_msg[]='ユーザー名は6文字以上18文字以下の半角英数字で入力してください<br />';
    }
    if($passwd===''){
        $err_msg[]='パスワードを入力してください<br />';
    }else if(preg_match($passwd_regex,$passwd)!==1){
        $err_msg[]='パスワードは6文字以上18文字以下の半角英数字で入力してください<br />';
    }
    if(count($err_msg)===0){
        try{
            $dbh=get_db_connect();
            $sql = 'SELECT user_id
                    FROM EC_users 
                    WHERE user_name=? 
                    AND password=?';
            $stmt=$dbh->prepare($sql);
            $stmt->bindValue(1,$user_name,PDO::PARAM_STR);
            $stmt->bindValue(2,$passwd,PDO::PARAM_STR);
            $stmt->execute();
            $rows_match_user=$stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(isset($rows_match_user[0]['user_id'])){
                $_SESSION['user_id']=$rows_match_user[0]['user_id'];
                header('Location:after_login.php');
                exit;
            }else{
                $err_msg[]='ユーザー名かパスワードが違います';
            }
        }catch(PDOException $e){
            $err_msg[]='エラーが発生しました。原因：'.$e->getMessage();
        }
    }
}


include_once './view/login_view.php';