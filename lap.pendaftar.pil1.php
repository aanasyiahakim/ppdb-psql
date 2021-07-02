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
    
    
    
    class lap_pendaftar_pil1Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Progres Pendaftar Pilihan 1');
            $this->SetMenuLabel('Progres Pendaftar Pilihan 1');
    
            $selectQuery = 'SELECT 
                   date_format(`p`.`tanggal_dibuat`, "%d-%m-%Y") tanggal, 
                   `pp`.`id_kk` kk, `pp`.`pilihan` pilihan, count(*) banyak 
            FROM 
                 `pdb` `p` 
            INNER JOIN `pdb_pilihan` `pp` 
                  ON `pp`.`id_pdb` = `p`.`id_pdb` 
            WHERE 
                  `pp`.`pilihan` = 1 
            GROUP BY 
                  tanggal, kk, pilihan 
            ORDER BY tanggal';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lap.pendaftar.pil1');
            $this->dataset->addFields(
                array(
                    new StringField('tanggal', false, true),
                    new IntegerField('kk', false, true),
                    new IntegerField('pilihan', true, true),
                    new IntegerField('banyak', false, true)
                )
            );
            $this->dataset->AddLookupField('kk', '(SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`)', new IntegerField('id_kk'), new StringField('nama_kk', false, false, false, false, 'kk_nama_kk', 'kk_nama_kk_ref_kompetensi_keahlian'), 'kk_nama_kk_ref_kompetensi_keahlian');
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
                new FilterColumn($this->dataset, 'tanggal', 'tanggal', 'Tanggal'),
                new FilterColumn($this->dataset, 'kk', 'kk_nama_kk', 'Kk'),
                new FilterColumn($this->dataset, 'pilihan', 'pilihan', 'Pilihan'),
                new FilterColumn($this->dataset, 'banyak', 'banyak', 'Banyak')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['tanggal'])
                ->addColumn($columns['kk'])
                ->addColumn($columns['pilihan'])
                ->addColumn($columns['banyak']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('kk');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('tanggal_edit');
            
            $filterBuilder->addColumn(
                $columns['tanggal'],
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
            
            $main_editor = new DynamicCombobox('kk_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_lap_pendaftar_pil1_kk_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kk', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_lap_pendaftar_pil1_kk_search');
            
            $filterBuilder->addColumn(
                $columns['kk'],
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
            
            $main_editor = new TextEdit('banyak_edit');
            
            $filterBuilder->addColumn(
                $columns['banyak'],
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
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for tanggal field
            //
            $column = new TextViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk', 'kk_nama_kk', 'Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for banyak field
            //
            $column = new TextViewColumn('banyak', 'banyak', 'Banyak', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for tanggal field
            //
            $column = new TextViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk', 'kk_nama_kk', 'Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for banyak field
            //
            $column = new TextViewColumn('banyak', 'banyak', 'Banyak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for tanggal field
            //
            $editor = new TextEdit('tanggal_edit');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kk field
            //
            $editor = new DynamicCombobox('kk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kk', 'kk', 'kk_nama_kk', 'edit_lap_pendaftar_pil1_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
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
            // Edit column for banyak field
            //
            $editor = new TextEdit('banyak_edit');
            $editColumn = new CustomEditColumn('Banyak', 'banyak', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for tanggal field
            //
            $editor = new TextEdit('tanggal_edit');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kk field
            //
            $editor = new DynamicCombobox('kk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kk', 'kk', 'kk_nama_kk', 'multi_edit_lap_pendaftar_pil1_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for banyak field
            //
            $editor = new TextEdit('banyak_edit');
            $editColumn = new CustomEditColumn('Banyak', 'banyak', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for tanggal field
            //
            $editor = new TextEdit('tanggal_edit');
            $editColumn = new CustomEditColumn('Tanggal', 'tanggal', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kk field
            //
            $editor = new DynamicCombobox('kk_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kk', 'kk', 'kk_nama_kk', 'insert_lap_pendaftar_pil1_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
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
            // Edit column for banyak field
            //
            $editor = new TextEdit('banyak_edit');
            $editColumn = new CustomEditColumn('Banyak', 'banyak', $editor, $this->dataset);
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
            // View column for tanggal field
            //
            $column = new TextViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk', 'kk_nama_kk', 'Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for banyak field
            //
            $column = new TextViewColumn('banyak', 'banyak', 'Banyak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for tanggal field
            //
            $column = new TextViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk', 'kk_nama_kk', 'Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for banyak field
            //
            $column = new TextViewColumn('banyak', 'banyak', 'Banyak', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for tanggal field
            //
            $column = new TextViewColumn('tanggal', 'tanggal', 'Tanggal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk', 'kk_nama_kk', 'Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for banyak field
            //
            $column = new TextViewColumn('banyak', 'banyak', 'Banyak', $this->dataset);
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
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            $result->SetTotal('pilihan', PredefinedAggregate::$Count);
            $result->SetTotal('banyak', PredefinedAggregate::$Sum);
            
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
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_lap_pendaftar_pil1_kk_search', 'id_kk', 'nama_kk', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_lap_pendaftar_pil1_kk_search', 'id_kk', 'nama_kk', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_lap_pendaftar_pil1_kk_search', 'id_kk', 'nama_kk', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.kompetensi.keahlian');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('id_pk'),
                    new StringField('kode_kk'),
                    new StringField('nama_kk'),
                    new StringField('singkat'),
                    new IntegerField('spektrum2018'),
                    new IntegerField('spektrum2021'),
                    new StringField('kode_nama_kk')
                )
            );
            $lookupDataset->setOrderByField('nama_kk', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_lap_pendaftar_pil1_kk_search', 'id_kk', 'nama_kk', null, 20);
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
            if ($columnName == 'pilihan') {
               
               $customText = '<strong>Banyak</strong>';
               $handled = true;
               
            }
            
            if ($columnName == 'banyak') {
               
               $customText = '<strong>' . $totalValue . '</strong>';
               $handled = true;
               
            }
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
        $Page = new lap_pendaftar_pil1Page("lap_pendaftar_pil1", "lap.pendaftar.pil1.php", GetCurrentUserPermissionsForPage("lap.pendaftar.pil1"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("lap.pendaftar.pil1"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
