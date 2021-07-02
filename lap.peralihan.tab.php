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
    
    
    
    class lap_peralihan_tabPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Laporan Peralihan TAB');
            $this->SetMenuLabel('Laporan Peralihan TAB');
    
            $selectQuery = 'SELECT 
                   `pp`.`id_kk`, `pp`.`pilihan`, 
                   `kk`.`nama_kk`, `p`.`nopen`, 
                   `p`.`nama`, `p`.`id_sp`, 
                   `p`.`nama_ayah`, `p`.`nama_ibu`, 
                   `p`.`kontak_pdb`, `p`.`kontak_ayah`, 
                   `p`.`kontak_ibu`, `p`.`kontak_lain`
            FROM `pdb` `p` 
            INNER JOIN `pdb_pilihan` `pp` 
            	ON `pp`.`id_pdb` = `p`.`id_pdb`
            INNER JOIN `smkn2s01_kystudio_ref`.`kompetensi_keahlian` `kk` 
            	ON `kk`.`id_kk` = `pp`.`id_kk`
            WHERE 
            	`p`.`id_pdb` IN(
                    SELECT `id_pdb` FROM `pdb_pilihan` `pp` 
                    WHERE `id_pdb_pilihan` NOT IN(
                        SELECT `id_pdb_pilihan` FROM `pdb_pilihan` `pp` 
                        WHERE `status` = 2
                    )
            	)
            ORDER BY `p`.`nama`, `pp`.`pilihan`, `kk`.`nama_kk`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'lap.peralihan.tab');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_kk', false, true),
                    new IntegerField('pilihan'),
                    new StringField('nama_kk'),
                    new IntegerField('nopen'),
                    new StringField('nama'),
                    new StringField('id_sp'),
                    new StringField('nama_ayah'),
                    new StringField('nama_ibu'),
                    new StringField('kontak_pdb'),
                    new StringField('kontak_ayah'),
                    new StringField('kontak_ibu'),
                    new StringField('kontak_lain')
                )
            );
            $this->dataset->AddLookupField('id_sp', '(SELECT 
                   *, 
                   CONCAT("(",`npsn`,")",`nama_sp`) npsn_nama 
            FROM 
                 `smkn2s01_kystudio_ref`.`satuan_pendidikan`)', new StringField('id_sp'), new StringField('nama_sp', false, false, false, false, 'id_sp_nama_sp', 'id_sp_nama_sp_ref_satuan_pendidikan'), 'id_sp_nama_sp_ref_satuan_pendidikan');
            $this->dataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), '(id_kk NOT IN(6))'));
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
                new FilterColumn($this->dataset, 'id_kk', 'id_kk', 'ID KK'),
                new FilterColumn($this->dataset, 'pilihan', 'pilihan', 'Pilihan Ke'),
                new FilterColumn($this->dataset, 'nama_kk', 'nama_kk', 'Kompetensi Keahlian'),
                new FilterColumn($this->dataset, 'nopen', 'nopen', 'No. Registrasi'),
                new FilterColumn($this->dataset, 'nama', 'nama', 'Nama PDB'),
                new FilterColumn($this->dataset, 'id_sp', 'id_sp_nama_sp', 'Sekolah Asal'),
                new FilterColumn($this->dataset, 'nama_ayah', 'nama_ayah', 'Nama Ayah'),
                new FilterColumn($this->dataset, 'nama_ibu', 'nama_ibu', 'Nama Ibu'),
                new FilterColumn($this->dataset, 'kontak_pdb', 'kontak_pdb', 'Kontak PDB'),
                new FilterColumn($this->dataset, 'kontak_ayah', 'kontak_ayah', 'Kontak Ayah'),
                new FilterColumn($this->dataset, 'kontak_ibu', 'kontak_ibu', 'Kontak Ibu'),
                new FilterColumn($this->dataset, 'kontak_lain', 'kontak_lain', 'Kontak Lain')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_kk'])
                ->addColumn($columns['pilihan'])
                ->addColumn($columns['nama_kk'])
                ->addColumn($columns['nopen'])
                ->addColumn($columns['nama'])
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
                ->setOptionsFor('pilihan')
                ->setOptionsFor('nama_kk')
                ->setOptionsFor('nopen')
                ->setOptionsFor('nama')
                ->setOptionsFor('id_sp');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new SpinEdit('id_kk_edit');
            
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
            
            $main_editor = new DynamicCombobox('id_sp_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_lap_peralihan_tab_id_sp_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_sp', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_lap_peralihan_tab_id_sp_search');
            
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
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_kk field
            //
            $column = new NumberViewColumn('id_kk', 'id_kk', 'ID KK', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan Ke', $this->dataset);
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
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Kompetensi Keahlian', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'No. Registrasi', $this->dataset);
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
            $column = new TextViewColumn('nama', 'nama', 'Nama PDB', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nama_sp field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_nama_sp', 'Sekolah Asal', $this->dataset);
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
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak PDB', $this->dataset);
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
            // View column for id_kk field
            //
            $column = new NumberViewColumn('id_kk', 'id_kk', 'ID KK', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan Ke', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Kompetensi Keahlian', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'No. Registrasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama PDB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_sp field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_nama_sp', 'Sekolah Asal', $this->dataset);
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
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak PDB', $this->dataset);
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
            // Edit column for id_kk field
            //
            $editor = new SpinEdit('id_kk_edit');
            $editColumn = new CustomEditColumn('ID KK', 'id_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan Ke', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama_kk field
            //
            $editor = new TextEdit('nama_kk_edit');
            $editColumn = new CustomEditColumn('Kompetensi Keahlian', 'nama_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('No. Registrasi', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama PDB', 'nama', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sekolah Asal', 'id_sp', 'id_sp_nama_sp', 'edit_lap_peralihan_tab_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'nama_sp', '');
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
            $editColumn = new CustomEditColumn('Kontak PDB', 'kontak_pdb', $editor, $this->dataset);
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
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan Ke', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama_kk field
            //
            $editor = new TextEdit('nama_kk_edit');
            $editColumn = new CustomEditColumn('Kompetensi Keahlian', 'nama_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('No. Registrasi', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama PDB', 'nama', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sekolah Asal', 'id_sp', 'id_sp_nama_sp', 'multi_edit_lap_peralihan_tab_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'nama_sp', '');
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
            // Edit column for kontak_pdb field
            //
            $editor = new TextEdit('kontak_pdb_edit');
            $editColumn = new CustomEditColumn('Kontak PDB', 'kontak_pdb', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_ayah field
            //
            $editor = new TextEdit('kontak_ayah_edit');
            $editColumn = new CustomEditColumn('Kontak Ayah', 'kontak_ayah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_ibu field
            //
            $editor = new TextEdit('kontak_ibu_edit');
            $editColumn = new CustomEditColumn('Kontak Ibu', 'kontak_ibu', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for kontak_lain field
            //
            $editor = new TextEdit('kontak_lain_edit');
            $editColumn = new CustomEditColumn('Kontak Lain', 'kontak_lain', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_kk field
            //
            $editor = new SpinEdit('id_kk_edit');
            $editColumn = new CustomEditColumn('ID KK', 'id_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pilihan field
            //
            $editor = new SpinEdit('pilihan_edit');
            $editColumn = new CustomEditColumn('Pilihan Ke', 'pilihan', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama_kk field
            //
            $editor = new TextEdit('nama_kk_edit');
            $editColumn = new CustomEditColumn('Kompetensi Keahlian', 'nama_kk', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('No. Registrasi', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nama field
            //
            $editor = new TextEdit('nama_edit');
            $editColumn = new CustomEditColumn('Nama PDB', 'nama', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sekolah Asal', 'id_sp', 'id_sp_nama_sp', 'insert_lap_peralihan_tab_id_sp_search', $editor, $this->dataset, $lookupDataset, 'id_sp', 'nama_sp', '');
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
            $editColumn = new CustomEditColumn('Kontak PDB', 'kontak_pdb', $editor, $this->dataset);
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
            // View column for id_kk field
            //
            $column = new NumberViewColumn('id_kk', 'id_kk', 'ID KK', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan Ke', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Kompetensi Keahlian', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'No. Registrasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama PDB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_sp field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_nama_sp', 'Sekolah Asal', $this->dataset);
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
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak PDB', $this->dataset);
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
            // View column for id_kk field
            //
            $column = new NumberViewColumn('id_kk', 'id_kk', 'ID KK', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan Ke', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Kompetensi Keahlian', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'No. Registrasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama PDB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_sp field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_nama_sp', 'Sekolah Asal', $this->dataset);
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
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak PDB', $this->dataset);
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
            // View column for id_kk field
            //
            $column = new NumberViewColumn('id_kk', 'id_kk', 'ID KK', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for pilihan field
            //
            $column = new NumberViewColumn('pilihan', 'pilihan', 'Pilihan Ke', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_kk field
            //
            $column = new TextViewColumn('nama_kk', 'nama_kk', 'Kompetensi Keahlian', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nopen field
            //
            $column = new NumberViewColumn('nopen', 'nopen', 'No. Registrasi', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama field
            //
            $column = new TextViewColumn('nama', 'nama', 'Nama PDB', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_sp field
            //
            $column = new TextViewColumn('id_sp', 'id_sp_nama_sp', 'Sekolah Asal', $this->dataset);
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
            $column = new TextViewColumn('kontak_pdb', 'kontak_pdb', 'Kontak PDB', $this->dataset);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_lap_peralihan_tab_id_sp_search', 'id_sp', 'nama_sp', null, 20);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_lap_peralihan_tab_id_sp_search', 'id_sp', 'nama_sp', null, 20);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_lap_peralihan_tab_id_sp_search', 'id_sp', 'nama_sp', null, 20);
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
            $lookupDataset->setOrderByField('nama_sp', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_lap_peralihan_tab_id_sp_search', 'id_sp', 'nama_sp', null, 20);
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
        $Page = new lap_peralihan_tabPage("lap_peralihan_tab", "lap.peralihan.tab.php", GetCurrentUserPermissionsForPage("lap.peralihan.tab"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("lap.peralihan.tab"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
