<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

/* закрываем базу данных */
mysqli_close($conn);
?>