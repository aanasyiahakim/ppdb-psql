<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class seleksi_tabPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Seleksi PDB');
            $this->SetMenuLabel('Seleksi PDB');
    
            $selectQuery = 'SELECT 
            	`ps`.*, `kk`.`nama_kk`, 
                `pp`.`pilihan`, `p`.`nopen`, 
                `p`.`nama`, `p`.`jenis_kelamin`, `p`.`nik`,
                `p`.`nisn`, `p`.`id_sp`, 
                `p`.`nama_ayah`, `p`.`nama_ibu`, 
                `p`.`kontak_pdb`, `p`.`kontak_ayah`, 
                `p`.`kontak_ibu`, `p`.`kontak_lain`
            FROM `pdb` `p` 
            INNER JOIN `pdb_pilihan` `pp` 
            	ON `pp`.`id_pdb` = `p`.`id_pdb` 
            INNER JOIN `pdb_seleksi` `ps`
            	ON `ps`.`id_pdb_pilihan` = `pp`.`id_pdb_pilihan`
            INNER JOIN `smkn2s01_kystudio_ref`.`kompetensi_keahlian` `kk`
            	ON `kk`.`id_kk` = `pp`.`id_kk`
            /*WHERE 
            	`pp`.`status` = 2
            
            
            `id_pdb_seleksi`, 
            
            `id_pdb_pilihan`, `tanggal_seleksi`, 
            
            `jenis_seleksi`, `status`	
            
            	*/';
            $insertQuery = array();
            $updateQuery = array('UPDATE `pdb_seleksi` 
            SET 
                `id_pdb_pilihan`=:id_pdb_pilihan,
                `tanggal_seleksi`=:tanggal_seleksi,
                `jenis_seleksi`=:jenis_seleksi,
                `status`=:status , 
                `seleksi_prov`=:seleksi_prov
            WHERE 
                  `id_pdb_seleksi` = :OLD_id_pdb_seleksi');
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'seleksi.tab');
            $this->dataset->addFields(
                array(
                    new StringField('id_pdb_seleksi', false, true),
                    new StringField('id_pdb_pilihan'),
                    new DateField('tanggal_seleksi'),
                    new IntegerField('jenis_seleksi'),
                    new IntegerField('status'),
                    new IntegerField('seleksi_prov'),
                    new StringField('nama_kk'),
                    new IntegerField('pilihan'),
                    new IntegerField('nopen'),
                    new StringField('nama'),
                    new StringField('jenis_kelamin'),
                    new StringField('nik'),
                    new StringField('nisn'),
                    new StringField('id_sp'),
                    new StringField('nama_ayah'),
                    new StringField('nama_ibu'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain')
                )
            );
            $this->dataset->AddLookupField('jenis_seleksi', '(SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`)', new IntegerField('id_jenis_seleksi'), new StringField('nama_seleksi', false, false, false, false, 'jenis_seleksi_nama_seleksi', 'jenis_seleksi_nama_seleksi_ref_jenis_seleksi'), 'jenis_seleksi_nama_seleksi_ref_jenis_seleksi');
            $this->dataset->AddLookupField('id_sp', '(SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`)', new StringField('id_sp'), new StringField('npsn_nama', false, false, false, false, 'id_sp_npsn_nama', 'id_sp_npsn_nama_ref_satuan_pendidikan'), 'id_sp_npsn_nama_ref_satuan_pendidikan');
        }
    
        protected function DoPrepare() {
            require 'aksi/Global_OnPreparePage.inc.php';
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(50);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi'),
                new FilterColumn($this->dataset, 'id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan'),
                new FilterColumn($this->dataset, 'tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi'),
                new FilterColumn($this->dataset, 'jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi'),
                new FilterColumn($this->dataset, 'status', 'status', 'Lulus'),
                new FilterColumn($this->dataset, 'seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi'),
                new FilterColumn($this->dataset, 'pilihan', 'pilihan', 'Pilihan'),
                new FilterColumn($this->dataset, 'nama_kk', 'nama_kk', 'Nama Kk'),
                new FilterColumn($this->dataset, 'nopen', 'nopen', 'Nopen'),
                new FilterColumn($this->dataset, 'nama', 'nama', 'Nama'),
                new FilterColumn($this->dataset, 'jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin'),
                new FilterColumn($this->dataset, 'nik', 'nik', 'Nik'),
                new FilterColumn($this->dataset, 'nisn', 'nisn', 'Nisn'),
                new FilterColumn($this->dataset, 'id_sp', 'id_sp_npsn_nama', 'Id Sp'),
                new FilterColumn($this->dataset, 'nama_ayah', 'nama_ayah', 'Nama Ayah'),
                new FilterColumn($this->dataset, 'nama_ibu', 'nama_ibu', 'Nama Ibu'),
                new FilterColumn($this->dataset, 'kontak_pdb', 'kontak_pdb', 'Kontak Pdb'),
                new FilterColumn($this->dataset, 'kontak_ayah', 'kontak_ayah', 'Kontak Ayah'),
                new FilterColumn($this->dataset, 'kontak_ibu', 'kontak_ibu', 'Kontak Ibu'),
                new FilterColumn($this->dataset, 'kontak_lain', 'kontak_lain', 'Kontak Lain')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_pdb_seleksi'])
                ->addColumn($columns['id_pdb_pilihan'])
                ->addColumn($columns['tanggal_seleksi'])
                ->addColumn($columns['jenis_seleksi'])
                ->addColumn($columns['status'])
                ->addColumn($columns['seleksi_prov'])
                ->addColumn($columns['pilihan'])
                ->addColumn($columns['nama_kk'])
                ->addColumn($columns['nopen'])
                ->addColumn($columns['nama'])
                ->addColumn($columns['jenis_kelamin'])
                ->addColumn($columns['nik'])
                ->addColumn($columns['nisn'])
                ->addColumn($columns['id_sp'])
                ->addColumn($columns['nama_ayah'])
                ->addColumn($columns['nama_ibu'])
                ->addColumn($columns['kontak_pdb'])
                ->addColumn($columns['kontak_ayah'])
                ->addColumn($columns['kontak_ibu'])
                ->addColumn($columns['kontak_lain']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('tanggal_seleksi')
                ->setOptionsFor('jenis_seleksi')
                ->setOptionsFor('status')
                ->setOptionsFor('seleksi_prov')
                ->setOptionsFor('nama_kk')
                ->setOptionsFor('nama')
                ->setOptionsFor('id_sp');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_pdb_seleksi_edit');
            
            $filterBuilder->addColumn(
                $columns['id_pdb_seleksi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('id_pdb_pilihan_edit');
            
            $filterBuilder->addColumn(
                $columns['id_pdb_pilihan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('tanggal_seleksi_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['tanggal_seleksi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('jenis_seleksi_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_seleksi_tab_jenis_seleksi_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('jenis_seleksi', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_seleksi_tab_jenis_seleksi_search');
            
            $filterBuilder->addColumn(
                $columns['jenis_seleksi'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('status');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['status'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('seleksi_prov');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['seleksi_prov'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('pilihan_edit');
            
            $filterBuilder->addColumn(
                $columns['pilihan'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nama_kk_edit');
            
            $filterBuilder->addColumn(
                $columns['nama_kk'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('nopen_edit');
            
            $filterBuilder->addColumn(
                $columns['nopen'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nama_edit');
            
            $filterBuilder->addColumn(
                $columns['nama'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('jenis_kelamin_edit');
            
            $filterBuilder->addColumn(
                $columns['jenis_kelamin'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nik_edit');
            
            $filterBuilder->addColumn(
                $columns['nik'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nisn_edit');
            
            $filterBuilder->addColumn(
                $columns['nisn'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_sp_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_seleksi_tab_id_sp_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_sp', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_seleksi_tab_id_sp_search');
            
            $text_editor = new TextEdit('id_sp');
            
            $filterBuilder->addColumn(
                $columns['id_sp'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nama_ayah_edit');
            
            $filterBuilder->addColumn(
                $columns['nama_ayah'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nama_ibu_edit');
            
            $filterBuilder->addColumn(
                $columns['nama_ibu'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kontak_pdb_edit');
            
            $filterBuilder->addColumn(
                $columns['kontak_pdb'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kontak_ayah_edit');
            
            $filterBuilder->addColumn(
                $columns['kontak_ayah'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kontak_ibu_edit');
            
            $filterBuilder->addColumn(
                $columns['kontak_ibu'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('kontak_lain_edit');
            
            $filterBuilder->addColumn(
                $columns['kontak_lain'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_pdb_seleksi field
            //
            $column = new TextViewColumn('id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tanggal_seleksi field
            //
            $column = new DateTimeViewColumn('tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_seleksi field
            //
            $column = new TextViewColumn('jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new CheckboxViewColumn('status', 'status', 'Lulus', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for seleksi_prov field
            //
            $column = new CheckboxViewColumn('seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Nama Kk', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_ayah field
            //
            $column = new TextViewColumn('nama_ayah', 'nama_ayah', 'Nama Ayah', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_ibu field
            //
            $column = new TextViewColumn('nama_ibu', 'nama_ibu', 'Nama Ibu', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_pdb_seleksi field
            //
            $column = new TextViewColumn('id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tanggal_seleksi field
            //
            $column = new DateTimeViewColumn('tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_seleksi field
            //
            $column = new TextViewColumn('jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new CheckboxViewColumn('status', 'status', 'Lulus', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for seleksi_prov field
            //
            $column = new CheckboxViewColumn('seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Nama Kk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_ayah field
            //
            $column = new TextViewColumn('nama_ayah', 'nama_ayah', 'Nama Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_ibu field
            //
            $column = new TextViewColumn('nama_ibu', 'nama_ibu', 'Nama Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb_seleksi field
            //
            $editor = new TextEdit('id_pdb_seleksi_edit');
            $editColumn = new CustomEditColumn('Id Pdb Seleksi', 'id_pdb_seleksi', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_pdb_pilihan field
            //
            $editor = new TextEdit('id_pdb_pilihan_edit');
            $editColumn = new CustomEditColumn('Id Pdb Pilihan', 'id_pdb_pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tanggal_seleksi field
            //
            $editor = new DateTimeEdit('tanggal_seleksi_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Seleksi', 'tanggal_seleksi', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jenis_seleksi field
            //
            $editor = new DynamicCombobox('jenis_seleksi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Jenis Seleksi', 'jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'edit_seleksi_tab_jenis_seleksi_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_seleksi', 'nama_seleksi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Lulus', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for seleksi_prov field
            //
            $editor = new CheckBox('seleksi_prov_edit');
            $editColumn = new CustomEditColumn('Seleksi Provinsi', 'seleksi_prov', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama_kk field
            //
            $editor = new TextEdit('nama_kk_edit');
            $editColumn = new CustomEditColumn('Nama Kk', 'nama_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new TextEdit('jenis_kelamin_edit');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nik field
            //
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new TextEdit('nisn_edit');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_sp field
            //
            $editor = new DynamicCombobox('id_sp_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.satuan.pendidikan');
            $lookupDataset->addFields(
                array(
                    new StringField('id_sp', false, true),
                    new StringField('npsn'),
                    new StringField('nama_sp'),
                    new StringField('jenjang_sp'),
                    new IntegerField('status'),
                    new StringField('npsn_nama')
                )
            );
            $lookupDataset->setOrderByField('npsn_nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Sp', 'id_sp', 'id_sp_npsn_nama', 'edit_seleksi_tab_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'npsn_nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama_ayah field
            //
            $editor = new TextEdit('nama_ayah_edit');
            $editColumn = new CustomEditColumn('Nama Ayah', 'nama_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama_ibu field
            //
            $editor = new TextEdit('nama_ibu_edit');
            $editColumn = new CustomEditColumn('Nama Ibu', 'nama_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak Pdb', 'kontak_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for tanggal_seleksi field
            //
            $editor = new DateTimeEdit('tanggal_seleksi_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Seleksi', 'tanggal_seleksi', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jenis_seleksi field
            //
            $editor = new DynamicCombobox('jenis_seleksi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Jenis Seleksi', 'jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'multi_edit_seleksi_tab_jenis_seleksi_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_seleksi', 'nama_seleksi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Lulus', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for seleksi_prov field
            //
            $editor = new CheckBox('seleksi_prov_edit');
            $editColumn = new CustomEditColumn('Seleksi Provinsi', 'seleksi_prov', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nik field
            //
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new TextEdit('nisn_edit');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb_seleksi field
            //
            $editor = new TextEdit('id_pdb_seleksi_edit');
            $editColumn = new CustomEditColumn('Id Pdb Seleksi', 'id_pdb_seleksi', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_pdb_pilihan field
            //
            $editor = new TextEdit('id_pdb_pilihan_edit');
            $editColumn = new CustomEditColumn('Id Pdb Pilihan', 'id_pdb_pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tanggal_seleksi field
            //
            $editor = new DateTimeEdit('tanggal_seleksi_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Seleksi', 'tanggal_seleksi', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jenis_seleksi field
            //
            $editor = new DynamicCombobox('jenis_seleksi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Jenis Seleksi', 'jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'insert_seleksi_tab_jenis_seleksi_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_seleksi', 'nama_seleksi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Lulus', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for seleksi_prov field
            //
            $editor = new CheckBox('seleksi_prov_edit');
            $editColumn = new CustomEditColumn('Seleksi Provinsi', 'seleksi_prov', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama_kk field
            //
            $editor = new TextEdit('nama_kk_edit');
            $editColumn = new CustomEditColumn('Nama Kk', 'nama_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new TextEdit('jenis_kelamin_edit');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nik field
            //
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new TextEdit('nisn_edit');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_sp field
            //
            $editor = new DynamicCombobox('id_sp_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.satuan.pendidikan');
            $lookupDataset->addFields(
                array(
                    new StringField('id_sp', false, true),
                    new StringField('npsn'),
                    new StringField('nama_sp'),
                    new StringField('jenjang_sp'),
                    new IntegerField('status'),
                    new StringField('npsn_nama')
                )
            );
            $lookupDataset->setOrderByField('npsn_nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Sp', 'id_sp', 'id_sp_npsn_nama', 'insert_seleksi_tab_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'npsn_nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama_ayah field
            //
            $editor = new TextEdit('nama_ayah_edit');
            $editColumn = new CustomEditColumn('Nama Ayah', 'nama_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama_ibu field
            //
            $editor = new TextEdit('nama_ibu_edit');
            $editColumn = new CustomEditColumn('Nama Ibu', 'nama_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak Pdb', 'kontak_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_pdb_seleksi field
            //
            $column = new TextViewColumn('id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tanggal_seleksi field
            //
            $column = new DateTimeViewColumn('tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_seleksi field
            //
            $column = new TextViewColumn('jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new CheckboxViewColumn('status', 'status', 'Lulus', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for seleksi_prov field
            //
            $column = new CheckboxViewColumn('seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Nama Kk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_ayah field
            //
            $column = new TextViewColumn('nama_ayah', 'nama_ayah', 'Nama Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_ibu field
            //
            $column = new TextViewColumn('nama_ibu', 'nama_ibu', 'Nama Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_pdb_seleksi field
            //
            $column = new TextViewColumn('id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tanggal_seleksi field
            //
            $column = new DateTimeViewColumn('tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_seleksi field
            //
            $column = new TextViewColumn('jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new CheckboxViewColumn('status', 'status', 'Lulus', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for seleksi_prov field
            //
            $column = new CheckboxViewColumn('seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Nama Kk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_ayah field
            //
            $column = new TextViewColumn('nama_ayah', 'nama_ayah', 'Nama Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_ibu field
            //
            $column = new TextViewColumn('nama_ibu', 'nama_ibu', 'Nama Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_pdb_seleksi field
            //
            $column = new TextViewColumn('id_pdb_seleksi', 'id_pdb_seleksi', 'Id Pdb Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tanggal_seleksi field
            //
            $column = new DateTimeViewColumn('tanggal_seleksi', 'tanggal_seleksi', 'Tanggal Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_seleksi field
            //
            $column = new TextViewColumn('jenis_seleksi', 'jenis_seleksi_nama_seleksi', 'Jenis Seleksi', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for status field
            //
            $column = new CheckboxViewColumn('status', 'status', 'Lulus', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for seleksi_prov field
            //
            $column = new CheckboxViewColumn('seleksi_prov', 'seleksi_prov', 'Seleksi Provinsi', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Nama Kk', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_ayah field
            //
            $column = new TextViewColumn('nama_ayah', 'nama_ayah', 'Nama Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_ibu field
            //
            $column = new TextViewColumn('nama_ibu', 'nama_ibu', 'Nama Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function GetEnableModalGridEdit() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(true);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setUseModalMultiEdit(true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(false);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'csv'));
            $this->setModalViewSize(Modal::SIZE_LG);
            $this->setModalFormSize(Modal::SIZE_LG);
            $this->setShowFormErrorsOnTop(true);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.satuan.pendidikan');
            $lookupDataset->addFields(
                array(
                    new StringField('id_sp', false, true),
                    new StringField('npsn'),
                    new StringField('nama_sp'),
                    new StringField('jenjang_sp'),
                    new IntegerField('status'),
                    new StringField('npsn_nama')
                )
            );
            $lookupDataset->setOrderByField('npsn_nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_seleksi_tab_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.satuan.pendidikan');
            $lookupDataset->addFields(
                array(
                    new StringField('id_sp', false, true),
                    new StringField('npsn'),
                    new StringField('nama_sp'),
                    new StringField('jenjang_sp'),
                    new IntegerField('status'),
                    new StringField('npsn_nama')
                )
            );
            $lookupDataset->setOrderByField('npsn_nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_seleksi_tab_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.satuan.pendidikan');
            $lookupDataset->addFields(
                array(
                    new StringField('id_sp', false, true),
                    new StringField('npsn'),
                    new StringField('nama_sp'),
                    new StringField('jenjang_sp'),
                    new IntegerField('status'),
                    new StringField('npsn_nama')
                )
            );
            $lookupDataset->setOrderByField('npsn_nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_seleksi_tab_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_seleksi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.seleksi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_seleksi', false, true),
                    new StringField('nama_seleksi')
                )
            );
            $lookupDataset->setOrderByField('nama_seleksi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_seleksi_tab_jenis_seleksi_search', 'id_jenis_seleksi', 'nama_seleksi', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new seleksi_tabPage("seleksi_tab", "seleksi.tab.php", GetCurrentUserPermissionsForPage("seleksi.tab"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("seleksi.tab"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
