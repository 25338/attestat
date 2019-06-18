<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//авторизация в админ панель
$tag=1;
$inc=(!$admin_id) ? 'login_form.php' : 'admmenu.php';

//выход из админ панели
if($uri[1]=='exit'){ 
	unset($_SESSION["admin_id"]); 
	header("location: /"); return;
} 

//подключить модуль по условиям
if($inc){ include $inc; }
?>