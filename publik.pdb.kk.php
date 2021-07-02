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
    
    
    
    class publik_pdb_kkPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Verval KK');
            $this->SetMenuLabel('Verval KK');
    
            $selectQuery = 'SELECT 
            	`id_pdb`, 
                `nopen`, 
                `no_kk`, 
                `nama`, 
                `nik`, 
                `jenis_kelamin`, 
                `tempat_lahir`, 
                `tanggal_lahir`, 
                `id_agama`, 
                `golongan_darah`, 
                `alamat_jalan`, 
                `rt`, 
                `rw`, 
                `nama_dusun`, 
                `kode_wilayah`, 
                `nama_ayah`, 
                `nama_ibu`
            FROM `pdb`';
            $insertQuery = array();
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
                `nama_ibu` = :nama_ibu
            WHERE 
                  `id_pdb` = :OLD_id_pdb');
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'publik.pdb.kk');
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
                    new StringField('nama_ibu', true)
                )
            );
            $this->dataset->AddLookupField('id_agama', '(SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`)', new IntegerField('id_agama'), new StringField('nama', false, false, false, false, 'id_agama_nama', 'id_agama_nama_ref_agama'), 'id_agama_nama_ref_agama');
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
        }
    
        protected function DoPrepare() {
            // OnGlobalPreparePage event handler code
            require 'aksi/Global_OnPreparePage.inc.php';
            
            // OnPreparePage event handler code
            require 'aksi/pdb.verval.kk_OnPreparePage.inc.php';
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
                new FilterColumn($this->dataset, 'id_agama', 'id_agama_nama', 'Id Agama'),
                new FilterColumn($this->dataset, 'golongan_darah', 'golongan_darah', 'Golongan Darah'),
                new FilterColumn($this->dataset, 'alamat_jalan', 'alamat_jalan', 'Alamat Jalan'),
                new FilterColumn($this->dataset, 'rt', 'rt', 'Rt'),
                new FilterColumn($this->dataset, 'rw', 'rw', 'Rw'),
                new FilterColumn($this->dataset, 'nama_dusun', 'nama_dusun', 'Nama Dusun'),
                new FilterColumn($this->dataset, 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'Kode Wilayah'),
                new FilterColumn($this->dataset, 'nama_ayah', 'nama_ayah', 'Nama Ayah'),
                new FilterColumn($this->dataset, 'nama_ibu', 'nama_ibu', 'Nama Ibu')
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
                ->addColumn($columns['nama_ibu']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('tanggal_lahir')
                ->setOptionsFor('id_agama')
                ->setOptionsFor('kode_wilayah');
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
            
            $main_editor = new TextEdit('no_kk_edit');
            
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
            
            $main_editor = new MultiValueSelect('jenis_kelamin');
            $main_editor->addChoice('L', 'L');
            $main_editor->addChoice('P', 'P');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tempat_lahir_edit');
            
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
            
            $main_editor = new DynamicCombobox('id_agama_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_publik_pdb_kk_id_agama_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_agama', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_kk_id_agama_search');
            
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
            
            $main_editor = new TextEdit('golongan_darah_edit');
            
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
            
            $main_editor = new TextEdit('alamat_jalan_edit');
            
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
            $main_editor->SetHandlerName('filter_builder_publik_pdb_kk_kode_wilayah_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('kode_wilayah', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_publik_pdb_kk_kode_wilayah_search');
            
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for nama field
            //
            $column = new TextViewColumn('id_agama', 'id_agama_nama', 'Id Agama', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            // View column for nama field
            //
            $column = new TextViewColumn('id_agama', 'id_agama_nama', 'Id Agama', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(true);
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
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
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new TextEdit('no_kk_edit');
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
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new CheckBoxGroup('jenis_kelamin_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('L', 'L');
            $editor->addChoice('P', 'P');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new TextEdit('tempat_lahir_edit');
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
            $editor = new DynamicCombobox('id_agama_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Agama', 'id_agama', 'id_agama_nama', 'edit_publik_pdb_kk_id_agama_search', $editor, $this->dataset, $lookupDataset, 'id_agama', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new TextEdit('golongan_darah_edit');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextEdit('alamat_jalan_edit');
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'edit_publik_pdb_kk_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
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
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new TextEdit('no_kk_edit');
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
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new CheckBoxGroup('jenis_kelamin_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('L', 'L');
            $editor->addChoice('P', 'P');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new TextEdit('tempat_lahir_edit');
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
            $editor = new DynamicCombobox('id_agama_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Agama', 'id_agama', 'id_agama_nama', 'multi_edit_publik_pdb_kk_id_agama_search', $editor, $this->dataset, $lookupDataset, 'id_agama', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new TextEdit('golongan_darah_edit');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextEdit('alamat_jalan_edit');
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'multi_edit_publik_pdb_kk_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
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
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
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
            // Edit column for nopen field
            //
            $editor = new SpinEdit('nopen_edit');
            $editColumn = new CustomEditColumn('Nopen', 'nopen', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for no_kk field
            //
            $editor = new TextEdit('no_kk_edit');
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
            $editor = new TextEdit('nik_edit');
            $editColumn = new CustomEditColumn('Nik', 'nik', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for jenis_kelamin field
            //
            $editor = new CheckBoxGroup('jenis_kelamin_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('L', 'L');
            $editor->addChoice('P', 'P');
            $editColumn = new CustomEditColumn('Jenis Kelamin', 'jenis_kelamin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tempat_lahir field
            //
            $editor = new TextEdit('tempat_lahir_edit');
            $editColumn = new CustomEditColumn('Tempat Lahir', 'tempat_lahir', $editor, $this->dataset);
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
            $editor = new DynamicCombobox('id_agama_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Agama', 'id_agama', 'id_agama_nama', 'insert_publik_pdb_kk_id_agama_search', $editor, $this->dataset, $lookupDataset, 'id_agama', 'nama', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for golongan_darah field
            //
            $editor = new TextEdit('golongan_darah_edit');
            $editColumn = new CustomEditColumn('Golongan Darah', 'golongan_darah', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for alamat_jalan field
            //
            $editor = new TextEdit('alamat_jalan_edit');
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for rw field
            //
            $editor = new SpinEdit('rw_edit');
            $editColumn = new CustomEditColumn('Rw', 'rw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Kode Wilayah', 'kode_wilayah', 'kode_wilayah_wilayah_administratif', 'insert_publik_pdb_kk_kode_wilayah_search', $editor, $this->dataset, $lookupDataset, 'kode_wilayah', 'wilayah_administratif', '');
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
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            // View column for nama field
            //
            $column = new TextViewColumn('id_agama', 'id_agama_nama', 'Id Agama', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(true);
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            // View column for nama field
            //
            $column = new TextViewColumn('id_agama', 'id_agama_nama', 'Id Agama', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(true);
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for no_kk field
            //
            $column = new TextViewColumn('no_kk', 'no_kk', 'No Kk', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
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
            // View column for nama field
            //
            $column = new TextViewColumn('id_agama', 'id_agama_nama', 'Id Agama', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for rt field
            //
            $column = new NumberViewColumn('rt', 'rt', 'Rt', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for rw field
            //
            $column = new NumberViewColumn('rw', 'rw', 'Rw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nama_dusun field
            //
            $column = new TextViewColumn('nama_dusun', 'nama_dusun', 'Nama Dusun', $this->dataset);
            $column->SetOrderable(true);
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
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_kk_id_agama_search', 'id_agama', 'nama', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_publik_pdb_kk_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kk_id_agama_search', 'id_agama', 'nama', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_publik_pdb_kk_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_kk_id_agama_search', 'id_agama', 'nama', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_publik_pdb_kk_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT 
                   *
            FROM 
                 `smkn2s01_kystudio_ref`.`agama`';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MyPDOConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'ref.agama');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_agama'),
                    new StringField('nama'),
                    new DateTimeField('tanggal_dibuat'),
                    new DateTimeField('tanggal_perbarui'),
                    new DateTimeField('sinkronisasi')
                )
            );
            $lookupDataset->setOrderByField('nama', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_kk_id_agama_search', 'id_agama', 'nama', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_publik_pdb_kk_kode_wilayah_search', 'kode_wilayah', 'wilayah_administratif', null, 20);
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
        $Page = new publik_pdb_kkPage("publik_pdb_kk", "publik.pdb.kk.php", GetCurrentUserPermissionsForPage("publik.pdb.kk"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("publik.pdb.kk"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
