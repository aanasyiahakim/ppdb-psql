<?php

/*
function OnAfterInsertRecord ($page, $rowData, $tableName, 

       &$success, &$message, &$messageDisplayTime)
*/	   

switch ($tableName) {
  case 'publik.pdb':
	/* 
	 * Tabel : pdb
	 * Kolom : 
	 * Unik  : 
	
	$_SQL['cekKK'] = sprintf(
							"SELECT count(id_kk) FROM pdb_pilihan 
							WHERE id_pdb = '%s' AND id_kk = '%s'",$rowData['id_pdb'], $rowData['id_kk']
					);
	$_Hasil['cekKK'] = $page->GetConnection()->ExecScalarSQL($_SQL['cekKK']);
	if ($_Hasil['cekKK'] > 0) {
		
		$_SQL['KK'] = sprintf(
							"SELECT nama_kk FROM kystudio_ref.kompetensi_keahlian 
							WHERE id_kk = '%s'",$rowData['id_kk']
					);
		$_Hasil['KK'] = $page->GetConnection()->ExecScalarSQL($_SQL['KK']);
		$_KK = $_Hasil['KK'];
		$pesan1 = sprintf('%s sudah dipilih sebagai pilihan %s', $_KK, $rowData['pilihan']);
		
	}
	$_SQL['cekPilihan'] = sprintf(
							"SELECT count(pilihan) FROM pdb_pilihan 
							WHERE id_pdb = '%s' AND pilihan = '%s'",$rowData['id_pdb'], $rowData['pilihan']
						);
	$_Hasil['cekPilihan'] = $page->GetConnection()->ExecScalarSQL($_SQL['cekPilihan']);
	if ($_Hasil['cekPilihan'] > 0) {
		$pesan2 = sprintf('Pilihan %s sudah dipilih', $rowData['pilihan']);
	}
    
	if (!$success) {
		$message = sprintf('Data pilihan kompetensi keahlian gagal disimpan, karena<br />* %s<br />* %s', $pesan1, $pesan2);
		$messageDisplayTime = 4;
	}
    break;
	*/
	case 'publik.pdb.pilihan':
	/* 
	 * Tabel : pdb_pilihan
	 * Kolom : id_pdb_pilihan, id_pdb, id_kk, pilihan
	 * Unik  : (id_pdb, id_kk), (id_pdb, pilihan)
	
	$_SQL['cekKK'] = sprintf(
							"SELECT count(id_kk) FROM pdb_pilihan 
							WHERE id_pdb = '%s' AND id_kk = '%s'",$rowData['id_pdb'], $rowData['id_kk']
					);
	$_Hasil['cekKK'] = $page->GetConnection()->ExecScalarSQL($_SQL['cekKK']);
	if ($_Hasil['cekKK'] > 0) {
		
		$_SQL['KK'] = sprintf(
							"SELECT nama_kk FROM kystudio_ref.kompetensi_keahlian 
							WHERE id_kk = '%s'",$rowData['id_kk']
					);
		$_Hasil['KK'] = $page->GetConnection()->ExecScalarSQL($_SQL['KK']);
		$_KK = $_Hasil['KK'];
		$pesan1 = sprintf('%s sudah dipilih sebagai pilihan %s', $_KK, $rowData['pilihan']);
		
	}
	$_SQL['cekPilihan'] = sprintf(
							"SELECT count(pilihan) FROM pdb_pilihan 
							WHERE id_pdb = '%s' AND pilihan = '%s'",$rowData['id_pdb'], $rowData['pilihan']
						);
	$_Hasil['cekPilihan'] = $page->GetConnection()->ExecScalarSQL($_SQL['cekPilihan']);
	if ($_Hasil['cekPilihan'] > 0) {
		$pesan2 = sprintf('Pilihan %s sudah dipilih', $rowData['pilihan']);
	}
    
	if (!$success) {
		$message = sprintf('Data pilihan kompetensi keahlian gagal disimpan, karena<br />* %s<br />* %s', $pesan1, $pesan2);
		$messageDisplayTime = 4;
	}
    break;
	*/
} 