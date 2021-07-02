<?php

$column = $this->GetGrid()->getViewColumn('id_berkas');
$column->setCaption('Kelengkapan berkas');

$column = $this->GetGrid()->getInsertColumn('id_berkas');
$column->setCaption('Kelengkapan berkas');

$column = $this->GetGrid()->getEditColumn('id_berkas');
$column->setCaption('Kelengkapan berkas');

/*
$queryResult = array();
$sql = "SELECT * FROM `kystudio_ref`.`berkas`";
$this->GetConnection()->ExecQueryToArray($sql, $queryResult);

foreach ($queryResult as $row) {
	$berkas1 = $row[0];
	
	$sql_pdb = "SELECT * FROM `pdb_berkas` ";
	$sql_pdb .= "WHERE `id_pdb` = '' AND ";
$this->GetConnection()->ExecQueryToArray($sql, $queryResult);
	
	$berkas2 = $row[1];
	$berkas3 = $row[2];
	$berkas4 = $row[3];
	$berkas5 = $row[4];
	$berkas6 = $row[5];
	$berkas7 = $row[6];
	$berkas8 = $row[7];
	$berkas9 = $row[8];
	$berkas10 = $row[9];
} 
*/