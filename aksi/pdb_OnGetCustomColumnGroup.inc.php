<?php

$columnGroup->add(new ViewColumnGroup('Biodata', 
    array(
        $columns['nopen'],
        $columns['no_kk'],
        $columns['nama'],
        $columns['nik'],
        $columns['jenis_kelamin'],
        $columns['tempat_lahir'],
        $columns['tanggal_lahir'],
        $columns['id_agama'],
        $columns['golongan_darah']
    )
));

$columnGroup->add(new ViewColumnGroup('Alamat', 
    array(
        $columns['alamat_jalan'],
        $columns['rt'],
        $columns['rw'],
        $columns['nama_dusun'],
        $columns['kode_wilayah']
    )
));

$columnGroup->add(new ViewColumnGroup('Orang Tua', 
    array(
        $columns['nama_ayah'],
        $columns['nama_ibu']
    )
));

$columnGroup->add(new ViewColumnGroup('SMP/ Sederajat', 
    array(
        $columns['id_sp'],
        $columns['nisn'],
        $columns['nopes']
    )
));

$columnGroup->add(new ViewColumnGroup('No. HP/ WA', 
    array(
        $columns['email'],
        $columns['kontak_pdb'],
        $columns['kontak_ayah'],
        $columns['kontak_ibu'],
        $columns['kontak_lain']
    )
));

$columnGroup->add(new ViewColumnGroup('Lain-lain', 
    array(
        $columns['id_jenis_tinggal'],
        $columns['id_alat_transportasi'],
        $columns['tinggi_badan'],
        $columns['berat_badan'],
        $columns['cita'],
        $columns['hobi']
    )
));