<?php

$id = 'id_pdb';
$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(true);
  $column->setCaption('Nama Peserta Didik');
}

$column = $this->GetGrid()->getViewColumn('id_kk');
$column->setCaption('Kompetensi keahlian');

$column = $this->GetGrid()->getViewColumn('pilihan');
$column->setCaption('Pilihan ke');

$column = $this->GetGrid()->getInsertColumn('id_kk');
$column->setCaption('Kompetensi keahlian');

$column = $this->GetGrid()->getInsertColumn('pilihan');
$column->setCaption('Pilihan ke');

$column = $this->GetGrid()->getEditColumn('id_kk');
$column->setCaption('Kompetensi keahlian');

$column = $this->GetGrid()->getEditColumn('pilihan');
$column->setCaption('Pilihan ke');
