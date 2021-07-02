<?php

$data = explode(' ', strtoupper(trim($rowData['nama'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['nama'] = $dataBaru;

$data = explode(' ', strtoupper(trim($rowData['tempat_lahir'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['tempat_lahir'] = $dataBaru;

$data = explode(' ', strtoupper(trim($rowData['alamat_jalan'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['alamat_jalan'] = $dataBaru;

$data = explode(' ', strtoupper(trim($rowData['nama_dusun'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['nama_dusun'] = $dataBaru;
            
$data = explode(' ', strtoupper(trim($rowData['nama_ayah'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['nama_ayah'] = $dataBaru;

$data = explode(' ', strtoupper(trim($rowData['nama_ibu'])));
$dataBaru = '';
for ($x=0;$x<count($data);$x++) {
	$kapital = substr($data[$x], 0, 1);
	$kecil = strtolower(substr($data[$x], 1, strlen($data[$x])));
	$dataBaru .= $kapital . $kecil . ' ';
}
$rowData['nama_ibu'] = $dataBaru;

$rowData['email'] = strtolower(trim($rowData['email']));