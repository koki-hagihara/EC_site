<?php
require_once './model/function.php';
require_once './conf/const.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $user_name=get_post_data('user_name');
    $passwd=get_post_data('passwd');
    $email=get_post_data('email');
    $gender=get_post_data('gender');
    if($user_name===''){
        $err_msg[]='ユーザー名を入力してください';
    }else if(preg_match($user_name_regex,$user_name)!==1){
        $err_msg[]='ユーザー名は4文字以上18文字以下の半角英数字で入力してください';
    }
    if($passwd===''){
        $err_msg[]='パスワードを入力してください';
    }else if(preg_match($passwd_regex,$passwd)!==1){
        $err_msg[]='パスワードは4文字以上18文字以下の半角英数字で入力してください';
    }
    if($email===''){
        $err_msg[]='メールアドレスを入力してください';
    }else if(preg_match($email_regex,$email)!==1){
        $err_msg[]='メールアドレスを正しく入力してください';
    }
    if($gender===''){
        $err_msg[]='性別を選択してください';
    }
    if(count($err_msg)===0){
        try{
            $dbh=get_db_connect();
            $sql='SELECT user_name,email FROM EC_users WHERE user_name=? OR email=?';
            $stmt=$dbh->prepare($sql);
            $stmt->bindValue(1,$user_name,PDO::PARAM_STR);
            $stmt->bindValue(2,$email,PDO::PARAM_STR);
            $stmt->execute();
            $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if($row[0]['user_name']===$user_name){
                $err_msg[]='このユーザー名はすでに登録されています';
            }
            if($row[0]['email']===$email){
                $err_msg[]='このメールアドレスはすでに登録されています';
            }
            if(count($err_msg)===0){
                $sql='INSERT INTO EC_users 
                    (user_name,password,email,gender,create_date,update_date)
                    VALUES (?,?,?,?,now(),now())';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$user_name,PDO::PARAM_STR);
                $stmt->bindValue(2,$passwd,PDO::PARAM_STR);
                $stmt->bindValue(3,$email,PDO::PARAM_STR);
                $stmt->bindValue(4,$gender,PDO::PARAM_STR);
                $stmt->execute();
                header('Location:./sign_up_result.php');
                exit;
            }
        }catch(PDOException $e){
            $err_msg[]='接続エラー 理由：'.$e->getMessage();
        }
    }
}

include_once './view/sign_up_view.php';