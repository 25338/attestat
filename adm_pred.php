<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=1;

$id_pred=intval($_REQUEST["id_pred"]);
//если выбран то меняем на tag=2 редактирование
if($id_pred>0){ $tag=2;}

//запрос на фильтрацию
$klass=intval($_REQUEST["klass"]);

//запрос на добавление 
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

// удалить 
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="delete from predmets where id=$delete";
	$conn->query($sql);
	$tag=1;
}

// сохранить 
$save_menu=$_POST["save_menu"];
if($save_menu){
	$tag=1;
	$predmet_name=strip_tags($_POST["predmet_name"]);
	$klass=intval($_POST["klass"]);
	$predmet_custom=($_POST["predmet_custom"]) ? 1 : 0;
	$position=intval($_POST["position"]);
	//если не указан позиция то получаем последнюю 
	if(!$position){
		$data=getrec("predmets","max(pos)","where klass=$klass");
		$position=intval($data[0])+1;
	}

	$set="set predmet_name='$predmet_name', klass=$klass, custom=$predmet_custom, pos=$position ";
	$sql=($id_pred) ? "update predmets ".$set." where id=$id_pred" : "insert into predmets ".$set;
	$conn->query($sql);
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["predmets"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//список 
if($tag==1){ 
	$class=($klass ) ? 'class="btn btn-primary btn-sm"' : 'class="btn btn-dark btn-sm disabled"';
	?>
	<form>
 <div class="col" style="padding:10px;">
   <a href="?do=add&klass=<?=$klass;?>" <?=$class;?> ><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
   <span style="padding-left:20px;"></span>
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
<th scope="col" class="text-center" style="width:80px;">ID</th>
<th scope="col"><? echo $kw["name"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["klass"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["position"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<? 
$where=($klass) ? "where klass=".$klass : " where id=0";
$sql="select id, predmet_name, klass,pos from predmets $where order by klass, pos";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id_pred=$row['id'];
	$predmet_name=$row['predmet_name'];
	$klass=$row['klass'];
	$pos=$row['pos'];
?>
	<tr>
	<td class="text-center"><?=$id_pred;?></td>
	<td><?=$predmet_name;?></td>
	<td class="text-center"><?=$klass;?></td>
	<td class="text-center"><?=$pos;?></td>
	<td class="text-center">
		<a class="btn btn-success btn-sm" href="?id_pred=<?=$id_pred;?>&klass=<?=$klass;?>" >
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
	$position=0;
	$custom=0;
	$predmet_name='';
	if($id_pred>0){
		$data=getrec("predmets","predmet_name,klass,custom,pos","where id=$id_pred");
		$predmet_name=$data["predmet_name"];
		$klass=intval($data["klass"]);
		$pos=intval($data["pos"]);
		$predmet_custom=( intval($data["custom"]) ) ? 'checked' : '';
	}
	$sel[$klass]='selected';
	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_pred" value="'.$id_pred.'">';

	echo '<div class="form-group row">';
		echo '<label for="predmet_name" class="col-sm-3 col-form-label text_16 text-right">'.$kw["predmet"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="predmet_name" class="form-control form-control-sm" name="predmet_name"  value="'.$predmet_name.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="klass" class="col-sm-3 col-form-label text_16 text-right">'.$kw["klass"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<select id="klass" class="form-control form-control-sm" name="klass" required>';
			echo '<option value=9 '.$sel[9].'>9</option>';
			echo '<option value=11 '.$sel[11].'>11</option>';
			echo '</select>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="predmet_custom" class="col-sm-3 col-form-label text_16 text-right">'.$kw["predmet_custom"].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="predmet_custom" '.$predmet_custom.' id="predmet_custom">';
		echo '</div>';
	echo '</div>';

	if($id_pred){
	  echo '<div class="form-group row">';
		echo '<label for="position" class="col-sm-3 col-form-label text_16 text-right">'.$kw["position"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<select name="position" id="position" class="form-control form-control-sm">';
			echo '<option value="0"></option>';
			//создаем массив позиции 
			$data=getrec("predmets","count(*)","where klass=$klass");
			$max_pos=intval($data[0]);
			for($i=1;$i<=$max_pos;$i++){
				$sel=($i==$pos) ? "selected" : "";
				echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			echo '</select>';
		echo '</div>';
	  echo '</div>';
	}

	echo '<div class="form-group row">';
		echo '<label class="col-sm-3"></label>';
		echo '<div class="col">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_menu" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/predmets/?klass='.$klass.'" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">';
			echo '<i class="fas fa-trash-alt"></i> ';
			echo $kw["delete"];
			echo '</button>';
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
	//вызов окно подверждений
	echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/predmets/?delete='.$id_pred);
}
?>
</div>
</div>