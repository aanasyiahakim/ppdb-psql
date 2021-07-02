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
    
    
    
    class verval_pdb_berkasPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Verval Berkas');
            $this->SetMenuLabel('Verval Berkas');
    
            $selectQuery = 'SELECT * FROM `pdb_berkas`';
            $insertQuery = array('INSERT INTO `pdb_berkas`(
              `id_pdb_berkas`, 
              `id_pdb`, 
              `id_berkas`, 
              `status`
            ) VALUES (
              :id_pdb_berkas, 
              :id_pdb, 
              :id_berkas, 
              :status
            )');
            $updateQuery = array('UPDATE `pdb_berkas` 
            SET
              `id_pdb` = :id_pdb, 
              `id_berkas` = :id_berkas, 
              `status` = :status
            WHERE 
              `id_pdb_berkas` = :OLD_id_pdb_berkas');
            $deleteQuery = array('DELETE FROM `pdb_berkas` 
            WHERE 
              `id_pdb_berkas` = :id_pdb_berkas');
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'verval.pdb.berkas');
            $this->dataset->addFields(
                array(
                    new StringField('id_pdb_berkas', true, true),
                    new StringField('id_pdb', true),
                    new IntegerField('id_berkas', true),
                    new IntegerField('status', true)
                )
            );
            $this->dataset->AddLookupField('id_pdb', '(SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb)', new StringField('id_pdb'), new StringField('nama', false, false, false, false, 'id_pdb_nama', 'id_pdb_nama_publik_pdb'), 'id_pdb_nama_publik_pdb');
            $this->dataset->AddLookupField('id_berkas', '(SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`)', new IntegerField('id_berkas'), new StringField('nama', false, false, false, false, 'id_berkas_nama', 'id_berkas_nama_ref_berkas'), 'id_berkas_nama_ref_berkas');
        }
    
        protected function DoPrepare() {
            // OnGlobalPreparePage event handler code
            require 'aksi/Global_OnPreparePage.inc.php';
            
            // OnPreparePage event handler code
            require 'aksi/pdb.berkas_OnPreparePage.inc.php';
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
                new FilterColumn($this->dataset, 'id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas'),
                new FilterColumn($this->dataset, 'id_pdb', 'id_pdb_nama', 'Id Pdb'),
                new FilterColumn($this->dataset, 'id_berkas', 'id_berkas_nama', 'Id Berkas'),
                new FilterColumn($this->dataset, 'status', 'status', 'Status')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_pdb_berkas'])
                ->addColumn($columns['id_pdb'])
                ->addColumn($columns['id_berkas'])
                ->addColumn($columns['status']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_pdb')
                ->setOptionsFor('id_berkas');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_pdb_berkas_edit');
            
            $filterBuilder->addColumn(
                $columns['id_pdb_berkas'],
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
            
            $main_editor = new DynamicCombobox('id_pdb_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_verval_pdb_berkas_id_pdb_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_pdb', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_verval_pdb_berkas_id_pdb_search');
            
            $text_editor = new TextEdit('id_pdb');
            
            $filterBuilder->addColumn(
                $columns['id_pdb'],
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
            
            $main_editor = new DynamicCombobox('id_berkas_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_verval_pdb_berkas_id_berkas_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_berkas', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_verval_pdb_berkas_id_berkas_search');
            
            $filterBuilder->addColumn(
                $columns['id_berkas'],
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
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_pdb_berkas field
            //
            $column = new TextViewColumn('id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb_nama', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_berkas', 'id_berkas_nama', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_pdb_berkas field
            //
            $column = new TextViewColumn('id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb_nama', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_berkas', 'id_berkas_nama', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb_berkas field
            //
            $editor = new TextEdit('id_pdb_berkas_edit');
            $editColumn = new CustomEditColumn('Id Pdb Berkas', 'id_pdb_berkas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_pdb field
            //
            $editor = new DynamicCombobox('id_pdb_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nama', 'edit_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new DynamicCombobox('id_berkas_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Berkas', 'id_berkas', 'id_berkas_nama', 'edit_verval_pdb_berkas_id_berkas_search', $editor, $this->dataset, $lookupDataset, 'id_berkas', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb field
            //
            $editor = new DynamicCombobox('id_pdb_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nama', 'multi_edit_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new DynamicCombobox('id_berkas_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Berkas', 'id_berkas', 'id_berkas_nama', 'multi_edit_verval_pdb_berkas_id_berkas_search', $editor, $this->dataset, $lookupDataset, 'id_berkas', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb_berkas field
            //
            $editor = new TextEdit('id_pdb_berkas_edit');
            $editColumn = new CustomEditColumn('Id Pdb Berkas', 'id_pdb_berkas', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%UUID%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_pdb field
            //
            $editor = new DynamicCombobox('id_pdb_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nama', 'insert_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new DynamicCombobox('id_berkas_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Berkas', 'id_berkas', 'id_berkas_nama', 'insert_verval_pdb_berkas_id_berkas_search', $editor, $this->dataset, $lookupDataset, 'id_berkas', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new CheckBox('status_edit');
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_pdb_berkas field
            //
            $column = new TextViewColumn('id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb_nama', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_berkas', 'id_berkas_nama', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_pdb_berkas field
            //
            $column = new TextViewColumn('id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb_nama', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_berkas', 'id_berkas_nama', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_pdb_berkas field
            //
            $column = new TextViewColumn('id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb_nama', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_berkas', 'id_berkas_nama', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(true);
            $result->SetShowLineNumbers(true);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
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
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_verval_pdb_berkas_id_berkas_search', 'id_berkas', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_verval_pdb_berkas_id_berkas_search', 'id_berkas', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_verval_pdb_berkas_id_berkas_search', 'id_berkas', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_verval_pdb_berkas_id_berkas_search', 'id_berkas', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   "kk_utama", 
                   "kk_pilihan" 
            FROM pdb';
            $insertQuery = array('INSERT INTO `pdb`(
                   `id_pdb`,
                   `nopen`,
                   `no_kk`, 
                   `nama`, 
                   `nik`, 
                   `jenis_kelamin`, 
                   `tempat_lahir`, 
                   `tanggal_lahir`, 
                   `id_agama`, 
                   `alamat_jalan`, 
                   `rt`, 
                   `rw`, 
                   `nama_dusun`, 
                   `kode_wilayah`, 
                   `nama_ayah`, 
                   `nama_ibu`, 
                   `nisn`, 
                   `id_sp`, 
                   `nopes`,
                   `id_jenis_tinggal`, 
                   `id_alat_transportasi`, 
                   `golongan_darah`, 
                   `tinggi_badan`, 
                   `berat_badan`,
                   `lingkar_kepala`,  
                   `cita`, 
                   `hobi`, 
                   `email`,
                   `kontak_pdb`, 
                   `kontak_ayah`, 
                   `kontak_ibu`, 
                   `kontak_lain`
            ) VALUES (
              :id_pdb,
              :nopen,
              :no_kk, 
              :nama, 
              :nik, 
              :jenis_kelamin, 
              :tempat_lahir, 
              :tanggal_lahir, 
              :id_agama, 
              :alamat_jalan, 
              :rt, 
              :rw, 
              :nama_dusun, 
              :kode_wilayah, 
              :nama_ayah, 
              :nama_ibu, 
              :nisn, 
              :id_sp, 
              :nopes, 
              :id_jenis_tinggal,
              :id_alat_transportasi,
              :golongan_darah, 
              :tinggi_badan, 
              :berat_badan,
              :lingkar_kepala, 
              :cita, 
              :hobi, 
              :email, 
              :kontak_pdb, 
              :kontak_ayah, 
              :kontak_ibu, 
              :kontak_lain
            )');
            $updateQuery = array('UPDATE `pdb` 
            SET 
                `nopen` = :nopen,
                `no_kk` = :no_kk,  
                `nama` = :nama,  
                `nik` = :nik,  
                `jenis_kelamin` = :jenis_kelamin,  
                `tempat_lahir` = :tempat_lahir,  
                `tanggal_lahir` = :tanggal_lahir,  
                `id_agama` = :id_agama,  
                `alamat_jalan` = :alamat_jalan,  
                `rt` = :rt,  
                `rw` = :rw,  
                `nama_dusun` = :nama_dusun,  
                `kode_wilayah` = :kode_wilayah,  
                `nama_ayah` = :nama_ayah,  
                `nama_ibu` = :nama_ibu,  
                `nisn` = :nisn,  
                `id_sp` = :id_sp,  
                `nopes` = :nopes,  
                `id_jenis_tinggal` = :id_jenis_tinggal, 
                `id_alat_transportasi` = :id_alat_transportasi,
                `golongan_darah` = :golongan_darah,  
                `tinggi_badan` = :tinggi_badan,  
                `berat_badan` = :berat_badan,  
                `lingkar_kepala` = :lingkar_kepala, 
                `cita` = :cita,  
                `hobi` = :hobi,  
                `email` = :email,
                `kontak_pdb` = :kontak_pdb, 
                `kontak_ayah` = :kontak_ayah, 
                `kontak_ibu` = :kontak_ibu, 
                `kontak_lain` = :kontak_lain
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array('UPDATE `pdb` 
            SET `aktif` = 0 
            WHERE `id_pdb` = :id_pdb');
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $lookupDataset->addFields(
                array(
                    new StringField('id_pdb', true, true),
                    new IntegerField('nopen'),
                    new StringField('no_kk'),
                    new StringField('nama', true),
                    new StringField('nik', true),
                    new StringField('jenis_kelamin', true),
                    new StringField('tempat_lahir', true),
                    new DateField('tanggal_lahir', true),
                    new IntegerField('id_agama'),
                    new StringField('golongan_darah'),
                    new StringField('alamat_jalan'),
                    new IntegerField('rt'),
                    new IntegerField('rw'),
                    new StringField('nama_dusun'),
                    new StringField('kode_wilayah'),
                    new StringField('nama_ayah', true),
                    new StringField('nama_ibu', true),
                    new StringField('id_sp', true),
                    new StringField('nisn'),
                    new StringField('nopes'),
                    new IntegerField('id_jenis_tinggal'),
                    new IntegerField('id_alat_transportasi'),
                    new IntegerField('tinggi_badan'),
                    new IntegerField('berat_badan'),
                    new IntegerField('lingkar_kepala'),
                    new IntegerField('cita'),
                    new IntegerField('hobi'),
                    new StringField('email'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain'),
                    new IntegerField('aktif'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi'),
                    new StringField('kk_utama'),
                    new StringField('kk_pilihan')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`berkas`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.berkas');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_berkas', false, true),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_verval_pdb_berkas_id_berkas_search', 'id_berkas', 'nama', null, 20);
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
            require 'aksi/OnAddEnvirontVariable.inc.php';
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new verval_pdb_berkasPage("verval_pdb_berkas", "verval.pdb.berkas.php", GetCurrentUserPermissionsForPage("verval.pdb.berkas"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("verval.pdb.berkas"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
