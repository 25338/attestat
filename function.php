<?
  function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ','Ә','ә','І','і','Ң','ң','Ғ','ғ','Ү','ү','Ұ','ұ','Қ','қ','Ө','ө','Һ','һ');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_','A','a','I','i','N','n','G','g','Y','y','Y','y','Q','q','O','o','h','h');
    return str_replace($rus, $lat, $str);
}
//получить контент из базы
function getcontent($kod){
	//функция для получение контента из базы страницы сайта
	global $lang;
	$data=getrec("menu","id","where module_name='".$kod."' or url='".$kod."'");
	$id_menu=intval($data[0]);

	$data=getrec("pages","id,title_1,title_2, title_3, txt_1,txt_2,txt_3","where id_menu=".$id_menu." and visibled=1 order by public_date desc");
	$tit=$data[$lang];
	$txt=$data[3+$lang];
	return array('tit'=>$tit,'txt'=>$txt);
}

function getrec($table,$field,$where){
	global $conn;
	$_sql="select ".$field. " from ".$table." ".$where;
	$_res = $conn->query($_sql);
	return $_res->fetch_array();
}


//Диалоговое окно с подверждением
function Dialog($Title,$Text,$Url){
	global $kw;
	return '
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#eee;">
        <h5 class="modal-title" id="exampleModalLabel">'.$Title.'</h5>
		<!--
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		-->
      </div>
      <div class="modal-body">'.$Text.'</div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="'.$Url.'"><i class="fas fa-check"></i> '.$kw["close"].'</a>
      </div>
    </div>
  </div>
</div>
';
}


//Диалоговое окно с подверждением
function ConfirmDialog($Title,$Text,$Url){
	global $kw;
	return '
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#eee;">
        <h5 class="modal-title" id="exampleModalLabel">'.$Title.'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">'.$Text.'</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> '.$kw["no"].'</button>
        <a class="btn btn-primary" href="'.$Url.'"><i class="fas fa-check"></i> '.$kw["yes"].'</a>
      </div>
    </div>
  </div>
</div>
';
}

/*
$maxrec = кол-во записей в базе/number of results
$max_view = кол-во записей на странице/results per page
$v_page = кол-во отображений номерации/page navigation pages
$page = текущая страница/current page
$url = base url to amax_viewend navigation to
$sr = отображаемый запись базы /starting row
*/
function navLinks( $maxrec, $page, $url ) {
global $kw;
global $max_view;

$v_page=4;
$pageav = '';
$link = '';
$start = '';
$previous = '';
$next = '';
$end = '';

if( $page >= 2 ) {
	$previous .= '<a class="page-link" href="' . $url;
	$previous .= 'page=' . ( $page - 1) . '">'.$kw["back_page"].'</a>';
}

if( $page < $maxrec and ( $page * $max_view) < $maxrec ) {
	$next .= '<a class="page-link"  href="' . $url ;
	$next .= 'page=' . ( $page + 1) . '">'.$kw["next_page"].'</a> ';
}

if( $maxrec > $max_view ) {
	$tp = $maxrec / $max_view;

	if( $tp != intval( $tp ) ) {
		$tp = intval( $tp) + 1;
	}

	$cp = 0;

  while( $cp++ < $tp ) {
	if( ( $cp < $page - $v_page or $cp > $page + $v_page) and $v_page != 0 ) {
		if( $cp == 1 ) {
			$start .= '<a class="page-link" href="' . $url;
			$start .= 'page=1">'.$kw["start_page"].'</a>';
		}

		if( $cp == $tp ) {
			$end .= '<a class="page-link" href="' . $url;
			$end .= 'page=';
			$end .= $tp . '">'.$kw["end_page"].' </a>';
		}
	}else{
		if( $cp == $page ) {
			$link .= '<li class="page-item active"><a class="page-link" >'.$cp.'</a></li>';
		}else{
			$link .= '<li class="page-item">';
			$link .= '<a class="page-link" href="' . $url;
			$link .= 'page=' . $cp . '" >'.$cp.'</a>';
			$link .= '</li>';
		}
	}
  }

  $pageav .= '<li class="page-item">'.$start.'</li>';
  $pageav .= '<li class="page-item">'.$previous.'</li>';
  $pageav .= $link;
  $pageav .= '<li class="page-item">'.$next.'</li>';
  $pageav .= '<li class="page-item">'.$end.'</li>';
}

$pageav_e='<nav aria-label="Page navigation example"><ul class="pagination">'.$pageav.'</ul></nav>';

return $pageav_e;
}


function save_date($d){
	//20-02-2019
	$r=substr($d,6,4).substr($d,3,2).substr($d,0,2);
	return $r;
}

function load_date($d,$f){
	//$d=20180327 -> 27-03-2018
	$r=substr($d,6,2).$f.substr($d,4,2).$f.substr($d,0,4);
	return $r;
}
function load_datetime($d){
	//$d=20180327 -> 27-03-2018
	$f="-";
	$r=substr($d,6,2).$f.substr($d,4,2).$f.substr($d,0,4);
	$r.=' '.substr($d,8,2).':'.substr($d,10,2).':'.substr($d,12,2);
	return $r;
}

function getoption($table,$field,$where,$sel){
	global $conn;
	$sql_f="select $field from $table $where";
	$r_f=$conn->query($sql_f);
	$s='';
	while($mr_f=$r_f->fetch_array()){
		$selected=($sel==$mr_f[0]) ? "selected" : "";
		$s.='<option value="'.$mr_f[0].'" '.$selected.'>'.$mr_f[1].'</option>';
	}
	return $s;
}
?>
