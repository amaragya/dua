<?php
header("Access-Control-Allow-Origin: *");
mysql_connect("localhost","root","");
mysql_select_db("test");

$ambil = $_REQUEST['bidang'];

if($ambil == 'provinsi'){
	$qongkir = mysql_query("select * from ongkir group by provinsi");

	echo "<option value=''>Pilih Provinsi</option>";
	while($ongkir = mysql_fetch_array($qongkir)){
		echo "<option value='$ongkir[provinsi]'>$ongkir[provinsi]</option>";
	}
}else if($ambil == 'kota'){
	$provinsi = $_REQUEST['provinsi'];
	$qongkir = mysql_query("select * from ongkir where provinsi='$provinsi' group by kota");


	echo "<option value=''>Pilih kota</option>";
	while($ongkir = mysql_fetch_array($qongkir)){
		echo "<option value='$ongkir[kota]'>$ongkir[kota]</option>";
	}

}else if($ambil == 'kecamatan'){
	$provinsi = $_REQUEST['provinsi'];
	$kota = $_REQUEST['kota'];

	$qongkir = mysql_query("select * from ongkir where provinsi='$provinsi' and kota='$kota' group by kecamatan");


	echo "<option value=''>Pilih kecamatan</option>";
	while($ongkir = mysql_fetch_array($qongkir)){
		echo "<option value='$ongkir[kecamatan]'>$ongkir[kecamatan]</option>";
	}

}else if($ambil == 'jenis'){
	$provinsi = $_REQUEST['provinsi'];
	$kota = $_REQUEST['kota'];
	$kecamatan = $_REQUEST['kecamatan'];

	$ongkir =mysql_query("select  oke ,reg, yes from ongkir where provinsi='$provinsi' and kota ='$kota' and kecamatan='$kecamatan'");

	while($qongkir= mysql_fetch_array($ongkir)){
		if($qongkir['oke'] != ""){
			echo "<option value='oke'>OKE</option>";
		}
		if($qongkir['reg'] != ""){
			echo "<option value='reg'>REGULER</option>";
		}
		if($qongkir['yes'] != ""){
			echo "<option value='oke'>YES</option>";
		}
	}


}else if($ambil == 'ongkir'){
	$provinsi = $_REQUEST['provinsi'];
	$kota = $_REQUEST['kota'];
	$kecamatan = $_REQUEST['kecamatan'];
	$jenis = $_REQUEST['jenis'];
	$hasil = array();
	$qongkir = mysql_query("select id, $jenis as hasil from ongkir where provinsi='$provinsi' and kota='$kota' and kecamatan='$kecamatan'");

	while($ongkir = mysql_fetch_array($qongkir)){
		$hasil['harga'] = $ongkir['hasil'];
		$hasil['id'] = $ongkir['id'];
	}
	echo json_encode($hasil);
}


?>