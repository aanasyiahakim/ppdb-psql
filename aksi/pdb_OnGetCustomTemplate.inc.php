<?php

if ($part == PagePart::Grid && $mode == PageMode::ExportPdf) {
               $result = 'pdb.tpl';
}

if ($part == PagePart::Grid && $mode == PageMode::ExportExcel) {
               $result = 'pdb.excel.tpl';
}
