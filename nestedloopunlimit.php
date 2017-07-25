<?php 

$db = new mysqli("localhost","root","","smartakuntan") or die ("<script>alert('ERROR : Gagal Koneksi ke Server, Silahkan Cek Kembali.')</script>");

$dataitem = array();

$itemgroupsql = $db->query("select * from item_group_1 order by id desc");



while($datanya1 = $itemgroupsql->fetch_assoc()){
	$dataitem[] = $datanya1;
}

$dataitem1 = array();

$itemgroupsql1 = $db->query("select * from item_group_1 order by id desc");



while($datanya2 = $itemgroupsql1->fetch_assoc()){
	$dataitem1[] = $datanya2;
}

function printListRecursive($list,$parent=0){
	$foundSome = false;
	for( $i=0,$c=count($list);$i<$c;$i++ ){
		if( $list[$i]['id_parent']==$parent ){
			if( $foundSome==false ){
				echo '<ul>';
				$foundSome = true;
			}
			echo '<li>'.$list[$i]['nama'].'</li>';
			printListRecursive($list,$list[$i]['id']);
		}
	}
	if( $foundSome ){
		echo '</ul>';
	}
}

printListRecursive($dataitem);
?>