<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//подключаем шапку страницы сайта
include_once "admhead.php";

$data=getrec("u","user_group","where id=$admin_id");
$user_group=intval($data['user_group']);

//массив функции админ панели
$menus=array(
	'profile'=>array($kw['profile'],'adm_profile.php','0',''),
	'ucheniki'=>array($kw['ucheniki'],'adm_uchenik.php',1,'fas fa-user-graduate'),
	'predmets'=>array($kw['predmets'],'adm_pred.php',$user_group,'fas fa-stream'),
	'predcust'=>array($kw['predcust'],'adm_predcust.php',1,'fas fa-stream'),
	'ocenka'=>array($kw['ocenka'],'adm_ocenka.php',1,'fas fa-pen-nib'),
	'print'=>array($kw['print_set'],'adm_print.php',1,'fas fa-print'),
	'setting'=>array($kw['setting'],'adm_conf.php','1','fas fa-tools'),
	'newuser'=>array($kw['newuser'],'adm_user.php',$user_group,'fas fa-user'),
);

?>
<div class="row fixed-top" style="background-color:#000;height:40px;line-height:40px;">
	<div class="col-3 " >
		<div style="padding-left:20px;height:40px;white-space:nowrap;overflow:hidden;">
		<a href="/" target="_blank"><img src="/img/browser.png" width="32" title="Open site" align="left" vspace="6"></a>
		<span style="color:#aaa;font-size:30px;padding-left:4px;">Admin Panel</span> 
		<span style="color:#007bff;font-size:13px;">MU</span>
		</div>
	</div>
	<div class="col" style="color:#999; ">
		<?
		//получаем текущую дату и время
		echo $kw["today"].': '.date("d-m-Y").' '.mb_strtolower($day_week[date("N")]).' '; 
		echo '<span class="clock">'.date("H:i:s").'</span> ';
		
		//получаем текущего пользователя
		$data=getrec("u","fio","where id=$admin_id");
		$fio=$data["fio"];
		?>
	</div>
	<div class="col-2 ">
		<nav class="profile">
			<ul style="text-align:right;padding-right:10px;height:45px;">
				<li>
				<img src="/img/user.png" height="25" style="-webkit-filter: invert(1);filter: invert(1);"> <? echo $fio;?>
				<ul>
					<li><a href="/profile/"><? echo $kw["profile"];?></a></li>
					<li><a href="/exit/" ><? echo $kw["exit"];?></a></li>
				</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
<div class="row" style="margin: 40px 0 0 0;height:92%;">
	<div class="col-3 " style="background-color:#303D4C;padding-top:10px;overflow-y: auto;height:100%;">
		<?
		//строим меню из массива
		foreach($menus as $key=>$menu){
			if($menu[2]==1){
				$sel=($key==$uri[2]) ? "sel":"";
				echo '<a href="/'.$key.'/" style="text-decoration:none;">';
				echo '<li class="left_menu '.$sel.'"> ';
				echo '<i class="'.$menu[3].'" style="width:20px;"></i> ';
				echo $menu[0];
				echo '</li>';
				echo '</a>';
			}
		}
		?>
	</div>
	<div class="col" style="background-color:#E6E8E9;overflow-y: scroll;height:100%;">
	<?
	//проверяем существование файла, если есть подключаем
	$key=$uri[1];
	$sel_file=$menus[$key][1];
	if(file_exists($sel_file)){
		include $sel_file;
	}else{
		include "dashboard.php";
	}
	?>
	</div>
</div>
<script>
setInterval(function(){

        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;
        hours = (hours < 10 ? "0" : "") + hours;

        // Compose the string for display
        var currentTimeString = hours + ":" + minutes + ":" + seconds;
        $(".clock").html(currentTimeString);

},500);

$( function() {
    $( "#public_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',
	  closeText: 'Закрыть',
      prevText: '',
      currentText: 'Сегодня',
      monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                    'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
      monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                    'Июл','Авг','Сен','Окт','Ноя','Дек'],
      dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
      dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
      dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
      weekHeader: 'Не',
      firstDay: 1
    });
});
$( function() {
	$( "#tabs" ).tabs();
} );
</script>