<?php

$item_id = '';
$item_name = '';
$price = '';
$stock = '';
$status = '';
$comment = '';
$carts_id = '';
$carts_amount = '';
$rough_type_id = '';
$history = '';

$user_id = '';
$user_name = '';
$passwd = '';
$email = '';
$gender = '';
$amount = '';

$img_dir = './img/';
$new_img_filename = '';

$type1 = '';
$type2 = '';

$addition_type_msg = '';
$addition_item_msg = '';
$sign_up_msg = '';
$err_msg = array();

$non_stock_msg = '';

//半角カタカナは除く
$itemtype_regex = '/^[A-Z ぁ-んァ-ン一-龥]+$/';
//半角数字のみ
$num_regex = '/^[0-9]+$/';
//半角0か1のみ
$status_regex = '/^[01]$/';
//http://ssk-development.blogspot.com/2013/08/blog-post.html
$user_name_regex = '/^[a-zA-Z0-9]{4,18}$/';
$passwd_regex = '/^[a-zA-Z0-9]{4,18}$/';
$email_regex = '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/';
$gender_regex = '/^[男女]$/';

define('DB_USER','testuser');
define('DB_PASSWD','password');
define('DB_NAME','sample');
define('DB_CHARSET','SET NAMES utf8mb4');
define('DSN','mysql:dbname='.DB_NAME.';host=mysql;charset=utf8');
define('HTML_CHARACTER_SET','UTF-8');

define('USER_TYPE_ADMIN',0);
define('USER_TYPE_NORMAL',1);
//ドキュメントルート:/home/codecamp28789/htdocs 
define('LOGIN_URL',$_SERVER['DOCUMENT_ROOT'] . '/EC/login.php');




