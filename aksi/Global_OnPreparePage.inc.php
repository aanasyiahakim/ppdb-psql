<?php

/*
if (!GetApplication()->IsLoggedInAsAdmin()) {

    $updateDateTimeColumnName = 'update_date_time';

    $column = $this->GetGrid()->getSingleRecordViewColumn($updateDateTimeColumnName);

    if ($column) {

        $column->setVisible(false);

    }

    $column = $this->GetGrid()->getViewColumn($updateDateTimeColumnName);

    if ($column) {

        $column->setVisible(false);

    }

 

    $statusColumnName = 'status';

    $column = $this->GetGrid()->getEditColumn($statusColumnName);

    if ($column) {

        $column->setVisible(false);

    }

    $column = $this->GetGrid()->getInsertColumn($statusColumnName);

    if ($column) {

        $column->setVisible(false);

    }

}
*/

// id_pdb_reg
$id = 'id_pdb_reg';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

// Aktif
$id = 'aktif';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

// Tanggal dibuat
$id = 'tanggal_dibuat';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}


// Tanggal perbarui
$id = 'tanggal_perbarui';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

// Sinkronisasi
$id = 'sinkronisasi';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

// Peserta didik baru
$id = 'id_pdb';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

// Pilihan kompetensi keahlian
$id = 'id_pdb_pilihan';
$column = $this->GetGrid()->getSingleRecordViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}