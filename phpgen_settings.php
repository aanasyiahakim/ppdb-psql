<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Asia/Brunei');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => 'localhost',
          'port' => '3306',
          'username' => 'root',
          'database' => 'smkn2s01_kystudio_simata_pdb',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'beranda.php';
}

function GetHomePageBanner()
{
    return '<div style="text-align: center;">
  <h1>
    Selamat Datang<br />
    Aplikasi PPDB SMK Negeri 2 Sumbawa Besar
    <h2>Tahun Pelajaran 2021/2022</h2>
  </h1>
</div>

<style>
  .button {
    border-radius: 4px;
    background-color: #f4511e;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 28px;
    padding: 20px;
    width: 200px;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px;
  }
  
  .button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }
  
  .button span:after {
    content: \'\00bb\';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }
  
  .button:hover span {
    padding-right: 25px;
  }
  
  .button:hover span:after {
    opacity: 1;
    right: 0;
  }
  
</style>

<center>
  <a href="http://localhost/pusdatin/pdb/publik.pdb.php">
    <button class="button"><span>Pendaftaran</span></button>
  </a>
</center>';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Referensi', 'description' => '');
    $result[] = array('caption' => 'Kurikulum', 'description' => '');
    $result[] = array('caption' => 'Pendaftaran', 'description' => '');
    $result[] = array('caption' => 'Verval', 'description' => '');
    $result[] = array('caption' => 'Seleksi', 'description' => '');
    $result[] = array('caption' => 'Laporan', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Pendaftaran PDB', 'short_caption' => 'Biodata Peserta Didik Baru', 'filename' => 'publik.pdb.php', 'name' => 'publik.pdb', 'group_name' => 'Pendaftaran', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Pilihan Kompetensi Keahlian', 'short_caption' => 'Pilihan Kompetensi Keahlian', 'filename' => 'publik.pdb.pilihan.php', 'name' => 'publik.pdb.pilihan', 'group_name' => 'Pendaftaran', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tarik Berkas PDB', 'short_caption' => 'Tarik Berkas PDB', 'filename' => 'publik.pdb.registrasi.php', 'name' => 'publik.pdb.registrasi', 'group_name' => 'Pendaftaran', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Agama', 'short_caption' => 'Agama', 'filename' => 'ref.agama.php', 'name' => 'ref.agama', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Berkas PDB', 'short_caption' => 'Berkas PDB', 'filename' => 'ref.berkas.php', 'name' => 'ref.berkas', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Bidang Keahlian', 'short_caption' => 'Bidang Keahlian', 'filename' => 'ref.bidang.keahlian.php', 'name' => 'ref.bidang.keahlian', 'group_name' => 'Kurikulum', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Jenis Cita-cita', 'short_caption' => 'Jenis Cita-cita', 'filename' => 'ref.jenis.cita.php', 'name' => 'ref.jenis.cita', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Jenis Hobi', 'short_caption' => 'Jenis Hobi', 'filename' => 'ref.jenis.hobi.php', 'name' => 'ref.jenis.hobi', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Jenis Seleksi', 'short_caption' => 'Jenis Seleksi', 'filename' => 'ref.jenis.seleksi.php', 'name' => 'ref.jenis.seleksi', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Satuan Pendidikan', 'short_caption' => 'Satuan Pendidikan', 'filename' => 'ref.satuan.pendidikan.php', 'name' => 'ref.satuan.pendidikan', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Wilayah Administratif', 'short_caption' => 'Wilayah Administratif', 'filename' => 'ref.wilayah.php', 'name' => 'ref.wilayah', 'group_name' => 'Referensi', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Laporan Kilat', 'short_caption' => 'Laporan Kilat', 'filename' => 'lap.kilat.php', 'name' => 'lap.kilat', 'group_name' => 'Laporan', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Laporan Pilihan Kompetensi Keahlian', 'short_caption' => 'Laporan Pilihan Kompetensi Keahlian', 'filename' => 'lap.pilihan.kk.php', 'name' => 'lap.pilihan.kk', 'group_name' => 'Laporan', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Laporan Peralihan TAB', 'short_caption' => 'Laporan Peralihan TAB', 'filename' => 'lap.peralihan.tab.php', 'name' => 'lap.peralihan.tab', 'group_name' => 'Laporan', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Progres Pendaftar Pilihan 1', 'short_caption' => 'Progres Pendaftar Pilihan 1', 'filename' => 'lap.pendaftar.pil1.php', 'name' => 'lap.pendaftar.pil1', 'group_name' => 'Laporan', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Progres Pendaftar Pilihan 2', 'short_caption' => 'Progres Pendaftar Pilihan 2', 'filename' => 'lap.pendaftar.pil2.php', 'name' => 'lap.pendaftar.pil2', 'group_name' => 'Laporan', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Verval Berkas', 'short_caption' => 'Verval Berkas', 'filename' => 'verval.pdb.berkas.php', 'name' => 'verval.pdb.berkas', 'group_name' => 'Verval', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Verval KK', 'short_caption' => 'Verval KK', 'filename' => 'publik.pdb.kk.php', 'name' => 'publik.pdb.kk', 'group_name' => 'Verval', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Seleksi PDB', 'short_caption' => 'Seleksi PDB', 'filename' => 'seleksi.tab.php', 'name' => 'seleksi.tab', 'group_name' => 'Seleksi', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '';
}

function GetPagesFooter()
{
    return
        '';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->setShowNavigation(true);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{
    /*$customHtmlHeaderText = 
    
      '<link rel="stylesheet" href="external_data/pg_styles.css">' .
    
      '<script src="external_data/pg_utils.js"></script>';
    */
    
    $customHtmlHeaderText = '<link rel="stylesheet"  type="text/css" href="components/assets/css/pdb.css">';
}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{
    require 'aksi/OnAfterInsertRecord.inc.php';
}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'd-m-Y';
}

function GetFirstDayOfWeek()
{
    return 1;
}

function GetPageListType()
{
    return PageList::TYPE_MENU;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MyPDOConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
