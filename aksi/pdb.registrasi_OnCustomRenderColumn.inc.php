<?php

if ($fieldName == 'id_pdb') {
  
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
  
  $nama = $rowData['nama'];
  $nama = sprintf("<span style='font-size:16px; font-weight: bold'>%s</span>", $nama);
  $wilayah = substr($rowData['nik'], 0, 4);
  
  $customText = sprintf("N%'.03d-H%s-21-%s-%s<br />%s", $fieldData, $jenjang_sp, $wilayah, $npsn, $nama);
  $handled = true;
  
}

/*

Kode Jenjang
Tahun PPDB
NIK 4 digit Pertama
NPSN
Kode peserta


*/

