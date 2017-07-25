<?php

 header("Access-Control-Allow-Origin: http://localhost/");
mysql_connect("localhost","root","");
mysql_select_db("test");

@$namadomain = $_REQUEST['nama'];
$datadomain = mysql_query("select * from domain where namadomain='$namadomain'");
if(mysql_num_rows($datadomain)){
	echo 1;
}else{
	echo 2;
}
?>

