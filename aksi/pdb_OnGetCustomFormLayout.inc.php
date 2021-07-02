<?php

if ($mode=='insert' or $mode=='edit') {
  
  // this customization is used for Insert and Edit forms
  $layout->setMode(FormLayoutMode::VERTICAL);
  // labels are placed on the top of the editors
  $layout->enableTabs(FormTabsStyle::TABS);
  // these forms consist of tabs
  
  // #Tabulasi Identitas
  $TabIdentitas = $layout->addTab('Biodata');
  $TabIdentitas->setMode(FormLayoutMode::HORIZONTAL);  
  $GrupIdentitas = $TabIdentitas->addGroup(null, 12);
  $GrupIdentitas->addRow()->addCol($columns['nopen'], 4, 2);
  $GrupIdentitas->addRow()->addCol($columns['no_kk'], 4, 2);
  $GrupIdentitas->addRow()->addCol($columns['nama'], 10, 2);
  $GrupIdentitas->addRow()->addCol($columns['nik'], 10, 2);
  $GrupIdentitas->addRow()->addCol($columns['jenis_kelamin'], 10, 2);
  $GrupIdentitas->addRow()
    ->addCol($columns['tempat_lahir'], 4, 2)
    ->addCol($columns['tanggal_lahir'], 4, 2);
  $GrupIdentitas->addRow()
    ->addCol($columns['id_agama'], 4, 2)
    ->addCol($columns['golongan_darah'],4, 2);
  
  
  // -------------------------------------------------------------
  
  $TabAlamat = $layout->addTab('Alamat');
  $TabAlamat->setMode(FormLayoutMode::HORIZONTAL);
  $GrupAlamat = $TabAlamat->addGroup(null,12);
  $GrupAlamat->addRow()->addCol($columns['alamat_jalan'], 10, 2);
  $GrupAlamat->addRow()
    ->addCol($columns['rt'], 4, 2)
    ->addCol($columns['rw'], 4, 2);
  $GrupAlamat->addRow()->addCol($columns['nama_dusun'], 10, 2);
  $GrupAlamat->addRow()->addCol($columns['kode_wilayah'], 10, 2);
  
  // -------------------------------------------------------------
  
  $TabOrtu = $layout->addTab('Orang Tua');
  $TabOrtu->setMode(FormLayoutMode::HORIZONTAL);
  $GrupOrtu = $TabOrtu->addGroup(null,12);
  $GrupOrtu->addRow()->addCol($columns['nama_ayah'], 10, 2);
  $GrupOrtu->addRow()->addCol($columns['nama_ibu'], 10, 2);
  
  $TabSP = $layout->addTab('Satuan Pendidikan');
  $TabSP->setMode(FormLayoutMode::HORIZONTAL);
  $GrupSP = $TabSP->addGroup(null, 12);
  $GrupSP->addRow()->addCol($columns['id_sp'], 10, 2);
  $GrupSP->addRow()->addCol($columns['nisn'], 4, 2);
  $GrupSP->addRow()->addCol($columns['nopes'], 6, 2);
  
  $TabKontak = $layout->addTab('Kontak');
  $TabKontak->setMode(FormLayoutMode::HORIZONTAL);
  $GrupKontak = $TabKontak->addGroup(null, 12);
  $GrupKontak->addRow()->addCol($columns['email'], 10, 2);
  $GrupKontak->addRow()->addCol($columns['kontak_pdb'], 4, 2);
  $GrupKontak->addRow()
    ->addCol($columns['kontak_ayah'], 4, 2)
    ->addCol($columns['kontak_ibu'], 4, 2);
  $GrupKontak->addRow()->addCol($columns['kontak_lain'], 4, 2);
  
  $TabLain = $layout->addTab('Lain-lain');
  $TabLain->setMode(FormLayoutMode::HORIZONTAL);
  $GrupLain = $TabLain->addGroup(null, 12);
  $GrupLain->addRow()
    ->addCol($columns['id_jenis_tinggal'], 4, 2)
    ->addCol($columns['id_alat_transportasi'], 4, 2);
  $GrupLain->addRow()
    ->addCol($columns['tinggi_badan'], 4, 2)
    ->addCol($columns['berat_badan'], 4, 2);
  $GrupLain->addRow()->addCol($columns['cita'], 10, 2);
  $GrupLain->addRow()->addCol($columns['hobi'], 10, 2);
  
}