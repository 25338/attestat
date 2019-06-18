<?
//при добавление нового пользователя
//$klass=9;
//$new_user=2;
//$sql="insert into styles (id_u,klass,style_name,class,mtop_1,mtop_2,mleft_1,mleft_2) (select $new_user,$klass,style_name,class,mtop_1,mtop_2,mleft_1,mleft_2 from styles where id_u=1 and klass=$klass)";

$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=1;

$id_user=intval($_REQUEST["id_user"]);
//если выбран то меняем на tag=2 редактирование
if($id_user>0){ $tag=2;}

//запрос на добавление 
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

// сохранить 
$save_menu=$_POST["save_menu"];
if($save_menu){
	$tag=1;
	$fio=strip_tags($_POST["fio"]);
	$user=strip_tags($_POST["user"]);
	$pass=strip_tags($_POST["pass"]);

	$set="set fio='$fio', user='$user', pass='$pass', user_group=0 ";
	$sql=($id_user) ? "update u ".$set." where id=$id_user" : "insert into u ".$set;
	$conn->query($sql);
	//добавить копию кординатов
	$new_user=$conn->insert_id;
	if($new_user>0){
		$sql1="insert into kw (kod,txt,visibled,id_u) (select kod,txt,1,$new_user from kw where id_u=1)";
		$conn->query($sql1);
		$sql2="insert into styles (id_u,klass,style_name,class,mtop_1,mtop_2,mleft_1,mleft_2) (select $new_user,klass,style_name,class,mtop_1,mtop_2,mleft_1,mleft_2 from styles where id_u=1)";
		$conn->query($sql2);
		$sql3="insert into predmet_custom (id_u,txt_1,txt_2) (select $new_user,txt_1,txt_2 from predmet_custom where id_u=1)";
		$conn->query($sql3);
	}
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["newuser"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//список 
if($tag==1){ 
	$class='class="btn btn-primary btn-sm"';
	?>
 <div class="col" style="padding:10px;">
   <a href="?do=add" <?=$class;?> ><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
 </div>
 
<table class="table table-sm table-bordered table-striped ">
<thead class="thead-dark ">
<tr>
<th scope="col" class="text-center" style="width:80px;">#</th>
<th scope="col"><? echo $kw["name"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<? 
$j=0;
$sql="select id, fio from u where user_group=0 order by fio ";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$j++;
	$id_user=$row['id'];
	$fio=$row['fio'].' '.$row['txt_1'];
?>
	<tr>
	<td class="text-center"><?=$j;?></td>
	<td><?=$fio;?></td>
	<td class="text-center">
		<a class="btn btn-success btn-sm" href="?id_user=<?=$id_user;?>" >
		<i class="far fa-edit"></i>
		<?=$kw["edit"];?></a>
	</td>
	</tr>
<?
}
?>
</tbody>
</table>
<?
} 
//конец условий tag=1

//процедура редактирование меню
if($tag==2){
	if($id_user>0){
		$data=getrec("u","fio,user,pass","where id=$id_user");
		$fio1=$data['fio'];
		$user=$data["user"];
		$pass=$data["pass"];
	}

	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_user" value="'.$id_user.'">';

	echo '<div class="form-group row">';
		echo '<label for="fio" class="col-sm-3 col-form-label text_16 text-right">'.$kw["fio"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="fio" id="fio" class="form-control form-control-sm" value="'.$fio1.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="user" class="col-sm-3 col-form-label text_16 text-right">'.$kw["login"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="user" id="user" class="form-control form-control-sm" value="'.$user.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="pass" class="col-sm-3 col-form-label text_16 text-right">'.$kw["password"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="pass" id="pass" class="form-control form-control-sm" value="'.$pass.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label class="col-sm-3"></label>';
		echo '<div class="col">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_menu" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/'.$uri[1].'/" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
}
?>
</div>
</div>
