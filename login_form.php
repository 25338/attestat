<? 
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

include "admhead.php";
?>
<div style="height:50px;"></div>
<h2><center class="text-danger">AC "<?=$kw["title_site"];?>"</center></h2>
<div style="height:30px;"></div>
<div class="form-group shadow " style="border:1px solid #eee; padding:10px 30px;width: 330px;text-align:center;margin:auto; ">
	<form method="POST" >
		<h2 style="color:#666;"><? echo $kw["autorization"];?></h2>
		<span class="text-danger"><?= $err;?></span>
		<div style="height:20px;"></div>
		<input name="_username" class="form-control" value="" type="text" placeholder="<? echo $kw["login"];?>" required autofocus="">
		<div style="height:20px;"></div>
		<input name="_password" class="form-control" type="password" placeholder="<? echo $kw["password"];?>" required>
		<div style="height:20px;"></div>
		<input type="submit" name="enter" class="btn btn-primary" value="<? echo $kw["enter"];?>" style="width:150px;">
	</form>
</div>
