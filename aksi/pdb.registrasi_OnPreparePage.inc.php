<?php

$id = 'id_pdb';
$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(true);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(true);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(true);
}

$id = 'nama';
$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$id = 'status';
$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}































$id = 'nik';
$column = $this->GetGrid()->getViewColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getInsertColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getEditColumn($id);
if ($column) {
  $column->setVisible(false);
}

$column = $this->GetGrid()->getViewColumn('id_pdb');
$column->setCaption('Nama PDB');
$column = $this->GetGrid()->getViewColumn('tanggal_keluar');
$column->setCaption('Tanggal Keluar');
$column = $this->GetGrid()->getViewColumn('alasan');
$column->setCaption('Alasan Keluar');

$column = $this->GetGrid()->getInsertColumn('id_pdb');
$column->setCaption('Nama PDB');
$column = $this->GetGrid()->getInsertColumn('tanggal_keluar');
$column->setCaption('Tanggal Keluar');
$column = $this->GetGrid()->getInsertColumn('alasan');
$column->setCaption('Alasan Keluar');

$column = $this->GetGrid()->getEditColumn('id_pdb');
$column->setCaption('Nama PDB');
$column = $this->GetGrid()->getEditColumn('tanggal_keluar');
$column->setCaption('Tanggal Keluar');
$column = $this->GetGrid()->getEditColumn('alasan');
$column->setCaption('Alasan Keluar');
