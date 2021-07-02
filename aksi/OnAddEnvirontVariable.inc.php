<?php

$_SQL['select'] = 'SELECT uuid()';
$_Hasil['UUID'] = $this->GetConnection()->ExecScalarSQL($_SQL['select']);
$variables['UUID'] = $_Hasil['UUID'];

$_SQL['select'] = 'SELECT max(nopen) FROM pdb';
$_Hasil['MAKS'] = $this->GetConnection()->ExecScalarSQL($_SQL['select']);
$variables['MAKS'] = $_Hasil['MAKS'] + 1;