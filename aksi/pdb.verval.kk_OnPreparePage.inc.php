<?php

$column = $this->GetGrid()->getViewColumn('nopen');
$column->setCaption('Noreg');

$column = $this->GetGrid()->getViewColumn('no_kk');
$column->setCaption('No.KK');

$column = $this->GetGrid()->getViewColumn('nik');
$column->setCaption('NIK');
			
$column = $this->GetGrid()->getViewColumn('jenis_kelamin');
$column->setCaption('L/P');

$column = $this->GetGrid()->getViewColumn('id_agama');
$column->setCaption('Agama');

$column = $this->GetGrid()->getViewColumn('rt');
$column->setCaption('RT');

$column = $this->GetGrid()->getViewColumn('rw');
$column->setCaption('RW');

$column = $this->GetGrid()->getViewColumn('kode_wilayah');
$column->setCaption('Desa/Kelurahan');

$column = $this->GetGrid()->getInsertColumn('nopen');
$column->setCaption('No.Registrasi');

$column = $this->GetGrid()->getInsertColumn('no_kk');
$column->setCaption('No.KK');

$column = $this->GetGrid()->getInsertColumn('nik');
$column->setCaption('NIK');
			
$column = $this->GetGrid()->getInsertColumn('jenis_kelamin');
$column->setCaption('L/P');

$column = $this->GetGrid()->getInsertColumn('id_agama');
$column->setCaption('Agama');

$column = $this->GetGrid()->getInsertColumn('rt');
$column->setCaption('RT');

$column = $this->GetGrid()->getInsertColumn('rw');
$column->setCaption('RW');

$column = $this->GetGrid()->getInsertColumn('kode_wilayah');
$column->setCaption('Desa/Kelurahan');

$column = $this->GetGrid()->getEditColumn('nopen');
$column->setCaption('No.Registrasi');

$column = $this->GetGrid()->getEditColumn('no_kk');
$column->setCaption('No.KK');

$column = $this->GetGrid()->getEditColumn('nik');
$column->setCaption('NIK');
			
$column = $this->GetGrid()->getEditColumn('jenis_kelamin');
$column->setCaption('L/P');

$column = $this->GetGrid()->getEditColumn('id_agama');
$column->setCaption('Agama');

$column = $this->GetGrid()->getEditColumn('rt');
$column->setCaption('RT');

$column = $this->GetGrid()->getEditColumn('rw');
$column->setCaption('RW');

$column = $this->GetGrid()->getEditColumn('kode_wilayah');
$column->setCaption('Desa/Kelurahan');