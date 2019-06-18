<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=1;

$id_pred=intval($_REQUEST["id_pred"]);
//если выбран то меняем на tag=2 редактирование
if($id_pred>0){ $tag=2;}

//запрос на добавление 
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

// удалить 
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="delete from predmet_custom where id=$delete";
	//$conn->query($sql);
	$tag=1;
}

// сохранить 
$save_menu=$_POST["save_menu"];
if($save_menu){
	$tag=1;
	$txt_1=strip_tags($_POST["txt_1"]);
	$txt_2=strip_tags($_POST["txt_2"]);

	$set="set txt_1='$txt_1', txt_2='$txt_2' ";
	$sql=($id_pred) ? "update predmet_custom ".$set." where id=$id_pred" : "insert into predmet_custom ".$set;
	$conn->query($sql);
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["predcust"];?></h3>
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
$sql="select id, txt_1 from predmet_custom where id_u=$admin_id ";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$j++;
	$id_pred=$row['id'];
	$predmet_name=$row['txt_1'];
?>
	<tr>
	<td class="text-center"><?=$j;?></td>
	<td><?=$predmet_name;?></td>
	<td class="text-center">
		<a class="btn btn-success btn-sm" href="?id_pred=<?=$id_pred;?>" >
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
	if($id_pred>0){
		$data=getrec("predmet_custom","txt_1,txt_2","where id=$id_pred");
		$txt_1=$data["txt_1"];
		$txt_2=$data["txt_2"];
	}

	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_pred" value="'.$id_pred.'">';

	echo '<div class="form-group row">';
		echo '<label for="txt_1" class="col-sm-3 col-form-label text_16 text-right">'.$kw["predmet"].' ('.$kw['ru'].'):</label>';
		echo '<div class="col-sm-5">';
			echo '<textarea name="txt_1" id="txt_1" class="form-control form-control-sm" rows=5>'.$txt_1.'</textarea>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="txt_2" class="col-sm-3 col-form-label text_16 text-right">'.$kw["predmet"].' ('.$kw['kz'].'):</label>';
		echo '<div class="col-sm-5">';
			echo '<textarea name="txt_2" id="txt_2" class="form-control form-control-sm" rows=5>'.$txt_2.'</textarea>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label class="col-sm-3"></label>';
		echo '<div class="col">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_menu" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/predcust/" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			//echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">';
			//echo '<i class="fas fa-trash-alt"></i> ';
			//echo $kw["delete"];
			//echo '</button>';
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
	//вызов окно подверждений
	//echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/predcust/?delete='.$id_pred);
	
}
?>
</div>
</div>