<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;
$do=$_REQUEST["do"];

$id_stud=intval($_REQUEST['id_stud']);

//для фильтра
$klass=intval($_REQUEST['klass']);
$liter=intval($_REQUEST['liter']);

$save_stud=$_POST['save_stud'];
if($save_stud){
	$id_stud=intval($_POST['id_stud']);
	$fam=$_POST['fam'];
	$imy=$_POST['imy'];
	$otc=$_POST['otc'];
	$nomer=$_POST['nomer'];
	$kurator=$_POST['kurator'];
	$s_predmet=$_POST['s_predmet'];

	//получаем массив предметов
	$s_ocenka="";
	$s_predmet_custom="";
	$a_s_predmet=explode(',',$s_predmet);
	foreach ($a_s_predmet as $key => $value) {
		$s_ocenka.=$_POST['pred'.$value].',';
		$s_predmet_custom.=$_POST['cust'.$value].',';
	}

    $set=' set id_u='.$admin_id.', fam="'.$fam.'", imy="'.$imy.'", otc="'.$otc.'", nomer="'.$nomer.'", klass='.$klass.', liter='.$liter.', predmet="'.$s_predmet.'", ocenka="'.$s_ocenka.'", predmet_custom="'.$s_predmet_custom.'", kurator="'.$kurator.'" ';
	$sql=($id_stud) ? "update ucheniki ".$set." where id=$id_stud" : "insert into ucheniki ".$set;
	$conn->query($sql);
	if(!$id_stud) { $id_stud=$conn->insert_id; }
}

if($id_stud>0){ $tag=2;}
if($do=='add'){ $tag=2;}
?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["ucheniki"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
if($tag==1){ 
	$class=($klass && $liter) ? 'class="btn btn-primary btn-sm"' : 'class="btn btn-dark btn-sm disabled"';
	?>
	<form>
  <div class="col" style="padding:10px;">
   <a href="?do=add&klass=<?=$klass;?>&liter=<?=$liter;?>" <?=$class;?>  ><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
   <span style="padding-left:20px;"></span>
   <label for="klass">
   <? 
	//фильтрация страниц по модулю
	echo $kw["klass"].': ';
	echo '<select name="klass" id="klass" class="form-control-sm" onchange="this.form.submit();" >';
	echo '<option value="0"></option>';
	$sel[$klass]='selected';
	echo '<option value=9 '.$sel[9].'>9</option>';
	echo '<option value=11 '.$sel[11].'>11</option>';
   ?>
   </select>
   </label> 
   <label for="liter">&nbsp;&nbsp;&nbsp;
   <?=$kw["liter"].': ';?>
   <select name="liter" id="klass" class="form-control-sm " onchange="this.form.submit();">
		<option value="0"></option>
		<?
		foreach ($aliter as $key => $value) {
			$sel=($key==$liter) ? 'selected' : '';
			echo '<option value='.$key.' '.$sel.'>';
			echo $value;
			echo '</option>';
		}
		?>
   </select>
   </label>

 </div>
</form>

<table class="table table-bordered table-sm table-striped ">
<thead class="thead-dark">
<tr>
<th scope="col"><? echo $kw["fio"];?></th>
<th scope="col"><? echo $kw["klass"];?></th>
<th scope="col" style="width:160px;text-align:center;"><? echo $kw["actions"];?></th>
</tr>
</thead>

<tbody>
<?
$where =($klass) ? " and klass=$klass " : " and id=0 ";
$where.=($liter) ? " and liter=$liter " : "";

$sql="select id,fam, imy, otc, klass, liter from ucheniki where id_u=$admin_id ".$where." order by fam";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	$fio=$row['fam'].' '.$row['imy'].' '.$row['otc'];
	$klass=$row['klass'];$liter=$row['liter'];
	$sklass=$klass.'-'.$aliter[$liter];
	?>
	<tr>
	<td class="align-middle"><?=$fio;?></td>
	<td class="text-center"><?=$sklass;?></td>
	<td class="align-middle text-center " style"width:100px;">
		<a class="btn btn-success btn-sm" href="?id_stud=<?=$id;?>&klass=<?=$klass;?>&liter=<?=$liter;?>" >
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
	if($id_stud>0){
		$data=getrec('ucheniki','nomer, fam,imy,otc,klass,liter,predmet,ocenka,predmet_custom,kurator',"where id=$id_stud");
		$fam=$data['fam'];
		$imy=$data['imy'];
		$otc=$data['otc'];
		$nomer=$data['nomer'];
		$klass=intval($data['klass']);
		$liter=intval($data['liter']);
		$predmet=$data['predmet'];$apredmet=explode(",",$predmet);
		$ocenka=$data['ocenka'];$aocenka=explode(",",$ocenka);
		$predmet_custom=$data['predmet_custom'];$apredcust=explode(",",$predmet_custom);
		$kurator=$data['kurator'];
	}
	
	?>
	<div class="col" style="padding:10px;">
	<form method="POST" action="/<?=$uri[1];?>/">
	<input type="hidden" name="id_stud" value="<? echo $id_stud;?>">
	<input type="hidden" name="klass" value="<?=$klass;?>">
	<input type="hidden" name="liter" value="<?=$liter;?>">

	<table class="table table-borderless table-sm">
		<tr>
			<td class="text-right"><label for="klass" class="col-form-label-sm"><? echo $kw["klass"];?>:</label>
			</td>
			<td>
				<input type="text" name="klass" id="klass" class="form-control form-control-sm col-1" value="<?=$klass.'-'.$aliter[$liter];?>" disabled><br>
			</td>
		</tr>
		<tr>
			<td class="text-right"><label for="fam" class="col-form-label-sm"><? echo $kw["fam"];?>:</label>
			</td>
			<td><input type="text" name="fam" id="fam" class="form-control form-control-sm col-5" value="<? echo $fam;?>">
			</td>
		</tr>

		<tr>
			<td class="text-right"><label for="imy" class="col-form-label-sm"><? echo $kw["imy"];?>:</label>
			</td>
			<td><input type="text" name="imy" id="imy" class="form-control form-control-sm-5 col-5" value="<? echo $imy;?>">
			</td>
		</tr>

		<tr>
			<td class="text-right"><label for="otc" class="col-form-label-sm"><? echo $kw["otc"];?>:</label>
			</td>
			<td><input type="text" name="otc" id="otc" class="form-control form-control-sm col-5" value="<? echo $otc;?>">
			</td>
		</tr>

		<tr>
			<td class="text-right"><label for="nomer" class="col-form-label-sm"><? echo $kw["nomer"];?>:</label>
			</td>
			<td><input type="text" name="nomer" id="nomer" class="form-control form-control-sm col-3" value="<? echo $nomer;?>">
			</td>
		</tr>

<?
	$s_predmet="";
	$sql="select id, predmet_name, custom from predmets where klass=$klass order by pos";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		$id=$row['id'];
		$s_predmet.=$id.',';
		$predmet_name=$row["predmet_name"];
		$custom=$row['custom'];
		$label="pred".$id;
		$pred_c="cust".$id;

		//выбор оценки из базы
		$sel_ocenka=0;
		$sel_cust=0;
		foreach ($apredmet as $key => $value) {
			if($id==$value) { 
				$sel_ocenka=intval($aocenka[$key]);
				$sel_cust=intval($apredcust[$key]);
			}
		}
		$opt_ocenka=getoption("ocenka","id,concat(ocenka,' ',txt_1)",'',$sel_ocenka);
?>
		<tr>
			<td style="width:300px;" class="text-right"><label for="<?=$label;?>" class="col-form-label-sm"><? echo $predmet_name;?>:</label>
			</td>
			<td ><select name="<?=$label;?>" class="form-control form-control-sm col-4 mynowrap">
					<option value="0"></option>
					<? echo $opt_ocenka; ?>
				</select>
			<? if($custom) { 
				$opt_cust=getoption("predmet_custom","id,txt_1","where id_u=$admin_id",$sel_cust);
			?>
				<select name="<?=$pred_c;?>" class="form-control form-control-sm col-4 mynowrap">
					<option value="0"></option>
					<? echo $opt_cust;?>
				</select>
			<?
			} ?>
			</td>
		</tr>
<?
	}
?>
		<tr>
			<td class="text-right"><label for="kurator" class="col-form-label"><? echo $kw["kurator"];?>:</label>
			</td>
			<td><input type="text" name="kurator" id="kurator" class="form-control form-control-sm col-7" value="<? echo $kurator;?>">
			</td>
		</tr>
	</table>
	<input type="hidden" name="s_predmet" value="<?=$s_predmet;?>">

	<br><div class="form-group row">
		<label for="txt_1" class="col-sm-2"></label>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-primary btn-sm" name="save_stud" value="<?=$kw["save"];?>"> 
			<i class="fas fa-save"></i> 
			<?=$kw["save"];?>
			</button> 
			<a href="/<?=$uri[1];?>/?klass=<?=$klass;?>&liter=<?=$liter;?>" class="btn btn-secondary  btn-sm" >
			<i class="fas fa-ban"></i> 
			<?=$kw["close"];?></a>
<?			if($id_stud){ ?>
			<span style="width: 100px;display: inline-block;"></span>
			<a href="/print.php?lang=1&id=<?=$id_stud;?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i>
				<?=$kw['print_rus'];?>
			</a>
			<a href="/print.php?lang=2&id=<?=$id_stud;?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i>
				<?=$kw['print_kaz'];?>
			</a>
<?			} ?>
		</div>
	</div>
	</form>
	</div>
	<?
}
?>

</div>
</div>
