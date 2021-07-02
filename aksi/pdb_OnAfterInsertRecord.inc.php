<?php

if ($success) {
   
   // $userId = $page->GetCurrentUserId();
   // $currentDateTime = SMDateTime::Now();
   $id_pdb = $rowData['id_pdb'];
   $kk_utama = $rowData['kk_utama'];
   $kk_pilihan = $rowData['kk_pilihan'];
   
   if ($kk_pilihan <> "") {
	   $val = ", (uuid(), '$id_pdb', $kk_pilihan, 2";
   }
   $sql = "INSERT INTO pdb_pilihan (`id_pdb_pilihan`, `id_pdb`, `id_kk`, `pilihan`) ";
   $sql .= "VALUES (uuid(), '$id_pdb', $kk_utama, 1)$val";
   $page->GetConnection()->ExecSQL($sql);
   
   $message = sprintf('%s, data telah ditambah', $rowData['nama']);
   $messageDisplayTime = 4;
   
}