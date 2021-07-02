<?php

if ($fieldName == 'nopen') {
  
  // Kode Jenjang
  $sql = "SELECT `npsn`, `jenjang_sp` FROM `smkn2s01_kystudio_ref`.`satuan_pendidikan`  ";
  $sql .= "WHERE `id_sp` IN(SELECT `id_sp` FROM `pdb` ";
  $sql .= "WHERE `id_pdb` = '" . $rowData['id_pdb'] . "')";
  //$kodeJenjang = $page->GetConnection()->ExecSQL($sql);
  
  $kodeJenjang = array();
  $this->GetConnection()->ExecQueryToArray($sql, $kodeJenjang);
  
  foreach ($kodeJenjang as $br) {
    
    $npsn = $br['npsn'];
    $jenjang_sp = $br['jenjang_sp'];
  
  }
  
  $wilayah = substr($rowData['nik'], 0, 4);
  
  $customText = sprintf("N%'.03d-H%s-21-%s-%s", $fieldData, $jenjang_sp, $wilayah, $npsn);
  $handled = true;
  
}

/*

Kode Jenjang
Tahun PPDB
NIK 4 digit Pertama
NPSN
Kode peserta


*/

if ($fieldName == 'kk_utama') {
	
	//if ($rowData['kk_utama'] != "")  {
		
		$sql = "SELECT COUNT(*) FROM `smkn2s01_kystudio_simata_pdb`.`pdb_pilihan` ";
		$sql .= "WHERE `id_pdb` IN(SELECT `id_pdb` FROM `smkn2s01_kystudio_simata_pdb`.`pdb` ";
		$sql .= "WHERE id_pdb = '".$rowData['id_pdb']."')";
		
		$banyak = $this->GetConnection()->ExecScalarSQL($sql);
		if ($banyak > 0) {
			
		
		
		
		$sql = "SELECT `nama_kk` FROM `smkn2s01_kystudio_ref`.`kompetensi_keahlian` ";
		$sql .= "WHERE `id_kk` IN(SELECT `id_kk` FROM `smkn2s01_kystudio_simata_pdb`.`pdb_pilihan` ";
		$sql .= "WHERE `id_pdb` IN(SELECT `id_pdb` FROM `smkn2s01_kystudio_simata_pdb`.`pdb` ";
		$sql .= "WHERE `id_pdb` = '".$rowData['id_pdb']."') AND ";
		$sql .= "`pilihan` = 1)";
		
		$kkUtama = $this->GetConnection()->ExecScalarSQL($sql);
		$customText = $kkUtama;
	$handled = true;
	
		}
	
	//} else {
		//$kkUtama = "";
	//}
	
	// $customText = $kkUtama;
	// $handled = true;
  
}

if ($fieldName == 'kk_pilihan') {
	
	//if ($rowData['kk_pilihan'] != "")  {
		
		$sql = "SELECT COUNT(*) FROM `smkn2s01_kystudio_simata_pdb`.`pdb_pilihan` ";
		$sql .= "WHERE `id_pdb` IN(SELECT `id_pdb` FROM `smkn2s01_kystudio_simata_pdb`.`pdb` ";
		$sql .= "WHERE `id_pdb` = '".$rowData['id_pdb']."')";
		
		$banyak = $this->GetConnection()->ExecScalarSQL($sql);
		if ($banyak == 2) {
			
		
		
		$sql = "SELECT `nama_kk` FROM `smkn2s01_kystudio_ref`.`kompetensi_keahlian` ";
		$sql .= "WHERE `id_kk` IN(SELECT `id_kk` FROM `smkn2s01_kystudio_simata_pdb`.`pdb_pilihan` ";
		$sql .= "WHERE `id_pdb` IN(SELECT `id_pdb` FROM `smkn2s01_kystudio_simata_pdb`.`pdb` ";
		$sql .= "WHERE `id_pdb` = '".$rowData['id_pdb']."') AND ";
		$sql .= "pilihan = 2)";
		
		$kkPilihan  = $this->GetConnection()->ExecScalarSQL($sql);
		
		$customText = $kkPilihan;
	$handled = true;
		
		}
	
	//} else {
	//	$kkPilihan = "";
	//}
  
  // $customText = $kkPilihan;
  //$handled = true;
  
}