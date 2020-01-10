<?php
require_once './conf/const.php';
require_once './model/function.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['admin1'])){
        $type1=get_post_data('type1');
        if($type1===''){
            $err_msg[]='商品タイプ1を入力してください';
        }else if(preg_match($itemtype_regex,$type1)!==1){
            $err_msg[]='商品タイプ1は全角文字または半角アルファベット(大文字)で入力してください';
        }
        if(count($err_msg)===0){
            try{
                $dbh=get_db_connect();
                $sql='SELECT rough_type FROM EC_rough_type WHERE rough_type=?';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$type1,PDO::PARAM_STR);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($rows)>0){
                    $err_msg[]='すでに登録されている商品タイプです';
                }else{
                    $sql='INSERT INTO EC_rough_type (rough_type,create_date,update_date) VALUES(?,now(),now())';
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindValue(1,$type1,PDO::PARAM_STR);
                    $stmt->execute();
                    $addition_type_msg='商品タイプ1を追加しました';
                }
            }catch(PDOException $e){
                $err_msg[]='エラーが発生しました。理由：'.$e->getMessage();
            }
        }
    }else if(isset($_POST['admin2'])){
        $type2=get_post_data('type2');
        if($type2===''){
            $err_msg[]='商品タイプ2を入力してください';
        }else if(preg_match($itemtype_regex,$type2)!==1){
            $err_msg[]='商品タイプ2は全角文字または半角アルファベット(大文字)で入力してください';
        }
        if(count($err_msg)===0){
            try{
                $dbh=get_db_connect();
                $sql='SELECT details_type FROM EC_details_type WHERE details_type=?';
                $stmt=$dbh->prepare($sql);
                $stmt->bindValue(1,$type2,PDO::PARAM_STR);
                $stmt->execute();
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($rows)>0){
                    $err_msg[]='すでに登録されている商品タイプです';
                }else{
                    $sql='INSERT INTO EC_details_type (details_type,create_date,update_date) VALUES(?,now(),now())';
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindValue(1,$type2,PDO::PARAM_STR);
                    $stmt->execute();
                    $addition_type_msg='商品タイプ2を追加しました';
                }
            }catch(PDOException $e){
                $err_msg[]='エラーが発生しました。理由：'.$e->getMessage();
            }
        }
    }
}


include_once './view/admin_type_addition_view.php';