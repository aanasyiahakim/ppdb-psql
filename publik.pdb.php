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
    
    
    
    class publik_pdb_publik_pdb_pilihanPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Pilihan Kompetensi Keahlian');
            $this->SetMenuLabel('Pilihan Kompetensi Keahlian');
    
            $selectQuery = 'SELECT 
                   `p`.`nopen`,
                   `pp`.* 
            FROM 
                 `pdb_pilihan` `pp`
            LEFT JOIN `pdb` `p` 
                 ON `p`.`id_pdb` = `pp`.`id_pdb`';
            $insertQuery = array('INSERT INTO `pdb_pilihan`(
                   `id_pdb_pilihan`, 
                   `id_pdb`, 
                   `id_kk`, 
                   `pilihan`, 
                   `status`
            ) VALUES (
                     :id_pdb_pilihan, 
                     :id_pdb, 
                     :id_kk, 
                     :pilihan, 
                     :status
            )');
            $updateQuery = array('UPDATE `pdb_pilihan` 
            SET 
              `id_pdb` = :id_pdb, 
              `id_kk` = :id_kk, 
              `pilihan` = :pilihan, 
              `status` = :status
            WHERE 
                  `id_pdb_pilihan` = :OLD_id_pdb_pilihan');
            $deleteQuery = array('DELETE FROM `pdb_pilihan` 
            WHERE `id_pdb_pilihan` = :id_pdb_pilihan');
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb.pilihan');
            $this->dataset->addFields(
                array(
                    new IntegerField('nopen'),
                    new StringField('id_pdb_pilihan', false, true),
                    new StringField('id_pdb'),
                    new IntegerField('id_kk'),
                    new IntegerField('pilihan'),
                    new IntegerField('status')
                )
            );
            $this->dataset->AddLookupField('id_kk', '(SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`)', new IntegerField('id_kk'), new StringField('nama_kk', false, false, false, false, 'id_kk_nama_kk', 'id_kk_nama_kk_ref_kompetensi_keahlian'), 'id_kk_nama_kk_ref_kompetensi_keahlian');
        }
    
        protected function DoPrepare() {
            // OnGlobalPreparePage event handler code
            require 'aksi/Global_OnPreparePage.inc.php';
            
            // OnPreparePage event handler code
            require 'aksi/pdb.pilihan_OnPreparePage.inc.php';
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
                new FilterColumn($this->dataset, 'id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan'),
                new FilterColumn($this->dataset, 'id_pdb', 'id_pdb', 'Id Pdb'),
                new FilterColumn($this->dataset, 'id_kk', 'id_kk_nama_kk', 'Id Kk'),
                new FilterColumn($this->dataset, 'pilihan', 'pilihan', 'Pilihan'),
                new FilterColumn($this->dataset, 'status', 'status', 'Status'),
                new FilterColumn($this->dataset, 'nopen', 'nopen', 'Nopen')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_pdb_pilihan'])
                ->addColumn($columns['id_pdb'])
                ->addColumn($columns['id_kk'])
                ->addColumn($columns['pilihan'])
                ->addColumn($columns['status'])
                ->addColumn($columns['nopen']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_kk');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
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
            
            $main_editor = new TextEdit('id_pdb_edit');
            
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
            
            $main_editor = new DynamicCombobox('id_kk_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_publik_pdb_pilihan_id_kk_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_kk', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_publik_pdb_pilihan_id_kk_search');
            
            $filterBuilder->addColumn(
                $columns['id_kk'],
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
            
            $main_editor = new ComboBox('pilihan');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('1', '1-Pilihan utama');
            $main_editor->addChoice('2', '2-Pilihan alternatif');
            $main_editor->addChoice('3', '3-Pilihan alternatif');
            $main_editor->addChoice('4', '4-Pilihan alternatif');
            
            $multi_value_select_editor = new MultiValueSelect('pilihan');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('status_edit');
            
            $filterBuilder->addColumn(
                $columns['status'],
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
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('id_kk', 'id_kk_nama_kk', 'Id Kk', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth('50cm');
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
            $column->SetFixedWidth('3cm');
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('id_kk', 'id_kk_nama_kk', 'Id Kk', $this->dataset);
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
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
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
            // Edit column for id_pdb field
            //
            $editor = new TextEdit('id_pdb_edit');
            $editColumn = new CustomEditColumn('Id Pdb', 'id_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_kk field
            //
            $editor = new DynamicCombobox('id_kk_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Id Kk', 'id_kk', 'id_kk_nama_kk', 'edit_publik_pdb_publik_pdb_pilihan_id_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new RadioEdit('pilihan_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', '1-Pilihan utama');
            $editor->addChoice('2', '2-Pilihan alternatif');
            $editor->addChoice('3', '3-Pilihan alternatif');
            $editor->addChoice('4', '4-Pilihan alternatif');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
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
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb field
            //
            $editor = new TextEdit('id_pdb_edit');
            $editColumn = new CustomEditColumn('Id Pdb', 'id_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_kk field
            //
            $editor = new DynamicCombobox('id_kk_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Id Kk', 'id_kk', 'id_kk_nama_kk', 'multi_edit_publik_pdb_publik_pdb_pilihan_id_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new RadioEdit('pilihan_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', '1-Pilihan utama');
            $editor->addChoice('2', '2-Pilihan alternatif');
            $editor->addChoice('3', '3-Pilihan alternatif');
            $editor->addChoice('4', '4-Pilihan alternatif');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb_pilihan field
            //
            $editor = new TextEdit('id_pdb_pilihan_edit');
            $editColumn = new CustomEditColumn('Id Pdb Pilihan', 'id_pdb_pilihan', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%UUID%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_pdb field
            //
            $editor = new TextEdit('id_pdb_edit');
            $editColumn = new CustomEditColumn('Id Pdb', 'id_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_kk field
            //
            $editor = new DynamicCombobox('id_kk_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Id Kk', 'id_kk', 'id_kk_nama_kk', 'insert_publik_pdb_publik_pdb_pilihan_id_kk_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new RadioEdit('pilihan_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('1', '1-Pilihan utama');
            $editor->addChoice('2', '2-Pilihan alternatif');
            $editor->addChoice('3', '3-Pilihan alternatif');
            $editor->addChoice('4', '4-Pilihan alternatif');
            $editColumn = new CustomEditColumn('Pilihan', 'pilihan', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('%p%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
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
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('id_kk', 'id_kk_nama_kk', 'Id Kk', $this->dataset);
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
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('id_kk', 'id_kk_nama_kk', 'Id Kk', $this->dataset);
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
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_pdb_pilihan field
            //
            $column = new TextViewColumn('id_pdb_pilihan', 'id_pdb_pilihan', 'Id Pdb Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('id_kk', 'id_kk_nama_kk', 'Id Kk', $this->dataset);
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
            // View column for status field
            //
            $column = new NumberViewColumn('status', 'status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('pilihan', 'ASC');
            $result->setDefaultOrdering($defaultSortedColumns);
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
    
    
            $this->SetViewFormTitle('Pilih Kompetensi Keahlian %id_pdb%');
            $this->SetEditFormTitle('Ubah Pilihan %pilihan% %id_pdb%');
            $this->SetInsertFormTitle('Pilih Kompetensi Keahlian');
            $this->setAddNewChoices(array(2));
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
            $this->setDescription('inline');
            $this->setModalViewSize(Modal::SIZE_LG);
            $this->setModalFormSize(Modal::SIZE_LG);
            $this->setShowFormErrorsOnTop(true);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetInsertClientEditorValueChangedScript('/*
            if (sender.getFieldName() == \'id_kk\') {
              if (sender.getValue() == \'\') {
                editors[\'pilihan\'].setValue(\'1\');
                // editors[\'nik\'].enabled(false);
                //$(\'#pilihan_edit\').next().show();
              } else {
                //editors[\'nik\'].enabled(true);
                //$(\'#pilihan_edit\').next().hide();
                editors[\'pilihan\'].setValue(editors[\'pilihan\'].getValue()+1);
              }
            }
            */');
            
            $grid->SetInsertClientFormLoadedScript('/*
            if (editors[\'id_kk\'].getValue() == \'\') {
              //editors[\'nik\'].setValue(\'\');
              //editors[\'nik\'].enabled(false);
              editors[\'pilihan\'].setValue(\'1\');  
            } else {
              //editors[\'pilihan\'].enabled(true);
              editors[\'pilihan\'].setValue(\'2\');
            }
            */');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_publik_pdb_pilihan_id_kk_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_publik_pdb_pilihan_id_kk_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_publik_pdb_pilihan_id_kk_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_publik_pdb_pilihan_id_kk_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_publik_pdb_pilihan_id_kk_search', 'id_kk', 'nama_kk', null, 20);
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
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class publik_pdb_verval_pdb_berkasPage extends DetailPage
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
            $this->dataset->AddLookupField('id_pdb', 'pdb', new StringField('id_pdb'), new IntegerField('nopen', false, false, false, false, 'id_pdb_nopen', 'id_pdb_nopen_pdb'), 'id_pdb_nopen_pdb');
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
                new FilterColumn($this->dataset, 'id_pdb_berkas', 'id_pdb_berkas', 'Id Pdb Berkas'),
                new FilterColumn($this->dataset, 'id_pdb', 'id_pdb_nopen', 'Id Pdb'),
                new FilterColumn($this->dataset, 'id_berkas', 'id_berkas', 'Id Berkas'),
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
                ->setOptionsFor('id_pdb');
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
            $main_editor->SetHandlerName('filter_builder_publik_pdb_verval_pdb_berkas_id_pdb_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_pdb', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_verval_pdb_berkas_id_pdb_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('id_berkas_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('status_edit');
            
            $filterBuilder->addColumn(
                $columns['status'],
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
            // View column for nopen field
            //
            $column = new NumberViewColumn('id_pdb', 'id_pdb_nopen', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id_berkas field
            //
            $column = new NumberViewColumn('id_berkas', 'id_berkas', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            // View column for nopen field
            //
            $column = new NumberViewColumn('id_pdb', 'id_pdb_nopen', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_berkas field
            //
            $column = new NumberViewColumn('id_berkas', 'id_berkas', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nopen', 'edit_publik_pdb_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nopen', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new SpinEdit('id_berkas_edit');
            $editColumn = new CustomEditColumn('Id Berkas', 'id_berkas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
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
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nopen', 'multi_edit_publik_pdb_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nopen', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new SpinEdit('id_berkas_edit');
            $editColumn = new CustomEditColumn('Id Berkas', 'id_berkas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
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
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Pdb', 'id_pdb', 'id_pdb_nopen', 'insert_publik_pdb_verval_pdb_berkas_id_pdb_search', $editor, $this->dataset, $lookupDataset, 'id_pdb', 'nopen', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_berkas field
            //
            $editor = new SpinEdit('id_berkas_edit');
            $editColumn = new CustomEditColumn('Id Berkas', 'id_berkas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new SpinEdit('status_edit');
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
            // View column for nopen field
            //
            $column = new NumberViewColumn('id_pdb', 'id_pdb_nopen', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_berkas field
            //
            $column = new NumberViewColumn('id_berkas', 'id_berkas', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            // View column for nopen field
            //
            $column = new NumberViewColumn('id_pdb', 'id_pdb_nopen', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_berkas field
            //
            $column = new NumberViewColumn('id_berkas', 'id_berkas', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            // View column for nopen field
            //
            $column = new NumberViewColumn('id_pdb', 'id_pdb_nopen', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_berkas field
            //
            $column = new NumberViewColumn('id_berkas', 'id_berkas', 'Id Berkas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nopen', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nopen', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nopen', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`pdb`');
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
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nopen', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_verval_pdb_berkas_id_pdb_search', 'id_pdb', 'nopen', null, 20);
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
    
    // OnBeforePageExecute event handler
    
    
    
    class publik_pdbPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Biodata Peserta Didik Baru');
            $this->SetMenuLabel('Pendaftaran PDB');
    
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
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('kode_wilayah', '(SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`)', new StringField('kode_wilayah'), new StringField('wilayah_administratif', false, false, false, false, 'kode_wilayah_wilayah_administratif', 'kode_wilayah_wilayah_administratif_ref_wilayah'), 'kode_wilayah_wilayah_administratif_ref_wilayah');
            $this->dataset->AddLookupField('id_sp', '(SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`)', new StringField('id_sp'), new StringField('npsn_nama', false, false, false, false, 'id_sp_npsn_nama', 'id_sp_npsn_nama_ref_satuan_pendidikan'), 'id_sp_npsn_nama_ref_satuan_pendidikan');
            $this->dataset->AddLookupField('id_jenis_tinggal', '(SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`)', new IntegerField('id_jenis_tinggal'), new StringField('nama', false, false, false, false, 'id_jenis_tinggal_nama', 'id_jenis_tinggal_nama_ref_jenis_tinggal'), 'id_jenis_tinggal_nama_ref_jenis_tinggal');
            $this->dataset->AddLookupField('id_alat_transportasi', '(SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`)', new IntegerField('id_alat_transportasi'), new StringField('nama', false, false, false, false, 'id_alat_transportasi_nama', 'id_alat_transportasi_nama_ref_alat_transportasi'), 'id_alat_transportasi_nama_ref_alat_transportasi');
            $this->dataset->AddLookupField('cita', '(SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`)', new IntegerField('id_cita'), new StringField('nm_cita', false, false, false, false, 'cita_nm_cita', 'cita_nm_cita_ref_jenis_cita'), 'cita_nm_cita_ref_jenis_cita');
            $this->dataset->AddLookupField('hobi', '(SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`)', new IntegerField('id_hobi'), new StringField('nm_hobi', false, false, false, false, 'hobi_nm_hobi', 'hobi_nm_hobi_ref_jenis_hobi'), 'hobi_nm_hobi_ref_jenis_hobi');
            $this->dataset->AddLookupField('kk_utama', '(SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`)', new IntegerField('id_kk'), new StringField('nama_kk', false, false, false, false, 'kk_utama_nama_kk', 'kk_utama_nama_kk_ref_kompetensi_keahlian'), 'kk_utama_nama_kk_ref_kompetensi_keahlian');
            $this->dataset->AddLookupField('kk_pilihan', '(SELECT 
                   *, 
                   CONCAT(`kode_kk`, " ", `nama_kk`)kode_nama_kk 
            FROM 
                 `smkn2s01_kystudio_ref`.`kompetensi_keahlian`)', new IntegerField('id_kk'), new StringField('nama_kk', false, false, false, false, 'kk_pilihan_nama_kk', 'kk_pilihan_nama_kk_ref_kompetensi_keahlian'), 'kk_pilihan_nama_kk_ref_kompetensi_keahlian');
            $this->dataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'aktif = 1'));
        }
    
        protected function DoPrepare() {
            // OnGlobalPreparePage event handler code
            require 'aksi/Global_OnPreparePage.inc.php';
            
            // OnPreparePage event handler code
            require 'aksi/pdb_OnPreparePage.inc.php';
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
                new FilterColumn($this->dataset, 'id_pdb', 'id_pdb', 'Id Pdb'),
                new FilterColumn($this->dataset, 'nopen', 'nopen', 'Nopen'),
                new FilterColumn($this->dataset, 'no_kk', 'no_kk', 'No Kk'),
                new FilterColumn($this->dataset, 'nama', 'nama', 'Nama'),
                new FilterColumn($this->dataset, 'nik', 'nik', 'Nik'),
                new FilterColumn($this->dataset, 'jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin'),
                new FilterColumn($this->dataset, 'tempat_lahir', 'tempat_lahir', 'Tempat Lahir'),
                new FilterColumn($this->dataset, 'tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir'),
                new FilterColumn($this->dataset, 'id_agama', 'id_agama', 'Id Agama'),
                new FilterColumn($this->dataset, 'golongan_darah', 'golongan_darah', 'Golongan Darah'),
                new FilterColumn($this->dataset, 'alamat_jalan', 'alamat_jalan', 'Alamat Jalan'),
                new FilterColumn($this->dataset, 'rt', 'rt', 'Rt'),
                new FilterColumn($this->dataset, 'rw', 'rw', 'Rw'),
                new FilterColumn($this->dataset, 'nama_dusun', 'nama_dusun', 'Nama Dusun'),
                new FilterColumn($this->dataset, 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah'),
                new FilterColumn($this->dataset, 'nama_ayah', 'nama_ayah', 'Nama Ayah'),
                new FilterColumn($this->dataset, 'nama_ibu', 'nama_ibu', 'Nama Ibu'),
                new FilterColumn($this->dataset, 'id_sp', 'id_sp_npsn_nama', 'Id Sp'),
                new FilterColumn($this->dataset, 'nisn', 'nisn', 'Nisn'),
                new FilterColumn($this->dataset, 'nopes', 'nopes', 'Nopes'),
                new FilterColumn($this->dataset, 'id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal'),
                new FilterColumn($this->dataset, 'id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi'),
                new FilterColumn($this->dataset, 'tinggi_badan', 'tinggi_badan', 'Tinggi Badan'),
                new FilterColumn($this->dataset, 'berat_badan', 'berat_badan', 'Berat Badan'),
                new FilterColumn($this->dataset, 'cita', 'cita_nm_cita', 'Cita'),
                new FilterColumn($this->dataset, 'hobi', 'hobi_nm_hobi', 'Hobi'),
                new FilterColumn($this->dataset, 'email', 'email', 'Email'),
                new FilterColumn($this->dataset, 'kontak_pdb', 'kontak_pdb', 'Kontak Pdb'),
                new FilterColumn($this->dataset, 'kontak_ayah', 'kontak_ayah', 'Kontak Ayah'),
                new FilterColumn($this->dataset, 'kontak_ibu', 'kontak_ibu', 'Kontak Ibu'),
                new FilterColumn($this->dataset, 'kontak_lain', 'kontak_lain', 'Kontak Lain'),
                new FilterColumn($this->dataset, 'kk_utama', 'kk_utama_nama_kk', 'Kk Utama'),
                new FilterColumn($this->dataset, 'kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan'),
                new FilterColumn($this->dataset, 'aktif', 'aktif', 'Aktif'),
                new FilterColumn($this->dataset, 'tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat'),
                new FilterColumn($this->dataset, 'tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui'),
                new FilterColumn($this->dataset, 'sinkronisasi', 'sinkronisasi', 'Sinkronisasi'),
                new FilterColumn($this->dataset, 'lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_pdb'])
                ->addColumn($columns['nopen'])
                ->addColumn($columns['no_kk'])
                ->addColumn($columns['nama'])
                ->addColumn($columns['nik'])
                ->addColumn($columns['jenis_kelamin'])
                ->addColumn($columns['tempat_lahir'])
                ->addColumn($columns['tanggal_lahir'])
                ->addColumn($columns['id_agama'])
                ->addColumn($columns['golongan_darah'])
                ->addColumn($columns['alamat_jalan'])
                ->addColumn($columns['rt'])
                ->addColumn($columns['rw'])
                ->addColumn($columns['nama_dusun'])
                ->addColumn($columns['kode_wilayah'])
                ->addColumn($columns['nama_ayah'])
                ->addColumn($columns['nama_ibu'])
                ->addColumn($columns['id_sp'])
                ->addColumn($columns['nisn'])
                ->addColumn($columns['nopes'])
                ->addColumn($columns['id_jenis_tinggal'])
                ->addColumn($columns['id_alat_transportasi'])
                ->addColumn($columns['tinggi_badan'])
                ->addColumn($columns['berat_badan'])
                ->addColumn($columns['cita'])
                ->addColumn($columns['hobi'])
                ->addColumn($columns['email'])
                ->addColumn($columns['kontak_pdb'])
                ->addColumn($columns['kontak_ayah'])
                ->addColumn($columns['kontak_ibu'])
                ->addColumn($columns['kontak_lain'])
                ->addColumn($columns['kk_utama'])
                ->addColumn($columns['kk_pilihan'])
                ->addColumn($columns['aktif'])
                ->addColumn($columns['tanggal_dibuat'])
                ->addColumn($columns['tanggal_perbarui'])
                ->addColumn($columns['sinkronisasi'])
                ->addColumn($columns['lingkar_kepala']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('nopen')
                ->setOptionsFor('nama')
                ->setOptionsFor('jenis_kelamin')
                ->setOptionsFor('tanggal_lahir')
                ->setOptionsFor('golongan_darah')
                ->setOptionsFor('kode_wilayah')
                ->setOptionsFor('nama_ayah')
                ->setOptionsFor('nama_ibu')
                ->setOptionsFor('id_sp')
                ->setOptionsFor('kk_utama')
                ->setOptionsFor('kk_pilihan');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_pdb_edit');
            
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
            
            $main_editor = new TextEdit('nopen_edit');
            
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
            
            $main_editor = new MaskedEdit('no_kk_edit', '9999999999999999');
            
            $text_editor = new TextEdit('no_kk');
            
            $filterBuilder->addColumn(
                $columns['no_kk'],
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
            
            $main_editor = new MaskedEdit('nik_edit', '9999999999999999');
            
            $text_editor = new TextEdit('nik');
            
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
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('jenis_kelamin');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('L', 'Laki-laki');
            $main_editor->addChoice('P', 'Perempuan');
            
            $multi_value_select_editor = new MultiValueSelect('jenis_kelamin');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('jenis_kelamin');
            
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
            
            $main_editor = new AutocompleteEditor('tempat_lahir_edit', $this->CreateLinkBuilder(), 'filter_builder_publik_pdb_tempat_lahir_ac');
            
            $filterBuilder->addColumn(
                $columns['tempat_lahir'],
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
            
            $main_editor = new DateTimeEdit('tanggal_lahir_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['tanggal_lahir'],
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
            
            $main_editor = new ComboBox('id_agama_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('1', 'Islam');
            $main_editor->addChoice('2', 'Kristen');
            $main_editor->addChoice('3', 'Katholik');
            $main_editor->addChoice('4', 'Hindu');
            $main_editor->addChoice('5', 'Budha');
            $main_editor->addChoice('6', 'Khonghucu');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('id_agama');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $filterBuilder->addColumn(
                $columns['id_agama'],
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
            
            $main_editor = new ComboBox('golongan_darah_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('0', 'Belum diketahui');
            $main_editor->addChoice('1', 'A');
            $main_editor->addChoice('2', 'AB');
            $main_editor->addChoice('3', 'B');
            $main_editor->addChoice('4', 'O');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('golongan_darah');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('golongan_darah');
            
            $filterBuilder->addColumn(
                $columns['golongan_darah'],
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
            
            $main_editor = new TextEdit('alamat_jalan');
            
            $filterBuilder->addColumn(
                $columns['alamat_jalan'],
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
            
            $main_editor = new SpinEdit('rt_edit');
            
            $filterBuilder->addColumn(
                $columns['rt'],
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
            
            $main_editor = new SpinEdit('rw_edit');
            
            $filterBuilder->addColumn(
                $columns['rw'],
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
            
            $main_editor = new TextEdit('nama_dusun_edit');
            
            $filterBuilder->addColumn(
                $columns['nama_dusun'],
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
            
            $main_editor = new DynamicCombobox('kode_wilayah_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_kode_wilayah_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kode_wilayah', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_kode_wilayah_search');
            
            $text_editor = new TextEdit('kode_wilayah');
            
            $filterBuilder->addColumn(
                $columns['kode_wilayah'],
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
            
            $main_editor = new DynamicCombobox('id_sp_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_id_sp_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_sp', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_id_sp_search');
            
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
            
            $main_editor = new MaskedEdit('nisn_edit', '9999999999');
            
            $text_editor = new TextEdit('nisn');
            
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
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new MaskedEdit('nopes_edit', '9-99-99-99-999-999-9');
            
            $text_editor = new TextEdit('nopes');
            
            $filterBuilder->addColumn(
                $columns['nopes'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_jenis_tinggal_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_id_jenis_tinggal_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_jenis_tinggal', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_id_jenis_tinggal_search');
            
            $filterBuilder->addColumn(
                $columns['id_jenis_tinggal'],
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
            
            $main_editor = new DynamicCombobox('id_alat_transportasi_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_id_alat_transportasi_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_alat_transportasi', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_id_alat_transportasi_search');
            
            $filterBuilder->addColumn(
                $columns['id_alat_transportasi'],
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
            
            $main_editor = new TextEdit('tinggi_badan_edit');
            
            $filterBuilder->addColumn(
                $columns['tinggi_badan'],
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
            
            $main_editor = new TextEdit('berat_badan_edit');
            
            $filterBuilder->addColumn(
                $columns['berat_badan'],
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
            
            $main_editor = new DynamicCombobox('cita_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_cita_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('cita', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_cita_search');
            
            $filterBuilder->addColumn(
                $columns['cita'],
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
            
            $main_editor = new DynamicCombobox('hobi_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_hobi_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('hobi', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_hobi_search');
            
            $filterBuilder->addColumn(
                $columns['hobi'],
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
            
            $main_editor = new TextEdit('email_edit');
            
            $filterBuilder->addColumn(
                $columns['email'],
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
            
            $main_editor = new DynamicCombobox('kk_utama_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_kk_utama_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kk_utama', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_kk_utama_search');
            
            $text_editor = new TextEdit('kk_utama');
            
            $filterBuilder->addColumn(
                $columns['kk_utama'],
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
            
            $main_editor = new DynamicCombobox('kk_pilihan_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_kk_pilihan_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kk_pilihan', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_kk_pilihan_search');
            
            $text_editor = new TextEdit('kk_pilihan');
            
            $filterBuilder->addColumn(
                $columns['kk_pilihan'],
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
            
            $main_editor = new ComboBox('aktif');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['aktif'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('tanggal_dibuat_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['tanggal_dibuat'],
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
            
            $main_editor = new DateTimeEdit('tanggal_perbarui_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['tanggal_perbarui'],
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
            
            $main_editor = new DateTimeEdit('sinkronisasi_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['sinkronisasi'],
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
            
            $main_editor = new SpinEdit('lingkar_kepala_edit');
            
            $filterBuilder->addColumn(
                $columns['lingkar_kepala'],
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
            if (GetCurrentUserPermissionsForPage('publik.pdb.publik.pdb.pilihan')->HasViewGrant() && $withDetails)
            {
            //
            // View column for publik_pdb_publik_pdb_pilihan detail
            //
            $column = new DetailColumn(array('id_pdb'), 'publik.pdb.publik.pdb.pilihan', 'publik_pdb_publik_pdb_pilihan_handler', $this->dataset, 'Pilihan Kompetensi Keahlian');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('publik.pdb.verval.pdb.berkas')->HasViewGrant() && $withDetails)
            {
            //
            // View column for publik_pdb_verval_pdb_berkas detail
            //
            $column = new DetailColumn(array('id_pdb'), 'publik.pdb.verval.pdb.berkas', 'publik_pdb_verval_pdb_berkas_handler', $this->dataset, 'Verval Berkas');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
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
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(false);
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
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(false);
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
            // View column for tempat_lahir field
            //
            $column = new TextViewColumn('tempat_lahir', 'tempat_lahir', 'Tempat Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tanggal_lahir field
            //
            $column = new DateTimeViewColumn('tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id_agama field
            //
            $column = new NumberViewColumn('id_agama', 'id_agama', 'Id Agama', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for golongan_darah field
            //
            $column = new TextViewColumn('golongan_darah', 'golongan_darah', 'Golongan Darah', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for alamat_jalan field
            //
            $column = new TextViewColumn('alamat_jalan', 'alamat_jalan', 'Alamat Jalan', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for wilayah_administratif field
            //
            $column = new TextViewColumn('kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah', $this->dataset);
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
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nopes field
            //
            $column = new TextViewColumn('nopes', 'nopes', 'Nopes', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('Fomat baku: 2-19-23-08-068-067-6');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tinggi_badan field
            //
            $column = new NumberViewColumn('tinggi_badan', 'tinggi_badan', 'Tinggi Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for berat_badan field
            //
            $column = new NumberViewColumn('berat_badan', 'berat_badan', 'Berat Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nm_cita field
            //
            $column = new TextViewColumn('cita', 'cita_nm_cita', 'Cita', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nm_hobi field
            //
            $column = new TextViewColumn('hobi', 'hobi_nm_hobi', 'Hobi', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_utama', 'kk_utama_nama_kk', 'Kk Utama', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new CheckboxViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(false);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tanggal_dibuat field
            //
            $column = new DateTimeViewColumn('tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tanggal_perbarui field
            //
            $column = new DateTimeViewColumn('tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for sinkronisasi field
            //
            $column = new DateTimeViewColumn('sinkronisasi', 'sinkronisasi', 'Sinkronisasi', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for lingkar_kepala field
            //
            $column = new NumberViewColumn('lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala', $this->dataset);
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
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tempat_lahir field
            //
            $column = new TextViewColumn('tempat_lahir', 'tempat_lahir', 'Tempat Lahir', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tanggal_lahir field
            //
            $column = new DateTimeViewColumn('tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_agama field
            //
            $column = new NumberViewColumn('id_agama', 'id_agama', 'Id Agama', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for golongan_darah field
            //
            $column = new TextViewColumn('golongan_darah', 'golongan_darah', 'Golongan Darah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for alamat_jalan field
            //
            $column = new TextViewColumn('alamat_jalan', 'alamat_jalan', 'Alamat Jalan', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for wilayah_administratif field
            //
            $column = new TextViewColumn('kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah', $this->dataset);
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
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nopes field
            //
            $column = new TextViewColumn('nopes', 'nopes', 'Nopes', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tinggi_badan field
            //
            $column = new NumberViewColumn('tinggi_badan', 'tinggi_badan', 'Tinggi Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for berat_badan field
            //
            $column = new NumberViewColumn('berat_badan', 'berat_badan', 'Berat Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nm_cita field
            //
            $column = new TextViewColumn('cita', 'cita_nm_cita', 'Cita', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nm_hobi field
            //
            $column = new TextViewColumn('hobi', 'hobi_nm_hobi', 'Hobi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_utama', 'kk_utama_nama_kk', 'Kk Utama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new CheckboxViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(false);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tanggal_dibuat field
            //
            $column = new DateTimeViewColumn('tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tanggal_perbarui field
            //
            $column = new DateTimeViewColumn('tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sinkronisasi field
            //
            $column = new DateTimeViewColumn('sinkronisasi', 'sinkronisasi', 'Sinkronisasi', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for lingkar_kepala field
            //
            $column = new NumberViewColumn('lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb field
            //
            $editor = new TextEdit('id_pdb_edit');
            $editColumn = new CustomEditColumn('Id Pdb', 'id_pdb', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new TextEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new MaskedEdit('no_kk_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('No Kk', 'no_kk', $editor, $this->dataset);
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
            // Edit column for nik field
            //
            $editor = new MaskedEdit('nik_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new RadioEdit('jenis_kelamin_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('L', 'Laki-laki');
            $editor->addChoice('P', 'Perempuan');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new AutocompleteEditor('tempat_lahir_edit', $this->CreateLinkBuilder(), 'edit_publik_pdb_tempat_lahir_ac');
            $editColumn = new CustomEditColumn('Tempat Lahir', 'tempat_lahir', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tanggal_lahir field
            //
            $editor = new DateTimeEdit('tanggal_lahir_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Lahir', 'tanggal_lahir', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_agama field
            //
            $editor = new ComboBox('id_agama_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', 'Islam');
            $editor->addChoice('2', 'Kristen');
            $editor->addChoice('3', 'Katholik');
            $editor->addChoice('4', 'Hindu');
            $editor->addChoice('5', 'Budha');
            $editor->addChoice('6', 'Khonghucu');
            $editColumn = new CustomEditColumn('Id Agama', 'id_agama', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new ComboBox('golongan_darah_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('0', 'Belum diketahui');
            $editor->addChoice('1', 'A');
            $editor->addChoice('2', 'AB');
            $editor->addChoice('3', 'B');
            $editor->addChoice('4', 'O');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextAreaEdit('alamat_jalan_edit', 50, 4);
            $editColumn = new CustomEditColumn('Alamat Jalan', 'alamat_jalan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for rt field
            //
            $editor = new SpinEdit('rt_edit');
            $editColumn = new CustomEditColumn('Rt', 'rt', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama_dusun field
            //
            $editor = new TextEdit('nama_dusun_edit');
            $editColumn = new CustomEditColumn('Nama Dusun', 'nama_dusun', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kode_wilayah field
            //
            $editor = new DynamicCombobox('kode_wilayah_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'edit_publik_pdb_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
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
            $editColumn = new DynamicLookupEditColumn('Id Sp', 'id_sp', 'id_sp_npsn_nama', 'edit_publik_pdb_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'npsn_nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new MaskedEdit('nisn_edit', '9999999999');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nopes field
            //
            $editor = new MaskedEdit('nopes_edit', '9-99-99-99-999-999-9');
            $editColumn = new CustomEditColumn('Nopes', 'nopes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_jenis_tinggal field
            //
            $editor = new DynamicCombobox('id_jenis_tinggal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Jenis Tinggal', 'id_jenis_tinggal', 'id_jenis_tinggal_nama', 'edit_publik_pdb_id_jenis_tinggal_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_tinggal', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_alat_transportasi field
            //
            $editor = new DynamicCombobox('id_alat_transportasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Alat Transportasi', 'id_alat_transportasi', 'id_alat_transportasi_nama', 'edit_publik_pdb_id_alat_transportasi_search', $editor, $this->dataset, $lookupDataset, 'id_alat_transportasi', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tinggi_badan field
            //
            $editor = new TextEdit('tinggi_badan_edit');
            $editColumn = new CustomEditColumn('Tinggi Badan', 'tinggi_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(200, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(130, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for berat_badan field
            //
            $editor = new TextEdit('berat_badan_edit');
            $editColumn = new CustomEditColumn('Berat Badan', 'berat_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(30, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cita field
            //
            $editor = new DynamicCombobox('cita_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cita', 'cita', 'cita_nm_cita', 'edit_publik_pdb_cita_search', $editor, $this->dataset, $lookupDataset, 'id_cita', 'nm_cita', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hobi field
            //
            $editor = new DynamicCombobox('hobi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Hobi', 'hobi', 'hobi_nm_hobi', 'edit_publik_pdb_hobi_search', $editor, $this->dataset, $lookupDataset, 'id_hobi', 'nm_hobi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextEdit('email_edit');
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak Pdb', 'kontak_pdb', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kk_utama field
            //
            $editor = new DynamicCombobox('kk_utama_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Utama', 'kk_utama', 'kk_utama_nama_kk', 'edit_publik_pdb_kk_utama_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for kk_pilihan field
            //
            $editor = new DynamicCombobox('kk_pilihan_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Pilihan', 'kk_pilihan', 'kk_pilihan_nama_kk', 'edit_publik_pdb_kk_pilihan_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new CheckBox('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tanggal_dibuat field
            //
            $editor = new DateTimeEdit('tanggal_dibuat_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Dibuat', 'tanggal_dibuat', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tanggal_perbarui field
            //
            $editor = new DateTimeEdit('tanggal_perbarui_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Perbarui', 'tanggal_perbarui', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sinkronisasi field
            //
            $editor = new DateTimeEdit('sinkronisasi_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Sinkronisasi', 'sinkronisasi', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for lingkar_kepala field
            //
            $editor = new SpinEdit('lingkar_kepala_edit');
            $editColumn = new CustomEditColumn('Lingkar Kepala', 'lingkar_kepala', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for nopen field
            //
            $editor = new TextEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new MaskedEdit('no_kk_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('No Kk', 'no_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama', 'nama', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nik field
            //
            $editor = new MaskedEdit('nik_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new RadioEdit('jenis_kelamin_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('L', 'Laki-laki');
            $editor->addChoice('P', 'Perempuan');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new AutocompleteEditor('tempat_lahir_edit', $this->CreateLinkBuilder(), 'multi_edit_publik_pdb_tempat_lahir_ac');
            $editColumn = new CustomEditColumn('Tempat Lahir', 'tempat_lahir', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tanggal_lahir field
            //
            $editor = new DateTimeEdit('tanggal_lahir_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Lahir', 'tanggal_lahir', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_agama field
            //
            $editor = new ComboBox('id_agama_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', 'Islam');
            $editor->addChoice('2', 'Kristen');
            $editor->addChoice('3', 'Katholik');
            $editor->addChoice('4', 'Hindu');
            $editor->addChoice('5', 'Budha');
            $editor->addChoice('6', 'Khonghucu');
            $editColumn = new CustomEditColumn('Id Agama', 'id_agama', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new ComboBox('golongan_darah_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('0', 'Belum diketahui');
            $editor->addChoice('1', 'A');
            $editor->addChoice('2', 'AB');
            $editor->addChoice('3', 'B');
            $editor->addChoice('4', 'O');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextAreaEdit('alamat_jalan_edit', 50, 4);
            $editColumn = new CustomEditColumn('Alamat Jalan', 'alamat_jalan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for rt field
            //
            $editor = new SpinEdit('rt_edit');
            $editColumn = new CustomEditColumn('Rt', 'rt', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama_dusun field
            //
            $editor = new TextEdit('nama_dusun_edit');
            $editColumn = new CustomEditColumn('Nama Dusun', 'nama_dusun', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kode_wilayah field
            //
            $editor = new DynamicCombobox('kode_wilayah_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'multi_edit_publik_pdb_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama_ayah field
            //
            $editor = new TextEdit('nama_ayah_edit');
            $editColumn = new CustomEditColumn('Nama Ayah', 'nama_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama_ibu field
            //
            $editor = new TextEdit('nama_ibu_edit');
            $editColumn = new CustomEditColumn('Nama Ibu', 'nama_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
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
            $editColumn = new DynamicLookupEditColumn('Id Sp', 'id_sp', 'id_sp_npsn_nama', 'multi_edit_publik_pdb_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'npsn_nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new MaskedEdit('nisn_edit', '9999999999');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nopes field
            //
            $editor = new MaskedEdit('nopes_edit', '9-99-99-99-999-999-9');
            $editColumn = new CustomEditColumn('Nopes', 'nopes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_jenis_tinggal field
            //
            $editor = new DynamicCombobox('id_jenis_tinggal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Jenis Tinggal', 'id_jenis_tinggal', 'id_jenis_tinggal_nama', 'multi_edit_publik_pdb_id_jenis_tinggal_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_tinggal', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_alat_transportasi field
            //
            $editor = new DynamicCombobox('id_alat_transportasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Alat Transportasi', 'id_alat_transportasi', 'id_alat_transportasi_nama', 'multi_edit_publik_pdb_id_alat_transportasi_search', $editor, $this->dataset, $lookupDataset, 'id_alat_transportasi', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tinggi_badan field
            //
            $editor = new TextEdit('tinggi_badan_edit');
            $editColumn = new CustomEditColumn('Tinggi Badan', 'tinggi_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(200, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(130, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for berat_badan field
            //
            $editor = new TextEdit('berat_badan_edit');
            $editColumn = new CustomEditColumn('Berat Badan', 'berat_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(30, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cita field
            //
            $editor = new DynamicCombobox('cita_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cita', 'cita', 'cita_nm_cita', 'multi_edit_publik_pdb_cita_search', $editor, $this->dataset, $lookupDataset, 'id_cita', 'nm_cita', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hobi field
            //
            $editor = new DynamicCombobox('hobi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Hobi', 'hobi', 'hobi_nm_hobi', 'multi_edit_publik_pdb_hobi_search', $editor, $this->dataset, $lookupDataset, 'id_hobi', 'nm_hobi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextEdit('email_edit');
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak Pdb', 'kontak_pdb', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kk_utama field
            //
            $editor = new DynamicCombobox('kk_utama_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Utama', 'kk_utama', 'kk_utama_nama_kk', 'multi_edit_publik_pdb_kk_utama_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kk_pilihan field
            //
            $editor = new DynamicCombobox('kk_pilihan_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Pilihan', 'kk_pilihan', 'kk_pilihan_nama_kk', 'multi_edit_publik_pdb_kk_pilihan_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new CheckBox('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tanggal_dibuat field
            //
            $editor = new DateTimeEdit('tanggal_dibuat_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Dibuat', 'tanggal_dibuat', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tanggal_perbarui field
            //
            $editor = new DateTimeEdit('tanggal_perbarui_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Perbarui', 'tanggal_perbarui', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for sinkronisasi field
            //
            $editor = new DateTimeEdit('sinkronisasi_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Sinkronisasi', 'sinkronisasi', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for lingkar_kepala field
            //
            $editor = new SpinEdit('lingkar_kepala_edit');
            $editColumn = new CustomEditColumn('Lingkar Kepala', 'lingkar_kepala', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_pdb field
            //
            $editor = new TextEdit('id_pdb_edit');
            $editColumn = new CustomEditColumn('Id Pdb', 'id_pdb', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetInsertDefaultValue('%UUID%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new TextEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%MAKS%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new MaskedEdit('no_kk_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('No Kk', 'no_kk', $editor, $this->dataset);
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
            // Edit column for nik field
            //
            $editor = new MaskedEdit('nik_edit', '9999999999999999');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new RadioEdit('jenis_kelamin_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('L', 'Laki-laki');
            $editor->addChoice('P', 'Perempuan');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('\'L\'');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new AutocompleteEditor('tempat_lahir_edit', $this->CreateLinkBuilder(), 'insert_publik_pdb_tempat_lahir_ac');
            $editColumn = new CustomEditColumn('Tempat Lahir', 'tempat_lahir', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('Sumbawa');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tanggal_lahir field
            //
            $editor = new DateTimeEdit('tanggal_lahir_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Tanggal Lahir', 'tanggal_lahir', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_agama field
            //
            $editor = new ComboBox('id_agama_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('1', 'Islam');
            $editor->addChoice('2', 'Kristen');
            $editor->addChoice('3', 'Katholik');
            $editor->addChoice('4', 'Hindu');
            $editor->addChoice('5', 'Budha');
            $editor->addChoice('6', 'Khonghucu');
            $editColumn = new CustomEditColumn('Id Agama', 'id_agama', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('1');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new ComboBox('golongan_darah_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('0', 'Belum diketahui');
            $editor->addChoice('1', 'A');
            $editor->addChoice('2', 'AB');
            $editor->addChoice('3', 'B');
            $editor->addChoice('4', 'O');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextAreaEdit('alamat_jalan_edit', 50, 4);
            $editColumn = new CustomEditColumn('Alamat Jalan', 'alamat_jalan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for rt field
            //
            $editor = new SpinEdit('rt_edit');
            $editColumn = new CustomEditColumn('Rt', 'rt', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama_dusun field
            //
            $editor = new TextEdit('nama_dusun_edit');
            $editColumn = new CustomEditColumn('Nama Dusun', 'nama_dusun', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kode_wilayah field
            //
            $editor = new DynamicCombobox('kode_wilayah_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'insert_publik_pdb_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
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
            $editColumn = new DynamicLookupEditColumn('Id Sp', 'id_sp', 'id_sp_npsn_nama', 'insert_publik_pdb_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'npsn_nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nisn field
            //
            $editor = new MaskedEdit('nisn_edit', '9999999999');
            $editColumn = new CustomEditColumn('Nisn', 'nisn', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nopes field
            //
            $editor = new MaskedEdit('nopes_edit', '9-99-99-99-999-999-9');
            $editColumn = new CustomEditColumn('Nopes', 'nopes', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_jenis_tinggal field
            //
            $editor = new DynamicCombobox('id_jenis_tinggal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Jenis Tinggal', 'id_jenis_tinggal', 'id_jenis_tinggal_nama', 'insert_publik_pdb_id_jenis_tinggal_search', $editor, $this->dataset, $lookupDataset, 'id_jenis_tinggal', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_alat_transportasi field
            //
            $editor = new DynamicCombobox('id_alat_transportasi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Alat Transportasi', 'id_alat_transportasi', 'id_alat_transportasi_nama', 'insert_publik_pdb_id_alat_transportasi_search', $editor, $this->dataset, $lookupDataset, 'id_alat_transportasi', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tinggi_badan field
            //
            $editor = new TextEdit('tinggi_badan_edit');
            $editColumn = new CustomEditColumn('Tinggi Badan', 'tinggi_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(200, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(130, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for berat_badan field
            //
            $editor = new TextEdit('berat_badan_edit');
            $editColumn = new CustomEditColumn('Berat Badan', 'berat_badan', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(30, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cita field
            //
            $editor = new DynamicCombobox('cita_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cita', 'cita', 'cita_nm_cita', 'insert_publik_pdb_cita_search', $editor, $this->dataset, $lookupDataset, 'id_cita', 'nm_cita', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hobi field
            //
            $editor = new DynamicCombobox('hobi_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Hobi', 'hobi', 'hobi_nm_hobi', 'insert_publik_pdb_hobi_search', $editor, $this->dataset, $lookupDataset, 'id_hobi', 'nm_hobi', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextEdit('email_edit');
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak Pdb', 'kontak_pdb', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kk_utama field
            //
            $editor = new DynamicCombobox('kk_utama_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Utama', 'kk_utama', 'kk_utama_nama_kk', 'insert_publik_pdb_kk_utama_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for kk_pilihan field
            //
            $editor = new DynamicCombobox('kk_pilihan_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('Kk Pilihan', 'kk_pilihan', 'kk_pilihan_nama_kk', 'insert_publik_pdb_kk_pilihan_search', $editor, $this->dataset, $lookupDataset, 'id_kk', 'nama_kk', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for aktif field
            //
            $editor = new CheckBox('aktif_edit');
            $editColumn = new CustomEditColumn('Aktif', 'aktif', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('1');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tanggal_dibuat field
            //
            $editor = new DateTimeEdit('tanggal_dibuat_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Dibuat', 'tanggal_dibuat', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tanggal_perbarui field
            //
            $editor = new DateTimeEdit('tanggal_perbarui_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Tanggal Perbarui', 'tanggal_perbarui', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sinkronisasi field
            //
            $editor = new DateTimeEdit('sinkronisasi_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Sinkronisasi', 'sinkronisasi', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATETIME%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for lingkar_kepala field
            //
            $editor = new SpinEdit('lingkar_kepala_edit');
            $editColumn = new CustomEditColumn('Lingkar Kepala', 'lingkar_kepala', $editor, $this->dataset);
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
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tempat_lahir field
            //
            $column = new TextViewColumn('tempat_lahir', 'tempat_lahir', 'Tempat Lahir', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tanggal_lahir field
            //
            $column = new DateTimeViewColumn('tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_agama field
            //
            $column = new NumberViewColumn('id_agama', 'id_agama', 'Id Agama', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for golongan_darah field
            //
            $column = new TextViewColumn('golongan_darah', 'golongan_darah', 'Golongan Darah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for alamat_jalan field
            //
            $column = new TextViewColumn('alamat_jalan', 'alamat_jalan', 'Alamat Jalan', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for wilayah_administratif field
            //
            $column = new TextViewColumn('kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah', $this->dataset);
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
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nopes field
            //
            $column = new TextViewColumn('nopes', 'nopes', 'Nopes', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tinggi_badan field
            //
            $column = new NumberViewColumn('tinggi_badan', 'tinggi_badan', 'Tinggi Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for berat_badan field
            //
            $column = new NumberViewColumn('berat_badan', 'berat_badan', 'Berat Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nm_cita field
            //
            $column = new TextViewColumn('cita', 'cita_nm_cita', 'Cita', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nm_hobi field
            //
            $column = new TextViewColumn('hobi', 'hobi_nm_hobi', 'Hobi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_utama', 'kk_utama_nama_kk', 'Kk Utama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new CheckboxViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(false);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tanggal_dibuat field
            //
            $column = new DateTimeViewColumn('tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tanggal_perbarui field
            //
            $column = new DateTimeViewColumn('tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for sinkronisasi field
            //
            $column = new DateTimeViewColumn('sinkronisasi', 'sinkronisasi', 'Sinkronisasi', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for lingkar_kepala field
            //
            $column = new NumberViewColumn('lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tempat_lahir field
            //
            $column = new TextViewColumn('tempat_lahir', 'tempat_lahir', 'Tempat Lahir', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tanggal_lahir field
            //
            $column = new DateTimeViewColumn('tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_agama field
            //
            $column = new NumberViewColumn('id_agama', 'id_agama', 'Id Agama', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for golongan_darah field
            //
            $column = new TextViewColumn('golongan_darah', 'golongan_darah', 'Golongan Darah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for alamat_jalan field
            //
            $column = new TextViewColumn('alamat_jalan', 'alamat_jalan', 'Alamat Jalan', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for wilayah_administratif field
            //
            $column = new TextViewColumn('kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah', $this->dataset);
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
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nopes field
            //
            $column = new TextViewColumn('nopes', 'nopes', 'Nopes', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for tinggi_badan field
            //
            $column = new NumberViewColumn('tinggi_badan', 'tinggi_badan', 'Tinggi Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for berat_badan field
            //
            $column = new NumberViewColumn('berat_badan', 'berat_badan', 'Berat Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nm_cita field
            //
            $column = new TextViewColumn('cita', 'cita_nm_cita', 'Cita', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nm_hobi field
            //
            $column = new TextViewColumn('hobi', 'hobi_nm_hobi', 'Hobi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_utama', 'kk_utama_nama_kk', 'Kk Utama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new CheckboxViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(false);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for tanggal_dibuat field
            //
            $column = new DateTimeViewColumn('tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for tanggal_perbarui field
            //
            $column = new DateTimeViewColumn('tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for sinkronisasi field
            //
            $column = new DateTimeViewColumn('sinkronisasi', 'sinkronisasi', 'Sinkronisasi', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for lingkar_kepala field
            //
            $column = new NumberViewColumn('lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_pdb field
            //
            $column = new TextViewColumn('id_pdb', 'id_pdb', 'Id Pdb', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'Nopen', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nik field
            //
            $column = new TextViewColumn('nik', 'nik', 'Nik', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for jenis_kelamin field
            //
            $column = new TextViewColumn('jenis_kelamin', 'jenis_kelamin', 'Jenis Kelamin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tempat_lahir field
            //
            $column = new TextViewColumn('tempat_lahir', 'tempat_lahir', 'Tempat Lahir', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tanggal_lahir field
            //
            $column = new DateTimeViewColumn('tanggal_lahir', 'tanggal_lahir', 'Tanggal Lahir', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_agama field
            //
            $column = new NumberViewColumn('id_agama', 'id_agama', 'Id Agama', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for golongan_darah field
            //
            $column = new TextViewColumn('golongan_darah', 'golongan_darah', 'Golongan Darah', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for alamat_jalan field
            //
            $column = new TextViewColumn('alamat_jalan', 'alamat_jalan', 'Alamat Jalan', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for wilayah_administratif field
            //
            $column = new TextViewColumn('kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah', $this->dataset);
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
            // View column for npsn_nama field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_npsn_nama', 'Id Sp', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nisn field
            //
            $column = new TextViewColumn('nisn', 'nisn', 'Nisn', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nopes field
            //
            $column = new TextViewColumn('nopes', 'nopes', 'Nopes', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_jenis_tinggal', 'id_jenis_tinggal_nama', 'Id Jenis Tinggal', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('id_alat_transportasi', 'id_alat_transportasi_nama', 'Id Alat Transportasi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tinggi_badan field
            //
            $column = new NumberViewColumn('tinggi_badan', 'tinggi_badan', 'Tinggi Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for berat_badan field
            //
            $column = new NumberViewColumn('berat_badan', 'berat_badan', 'Berat Badan', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nm_cita field
            //
            $column = new TextViewColumn('cita', 'cita_nm_cita', 'Cita', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nm_hobi field
            //
            $column = new TextViewColumn('hobi', 'hobi_nm_hobi', 'Hobi', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_pdb field
            //
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak Pdb', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_ayah field
            //
            $column = new TextViewColumn('kontak_ayah', 'kontak_ayah', 'Kontak Ayah', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_ibu field
            //
            $column = new TextViewColumn('kontak_ibu', 'kontak_ibu', 'Kontak Ibu', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for kontak_lain field
            //
            $column = new TextViewColumn('kontak_lain', 'kontak_lain', 'Kontak Lain', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_utama', 'kk_utama_nama_kk', 'Kk Utama', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('kk_pilihan', 'kk_pilihan_nama_kk', 'Kk Pilihan', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for aktif field
            //
            $column = new CheckboxViewColumn('aktif', 'aktif', 'Aktif', $this->dataset);
            $column->SetOrderable(false);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tanggal_dibuat field
            //
            $column = new DateTimeViewColumn('tanggal_dibuat', 'tanggal_dibuat', 'Tanggal Dibuat', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tanggal_perbarui field
            //
            $column = new DateTimeViewColumn('tanggal_perbarui', 'tanggal_perbarui', 'Tanggal Perbarui', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for sinkronisasi field
            //
            $column = new DateTimeViewColumn('sinkronisasi', 'sinkronisasi', 'Sinkronisasi', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for lingkar_kepala field
            //
            $column = new NumberViewColumn('lingkar_kepala', 'lingkar_kepala', 'Lingkar Kepala', $this->dataset);
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
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
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
            $result->SetTotal('nama', PredefinedAggregate::$Count);
            
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
    
    
            $this->SetViewFormTitle('Data %nik% - %nama%');
            $this->SetEditFormTitle('Ubah Data %nik% - %nama%');
            $this->SetInsertFormTitle('Pendaftaran Peserta Didik Baru');
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
            $grid->SetInsertClientValidationScript('if (fieldValues[\'kk_utama\'] == "" ) {
              
              errorInfo.SetMessage(\'Kompetensi pilihan 1 belum diisi\'); 
              return false;
              
            } else if (fieldValues[\'kk_utama\'] == fieldValues[\'kk_pilihan\'] > 100) {
              
              errorInfo.SetMessage(\'Kompetensi keahlian pilihan 1 dan 2 harus berbeda \'); 
              return false;
            
            } else {
            
            }');
            
            $grid->SetEditClientValidationScript('if (fieldValues[\'kk_utama\'] == "" ) {
              
              errorInfo.SetMessage(\'Kompetensi pilihan 1 belum diisi\'); 
              return false;
              
            } else if (fieldValues[\'kk_utama\'] == fieldValues[\'kk_pilihan\'] > 100) {
              
              errorInfo.SetMessage(\'Kompetensi keahlian pilihan 1 dan 2 harus berbeda \'); 
              return false;
            
            } else {
            
            }');
            
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() == \'no_kk\') {
              if (sender.getValue() == \'\') {
                editors[\'nik\'].setValue(\'\');
                editors[\'nik\'].enabled(false);
                $(\'#nik_edit\').next().show();
              } else {
                editors[\'nik\'].enabled(true);
                $(\'#nik_edit\').next().hide();
              }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('if (fieldValues[\'kk_utama\'] == "" ) {
              
              errorInfo.SetMessage(\'Kompetensi pilihan 1 belum diisi\'); 
              return false;
              
            } else if (fieldValues[\'kk_utama\'] == fieldValues[\'kk_pilihan\'] > 100) {
              
              errorInfo.SetMessage(\'Kompetensi keahlian pilihan 1 dan 2 harus berbeda \'); 
              return false;
            
            } else {
            
            }');
            
            $grid->SetInsertClientFormLoadedScript('if (editors[\'no_kk\'].getValue() == \'\') {
              editors[\'nik\'].setValue(\'\');
              editors[\'nik\'].enabled(false);  
            } else {
              editors[\'nik\'].enabled(true);
            }
            
            editors[\'jenis_kelamin\'].setValue(\'L\');
            
            editors[\'alamat_jalan\'].setHint(\'Jalur tempat tinggal peserta didik baru, terdiri atas gang, kompleks, blok, nomor rumah, dan sebagainya selain informasi yang diminta oleh kolom-kolom yang lain pada bagian ini. Sebagai contoh, peserta didik baru tinggal di sebuah kompleks perumahan Moyo Indah yang berada pada Jalan Raya Moyo Hilir, dengan nomor rumah 4, di lingkungan RT 001 dan RW 001, Dusun Stowe Brang, Desa Moyo Mekar. Maka dapat diisi dengan Jl. Raya Moyo Hilir, Komp. Moyo Indah, No. 4\');
            editors[\'nama_dusun\'].setHint(\'Nama dusun tempat tinggal peserta didik saat ini\');
            editors[\'kode_wilayah\'].setHint(\'Nama desa/kelurahan tempat tinggal peserta didik saat ini\');
            editors[\'nama_ayah\'].setHint(\'Nama ayah kandung peserta didik sesuai dokumen resmi yang berlaku tanpa gelar akademik atau sosial\');
            editors[\'nama_ibu\'].setHint(\'Nama ibu kandung peserta didik sesuai dokumen resmi yang berlaku tanpa gelar akademik atau sosial\');
            editors[\'tinggi_badan\'].setHint(\'Tinggi badan dalam CM ditulis tanpa satuan, seperti 160\');
            editors[\'berat_badan\'].setHint(\'Berat badan dalam KG ditulis tanpa satuan, seperti 50\');');
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new publik_pdb_publik_pdb_pilihanPage('publik_pdb_publik_pdb_pilihan', $this, array('id_pdb'), array('id_pdb'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('publik.pdb.publik.pdb.pilihan'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('publik.pdb.publik.pdb.pilihan'));
            $detailPage->SetHttpHandlerName('publik_pdb_publik_pdb_pilihan_handler');
            $handler = new PageHTTPHandler('publik_pdb_publik_pdb_pilihan_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new publik_pdb_verval_pdb_berkasPage('publik_pdb_verval_pdb_berkas', $this, array('id_pdb'), array('id_pdb'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('publik.pdb.verval.pdb.berkas'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('publik.pdb.verval.pdb.berkas'));
            $detailPage->SetHttpHandlerName('publik_pdb_verval_pdb_berkas_handler');
            $handler = new PageHTTPHandler('publik_pdb_verval_pdb_berkas_handler', $detailPage);
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
            $suggestionsDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $suggestionsDataset->addFields(
                array(
                    new StringField('tempat_lahir', true)
                )
            );
            $suggestionsDataset->setOrderByField('tempat_lahir', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'tempat_lahir', 'insert_publik_pdb_tempat_lahir_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_id_jenis_tinggal_search', 'id_jenis_tinggal', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_id_alat_transportasi_search', 'id_alat_transportasi', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_cita_search', 'id_cita', 'nm_cita', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_hobi_search', 'id_hobi', 'nm_hobi', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_kk_utama_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_kk_pilihan_search', 'id_kk', 'nama_kk', null, 20);
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
            $suggestionsDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $suggestionsDataset->addFields(
                array(
                    new StringField('tempat_lahir', true)
                )
            );
            $suggestionsDataset->setOrderByField('tempat_lahir', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'tempat_lahir', 'filter_builder_publik_pdb_tempat_lahir_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_id_jenis_tinggal_search', 'id_jenis_tinggal', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_id_alat_transportasi_search', 'id_alat_transportasi', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_cita_search', 'id_cita', 'nm_cita', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_hobi_search', 'id_hobi', 'nm_hobi', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kk_utama_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kk_pilihan_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kk_pilihan_search', 'id_kk', 'nama_kk', null, 20);
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
            $suggestionsDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $suggestionsDataset->addFields(
                array(
                    new StringField('tempat_lahir', true)
                )
            );
            $suggestionsDataset->setOrderByField('tempat_lahir', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'tempat_lahir', 'edit_publik_pdb_tempat_lahir_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_id_jenis_tinggal_search', 'id_jenis_tinggal', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_id_alat_transportasi_search', 'id_alat_transportasi', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_cita_search', 'id_cita', 'nm_cita', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_hobi_search', 'id_hobi', 'nm_hobi', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_kk_utama_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_kk_pilihan_search', 'id_kk', 'nama_kk', null, 20);
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
            $suggestionsDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb');
            $suggestionsDataset->addFields(
                array(
                    new StringField('tempat_lahir', true)
                )
            );
            $suggestionsDataset->setOrderByField('tempat_lahir', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'tempat_lahir', 'multi_edit_publik_pdb_tempat_lahir_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   `urut`, 
                   `kode_wilayah`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`,
                   CONCAT(
                          `desa_kelurahan`, ", ",
                          `kec`, ", ", 
                          `kab_kota`, ", ", 
                          `prov`, ", " , 
                          `kode_pos`
                   ) wilayah_administratif
            FROM 
                 `smkn2s01_kystudio_ref`.`wilayah`';
            $insertQuery = array('INSERT INTO `smkn2s01_kystudio_ref`.`wilayah`(
                   `kode_wilayah`, 
                   `urut`, 
                   `desa_kelurahan`, 
                   `kec`, 
                   `kab_kota`, 
                   `prov`, 
                   `kode_pos`) 
            VALUES (
                   :kode_wilayah, 
                   :urut, 
                   :desa_kelurahan, 
                   :kec, 
                   :kab_kota, 
                   :prov, 
                   :kode_pos
            )');
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.wilayah');
            $lookupDataset->addFields(
                array(
                    new IntegerField('urut'),
                    new StringField('kode_wilayah', false, true),
                    new StringField('desa_kelurahan'),
                    new StringField('kec'),
                    new StringField('kab_kota'),
                    new StringField('prov'),
                    new StringField('kode_pos'),
                    new StringField('wilayah_administratif')
                )
            );
            $lookupDataset->setOrderByField('wilayah_administratif', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_id_sp_search', 'id_sp', 'npsn_nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_tinggal`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.tinggal');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_jenis_tinggal', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_id_jenis_tinggal_search', 'id_jenis_tinggal', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`alat_transportasi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.alat.transportasi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_alat_transportasi', false, true),
                    new StringField('nama')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_id_alat_transportasi_search', 'id_alat_transportasi', 'nama', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_cita`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.cita');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_cita', false, true),
                    new StringField('nm_cita')
                )
            );
            $lookupDataset->setOrderByField('nm_cita', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_cita_search', 'id_cita', 'nm_cita', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT * FROM `smkn2s01_kystudio_ref`.`jenis_hobi`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.jenis.hobi');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_hobi', false, true),
                    new StringField('nm_hobi')
                )
            );
            $lookupDataset->setOrderByField('nm_hobi', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_hobi_search', 'id_hobi', 'nm_hobi', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_kk_utama_search', 'id_kk', 'nama_kk', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_kk_pilihan_search', 'id_kk', 'nama_kk', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            require 'aksi/pdb_OnCustomRenderColumn.inc.php';
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
            require 'aksi/pdb_OnBeforeInsertRecord.inc.php';
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
            require 'aksi/pdb_OnBeforeUpdateRecord.inc.php';
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            require 'aksi/pdb_OnAfterInsertRecord.inc.php';
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            require 'aksi/pdb_OnAfterUpdateRecord.inc.php';
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
            require 'aksi/pdb_OnGetCustomTemplate.inc.php';
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
            require 'aksi/pdb_OnGetCustomFormLayout.inc.php';
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
            require 'aksi/pdb_OnGetCustomColumnGroup.inc.php';
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
        $Page = new publik_pdbPage("publik_pdb", "publik.pdb.php", GetCurrentUserPermissionsForPage("publik.pdb"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("publik.pdb"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
