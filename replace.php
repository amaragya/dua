<?php

$dataawal = "2017-07-23";

$hasil = explode("-", $dataawal);
$hasil[1] = 10;

echo implode("-", $hasil);

?>

