<div style="font-family: Arial, sans-serif;">

	<p>
		Daftar Peserta Didik Baru<br />
		SMK NEGERI 2 SUMBAWA BESAR<br />
		Kecamatan Kec. Unter Iwes, Kabupaten Kab. Sumbawa, Provinsi Prov. Nusa Tenggara Barat<br />		
		Tanggal Unduh: 2021-06-11 21:59:03		Pengunduh: Zainul Ikhsan Hakim (smk50203319@gmail.com)
	</p>
	
	<table border=1>
		<tr>
			{foreach item=Caption from=$HeaderCaptions}
				<td x:str>{$Caption}</td>
			{/foreach}
		</tr>
		{foreach item=Row from=$Rows name=RowsGrid}
			<tr>
				{foreach item=RowColumn from=$Row}
					<td{if $RowColumn.Align != null} align="{$RowColumn.Align}"{/if} style="vertical-align: top;">{$RowColumn.Value}</td>
				{/foreach}
			</tr>
		{/foreach}
		{include file='list/totals.tpl'}
	</table>

</div>