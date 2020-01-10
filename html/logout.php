<?php
require_once './model/function.php';
require_once './conf/const.php';

session_start();
$session_name=session_name();
$_SESSION=array();

if(isset($_COOKIE[$session_name])){
    setcookie($session_name,'',time()-10);
}
session_destroy();
header('Location:login.php');
exit;