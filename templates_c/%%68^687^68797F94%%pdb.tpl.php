<?php echo '<div><table style="width: 100%;"><tr><td><img style="width: 10%;" src="gambar/logo.png" /></td><td><div style="text-align: center; font-size: 14pt; font-weight: bold;">PEMERINTAH PROVINSI NUSA TENGGARA BARAT<br />DINAS PENDIDIKAN DAN KEBUDAYAAN</div><div style="text-align: center; font-size: 16pt; font-weight: bold;">SMK NEGERI 2 SUMBAWA BESAR</div></td></tr></table></div><hr style="border-bottom: 6px; border-bottom-style: solid double;" />'; ?>


<div style="">
	<table border="0" width="100%">
				
		<?php $this->assign('count', 1); ?>
		<?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Rows'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Rows']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['Rows']['iteration']++;
?>
		
		<!-- Bagian A -->
		<tr>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;">A</td>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;" colspan="3">Data Calon Peserta Didik</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No. KK</td>
			<td>:</td>
			<td style="text-align: left">
				<?php echo $this->_tpl_vars['Row']['no_kk']['Value']; ?>
&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;NIK&emsp;:&emsp;<?php echo $this->_tpl_vars['Row']['nik']['Value']; ?>

			</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Nama</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['nama']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Jenis Kelamin</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['jenis_kelamin']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Tempat, Tanggal Lahir</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['tempat_lahir']['Value']; ?>
, <?php echo $this->_tpl_vars['Row']['tanggal_lahir']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Agama</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['id_agama']['Value']; ?>
</td>
		</tr><tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Golongan Darah</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['golongan_darah']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Alamat</td>
			<td>:</td>
			<td style="text-align: left">
				<?php echo $this->_tpl_vars['Row']['alamat_jalan']['Value']; ?>
<br />
				RT <?php echo $this->_tpl_vars['Row']['rt']['Value']; ?>
 RW <?php echo $this->_tpl_vars['Row']['rw']['Value']; ?>
<br />
				Dusun <?php echo $this->_tpl_vars['Row']['nama_dusun']['Value']; ?>

			</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Wilayah</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['kode_wilayah']['Value']; ?>
</td>
		</tr>
		
		<!-- Bagian B -->
		<tr>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;">B</td>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;" colspan="3">Data Orang Tua</td>
		</tr>
		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Nama Ayah</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['nama_ayah']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Nama Ibu</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['nama_ibu']['Value']; ?>
</td>
		</tr>
		
		<tr>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;">C</td>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;" colspan="3">Data Sekolah Asal</td>
		</tr>
		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Sekolah asal</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['id_sp']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">NISN</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['nisn']['Value']; ?>
</td>
		</tr>		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No. Peserta UN</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['nopes']['Value']; ?>
</td>
		</tr>
		
		<tr>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;">D</td>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;" colspan="3">Data Periodik</td>
		</tr>
		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Tinggi Badan</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['tinggi_badan']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Berat Badan</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['berat_badan']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Cita-cita</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['cita']['Value']; ?>
</td>
		</tr>		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Hobi</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['hobi']['Value']; ?>
</td>
		</tr>
		
		<tr>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;">E</td>
			<td style="text-align: left; font-size: 10pt; font-weight: bold;" colspan="3">Data Kontak</td>
		</tr>
		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">Email</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['email']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No.HP/WA Pribadi</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['kontak_pdb']['Value']; ?>
</td>
		</tr>		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No.HP/WA Ayah</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['kontak_ayah']['Value']; ?>
</td>
		</tr>		
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No.HP/WA Ibu</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['kontak_ibu']['Value']; ?>
</td>
		</tr>
		<tr>
			<td style="padding-left: 30px;"><?php echo $this->_tpl_vars['count']++; ?>
</td>
			<td style="text-align: left">No.HP/WA Lainnya</td>
			<td>:</td>
			<td style="text-align: left"><?php echo $this->_tpl_vars['Row']['kontak_lain']['Value']; ?>
</td>
		</tr>
			
		<?php endforeach; endif; unset($_from); ?>
		
	</table>
</div>