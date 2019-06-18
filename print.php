<?
session_start();

include_once "db.php";
include_once "function.php";

$lang=intval($_REQUEST["lang"]);
$id=intval($_REQUEST["id"]);
$admin_id=intval($_SESSION["admin_id"]);

$school_name=getrec("kw","id,txt_1,txt_2","where id_u=$admin_id and kod='school_name'");
$school_director=getrec("kw","id,txt_1,txt_2","where id_u=$admin_id and kod='school_director'");
$school_sodirector=getrec("kw","id,txt_1,txt_2","where id_u=$admin_id and kod='school_sodirector'");

$sql="select id, txt_1, txt_2,ocenka from ocenka";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id_o=$row['id'];
	$s_ocenka[$id_o]=$row['ocenka'].' '.$row[$lang];
}

$sql="select id, txt_1, txt_2 from predmet_custom where id_u=$admin_id";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id_p=$row['id'];
	$s_pred_cust[$id_p]=$row[$lang];
}

$data=getrec('ucheniki','nomer, fam,imy,otc,klass,liter,predmet,ocenka,predmet_custom,kurator',"where id=$id");
$fam=$data['fam'];
$imy=$data['imy'];
$otc=$data['otc'];
$nomer=$data['nomer'];
$klass=intval($data['klass']);
$liter=intval($data['liter']);
$ocenka=$data['ocenka'];$aocenka=explode(",",$ocenka);
$predmet_custom=$data['predmet_custom'];$apredcust=explode(",",$predmet_custom);
$kurator=$data['kurator'];

include "prnhead.php";

$style="";
$sql="select class,mtop_1,mleft_1,mtop_2,mleft_2 from styles where klass=$klass and id_u=$admin_id";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$mtop=$row['mtop_'.$lang];
	$mleft=$row['mleft_'.$lang];

	$style.='.'.$row['class'].'{';
	$style.=($mtop) ? 'margin-top: '.$mtop.'cm;' : '';
	$style.=($mleft) ? 'margin-left: '.$mleft.'cm;' : '';
	$style.=($minterval) ? 'line-height: '.$minterval.'cm;' : '';
	$style.="} \n";
}
echo '<style> '.$style.'</style>';

$aschool=explode("\n",$school_name[$lang]);

//для 9 класса
if($klass==9){
?>
<div class="w9">
	<div class="nomer"><?=$nomer;?></div>
	<div class="fam"><?=$fam.' '.$imy;?></div>
	<div class="otc"><?=$otc;?></div>
	<div class="school_1"><?=$aschool[0];?></div>
	<div class="school_2"><?=$aschool[1];?></div>

	<div class="ocenka1"><?=$s_ocenka[$aocenka[0]];?></div>
	<div class="ocenka2"><?=$s_ocenka[$aocenka[1]];?></div>
	<div class="ocenka3"><?=$s_ocenka[$aocenka[2]];?></div>
	<div class="ocenka4"><?=$s_ocenka[$aocenka[3]];?></div>
	<div class="ocenka5"><?=$s_ocenka[$aocenka[4]];?></div>
	<div class="ocenka6"><?=$s_ocenka[$aocenka[5]];?></div>

	<div class="mynowrap predmet7"><?=$s_pred_cust[$apredcust[6]];?></div>
	<div class="mynowrap ocenka7"><?=$s_ocenka[$aocenka[6]];?></div>

	<div class="ocenka8"><?=$s_ocenka[$aocenka[7]];?></div>
	<div class="ocenka9"><?=$s_ocenka[$aocenka[8]];?></div>
	<div class="ocenka10"><?=$s_ocenka[$aocenka[9]];?></div>
	<div class="ocenka11"><?=$s_ocenka[$aocenka[10]];?></div>
	<div class="ocenka12"><?=$s_ocenka[$aocenka[11]];?></div>
	<div class="ocenka13"><?=$s_ocenka[$aocenka[12]];?></div>
	<div class="ocenka14"><?=$s_ocenka[$aocenka[13]];?></div>
	<div class="ocenka15"><?=$s_ocenka[$aocenka[14]];?></div>
</div>
<div class="w1"></div>
<div class="w9">
	<div class="ocenka16"><?=$s_ocenka[$aocenka[15]];?></div>
	<div class="ocenka17"><?=$s_ocenka[$aocenka[16]];?></div>
	<div class="ocenka18"><?=$s_ocenka[$aocenka[17]];?></div>
	<div class="ocenka19"><?=$s_ocenka[$aocenka[18]];?></div>
	<div class="ocenka20"><?=$s_ocenka[$aocenka[19]];?></div>
	<div class="ocenka21"><?=$s_ocenka[$aocenka[20]];?></div>
	<div class="ocenka22"><?=$s_ocenka[$aocenka[21]];?></div>
	<div class="ocenka23"><?=$s_ocenka[$aocenka[22]];?></div>

	<? 
	//если две строки
	$spred=explode("\n",$s_pred_cust[$apredcust[23]]); 
	$s=$s_ocenka[$aocenka[23]];
	$s2=(trim($spred[1])) ? $s : '';
	$s1=(trim($spred[1])) ? '': $s;
	?>
	<div class="predmet24_1"><?=$spred[0];?>
		<span class="ocenka24"><?=$s1;?></span>
	</div>
	<div class="predmet24_2"><?=$spred[1];?> 
		<span class="ocenka24"><?=$s2;?></span>
	</div>

	<? 
	//если две строки
	$spred=explode("\n",$s_pred_cust[$apredcust[24]]); 
	$s=$s_ocenka[$aocenka[24]];
	$s2=(trim($spred[1])) ? $s : '';
	$s1=(trim($spred[1])) ? '': $s;
	?>
	<div class="predmet25_1"><?=$spred[0];?>
		<span class="ocenka25"><?=$s1;?></span>
	</div>
	<div class="predmet25_2"><?=$spred[1];?> 
		<span class="ocenka25"><?=$s2;?></span>
	</div>

	<div class="director"><?=$school_director[$lang];?></div>
	<div class="sodirector"><?=$school_sodirector[$lang];?></div>
	<div class="kurator"><?=$kurator;?></div>
</div>
<? }

//для 11 класса
if($klass==11){
?>
<div class="w9">
	<div class="nomer"><?=$nomer;?></div>
	<div class="fam"><?=$fam.' '.$imy;?></div>
	<div class="otc"><?=$otc;?></div>
	<div class="school_1"><?=$aschool[0];?></div>
	<div class="school_2"><?=$aschool[1];?></div>

	<div class="ocenka1"><?=$s_ocenka[$aocenka[0]];?></div>
	<div class="ocenka2"><?=$s_ocenka[$aocenka[1]];?></div>
	<div class="ocenka3"><?=$s_ocenka[$aocenka[2]];?></div>
	<div class="ocenka4"><?=$s_ocenka[$aocenka[3]];?></div>
	<div class="ocenka5"><?=$s_ocenka[$aocenka[4]];?></div>
	<div class="ocenka6"><?=$s_ocenka[$aocenka[5]];?></div>

	<div class="mynowrap predmet7"><?=$s_pred_cust[$apredcust[6]];?></div>
	<div class="mynowrap ocenka7"><?=$s_ocenka[$aocenka[6]];?></div>

	<div class="ocenka8"><?=$s_ocenka[$aocenka[7]];?></div>
	<div class="ocenka9"><?=$s_ocenka[$aocenka[8]];?></div>
	<div class="ocenka10"><?=$s_ocenka[$aocenka[9]];?></div>
	<div class="ocenka11"><?=$s_ocenka[$aocenka[10]];?></div>
	<div class="ocenka12"><?=$s_ocenka[$aocenka[11]];?></div>
	<div class="ocenka13"><?=$s_ocenka[$aocenka[12]];?></div>
	<div class="ocenka14"><?=$s_ocenka[$aocenka[13]];?></div>
</div>
<div class="w1"></div>
<div class="w9">
	<div class="ocenka15"><?=$s_ocenka[$aocenka[14]];?></div>
	<div class="ocenka16"><?=$s_ocenka[$aocenka[15]];?></div>
	<div class="ocenka17"><?=$s_ocenka[$aocenka[16]];?></div>
	<div class="ocenka18"><?=$s_ocenka[$aocenka[17]];?></div>
	<div class="ocenka19"><?=$s_ocenka[$aocenka[18]];?></div>
	<div class="ocenka20"><?=$s_ocenka[$aocenka[19]];?></div>

	<div class="mynowrap predmet21"><?=$s_pred_cust[$apredcust[20]];?></div>
	<div class="mynowrap ocenka21"><?=$s_ocenka[$aocenka[20]];?></div>
	<div></div>
	<div class="mynowrap predmet22"><?=$s_pred_cust[$apredcust[21]];?></div>
	<div class="mynowrap ocenka22"><?=$s_ocenka[$aocenka[21]];?></div>
	<div></div>
	<div class="mynowrap predmet23"><?=$s_pred_cust[$apredcust[22]];?></div>
	<div class="mynowrap ocenka23"><?=$s_ocenka[$aocenka[22]];?></div>
	<div></div>
	<div class="mynowrap predmet24"><?=$s_pred_cust[$apredcust[23]];?></div>
	<div class="mynowrap ocenka24"><?=$s_ocenka[$aocenka[23]];?></div>
	<div></div>
	<div class="mynowrap predmet25"><?=$s_pred_cust[$apredcust[24]];?></div>
	<div class="mynowrap ocenka25"><?=$s_ocenka[$aocenka[24]];?></div>
	<div></div>
	<div class="mynowrap predmet26"><?=$s_pred_cust[$apredcust[25]];?></div>
	<div class="mynowrap ocenka26"><?=$s_ocenka[$aocenka[25]];?></div>
	<div></div>
	<div class="mynowrap predmet27"><?=$s_pred_cust[$apredcust[26]];?></div>
	<div class="mynowrap ocenka27"><?=$s_ocenka[$aocenka[26]];?></div>
	<div></div>
	<div class="mynowrap predmet28"><?=$s_pred_cust[$apredcust[27]];?></div>
	<div class="mynowrap ocenka28"><?=$s_ocenka[$aocenka[27]];?></div>
	<div></div>
	<div class="mynowrap predmet29"><?=$s_pred_cust[$apredcust[28]];?></div>
	<div class="mynowrap ocenka29"><?=$s_ocenka[$aocenka[28]];?></div>
	<div></div>
	<div class="director"><?=$school_director[$lang];?></div>
	<div class="sodirector"><?=$school_sodirector[$lang];?></div>
	<div class="kurator"><?=$kurator;?></div>
</div>
<? }
?>
