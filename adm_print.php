<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=1;

//запрос на фильтрацию
$klass=intval($_REQUEST["klass"]);

$id_style=intval($_REQUEST["id_style"]);
//если выбран то меняем на tag=2 редактирование
if($id_style>0){ $tag=2;}

// сохранить 
$save=$_POST["save"];
if($save){
	$tag=1;
	$mtop_1=strip_tags($_POST["mtop_1"]);
	$mtop_2=strip_tags($_POST["mtop_2"]);
	$mleft_1=strip_tags($_POST["mleft_1"]);
	$mleft_2=strip_tags($_POST["mleft_2"]);

	$set="set mtop_1='$mtop_1', mleft_1='$mleft_1', mtop_2='$mtop_2', mleft_2='$mleft_2'  ";
	$sql= "update styles ".$set." where id=$id_style";
	$conn->query($sql);
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["print_set"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//список 
if($tag==1){ 
	?>
 	<form>
 <div class="col" style="padding:10px;">
   <? 
	//фильтрация страниц по модулю
    echo '<label for="menu_filter">';
	echo $kw["klass"].': ';
	echo '<select name="klass" id="klass" class="form-control-sm col-2" onchange="this.form.submit();" style="width:600px;">';
	echo '<option value="0"></option>';
	$sel[$klass]='selected';
	echo '<option value=9 '.$sel[9].'>9</option>';
	echo '<option value=11 '.$sel[11].'>11</option>';
   ?>
   </select>
	</label>

 </div>
</form>

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
$where=($klass) ? " and klass=".$klass : " and id=0";
$sql="select id, style_name from styles where id_u=$admin_id ".$where;
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$j++;
	$id_style=$row['id'];
	$predmet_name=$row['style_name'];
?>
	<tr>
	<td class="text-center"><?=$j;?></td>
	<td><?=$predmet_name;?></td>
	<td class="text-center">
		<a class="btn btn-success btn-sm" href="?id_style=<?=$id_style;?>&klass=<?=$klass;?>" >
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
	if($id_style>0){
		$data=getrec("styles","style_name,mtop_1,mtop_2,mleft_1,mleft_2","where id=$id_style");
		$style_name=$data['style_name'];
		$mtop_1=$data['mtop_1'];
		$mtop_2=$data['mtop_2'];
		$mleft_1=$data['mleft_1'];
		$mleft_2=$data['mleft_2'];
	}

	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_style" value="'.$id_style.'">';
	echo '<div class="alert alert-success">';
	echo $kw['field_name'].': <b>'.$style_name.'</b>';
	echo '</div>';

	echo '<div class="row">';
	echo '<div class="col-3"></div>';
	echo '<div class="col-2">'.$kw["ru"].'</div>';
	echo '<div class="col-2">'.$kw["kz"].'</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="margintop" class="col-sm-3 col-form-label text_16 text-right">'.$kw["margintop"].' (cm):</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="number" step="0.05" min=0 max=10 name="mtop_1" id="margintop" class="form-control form-control-sm" value="'.$mtop_1.'" >';
		echo '</div>';
		echo '<div class="col-sm-2">';
			echo '<input type="number" step="0.05" min=0 max=10 name="mtop_2" class="form-control form-control-sm" value="'.$mtop_2.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="marginleft" class="col-sm-3 col-form-label text_16 text-right">'.$kw["marginleft"].' (cm):</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="number" step="0.05" min=0 max=10 name="mleft_1" id="marginleft" class="form-control form-control-sm" value="'.$mleft_1.'" >';
		echo '</div>';
		echo '<div class="col-sm-2">';
			echo '<input type="number" step="0.05" min=0 max=10 name="mleft_2" class="form-control form-control-sm" value="'.$mleft_2.'" >';
		echo '</div>';
	echo '</div>';


	echo '<div class="form-group row">';
		echo '<label class="col-sm-3"></label>';
		echo '<div class="col">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/'.$uri[1].'/?klass='.$klass.'" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["close"].'</a> ';
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
}
?>
</div>
</div>