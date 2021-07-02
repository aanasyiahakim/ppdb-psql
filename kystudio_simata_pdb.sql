-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 12:08 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kystudio_simata_pdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pdb`
--

CREATE TABLE `pdb` (
  `id_pdb` char(36) NOT NULL,
  `nopen` int(11) DEFAULT NULL,
  `no_kk` char(16) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `nama` varchar(83) NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `nik` char(16) NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `jenis_kelamin` set('L','P') NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `tempat_lahir` varchar(32) NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `tanggal_lahir` date NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `id_agama` tinyint(6) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `golongan_darah` varchar(50) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `alamat_jalan` varchar(80) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `rt` decimal(2,0) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `rw` decimal(2,0) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `nama_dusun` varchar(60) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `kode_wilayah` char(10) DEFAULT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `nama_ayah` varchar(83) NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `nama_ibu` varchar(83) NOT NULL COMMENT 'Data bersumber dari Kartu Keluarga',
  `id_sp` varchar(100) NOT NULL COMMENT 'Data bersumber dari SMP/ sederajat',
  `nisn` char(10) DEFAULT NULL COMMENT 'Data bersumber dari SMP/ sederajat',
  `nopes` char(20) DEFAULT NULL COMMENT 'Data bersumber dari SMP/ sederajat',
  `id_jenis_tinggal` tinyint(4) DEFAULT NULL,
  `id_alat_transportasi` tinyint(4) DEFAULT NULL,
  `tinggi_badan` smallint(6) DEFAULT NULL,
  `berat_badan` smallint(6) DEFAULT NULL,
  `lingkar_kepala` tinyint(4) DEFAULT '0',
  `cita` tinyint(4) DEFAULT NULL,
  `hobi` tinyint(4) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `kontak_pdb` varchar(15) DEFAULT NULL,
  `kontak_ayah` varchar(15) DEFAULT NULL,
  `kontak_ibu` varchar(15) DEFAULT NULL,
  `kontak_lain` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_perbarui` datetime DEFAULT CURRENT_TIMESTAMP,
  `sinkronisasi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pdb`
--

INSERT INTO `pdb` (`id_pdb`, `nopen`, `no_kk`, `nama`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `id_agama`, `golongan_darah`, `alamat_jalan`, `rt`, `rw`, `nama_dusun`, `kode_wilayah`, `nama_ayah`, `nama_ibu`, `id_sp`, `nisn`, `nopes`, `id_jenis_tinggal`, `id_alat_transportasi`, `tinggi_badan`, `berat_badan`, `lingkar_kepala`, `cita`, `hobi`, `email`, `kontak_pdb`, `kontak_ayah`, `kontak_ibu`, `kontak_lain`, `aktif`, `tanggal_dibuat`, `tanggal_perbarui`, `sinkronisasi`) VALUES
('02581a0f-c34d-11eb-ac40-0a0027000015', 8, '5204093101084673', 'Faris Basyar Ramdani', '5204093010050001', 'L', 'Moyo', '2005-10-30', 1, '0', '-', '4', '2', 'Moyo Bawah', '5204092013', 'Sabar', '', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0058590239', NULL, 1, 2, 148, 44, 57, 41, 15, 'basyarfaris@gmail.com', '085338143595', NULL, '085237714289', NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('039a6a76-c5af-11eb-b66c-60e327058ff5', 83, '5204291810060001', 'Ghifari Azhar Ramdani ', '5204291810060001', 'L', 'Sumbawa ', '2006-10-18', 1, '4', 'Dusun Sepukur ', '4', '2', 'Dusun Supukur ', '5204292002', 'Muhammad Fatoni ', 'Kusmiati ', '75eff31e-d87b-4189-a4ef-8882c84f4f50', '0064653733', NULL, 1, 13, 164, 65, 57, 37, 21, '', '081236934787', '085238219650', '085238219650', '082340508350', 1, '2021-06-05 11:45:27', '2021-06-05 11:45:27', '2021-06-05 11:45:27'),
('06b197b0-c412-11eb-bd8f-60e327058ff5', 25, '5204080102081629', 'Kamri Suhalludin ', '5204080610050001', 'L', 'Sumbawa ', '2005-10-06', 1, '4', 'Jalan Raya Prate ', '3', '6', 'Prate ', '5204081001', 'Muhammadak ', 'Rabiatullah ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0056146601', NULL, 1, 2, 160, 48, 57, 13, 19, '', '083192730344', '085239659248', '085337397098', NULL, 1, '2021-06-03 10:27:15', '2021-06-03 10:27:15', '2021-06-03 10:27:15'),
('0c9473a9-c348-11eb-ac40-0a0027000015', 2, '5204220611110008', 'Muhammad Alfarizi', '5204222503070002', 'L', 'Sumbawa', '2007-03-25', 1, '0', 'Jl. Sultan Kaharudin, Gang Uma Beringin 4', '1', '3', 'Uma Beringin', '5204222007', 'Mursali Limbang', '', '17b86ab0-b7dc-4ac9-8af2-51e22d8b35e0', '0066789323', NULL, 1, 2, 147, 34, 53, 8, 20, 'muhammadalfarizisbw@gmail.com', '082339661748', NULL, NULL, NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('0e7a7a41-c5ab-11eb-b66c-60e327058ff5', 75, '5204083003120008', 'Devan Lowinsky Mada', '5204082107050005', 'L', 'Manado', '2005-07-21', 3, '0', 'gg tenggiri', '4', '5', 'gang tenggiri 1', '5204081004', 'yosep hopeyanto wl mada', 'devi ntalia takaliuang', '918661d6-4831-4139-846d-7465f763f769', '0053550020', NULL, 1, 2, 160, 47, 58, 13, 19, 'devanmada217@gmail.com', '085333988151', NULL, NULL, NULL, 1, '2021-06-05 11:16:25', '2021-06-05 11:16:25', '2021-06-05 11:16:25'),
('0eef4de1-c59e-11eb-b66c-60e327058ff5', 57, '5204092406120005', 'Muhammad Ridwan ', '5204090112050002', 'L', 'Moyo ', '2005-12-01', 1, '0', 'Dusun Moyo Atas ', '10', '4', 'Moyo Atas ', '5204092013', 'Saharuddin ', 'Salma ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0058241272', NULL, 1, 13, 165, 52, 56, 2, 19, '', '082339107230', NULL, NULL, NULL, 1, '2021-06-05 09:40:45', '2021-06-05 09:40:45', '2021-06-05 09:40:45'),
('10e1c30c-c5b2-11eb-b66c-60e327058ff5', 88, '5204240102082209', 'Fitri Amanda ', '5204246911050001', 'P', 'Sumbawa ', '2005-11-29', 1, '2', 'Dusun Bukit Kembang ', '5', '4', 'Bukit Kembang ', '5204242003', 'Syarafuddin ', 'Siti Siah ', '8364eb1d-98d1-4073-bb62-d4a2720f89aa', '0059475069', '2-19-23-08-011-010-7', 1, 13, 153, 33, 56, 4, 6, 'fitriamanda0304@gmail.com', '08337257855', '082341648377', '082341648377', '082339549224', 1, '2021-06-05 12:20:04', '2021-06-05 12:20:04', '2021-06-05 12:20:04'),
('15614b88-c5a7-11eb-b66c-60e327058ff5', 69, '5204090606120001', 'Dafa Ardiansyah ', '5204090501050001', 'L', 'Sumbawa ', '2005-01-05', 1, '1', 'Moyo ', '6', '3', 'Moyo Atas ', '5204092013', 'Sarjono ', 'Sahra ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0051073605', NULL, 1, 13, 163, 51, 56, 2, 26, 'danilxolenk@gmail.com', '082145864024', NULL, NULL, NULL, 1, '2021-06-05 10:43:49', '2021-06-05 10:43:49', '2021-06-05 10:43:49'),
('174311b5-c59f-11eb-b66c-60e327058ff5', 60, '5204103101084171', 'Zyulva Dwi Syaputra ', '5204102112060001', 'L', 'Sumbawa ', '2005-12-21', 1, '0', 'Sumbawa Lunyuk ', '1', '2', 'Sebasang Unter ', '5204102010', 'Ashabudin ', 'Rabiah ', '40afa201-9482-4acc-bad4-a43806436a71', '0055966210', NULL, 1, 13, 149, 34, 51, 8, 19, '', '085338601404', NULL, NULL, NULL, 1, '2021-06-05 09:46:23', '2021-06-05 09:46:23', '2021-06-05 09:46:23'),
('1759f889-c4cf-11eb-b637-60e327058ff5', 35, '5204103101084963', 'Evan Sukila Ariansyah ', '5204100206060001', 'L', 'Sumbawa ', '2006-06-02', 1, '4', 'Jalan Sumbawa Lunyuk ', '8', '4', 'Berang Belo ', '-', 'Sukiman My ', 'Sulhiati ', '3749951c-4997-4409-8652-ff04fa0feaf9', '0063356052', NULL, 1, 13, 152, 43, 54, 2, 19, 'evansumbawa@gmail.com', '085338603331', NULL, NULL, NULL, 1, '2021-06-04 09:00:35', '2021-06-04 09:00:35', '2021-06-04 09:00:35'),
('1b1fd5d3-c353-11eb-ac40-0a0027000015', 10, '5207082209110001', 'Dimas Hadi Saputro', '5207081007050002', 'L', 'Sumbawa', '2021-06-10', 1, '3', 'Jl. Hassanudin', '2', '1', 'Brang Bara', '5204081002', 'Kusman Jaya', '', 'a256826b-3ece-4baf-b56d-0a314d8e15eb', '0056422878', NULL, 1, 2, 162, 46, 54, 12, 18, 'dimasshadiisaputroo@gmail.com', '082218023498', '082218949949', '085337438867', NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('1b44cff1-c5b5-11eb-b66c-60e327058ff5', 89, '5204123101082939', 'Muhammad Abdazzaki ', '5204122607060001', 'L', 'Sumbawa ', '2006-07-26', 1, '4', 'Lape ', '2', '10', 'Bukit Tinggi ', '5204122003', 'Syaparudin ', 'Darmawati ', '40aa55e9-a16a-4955-bd03-8839302223fa', '0063074947', NULL, 1, 13, 180, 48, 56, 4, 19, 'zakyprtm510@gmail.com', '087700912719', NULL, NULL, NULL, 1, '2021-06-05 12:25:04', '2021-06-05 12:25:04', '2021-06-05 12:25:04'),
('1e6e263e-c34d-11eb-ac40-0a0027000015', 7, '5204260102081234', 'Andika Aldiansyah', '5204261906050001', 'L', 'Sumbawa', '2021-06-09', 1, '0', '-', '1', '3', 'Ramolong', '5204262002', 'Wendi Irawan', '', '334a017d-6e1b-4997-bd37-6bf2683426d0', '0057076420', NULL, 1, 2, 154, 45, 55, 2, 19, NULL, '085338711799', '082339992902', '082359535873', NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('202a565e-c594-11eb-b66c-60e327058ff5', 58, '5204093101083542', 'Rendy Saputra', '5204090412040001', 'L', 'Sumbawa', '2004-12-04', 1, '0', 'Ai Puntuk', '2', '1', 'Serading', '5204092009', 'Herudin', 'Jemati', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0046016309', NULL, 1, 13, 156, 42, 54, 16, 19, 'rendy44saputra@gmail.com', '085338913297', '085338913297', '085338913297', NULL, 1, '2021-06-05 09:42:27', '2021-06-05 09:42:27', '2021-06-05 09:42:27'),
('23ab6f16-c40a-11eb-bd8f-60e327058ff5', 19, '5204220102080795', 'Farhan Nurhaqiqi ', '5204221611050001', 'L', 'Sumbawa ', '2005-11-16', 1, '2', 'Jalan Samongkat ', '1', '6', 'Pelat 2 ', '5204222001', 'Syafruddin ', 'Sopiani ', '334a017d-6e1b-4997-bd37-6bf2683426d0', '0055341531', NULL, 1, 2, 143, 40, 53, 30, 19, '', '087755778382', '082340118833', NULL, NULL, 1, '2021-06-03 09:29:49', '2021-06-03 09:29:49', '2021-06-03 09:29:49'),
('25859c37-c419-11eb-bd8f-60e327058ff5', 30, '5204240102080282', 'Rafly Putra Ilyas ', '5204242909050001', 'L', 'Sumbawa ', '2005-09-29', 1, '0', 'Samapuin ', '1', '1', 'Brang Bara ', '5204081001', 'Ilyas ', 'Patiara ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0053366234', NULL, 1, 2, 151, 59, 58, 20, 19, 'raflysbwa@gmail.com', '082340446328', '082340446328', '082340446328', NULL, 1, '2021-06-03 11:16:09', '2021-06-03 11:16:09', '2021-06-03 11:16:09'),
('29ae324f-c595-11eb-b66c-60e327058ff5', 53, '5204240102080415', 'Muhammad Fadli ', '5204243006050001', 'L', 'Sumbawa ', '2005-06-30', 1, '4', 'Maronge ', '1', '7', 'Maronge ', '5204242002', 'Asmaun ', 'Mardiana ', '3c7adfcb-529e-42a5-b896-62a63b333446', '0059557179', NULL, 99, 2, 157, 55, 54, 13, 19, 'fm2626891@gmail.com', '087824322845', NULL, '085205230028', NULL, 1, '2021-06-05 08:38:01', '2021-06-05 08:38:01', '2021-06-05 08:38:01'),
('2dd847ce-c5b7-11eb-b66c-60e327058ff5', 94, '5204081711090002', 'Aries Amril Yanto ', '5204080404050002', 'L', 'Sumbawa ', '2005-04-04', 1, '0', 'Jln.gunung Setia ', '2', '7', '- ', '5204081007', 'Suriyanto ', 'Aminanti ', 'ab0a32de-ef5b-4beb-aee3-cc97d2ac8733', '0057600362', NULL, 1, 13, 156, 48, 58, 8, 20, '', '085338571035', NULL, NULL, NULL, 1, '2021-06-05 12:38:11', '2021-06-05 12:38:11', '2021-06-05 12:38:11'),
('306f60c0-c418-11eb-bd8f-60e327058ff5', 29, '5204240102080286', 'M Nabil Afif Akbar ', '5204242811050001', 'L', 'Sumbawa ', '2005-11-28', 1, '0', 'Panto Daeng ', '1', '1', 'Labuan Sangor ', '5204242004', 'Suriyanto ', 'Patiamang ', 'dd10cdb6-a7f0-45f2-99c7-fca2798dc9d1', '0056703287', NULL, 1, 2, 161, 53, 56, 2, 19, 'nabilakbar829@gmail.com', '082339973900', NULL, NULL, NULL, 1, '2021-06-03 11:10:53', '2021-06-03 11:10:53', '2021-06-03 11:10:53'),
('31b1636e-c405-11eb-bd8f-60e327058ff5', 16, '5204081507140003', 'Shandy Rizki Auwalianto ', '5204081912050003', 'L', 'Sumbawa ', '2005-12-19', 1, '3', 'Jalan Osap Sio ', '2', '11', 'Kampung Irian ', '5204081008', 'Sugianto Santoso ', 'Yuliah ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0056571649', NULL, 1, 2, 160, 49, 53, 13, 19, 'shandyrizkiawalianto@gmail.com', '085237730752', NULL, NULL, NULL, 1, '2021-06-03 09:06:07', '2021-06-03 09:06:07', '2021-06-03 09:06:07'),
('3559e765-c4d5-11eb-b637-60e327058ff5', 36, '5204083101084733', 'Sahrul Usman ', '5204081612040001', 'L', 'Sumbawa ', '2004-12-16', 1, '0', 'Panto Daeng ', '3', '7', '- ', '5204081002', 'Umar Usman ', 'Fatmawati ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0047219134', NULL, 1, 13, 170, 69, 57, 2, 1, 'sahrulusman223@gmail.com', '085337008165', NULL, NULL, NULL, 1, '2021-06-04 09:40:25', '2021-06-04 09:40:25', '2021-06-04 09:40:25'),
('355f855b-c40c-11eb-bd8f-60e327058ff5', 21, '5204080102081569', 'Hardiansyah ', '5204080703060001', 'L', 'Sumbawa ', '2006-03-07', 1, '4', 'Parate ', '3', '6', '- ', '5204081001', 'Taufik Hidayat ', 'Maemunah ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0061848034', NULL, 1, 2, 167, 46, 56, 2, 19, 'ardiardan018@gmail.com', '085338433039', '085237710099', '085237710090', NULL, 1, '2021-06-03 09:48:35', '2021-06-03 09:48:35', '2021-06-03 09:48:35'),
('3b75669a-c4e1-11eb-b637-60e327058ff5', 49, '5204093101081918', 'Arif Ilmiansyah ', '5204092406060002', 'L', 'Sumbawa ', '2006-06-24', 1, '1', 'Berare ', '9', '3', 'Berare ', '5204092004', 'Supardi ', 'Mariama ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0069992605', NULL, 1, 13, 155, 40, 53, 8, 19, '', '085333630383', '082342607288', NULL, NULL, 1, '2021-06-04 11:13:29', '2021-06-04 11:13:29', '2021-06-04 11:13:29'),
('3b7817be-c5a4-11eb-b66c-60e327058ff5', 66, '3522243105110002', 'Muhammad Gipsi Subakti ', '5204180705050005', 'L', 'Sumbawa ', '2005-05-07', 1, '4', 'Dusun Buin Pandan ', '2', '4', 'Buin Pandan ', '5204182002', 'M Junaini ', 'Wulandari Pujilestari ', '4884f915-edc5-477a-aace-3830ee33688c', '0058224818', NULL, 1, 13, 169, 59, 56, 2, 25, 'gipsysubakti@gmail.com', '085237484328', NULL, NULL, NULL, 1, '2021-06-05 10:24:44', '2021-06-05 10:24:44', '2021-06-05 10:24:44'),
('3f237925-c4dc-11eb-b637-60e327058ff5', 45, '5204183101081075', 'Kunia Izizulhadi ', '5204182801060001', 'L', 'Sumbawa ', '2006-01-28', 1, '4', 'Dusun Pamulung ', '4', '8', 'Pamulung ', '5204182002', 'Supardi ', 'Hayatun Nupus ', '2b66e8f3-43d3-400e-90ae-58e6c0792c53', '0067894537', '2-21-23-08-004-077-4', 1, 13, 151, 70, 57, 30, 19, 'kurnia280106@gmail.com', '085284027051', '085239514074', '082340976819', '085333758890', 1, '2021-06-04 10:41:23', '2021-06-04 10:41:23', '2021-06-04 10:41:23'),
('421c6a8d-c358-11eb-ac40-0a0027000015', 12, '5204262205110001', 'Ayuby Satria Wibawa', '5204262207060002', 'L', 'Sumbawa', '2006-07-22', 1, '0', '-', '1', '1', 'Tepisilaga', '5204262005', 'Zulkifli', '', 'f314bbb6-7611-45d3-9a16-b85c737d432c', '0065260347', NULL, 1, 2, 170, 47, 53, 12, 20, NULL, '085337455925', NULL, NULL, NULL, 1, '2021-06-02 12:27:16', '2021-06-02 12:27:16', '2021-06-02 12:27:16'),
('455c49e2-c5ae-11eb-b66c-60e327058ff5', 81, '5204091409120002', 'Zikrul Ramdani ', '5204092309060001', 'L', 'Berare ', '2006-09-23', 1, '3', 'Berare B ', '12', '4', 'Berare B ', '5204092004', 'Jamaluddin ', 'Masnah ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0067082452', NULL, 1, 13, 160, 46, 57, 8, 19, 'zikrul23@gmail.com', '08522309033591', '08522309033591', '08522309033591', '08522309033591', 1, '2021-06-05 11:37:00', '2021-06-05 11:37:00', '2021-06-05 11:37:00'),
('4a85c223-c4dc-11eb-b637-60e327058ff5', 44, '5204080102081674', 'M. Fahri Dwi Ramdani ', '5204080111050004', 'L', 'Sumbawa ', '2005-11-01', 1, '4', 'Perate ', '4', '4', 'Perate ', '5204081001', 'Candra Gunawan ', 'Nurhayati ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0059824626', NULL, 2, 13, 152, 64, 57, 2, 19, 'fahrisumbawa12345@gmail.com', '085339343460', NULL, NULL, NULL, 1, '2021-06-04 10:40:11', '2021-06-04 10:40:11', '2021-06-04 10:40:11'),
('4b28b84f-c41b-11eb-bd8f-60e327058ff5', 32, '5204092006120012', 'Sultan Molana Putra ', '5204091504060002', 'L', 'Sumbawa ', '2006-04-15', 1, '4', 'Brang Beru ', '8', '4', 'Brang Beru ', '5204092001', 'Mastar ', 'Sumiati ', 'd33b6222-f02b-425a-b58b-5223eabe93fa', '0061173808', NULL, 1, 2, 155, 45, 56, 13, 19, '', '085337293039', '082340312127', '082342003965', NULL, 1, '2021-06-03 11:37:56', '2021-06-03 11:37:56', '2021-06-03 11:37:56'),
('4ff54788-c59e-11eb-b66c-60e327058ff5', 59, '5204081203120001', 'Candra Tata Pradipta ', '5204080806060004', 'L', 'Sumbawa ', '1970-01-01', 1, '4', 'Gang Transito ', '3', '6', 'Lempeh ', '5204081006', 'Agus Salim ', 'Winarsih ', '918661d6-4831-4139-846d-7465f763f769', '0067471834', NULL, 1, 6, 159, 52, 55, 41, 14, 'candratata546@gmail.com', '082144389568', '085338892228', '085238865148', NULL, 1, '2021-06-05 09:43:18', '2021-06-05 09:43:18', '2021-06-05 09:43:18'),
('51b9b16d-c4d6-11eb-b637-60e327058ff5', 37, '5204102910140001', 'Adi Rizky Pratama ', '5204221504060002', 'L', 'B0ak ', '2006-04-15', 1, '0', 'Dusun Batu Ongo ', '2', '5', 'Batu Ongo ', '5204102011', 'Ahmadi ', 'Tuti Kustianti ', '7b592513-2235-42d9-9f51-856dcc1b38bd', '0069685341', NULL, 1, 13, 148, 40, 57, 21, 20, '', '082359529383', NULL, NULL, NULL, 1, '2021-06-04 09:55:17', '2021-06-04 09:55:17', '2021-06-04 09:55:17'),
('54a60eff-c5b5-11eb-b66c-60e327058ff5', 92, '5204090807120001', 'Jufri Saputra', '5204090102060004', 'L', 'Sumbawa', '2006-02-01', 1, '3', 'Brang Beru', '8', '9', 'Berang Beru', '5204092001', 'Syafarudin', 'Fatima', 'd33b6222-f02b-425a-b58b-5223eabe93fa', '0067546209', '2-20-23-08-005-301-2', 1, 13, 158, 41, 54, 3, 22, 'juprisaputra3106@gmail.com', '085338943958', '085338943958', '085338943958', NULL, 1, '2021-06-05 12:29:14', '2021-06-05 12:29:14', '2021-06-05 12:29:14'),
('559de449-c5b3-11eb-b66c-60e327058ff5', 91, '5204080102081342', 'Aldi Eka Saputra ', '5204081809050001', 'L', 'Sumbawa ', '2005-09-18', 1, '4', 'Perate ', '3', '6', 'Perate ', '5204081001', 'Indra Jaya ', 'Sardiani ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0054434834', NULL, 1, 6, 145, 50, 58, 21, 28, '', '085337461008', NULL, '082341384605', NULL, 1, '2021-06-05 12:28:21', '2021-06-05 12:28:21', '2021-06-05 12:28:21'),
('592df4b6-c416-11eb-bd8f-60e327058ff5', 28, '5204103101082105', 'Erdilen Karnaen ', '5202100304060001', 'L', 'Sumbawa ', '2006-04-03', 1, '3', 'Jl. Lintas Sumbawa Lunyuk ', '2', '8', 'Mokong ', '5204102006', 'Dedi Zulkarnaen ', 'Hermawati ', '587b0e65-945b-4c69-8ddd-f0352676afae', '0061207305', NULL, 1, 2, 161, 46, 53, 21, 19, 'erdilenkarnaen7@gmail.com', '085338913983', '082247796412', NULL, NULL, 1, '2021-06-03 10:58:20', '2021-06-03 10:58:20', '2021-06-03 10:58:20'),
('5b2262c0-c40f-11eb-bd8f-60e327058ff5', 23, '5204093101083654', 'Zulkhayat ', '5204092012050001', 'L', 'Sumbawa ', '2005-12-20', 1, '3', 'Jalan Lintas Sumbawa Bima ', '6', '3', 'Karang Jati ', '5204092009', 'Syamsuddin A ', 'Sahariah ', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0057568045', NULL, 1, 2, 152, 43, 55, 41, 19, 'zulhayatsamawa@gmail.com', '082236840469', '085239226652', NULL, NULL, 1, '2021-06-03 10:09:19', '2021-06-03 10:09:19', '2021-06-03 10:09:19'),
('5c8f74fa-c4d8-11eb-b637-60e327058ff5', 40, '5204082310080007', 'Adit Permansya ', '5204082905060001', 'L', 'Sumbawa ', '2006-05-29', 1, '1', 'Jl. Ki Hajar Dewantara ', '2', '3', 'Bukit Tinggi,pekat ', '5204081003', 'M.safri ', 'Sri Idayu ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0067244849', NULL, 1, 13, 155, 36, 54, 30, 19, '', NULL, '082339056564', '085238926138', NULL, 1, '2021-06-04 10:12:57', '2021-06-04 10:12:57', '2021-06-04 10:12:57'),
('5e09fc0d-c352-11eb-ac40-0a0027000015', 11, '5204080509120001', 'Fitra Dena Marfiansyah', '5204182403060001', 'L', 'Sumbawa', '2006-03-24', 1, '0', 'Jl. Tongkol, Gang Walet', '3', '2', 'Pekat', '5204081003', 'Abdul Nasif', '', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0069381818', NULL, 1, 2, 159, 45, 53, 37, 28, 'fitradenaa@gmail.com', '081703769979', '087851745711', '081917683032', NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('6a1318cd-c404-11eb-bd8f-60e327058ff5', 20, '5204220102080950', 'Rahmat Zurriyat ', '5204223006060001', 'L', 'Sumbawa ', '2006-06-30', 1, '0', 'Pelat ', '1', '8', 'Pelat 2 ', '5204222001', 'Abdul Rosyid ', 'Nurmawati ', '334a017d-6e1b-4997-bd37-6bf2683426d0', '0068118471', NULL, 1, 2, 146, 41, 52, 30, 19, 'rzuriyat@gmail.com', '085253378835', '085253378835', '085253378835', '085253378835', 1, '2021-06-03 09:34:29', '2021-06-03 09:34:29', '2021-06-03 09:34:29'),
('6b90cfcc-c4d9-11eb-b637-60e327058ff5', 41, '5204123101082959', 'Dzulfajri Iman Anugrah ', '5204122711050001', 'L', 'Sumbawa ', '2005-11-27', 1, '4', 'Bukit Tinggi ', '2', '10', 'Bukit Tinggi ', '5204122006', 'Muhammad Imran ', 'Nurdiansyah ', '40aa55e9-a16a-4955-bd03-8839302223fa', '0056936581', NULL, 1, 13, 164, 71, 57, 2, 19, 'fajri123@gmail.com', '085238851589', NULL, NULL, NULL, 1, '2021-06-04 10:16:35', '2021-06-04 10:16:35', '2021-06-04 10:16:35'),
('70b7edd6-c5a9-11eb-b66c-60e327058ff5', 72, '5204080102081137', 'Akbar Hasim Maulana ', '5204080405060002', 'L', 'Sumbawa ', '2006-05-04', 1, '1', 'Jln.pendidikan.gg Belimbing ', '1', '6', 'Samapuin ', '5204081001', 'Haris Susanto ', 'Hasima ', 'dd10cdb6-a7f0-45f2-99c7-fca2798dc9d1', '0065351986', NULL, 1, 13, 150, 34, 54, 8, 21, '', '082340548198', NULL, NULL, NULL, 1, '2021-06-05 11:00:02', '2021-06-05 11:00:02', '2021-06-05 11:00:02'),
('71affab1-c411-11eb-bd8f-60e327058ff5', 26, '5204083101084733', 'Ahmad Dendi Usman ', '5204081012050003', 'L', 'Sumbawa ', '2005-12-10', 1, '3', 'Panto Daeng ', '3', '7', 'Brang Bara ', '5204081002', 'Umar Usman ', 'Fatmawati ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0054001600', NULL, 1, 2, 161, 49, 57, 21, 19, 'adendi193@gmail.com', '083135922866', NULL, '082341939170', NULL, 1, '2021-06-03 10:28:49', '2021-06-03 10:28:49', '2021-06-03 10:28:49'),
('73f57381-c4e1-11eb-b637-60e327058ff5', 50, '5204093101082037', 'Sandycha Ananda Utama ', '5204091804060001', 'L', 'Sumbawa ', '2006-04-18', 1, '4', 'Berare B ', '12', '4', 'Berare B ', '5204092004', 'Mochdahlan ', 'Siti Aisyah ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0064822544', NULL, 1, 13, 148, 38, 51, 41, 19, 'nanda18@gmail.com', '082340109602', '085337383649', '085337383649', '085337383649', 1, '2021-06-04 11:15:34', '2021-06-04 11:15:34', '2021-06-04 11:15:34'),
('78783eb4-c59c-11eb-b66c-60e327058ff5', 55, '5204093101083425', 'Riyan Ramadhan ', '5204090109050002', 'L', 'Sumbawa ', '2005-09-01', 1, '3', 'Sumbawa Bima ', '2', '1', 'Karang Jati ', '5204092009', 'Burhanuddin ', 'Fatimah ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0057548613', NULL, 1, 13, 170, 98, 59, 37, 19, 'r21849348@gmail.com', '082341948361', NULL, NULL, NULL, 1, '2021-06-05 09:28:48', '2021-06-05 09:28:48', '2021-06-05 09:28:48'),
('8e37723a-c5aa-11eb-b66c-60e327058ff5', 74, '5204093101081963', 'Idris Syah', '5204091802060002', 'L', 'Sumbawa', '2006-02-10', 1, '3', 'Berare', '10', '4', 'Berare B', '5204092004', 'Syamsi', 'Safaiyah', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0065425071', NULL, 1, 13, 165, 53, 56, 30, 19, NULL, '085253350162', '085253350162', '085253350162', NULL, 1, '2021-06-05 11:13:22', '2021-06-05 11:13:22', '2021-06-05 11:13:22'),
('8e625236-c5ab-11eb-b66c-60e327058ff5', 76, '5204113101080064', 'M Ivan Navero ', '5204110303060001', 'L', 'Lebangkar ', '2006-03-03', 1, '0', 'Lebangkar ', '2', '1', 'Lebangkar ', '5204112003', 'Akhmadi ', 'Hanita ', '27293be6-42af-41f5-8bff-2504f39221f4', '0065145959', NULL, 3, 13, 162, 69, 57, 2, 20, '', '087863903536', NULL, NULL, NULL, 1, '2021-06-05 11:18:38', '2021-06-05 11:18:38', '2021-06-05 11:18:38'),
('8f1b6341-c5ab-11eb-b66c-60e327058ff5', 78, '5204222710080002', 'Dimas Indra Jayadi ', '5204221106050003', 'L', 'Sumbawa ', '2005-06-11', 1, '3', 'Jalan Lingkar Selatan Km4 ', '3', '3', 'Temere ', '5204222006', 'Ahmad Suriadi ', 'Husnawati ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0054810183', NULL, 1, 1, 169, 49, 56, 8, 19, 'dimasidndrajayadi@gmail.com', '082340088710', '082340088710', '082340088710', '082340088710', 1, '2021-06-05 11:21:02', '2021-06-05 11:21:02', '2021-06-05 11:21:02'),
('921b1369-c412-11eb-bd8f-60e327058ff5', 27, '5204081203090002', 'Akbar Maulana Sabtura ', '5204081502060001', 'L', 'Sumbawa ', '2006-04-15', 1, '4', 'Jl. Osap Sio, Kampung Irian ', '2', '10', 'Umasima ', '5204081008', 'Syaifullah ', 'Sri Yulianti ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0068290561', NULL, 1, 2, 155, 39, 56, 2, 19, 'akbarakb567r@gmail.com', '087754629128', '085338649034', NULL, NULL, 1, '2021-06-03 10:34:22', '2021-06-03 10:34:22', '2021-06-03 10:34:22'),
('94e9eecd-c5a9-11eb-b66c-60e327058ff5', 73, '5204083101083128', 'Krisna Eka Prasetyo Noorsyamsu ', '5204081611040002', 'L', 'Sumbawa ', '2004-11-26', 1, '0', 'Gg.transito ', '2', '6', 'Gg.transito ', '5204081006', 'Hery Noorsyamsu ', 'Nining Haryati Ningsih ', '2b66e8f3-43d3-400e-90ae-58e6c0792c53', '0041889362', NULL, 1, 13, 163, 45, 56, 2, 19, '', '085338282825', NULL, NULL, NULL, 1, '2021-06-05 11:04:03', '2021-06-05 11:04:03', '2021-06-05 11:04:03'),
('9533ab45-c34c-11eb-ac40-0a0027000015', 6, '5204220102080462', 'Raditia Ananda ', '5204221910050001', 'L', 'Brang Pelat ', '2005-10-19', 1, '0', '- ', '1', '6', 'Brang Pelat ', '-', 'M Taufik Jando ', '- ', '334a017d-6e1b-4997-bd37-6bf2683426d0', '0053284244', NULL, 1, 2, 160, 58, 56, 30, 19, 'raditiannd@gmail.com', '082342337544', '085205996776', NULL, NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('98bede13-c4de-11eb-b637-60e327058ff5', 47, '5204081406090020', 'Gio Rama Prastyo ', '5204081310050003', 'L', 'Sumbawa ', '2005-10-13', 1, '1', '- ', '2', '15', 'Brang Biji ', '5204081007', 'Gianto ', 'Rumi Wulandari ', 'dd10cdb6-a7f0-45f2-99c7-fca2798dc9d1', '0053788584', NULL, 1, 13, 160, 46, 54, 2, 19, 'gioprasetyo78@gmail.com', '081236307618', NULL, NULL, NULL, 1, '2021-06-04 10:52:06', '2021-06-04 10:52:06', '2021-06-04 10:52:06'),
('9e1c7422-c5a6-11eb-b66c-60e327058ff5', 70, '5204090904110014', 'Aditiya Setiawan ', '5204090101060002', 'L', 'Sumbawa', '2006-01-01', 1, '0', 'LAbuhan Ijuk', '1', '1', 'Labuhan Ijuk Atas ', '5204092014', 'Supriadi', 'Siti Hadijah', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0066171586', NULL, 1, 13, 152, 40, 52, 30, 19, 'a9487873@gmail.com', '085237315372', '082339632450', '082339632450', NULL, 1, '2021-06-05 10:44:31', '2021-06-05 10:44:31', '2021-06-05 10:44:31'),
('9fb5586d-c350-11eb-ac40-0a0027000015', 9, '5204260102081298', 'Fiqri Sadillah', '5204260211060001', 'L', 'Sumbawa', '2006-11-02', 1, '0', '-', '1', '4', 'Ramolong', '5204262002', 'Abdullah', '', 'f314bbb6-7611-45d3-9a16-b85c737d432c', '0069381686', NULL, 1, 2, 159, 35, 54, 20, 19, NULL, '085238535943', NULL, NULL, NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('9fc74245-c5b5-11eb-b66c-60e327058ff5', 93, '5204093101080240', 'Dimas Pratomo ', '5204092006050001', 'L', 'Sumbawa ', '2005-06-20', 1, '3', 'Moyo Luar ', '4', '1', 'Moyo Luar ', '5204092001', 'Nanang Sugiartono ', 'Hayatun ', 'd33b6222-f02b-425a-b58b-5223eabe93fa', '0059487364', NULL, 1, 2, 151, 43, 57, 13, 19, '', '087810287333', NULL, '085338764586', NULL, 1, '2021-06-05 12:35:33', '2021-06-05 12:35:33', '2021-06-05 12:35:33'),
('a0a655ea-c5b2-11eb-b66c-60e327058ff5', 86, '5204101009080010', 'Sahrul Gunawan ', '5204100606930002', 'L', 'Sumbawa ', '2005-05-08', 1, '1', 'Sumbawa Lunyuk ', '1', '1', 'Sebasang A ', '5204102003', 'Suparaman ', 'Ramina ', '40afa201-9482-4acc-bad4-a43806436a71', '0044105439', NULL, 1, 13, 156, 60, 0, 8, 19, '', '0852239148099', NULL, NULL, NULL, 1, '2021-06-05 12:08:35', '2021-06-05 12:08:35', '2021-06-05 12:08:35'),
('a387fccc-c410-11eb-bd8f-60e327058ff5', 24, '5204093101083525', 'Ferdi Saputra ', '5204090702060002', 'L', 'Sumbawa ', '2006-02-07', 1, '0', 'Ai Puntuk ', '2', '7', 'Ai Puntuk ', '5204092009', 'M Nur ', 'Hadijah ', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0069735012', NULL, 1, 2, 165, 78, 55, 2, 22, 'saputraferdy267@gmail.com', '083192467664', '085205338269', '085205338269', NULL, 1, '2021-06-03 10:19:13', '2021-06-03 10:19:13', '2021-06-03 10:19:13'),
('a41cb0e2-c5b8-11eb-b66c-60e327058ff5', 95, '5204123101083103', 'Rajuna Satriaman ', '5204120106050002', 'L', 'Sumbawa ', '2005-06-01', 1, '4', 'Dete Atas ', '1', '1', 'Dete Atas ', '5204122006', 'M.husain ', 'Siti Ara ', '40aa55e9-a16a-4955-bd03-8839302223fa', '0053519674', NULL, 3, 13, 160, 46, 55, 2, 19, 'rajunasatriaman0902@gmail.com', '082341917235', '082341937082', NULL, NULL, 1, '2021-06-05 12:52:35', '2021-06-05 12:52:35', '2021-06-05 12:52:35'),
('a5d4f42e-c5b2-11eb-b66c-60e327058ff5', 87, '5204230102080913', 'Pradifta Tasri inaya', '5204321004050002', 'L', 'Sumbawa', '2005-04-10', 1, '0', 'Sebewe', '2', '2', 'Sebewe', '5204232002', 'Sambirang', 'Mastari', '0e137c2c-0d32-4c89-abbe-8e193a29b260', '0056508005', NULL, 1, 13, 160, 56, 56, 30, 19, NULL, '085237842710', '085237842710', '085237842710', NULL, 1, '2021-06-05 12:11:35', '2021-06-05 12:11:35', '2021-06-05 12:11:35'),
('a9c0e940-c4da-11eb-b637-60e327058ff5', 42, '5204183101010825', 'Muhammad Febriansyah ', '5204181502060001', 'L', 'Sumbawa ', '2006-02-15', 1, '0', 'Jl. Kauman 01 ', '1', '3', 'Olat Rarang ', '5204182001', 'Rahuddin ', 'Nasirah ', '2b66e8f3-43d3-400e-90ae-58e6c0792c53', '0065836900', NULL, 1, 13, 165, 59, 58, 2, 6, '', '082235270695', NULL, NULL, NULL, 1, '2021-06-04 10:23:54', '2021-06-04 10:23:54', '2021-06-04 10:23:54'),
('ac2c263f-c5b0-11eb-b66c-60e327058ff5', 84, '5204220102084126', 'Rizal Ansari Amandanu ', '5204222205060001', 'L', 'Sumbawa ', '2006-05-02', 1, '4', 'Pungka ', '9', '3', 'Tamere ', '5204222006', 'Husman ', 'Nurbaya ', 'e203d7ba-3bfe-4f08-aa64-8913c24e95bf', '0069687806', NULL, 1, 13, 152, 38, 55, 8, 19, '', '085338711683', NULL, NULL, NULL, 1, '2021-06-05 11:51:34', '2021-06-05 11:51:34', '2021-06-05 11:51:34'),
('aecf1805-c347-11eb-ac40-0a0027000015', 1, '5204082607100006', 'Abdilah Rian Danu', '5204082807060003', 'L', 'Sumbawa', '2006-07-28', 1, '0', '-', '2', '3', 'Lingkungan Sumer Batu', '5204081001', 'Syamsul Ahyar', '', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0067792030', NULL, 1, 2, 160, 50, 55, 26, 19, NULL, '085337625533', NULL, NULL, NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('b1cd9589-c5ae-11eb-b66c-60e327058ff5', 82, '5204183101083101', 'Nanang Hidayat', '5204182901060001', 'L', 'Sumbawa', '2006-01-29', 1, '4', 'Kampung Pasir', '3', '11', 'Pasir', '5204182001', 'Rusmin Poli', 'Masuji Ratu', '2b66e8f3-43d3-400e-90ae-58e6c0792c53', '0067866921', NULL, 1, 13, 156, 38, 56, 30, 26, 'nananghidayat@gmail.com', '085337478974', '085237623682', '082340900839', NULL, 1, '2021-06-05 11:41:17', '2021-06-05 11:41:17', '2021-06-05 11:41:17'),
('b60af114-c59c-11eb-b66c-60e327058ff5', 56, '5204091106100001', 'Muhammad Taufik Fazri ', '5204090806050002', 'L', 'Sumbawa ', '2005-06-08', 1, '4', 'Karang Jati ', '1', '1', 'Karang Jati ', '5204092009', 'Riman ', 'Badaria ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0055515968', NULL, 1, 2, 169, 70, 57, 21, 21, 'mousemik87@gmail.com', '083192917943', '081382971553', '081285079898', NULL, 1, '2021-06-05 09:34:00', '2021-06-05 09:34:00', '2021-06-05 09:34:00'),
('b6f8e6a0-c4e4-11eb-b637-60e327058ff5', 52, '5204080207009001', 'Andri Maulana Susanto ', '5204081004060001', 'L', 'Sumbawa ', '2006-04-10', 1, '4', 'Gang Tambora 1 ', '1', '10', 'Brang Biji ', '5204081007', 'Iwan Susanto ', 'Sri Hartini ', '918661d6-4831-4139-846d-7465f763f769', '0064105899', NULL, 1, 13, 158, 59, 54, 8, 19, '', '083813643959', '082340919097', NULL, NULL, 1, '2021-06-04 11:33:29', '2021-06-04 11:33:29', '2021-06-04 11:33:29'),
('b78f5bd0-c4dd-11eb-b637-60e327058ff5', 46, '5204080102081643', 'Rangga Anugrah Ab ', '5204081506050001', 'L', 'Sumbawa ', '2005-06-15', 1, '4', 'Perate ', '4', '4', 'Perate ', '-', 'Abu Bakar Ms ', 'Nurwita ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0056590284', NULL, 1, 13, 161, 54, 57, 2, 19, 'ranggaanugrah014@gmail.com', '085337400690', '085239029720', '081916982089', NULL, 1, '2021-06-04 10:42:56', '2021-06-04 10:42:56', '2021-06-04 10:42:56'),
('b87c76f2-c5a2-11eb-b66c-60e327058ff5', 65, '5204091907120007', 'Farhad Saidullah ', '5204091101060001', 'L', 'Sumbawa ', '2006-01-11', 1, '0', 'Ai Puntuk ', '5', '8', 'Ai Puntuk ', '5204092009', 'Saparudin M ', 'Farida ', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0069280143', NULL, 1, 2, 155, 42, 54, 13, 19, '', '082247144787', NULL, NULL, NULL, 1, '2021-06-05 10:12:53', '2021-06-05 10:12:53', '2021-06-05 10:12:53'),
('b884e9e7-c4df-11eb-b637-60e327058ff5', 48, '5204093101084800', 'Jodi Kurniawan', '5204090707060001', 'L', 'Moyo', '2000-04-27', 1, '0', '-', '6', '3', 'Moyo Atas', '5204092013', 'Hermansyah', 'Erni Sifatullah', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0058303261', NULL, 1, 2, 150, 38, 56, 8, 6, NULL, NULL, NULL, NULL, NULL, 1, '2021-06-04 10:55:40', '2021-06-04 10:55:40', '2021-06-04 10:55:40'),
('bad27429-c407-11eb-bd8f-60e327058ff5', 18, '5204270102080933', 'Galang Ramadhan ', '5204271210050001', 'L', 'Sumbawa ', '2005-10-12', 1, '4', '- ', '6', '3', 'Lenangguar Atas ', '5204272002', 'Hm Syaifuddin ', 'Supiati ', 'ab0a32de-ef5b-4beb-aee3-cc97d2ac8733', '0052140508', NULL, 1, 2, 155, 46, 54, 21, 19, 'gr6873727@gmail.com', '082341895448', '085333072728', '082359239173', NULL, 1, '2021-06-03 09:25:04', '2021-06-03 09:25:04', '2021-06-03 09:25:04'),
('bc3ad066-c5a6-11eb-b66c-60e327058ff5', 68, '5204092509080020', 'Aldi Yudiansyah ', '5204091601060003', 'L', 'Moyo ', '2006-01-16', 1, '0', 'Dusun Moyo Luar ', '1', '1', 'Moyo Luar ', '5204092001', 'Sahabuddin ', 'Kusmiati ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0069650667', NULL, 1, 13, 160, 38, 57, 33, 19, '', '085237017471', NULL, NULL, NULL, 1, '2021-06-05 10:43:05', '2021-06-05 10:43:05', '2021-06-05 10:43:05'),
('bc5c4c81-c5aa-11eb-b66c-60e327058ff5', 77, '5204083005170003', 'Rasul Afdian Firdaus ', '5204092202060001', 'L', 'Sumbawa ', '2006-02-22', 1, '0', 'Jl.hasanuddin ', '2', '4', 'Bugis ', '5204081005', 'Agus Sumantri ', 'Endang Supiati ', '918661d6-4831-4139-846d-7465f763f769', '0061212363', NULL, 1, 13, 159, 50, 57, 4, 19, 'rasulafdian@gmail.com', '085333469216', '085337129335', '085238215559', '085333469216', 1, '2021-06-05 11:18:44', '2021-06-05 11:18:44', '2021-06-05 11:18:44'),
('be0ca01e-c348-11eb-ac40-0a0027000015', 3, '5204093101082349', 'Muhammad Firdian Ramdani', '5204092710050001', 'L', 'Sumbawa', '2005-10-02', 1, '0', '-', '3', '3', 'Bekat', '5204092005', 'Firmansyah', '', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0053662414', NULL, 1, 2, 150, 50, 54, 8, 20, 'perdiansumbawa@gmail.com', '085237328189', '085333789209', '085333789209', '081918054959', 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('c0c5fd99-c4e3-11eb-b637-60e327058ff5', 51, '5204090610080004', 'Ibnu Hudzaifah ', '5204091408050001', 'L', 'Moyo ', '2005-08-14', 1, '0', 'Dusun Karang Orong ', '5', '2', 'Karang Orong ', '5204092001', 'Ramlan ', 'Sabariah ', 'bd3416c4-a4aa-4712-80ef-f126eabe191a', '0052977646', NULL, 1, 13, 159, 57, 56, 2, 19, '', '087879220879', NULL, NULL, NULL, 1, '2021-06-04 11:30:10', '2021-06-04 11:30:10', '2021-06-04 11:30:10'),
('c12ec191-c406-11eb-bd8f-60e327058ff5', 17, '5204103101083883', 'Ripal Jipano ', '5204102405070002', 'L', 'Lito ', '2007-05-24', 1, '0', '- ', '1', '4', 'Lito B ', '5204102009', 'M. Yusup ', 'Siti Wali ', '76f8eafe-b5ca-4718-a276-5d5f674afbfa', '0063692985', NULL, 1, 2, 155, 38, 54, 41, 19, 'jupanoripano@gmail.com', '082340674613', NULL, NULL, NULL, 1, '2021-06-03 09:06:55', '2021-06-03 09:06:55', '2021-06-03 09:06:55'),
('c540ff9f-c34d-11eb-ac40-0a0027000015', 5, '5204220102080732', 'Muhammad Thofanny', '5204220308060001', 'L', 'Sumbawa', '2006-08-03', 1, '0', '-', '1', '6', 'Pelat 2', '5204222001', 'Darsono', '', '6253eb54-2345-4f22-9201-0ff936075f78', '0065015866', NULL, 1, 2, 152, 41, 54, 32, 20, NULL, '085239048880', NULL, '085333842749', NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('c7e90f11-c5ad-11eb-b66c-60e327058ff5', 79, '5204092410080028', 'Aldi Supratman ', '5204090804060001', 'L', 'Sumbawa ', '2006-04-08', 1, '0', 'Ai Puntuk ', '6', '2', 'Ai Puntuk ', '5204092009', 'Kamaluddin ', 'Sustrawati ', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0067617176', NULL, 1, 13, 157, 41, 57, 21, 19, 'aldisupratman11@gmail.com', '087863960774', NULL, NULL, NULL, 1, '2021-06-05 11:31:03', '2021-06-05 11:31:03', '2021-06-05 11:31:03'),
('d12e7cd6-c35a-11eb-ac40-0a0027000015', 13, '5204240102081292', 'Adrian Maulana ', '5204241208050001', 'L', 'Sumbawa ', '2005-08-12', 1, '1', '- ', '5', '2', 'Unter Telang ', '5204242002', 'Muhammad Rifai ', '- ', '3c7adfcb-529e-42a5-b896-62a63b333446', '0055093533', NULL, 1, 2, 155, 48, 58, 3, 22, 'adrian@gmail.com', '082340479602', NULL, NULL, NULL, 1, '2021-06-02 12:34:21', '2021-06-02 12:34:21', '2021-06-02 12:34:21'),
('d1fc1da8-c41c-11eb-bd8f-60e327058ff5', 33, '5204101009080040', 'Feri Ardiasyah ', '5204102601050001', 'L', 'Praya ', '2005-01-26', 1, '4', 'Brang Rea ', '7', '8', 'Berang Belo ', '5204102012', 'Hermanto ', 'Nurul Aini ', '3749951c-4997-4409-8652-ff04fa0feaf9', '0052421411', NULL, 1, 2, 162, 72, 56, 30, 19, 'veryardian26@gmail.com', '085253372157', '082340092210', '082340092210', NULL, 1, '2021-06-03 11:46:24', '2021-06-03 11:46:24', '2021-06-03 11:46:24'),
('d22eddc6-c403-11eb-bd8f-60e327058ff5', 14, '5204083101089012', 'Mahmud Abbas ', '5204080911050004', 'L', 'Sumbawa ', '2005-11-09', 1, '1', 'Kebayan ', '3', '11', 'Kebayan ', '5204081007', 'Ismail Mude ', 'Murtini ', '918661d6-4831-4139-846d-7465f763f769', '0052853843', NULL, 1, 2, 155, 49, 55, 8, 20, 'abbasiyah294@gmail.com', '082247146066', '085205007089', '085205007084', NULL, 1, '2021-06-03 09:03:37', '2021-06-03 09:03:37', '2021-06-03 09:03:37'),
('d28a7144-c5b4-11eb-b66c-60e327058ff5', 90, '5204080102081582', 'Rakhan Okta Aryadi', '5204083010040001', 'L', 'Sumbawa', '2004-10-30', 1, '2', 'Perate , samapuin, sumbawa besar ', '3', '4', 'Perate', '5204081001', 'Iryadi', 'Endang Sulastri', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0045299609', NULL, 1, 2, 151, 32, 51, 12, 17, NULL, '087865661924', '082341384605', NULL, NULL, 1, '2021-06-05 12:26:48', '2021-06-05 12:26:48', '2021-06-05 12:26:48'),
('d90a5322-c347-11eb-ac40-0a0027000015', 4, '5204222311110008', 'Awalludin Jamil ', '5204222306060001', 'L', 'Pelat ', '2006-06-23', 1, '0', '- ', '1', '5', 'Pelat 2 ', '5204222001', 'Afdul Gafur ', '- ', '334a017d-6e1b-4997-bd37-6bf2683426d0', '0062935746', NULL, 1, 2, 148, 41, 52, 2, 19, 'djokja234@gmail.com', '085337158941', '082341385805', NULL, NULL, 1, '2021-06-02 12:45:03', '2021-06-02 12:45:03', '2021-06-02 12:45:03'),
('db5bb1ae-c422-11eb-bd8f-60e327058ff5', 34, '5204082605090004', 'Muhammad Sultan Ismul Azham ', '6204081404060003', 'L', 'Sumbawa ', '2006-04-14', 1, '2', 'Jalan Undru, Gang Merpati No. 8 ', '2', '1', ' ', '5204081002', 'Edi Bambang Susanto ', 'Susantriana ', '2a53fa03-b03e-4e3b-9a5e-d8cdfbf7c81b', '0061441914', NULL, 1, 2, 159, 43, 53, 8, 22, 'muhammadsultanismulazam@gmail.com', '081914738234', '087863764531', '081337371711', NULL, 1, '2021-06-03 12:28:14', '2021-06-03 12:28:14', '2021-06-03 12:28:14'),
('dba9b071-c5a7-11eb-b66c-60e327058ff5', 71, '5204083101085971', 'Elang Alifi Kiswono ', '5204081105060002', 'L', 'Sumbawa ', '2006-05-11', 1, '3', 'Hijrah No.14 ', '5', '6', 'Kampung Mande ', '5204081005', 'Yoni Kiswono ', 'Nurhasanah ', 'e50c7d3d-c5a8-11eb-b66c-60e327058ff5', '0064704814', NULL, 1, 2, 154, 56, 57, 21, 12, 'eyakkiswono@gmail.com', '085239086494', '085253764230', '085238209308', NULL, 1, '2021-06-05 10:56:40', '2021-06-05 10:56:40', '2021-06-05 10:56:40'),
('dc56ccc2-c5ad-11eb-b66c-60e327058ff5', 80, '5204121608110001', 'Casanova Roeslniry ', '5204122609050001', 'L', 'Batam ', '2005-09-26', 1, '0', 'Dusun Lape Bawa ', '3', '4', 'Lape Bawa ', '5204122003', 'Ruslan ', 'Nining Sundari Sitorus ', '40aa55e9-a16a-4955-bd03-8839302223fa', '0052462328', NULL, 1, 13, 148, 35, 53, 13, 19, '', '082341225575', NULL, NULL, NULL, 1, '2021-06-05 11:32:09', '2021-06-05 11:32:09', '2021-06-05 11:32:09'),
('dce9d6c4-c419-11eb-bd8f-60e327058ff5', 31, '5204231311100001', 'Ridho Sapnul Patanah ', '5204230311050001', 'L', 'Sumbawa ', '2005-11-03', 1, '3', 'Jalan Labu Sawo ', '4', '2', 'Penyaring A ', '5204232003', 'Syafruddin ', 'Nurbaiti ', '0e137c2c-0d32-4c89-abbe-8e193a29b260', '0059377550', NULL, 1, 2, 161, 44, 0, 30, 19, 'ridhosafnul@gmail.com', '082339608019', '081909046677', '082339627537', NULL, 1, '2021-06-03 11:30:22', '2021-06-03 11:30:22', '2021-06-03 11:30:22'),
('e1d9c691-c597-11eb-b66c-60e327058ff5', 54, '5204230102080437', 'Sri Ramadhani ', '5204232610060001', 'L', 'Sumbawa ', '2006-10-26', 1, '3', 'Pungkit ', '3', '2', 'Pungkit ', '5204232001', 'Abdul Hamid ', 'Sapiatun ', '0e137c2c-0d32-4c89-abbe-8e193a29b260', '0063739985', NULL, 1, 13, 164, 53, 57, 2, 19, 'sriramdani645@gmail.com', '082341193495', NULL, NULL, NULL, 1, '2021-06-05 08:58:29', '2021-06-05 08:58:29', '2021-06-05 08:58:29'),
('e216d642-c5b1-11eb-b66c-60e327058ff5', 85, '5204093101081761', 'Apriadi ', '5204090404060002', 'L', 'Sumbawa ', '2006-04-04', 1, '4', 'Berare A ', '5', '2', 'Berare A ', '5204092004', 'Jamaluddin ', 'Nuraini ', '09e4cc0c-cbd1-4da8-86dc-5f5e59ae9efd', '0066821643', NULL, 1, 2, 164, 50, 57, 21, 19, 'adec0904@gmail.com', '085237341177', '082340020013', NULL, NULL, 1, '2021-06-05 12:06:36', '2021-06-05 12:06:36', '2021-06-05 12:06:36'),
('e670e271-c5a5-11eb-b66c-60e327058ff5', 67, '5204103101084206', 'Muhammad Egiet Ilhami ', '5204100302060001', 'L', 'Sumbawa ', '2006-02-03', 1, '4', 'Sebasang Unter ', '2', '1', 'Sebasang Unter ', '5204102010', 'Sufrianto ', 'Mastari ', '40afa201-9482-4acc-bad4-a43806436a71', '0062947738', NULL, 1, 2, 152, 43, 55, 12, 24, 'fenihboss@gmail.com', '085237111520', '081916906001', NULL, NULL, 1, '2021-06-05 10:35:57', '2021-06-05 10:35:57', '2021-06-05 10:35:57'),
('e676965a-c4d7-11eb-b637-60e327058ff5', 38, '5204080706110009', 'Rizky Yoga Saputra ', '5204080606060001', 'L', 'Sumbawa ', '2006-06-06', 1, '4', 'Kihajar Dewantara ', '1', '3', '- ', '5204081003', 'Muslim ', 'Nuraini ', '7fbd941e-a5f5-40a7-be96-a333e7e62ddd', '0063204010', NULL, 1, 13, 139, 35, 53, 8, 19, '', '082340130551', NULL, NULL, NULL, 1, '2021-06-04 10:04:42', '2021-06-04 10:04:42', '2021-06-04 10:04:42'),
('eb5d8f64-c5a0-11eb-b66c-60e327058ff5', 63, '5204103101084906', 'Fajri Firmansyah ', '5204102407060002', 'L', 'Sumbawa ', '2006-07-24', 1, '3', 'Sumbawa Lunyuk ', '4', '2', 'Berang Rea ', '-', 'Suhardi ', 'Srianingsih ', '3749951c-4997-4409-8652-ff04fa0feaf9', '0069588926', NULL, 1, 13, 161, 54, 52, 8, 20, 'fajrifirmansyah107@gmail.com', '085237865856', NULL, NULL, NULL, 1, '2021-06-05 09:59:47', '2021-06-05 09:59:47', '2021-06-05 09:59:47'),
('ec30a429-c5a0-11eb-b66c-60e327058ff5', 64, '5204083101082014', 'Muhammad Zaky Daifullah', '5204081506060001', 'L', 'Sumbawa', '2006-05-15', 1, '3', 'Jln. Batu Pasak Gg.Kutilang1 No 30', '2', '1', 'pekat', '5204081003', 'Muhammad Kaharudin', 'Maulidia Savitri', '918661d6-4831-4139-846d-7465f763f769', '0062933093', NULL, 1, 13, 147, 43, 54, 41, 19, 'zaky1505206@gmail.com', '082340610695', '082340610695', '082340610695', NULL, 1, '2021-06-05 10:02:05', '2021-06-05 10:02:05', '2021-06-05 10:02:05'),
('eee8ea0b-c40e-11eb-bd8f-60e327058ff5', 22, '5204222205190001', 'Adri Apriansyah ', '5204142604050001', 'L', 'Sumbawa ', '2005-04-26', 1, '1', 'Jalan Sumbawa Lunyuk ', '3', '1', 'Boak ', '5204222003', 'Mahmud Ar ', 'Sulminawadi ', 'ab0a32de-ef5b-4beb-aee3-cc97d2ac8733', '0054616890', NULL, 1, 2, 164, 53, 58, 8, 6, 'apriansyahadri@gmail.com', '085338907607', NULL, '085337736903', '085337479097', 1, '2021-06-03 10:06:16', '2021-06-03 10:06:16', '2021-06-03 10:06:16'),
('f192e61e-c4da-11eb-b637-60e327058ff5', 43, '5204183101082749', 'Rivaldi Airlangga ', '5204180809050001', 'L', 'Sumbawa ', '2005-09-08', 1, '0', 'Dusun Olat Rarang ', '4', '7', 'Olat Rarang ', '5204182003', 'Supeno ', 'Zubaidah ', '2b66e8f3-43d3-400e-90ae-58e6c0792c53', '0054871721', NULL, 1, 13, 159, 46, 57, 2, 19, '', '083129438716', NULL, NULL, NULL, 1, '2021-06-04 10:28:25', '2021-06-04 10:28:25', '2021-06-04 10:28:25'),
('f24eddbc-c59f-11eb-b66c-60e327058ff5', 62, '5204183101081208', 'Deo Ade Saputra ', '5204181312060001', 'L', 'Sumbawa ', '2006-12-13', 1, '3', 'Pamulung ', '2', '9', 'Pamulung ', '5204222008', 'Syarafuddin ', 'Mariam ', '4884f915-edc5-477a-aace-3830ee33688c', '0063607782', NULL, 1, 2, 150, 42, 54, 21, 19, '', '085237582770', NULL, NULL, NULL, 1, '2021-06-05 09:55:46', '2021-06-05 09:55:46', '2021-06-05 09:55:46'),
('f51a7bce-c4d7-11eb-b637-60e327058ff5', 39, '5204082105100007', 'Muhamad Gamar Khadavi ', '5204081008050002', 'L', 'Sumbawa ', '2005-08-10', 1, '0', 'Kebayan ', '3', '13', 'Kebayan ', '5204081007', 'Gatot Subroto ', 'Sumarni ', 'dd10cdb6-a7f0-45f2-99c7-fca2798dc9d1', '0054315950', NULL, 1, 13, 151, 41, 54, 13, 19, '', '082247145442', '081238960249', '081238960249', '081238960249', 1, '2021-06-04 10:10:31', '2021-06-04 10:10:31', '2021-06-04 10:10:31'),
('faaadaff-c59f-11eb-b66c-60e327058ff5', 61, '5204220102082935', 'Annisa Salsabila ', '5204224301060001', 'P', 'Sumbawa ', '2006-01-03', 1, '0', 'Dusun Sering Ai Beta ', '1', '8', 'Sering Ai Beta ', '5204222005', 'Marpoan ', 'Suwarni ', 'dd10cdb6-a7f0-45f2-99c7-fca2798dc9d1', '0062790141', NULL, 1, 13, 155, 37, 52, 4, 15, '', '082339122077', NULL, NULL, NULL, 1, '2021-06-05 09:53:10', '2021-06-05 09:53:10', '2021-06-05 09:53:10'),
('fdc9d179-c405-11eb-bd8f-60e327058ff5', 15, '5204103101083908', 'Tomy Andika Saputra ', '5204101204060001', 'L', 'Sumbawa ', '2006-12-04', 1, '0', 'Dusun Lito B ', '3', '3', 'Lito B ', '5204102009', 'Syamsuddin ', 'Mastari ', '76f8eafe-b5ca-4718-a276-5d5f674afbfa', '0061829267', NULL, 1, 2, 147, 42, 55, 4, 19, '', '085239118949', '085239118949', NULL, NULL, 1, '2021-06-03 09:05:44', '2021-06-03 09:05:44', '2021-06-03 09:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `pdb_berkas`
--

CREATE TABLE `pdb_berkas` (
  `id_pdb_berkas` char(36) NOT NULL,
  `id_pdb` char(36) NOT NULL,
  `id_berkas` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pdb_pilihan`
--

CREATE TABLE `pdb_pilihan` (
  `id_pdb_pilihan` char(36) NOT NULL,
  `id_pdb` char(36) NOT NULL,
  `id_kk` int(11) NOT NULL,
  `pilihan` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pdb_pilihan`
--

INSERT INTO `pdb_pilihan` (`id_pdb_pilihan`, `id_pdb`, `id_kk`, `pilihan`) VALUES
('00951256-c5b7-11eb-b66c-60e327058ff5', '559de449-c5b3-11eb-b66c-60e327058ff5', 12, 2),
('0273636c-c5ba-11eb-b66c-60e327058ff5', 'a41cb0e2-c5b8-11eb-b66c-60e327058ff5', 7, 1),
('027e5ab9-c5ad-11eb-b66c-60e327058ff5', 'bc5c4c81-c5aa-11eb-b66c-60e327058ff5', 6, 1),
('02cd7c0b-c350-11eb-ac40-0a0027000015', '9533ab45-c34c-11eb-ac40-0a0027000015', 6, 1),
('02f9c31a-c5a9-11eb-b66c-60e327058ff5', '15614b88-c5a7-11eb-b66c-60e327058ff5', 5, 2),
('040e2420-c4d1-11eb-b637-60e327058ff5', '1759f889-c4cf-11eb-b637-60e327058ff5', 4, 2),
('05195b69-c5a0-11eb-b66c-60e327058ff5', '202a565e-c594-11eb-b66c-60e327058ff5', 6, 1),
('065141bb-c436-11eb-bd8f-60e327058ff5', '921b1369-c412-11eb-bd8f-60e327058ff5', 11, 2),
('06ee099e-c41c-11eb-bd8f-60e327058ff5', 'dce9d6c4-c419-11eb-bd8f-60e327058ff5', 6, 1),
('08a23742-c5a0-11eb-b66c-60e327058ff5', '202a565e-c594-11eb-b66c-60e327058ff5', 9, 2),
('09ad0027-c437-11eb-bd8f-60e327058ff5', '9fb5586d-c350-11eb-ac40-0a0027000015', 7, 2),
('0a627b7d-c41a-11eb-bd8f-60e327058ff5', '25859c37-c419-11eb-bd8f-60e327058ff5', 6, 1),
('0d3df4de-c4dd-11eb-b637-60e327058ff5', 'f51a7bce-c4d7-11eb-b637-60e327058ff5', 6, 1),
('0eceaf1b-c5b0-11eb-b66c-60e327058ff5', 'b1cd9589-c5ae-11eb-b66c-60e327058ff5', 7, 1),
('0f031661-c350-11eb-ac40-0a0027000015', '9533ab45-c34c-11eb-ac40-0a0027000015', 8, 2),
('1260f9be-c4e3-11eb-b637-60e327058ff5', '3b75669a-c4e1-11eb-b637-60e327058ff5', 6, 1),
('13498045-c35b-11eb-ac40-0a0027000015', '421c6a8d-c358-11eb-ac40-0a0027000015', 2, 2),
('13c4516f-c34b-11eb-ac40-0a0027000015', 'd90a5322-c347-11eb-ac40-0a0027000015', 6, 1),
('15b0c667-c41d-11eb-bd8f-60e327058ff5', '4b28b84f-c41b-11eb-bd8f-60e327058ff5', 6, 1),
('1643d2fe-c5b0-11eb-b66c-60e327058ff5', 'b1cd9589-c5ae-11eb-b66c-60e327058ff5', 5, 2),
('167b06a5-c412-11eb-bd8f-60e327058ff5', 'a387fccc-c410-11eb-bd8f-60e327058ff5', 6, 1),
('16b1a56a-c5a2-11eb-b66c-60e327058ff5', 'eb5d8f64-c5a0-11eb-b66c-60e327058ff5', 6, 1),
('16bc17b5-c4e3-11eb-b637-60e327058ff5', '3b75669a-c4e1-11eb-b637-60e327058ff5', 7, 2),
('194b3332-c5ba-11eb-b66c-60e327058ff5', 'a41cb0e2-c5b8-11eb-b66c-60e327058ff5', 4, 2),
('1ab702a3-c34b-11eb-ac40-0a0027000015', 'd90a5322-c347-11eb-ac40-0a0027000015', 4, 2),
('1b7d123d-c5a8-11eb-b66c-60e327058ff5', 'bc3ad066-c5a6-11eb-b66c-60e327058ff5', 5, 1),
('1ba903d9-c5ad-11eb-b66c-60e327058ff5', 'bc5c4c81-c5aa-11eb-b66c-60e327058ff5', 5, 2),
('1c15d17b-c424-11eb-bd8f-60e327058ff5', 'db5bb1ae-c422-11eb-bd8f-60e327058ff5', 6, 1),
('1cee42c6-c5a2-11eb-b66c-60e327058ff5', 'eb5d8f64-c5a0-11eb-b66c-60e327058ff5', 4, 2),
('1f70e555-c351-11eb-ac40-0a0027000015', '02581a0f-c34d-11eb-ac40-0a0027000015', 6, 1),
('1fc98725-c437-11eb-bd8f-60e327058ff5', '5e09fc0d-c352-11eb-ac40-0a0027000015', 7, 2),
('2399d027-c436-11eb-bd8f-60e327058ff5', '592df4b6-c416-11eb-bd8f-60e327058ff5', 4, 2),
('255ff3f8-c4d6-11eb-b637-60e327058ff5', '3559e765-c4d5-11eb-b637-60e327058ff5', 6, 1),
('2bda6b13-c4d6-11eb-b637-60e327058ff5', '3559e765-c4d5-11eb-b637-60e327058ff5', 5, 2),
('2c26cf57-c4df-11eb-b637-60e327058ff5', 'b78f5bd0-c4dd-11eb-b637-60e327058ff5', 6, 1),
('2c57b2e6-c5a8-11eb-b66c-60e327058ff5', 'bc3ad066-c5a6-11eb-b66c-60e327058ff5', 9, 2),
('2c57db82-c5a9-11eb-b66c-60e327058ff5', '9e1c7422-c5a6-11eb-b66c-60e327058ff5', 6, 1),
('2d4e9b55-c5a0-11eb-b66c-60e327058ff5', '4ff54788-c59e-11eb-b66c-60e327058ff5', 2, 1),
('2fbaaf45-c4df-11eb-b637-60e327058ff5', 'b78f5bd0-c4dd-11eb-b637-60e327058ff5', 12, 2),
('2ff0c6e2-c40b-11eb-bd8f-60e327058ff5', '23ab6f16-c40a-11eb-bd8f-60e327058ff5', 6, 1),
('3111c965-c5a9-11eb-b66c-60e327058ff5', '9e1c7422-c5a6-11eb-b66c-60e327058ff5', 9, 2),
('32b85be5-c437-11eb-bd8f-60e327058ff5', 'd12e7cd6-c35a-11eb-ac40-0a0027000015', 3, 2),
('34335f8f-c414-11eb-bd8f-60e327058ff5', '921b1369-c412-11eb-bd8f-60e327058ff5', 6, 1),
('349fd881-c5a0-11eb-b66c-60e327058ff5', '4ff54788-c59e-11eb-b66c-60e327058ff5', 1, 2),
('3593c727-c413-11eb-bd8f-60e327058ff5', '06b197b0-c412-11eb-bd8f-60e327058ff5', 6, 1),
('35967a90-c5ac-11eb-b66c-60e327058ff5', '8e37723a-c5aa-11eb-b66c-60e327058ff5', 6, 1),
('394007d4-c5ac-11eb-b66c-60e327058ff5', '8e37723a-c5aa-11eb-b66c-60e327058ff5', 5, 2),
('3a6fe0bf-c4ca-11eb-b637-60e327058ff5', 'db5bb1ae-c422-11eb-bd8f-60e327058ff5', 4, 2),
('3b94d28e-c354-11eb-ac40-0a0027000015', '5e09fc0d-c352-11eb-ac40-0a0027000015', 6, 1),
('3be5582b-c436-11eb-bd8f-60e327058ff5', '306f60c0-c418-11eb-bd8f-60e327058ff5', 7, 2),
('40c0d498-c5ad-11eb-b66c-60e327058ff5', '8f1b6341-c5ab-11eb-b66c-60e327058ff5', 5, 1),
('40fa02d4-c437-11eb-bd8f-60e327058ff5', 'd22eddc6-c403-11eb-bd8f-60e327058ff5', 3, 2),
('41163ce0-c438-11eb-bd8f-60e327058ff5', '06b197b0-c412-11eb-bd8f-60e327058ff5', 12, 2),
('43e2da5a-c4d9-11eb-b637-60e327058ff5', '51b9b16d-c4d6-11eb-b637-60e327058ff5', 6, 1),
('43e8f298-c5b8-11eb-b66c-60e327058ff5', '2dd847ce-c5b7-11eb-b66c-60e327058ff5', 6, 1),
('44246021-c41e-11eb-bd8f-60e327058ff5', 'd1fc1da8-c41c-11eb-bd8f-60e327058ff5', 6, 1),
('4594b4e9-c4dc-11eb-b637-60e327058ff5', 'a9c0e940-c4da-11eb-b637-60e327058ff5', 6, 1),
('465072f6-c4dc-11eb-b637-60e327058ff5', 'a9c0e940-c4da-11eb-b637-60e327058ff5', 5, 2),
('46aa63df-c5b4-11eb-b66c-60e327058ff5', 'a5d4f42e-c5b2-11eb-b66c-60e327058ff5', 6, 1),
('473af9b9-c410-11eb-bd8f-60e327058ff5', 'eee8ea0b-c40e-11eb-bd8f-60e327058ff5', 6, 1),
('4742f883-c5b8-11eb-b66c-60e327058ff5', '2dd847ce-c5b7-11eb-b66c-60e327058ff5', 11, 2),
('48b56d73-c5ad-11eb-b66c-60e327058ff5', '8f1b6341-c5ab-11eb-b66c-60e327058ff5', 11, 2),
('48ee00a5-c437-11eb-bd8f-60e327058ff5', 'fdc9d179-c405-11eb-bd8f-60e327058ff5', 4, 2),
('4cf01c12-c4da-11eb-b637-60e327058ff5', 'f51a7bce-c4d7-11eb-b637-60e327058ff5', 8, 2),
('4d5aee94-c34a-11eb-ac40-0a0027000015', '0c9473a9-c348-11eb-ac40-0a0027000015', 6, 1),
('4de770b8-c419-11eb-bd8f-60e327058ff5', '306f60c0-c418-11eb-bd8f-60e327058ff5', 6, 1),
('51d44f4d-c5b4-11eb-b66c-60e327058ff5', 'a5d4f42e-c5b2-11eb-b66c-60e327058ff5', 4, 2),
('520d602a-c5a5-11eb-b66c-60e327058ff5', '3b7817be-c5a4-11eb-b66c-60e327058ff5', 9, 1),
('526acf8f-c436-11eb-bd8f-60e327058ff5', '25859c37-c419-11eb-bd8f-60e327058ff5', 11, 2),
('5379edff-c437-11eb-bd8f-60e327058ff5', '31b1636e-c405-11eb-bd8f-60e327058ff5', 7, 2),
('57ca54c0-c34a-11eb-ac40-0a0027000015', '0c9473a9-c348-11eb-ac40-0a0027000015', 5, 2),
('58865feb-c5a0-11eb-b66c-60e327058ff5', '174311b5-c59f-11eb-b66c-60e327058ff5', 6, 1),
('59c88561-c4d9-11eb-b637-60e327058ff5', '51b9b16d-c4d6-11eb-b637-60e327058ff5', 4, 2),
('5af38096-c5b7-11eb-b66c-60e327058ff5', '54a60eff-c5b5-11eb-b66c-60e327058ff5', 2, 1),
('5b1b94f3-c412-11eb-bd8f-60e327058ff5', 'a387fccc-c410-11eb-bd8f-60e327058ff5', 3, 2),
('5cdcee26-c437-11eb-bd8f-60e327058ff5', 'c12ec191-c406-11eb-bd8f-60e327058ff5', 4, 2),
('5de6be37-c5b7-11eb-b66c-60e327058ff5', '54a60eff-c5b5-11eb-b66c-60e327058ff5', 5, 2),
('5e776003-c5a0-11eb-b66c-60e327058ff5', '174311b5-c59f-11eb-b66c-60e327058ff5', 7, 2),
('5f925a97-c5a5-11eb-b66c-60e327058ff5', '3b7817be-c5a4-11eb-b66c-60e327058ff5', 11, 2),
('64b65699-c5aa-11eb-b66c-60e327058ff5', '70b7edd6-c5a9-11eb-b66c-60e327058ff5', 2, 1),
('64cbcede-c5a1-11eb-b66c-60e327058ff5', 'f24eddbc-c59f-11eb-b66c-60e327058ff5', 9, 1),
('65fffa01-c437-11eb-bd8f-60e327058ff5', 'bad27429-c407-11eb-bd8f-60e327058ff5', 4, 2),
('67bad634-c40f-11eb-bd8f-60e327058ff5', '355f855b-c40c-11eb-bd8f-60e327058ff5', 12, 2),
('68baef5e-c5af-11eb-b66c-60e327058ff5', '455c49e2-c5ae-11eb-b66c-60e327058ff5', 5, 1),
('68cc7357-c436-11eb-bd8f-60e327058ff5', 'dce9d6c4-c419-11eb-bd8f-60e327058ff5', 7, 2),
('68ed54ff-c4e3-11eb-b637-60e327058ff5', '73f57381-c4e1-11eb-b637-60e327058ff5', 2, 1),
('69a64fe2-c4e3-11eb-b637-60e327058ff5', '73f57381-c4e1-11eb-b637-60e327058ff5', 7, 2),
('6a5f2a51-c4db-11eb-b637-60e327058ff5', '6b90cfcc-c4d9-11eb-b637-60e327058ff5', 11, 1),
('6c85770a-c351-11eb-ac40-0a0027000015', '02581a0f-c34d-11eb-ac40-0a0027000015', 4, 2),
('6d4be520-c5af-11eb-b66c-60e327058ff5', '455c49e2-c5ae-11eb-b66c-60e327058ff5', 3, 2),
('6d792af4-c413-11eb-bd8f-60e327058ff5', '71affab1-c411-11eb-bd8f-60e327058ff5', 6, 1),
('6f612893-c4db-11eb-b637-60e327058ff5', '6b90cfcc-c4d9-11eb-b637-60e327058ff5', 4, 2),
('7054e5bc-c353-11eb-ac40-0a0027000015', '1b1fd5d3-c353-11eb-ac40-0a0027000015', 6, 1),
('70e559dd-c437-11eb-bd8f-60e327058ff5', '23ab6f16-c40a-11eb-bd8f-60e327058ff5', 4, 2),
('761f8fbf-c5a2-11eb-b66c-60e327058ff5', 'ec30a429-c5a0-11eb-b66c-60e327058ff5', 6, 1),
('7739db64-c5b6-11eb-b66c-60e327058ff5', '1b44cff1-c5b5-11eb-b66c-60e327058ff5', 6, 1),
('7816291d-c5b6-11eb-b66c-60e327058ff5', '1b44cff1-c5b5-11eb-b66c-60e327058ff5', 12, 2),
('78d8f529-c437-11eb-bd8f-60e327058ff5', '6a1318cd-c404-11eb-bd8f-60e327058ff5', 4, 2),
('7af80eed-c5a2-11eb-b66c-60e327058ff5', 'ec30a429-c5a0-11eb-b66c-60e327058ff5', 2, 2),
('7e06efa7-c436-11eb-bd8f-60e327058ff5', '4b28b84f-c41b-11eb-bd8f-60e327058ff5', 7, 2),
('7fc6b9f8-c5b3-11eb-b66c-60e327058ff5', 'e216d642-c5b1-11eb-b66c-60e327058ff5', 6, 1),
('8106bf89-c5a1-11eb-b66c-60e327058ff5', 'f24eddbc-c59f-11eb-b66c-60e327058ff5', 12, 2),
('81dd1ede-c5aa-11eb-b66c-60e327058ff5', '70b7edd6-c5a9-11eb-b66c-60e327058ff5', 1, 2),
('8435e067-c350-11eb-ac40-0a0027000015', '1e6e263e-c34d-11eb-ac40-0a0027000015', 6, 1),
('8633c919-c40a-11eb-bd8f-60e327058ff5', 'bad27429-c407-11eb-bd8f-60e327058ff5', 6, 1),
('86d8afd4-c407-11eb-bd8f-60e327058ff5', 'd22eddc6-c403-11eb-bd8f-60e327058ff5', 6, 1),
('87bbe8b3-c4d9-11eb-b637-60e327058ff5', 'e676965a-c4d7-11eb-b637-60e327058ff5', 3, 1),
('8d030a80-c417-11eb-bd8f-60e327058ff5', '592df4b6-c416-11eb-bd8f-60e327058ff5', 6, 1),
('8d7b0e9a-c5b3-11eb-b66c-60e327058ff5', 'e216d642-c5b1-11eb-b66c-60e327058ff5', 5, 2),
('93ea4e98-c436-11eb-bd8f-60e327058ff5', 'd1fc1da8-c41c-11eb-bd8f-60e327058ff5', 5, 2),
('948f839c-c4d9-11eb-b637-60e327058ff5', 'e676965a-c4d7-11eb-b637-60e327058ff5', 9, 2),
('9821a490-c5ac-11eb-b66c-60e327058ff5', '0e7a7a41-c5ab-11eb-b66c-60e327058ff5', 4, 1),
('99ab9e91-c437-11eb-bd8f-60e327058ff5', 'eee8ea0b-c40e-11eb-bd8f-60e327058ff5', 8, 2),
('9a0af48d-c5ae-11eb-b66c-60e327058ff5', 'c7e90f11-c5ad-11eb-b66c-60e327058ff5', 2, 1),
('9cc1f8f1-c5ac-11eb-b66c-60e327058ff5', '0e7a7a41-c5ab-11eb-b66c-60e327058ff5', 12, 2),
('9e10161b-c5ae-11eb-b66c-60e327058ff5', 'c7e90f11-c5ad-11eb-b66c-60e327058ff5', 7, 2),
('a010e308-c352-11eb-ac40-0a0027000015', '9fb5586d-c350-11eb-ac40-0a0027000015', 6, 1),
('a01cd135-c5b1-11eb-b66c-60e327058ff5', 'ac2c263f-c5b0-11eb-b66c-60e327058ff5', 6, 1),
('a124c238-c355-11eb-ac40-0a0027000015', '1b1fd5d3-c353-11eb-ac40-0a0027000015', 4, 2),
('a43180c5-c5b1-11eb-b66c-60e327058ff5', 'ac2c263f-c5b0-11eb-b66c-60e327058ff5', 5, 2),
('a4ade7b3-c5a3-11eb-b66c-60e327058ff5', 'b87c76f2-c5a2-11eb-b66c-60e327058ff5', 6, 1),
('a5f7f9fb-c437-11eb-bd8f-60e327058ff5', '5b2262c0-c40f-11eb-bd8f-60e327058ff5', 2, 2),
('a62114dc-c34f-11eb-ac40-0a0027000015', 'c540ff9f-c34d-11eb-ac40-0a0027000015', 6, 1),
('a64a71c1-c59d-11eb-b66c-60e327058ff5', '78783eb4-c59c-11eb-b66c-60e327058ff5', 3, 1),
('a6ad22a8-c348-11eb-ac40-0a0027000015', 'aecf1805-c347-11eb-ac40-0a0027000015', 6, 1),
('aa143dad-c4de-11eb-b637-60e327058ff5', '4a85c223-c4dc-11eb-b637-60e327058ff5', 6, 1),
('aa3a927c-c5b0-11eb-b66c-60e327058ff5', '039a6a76-c5af-11eb-b66c-60e327058ff5', 4, 1),
('ae195887-c5b0-11eb-b66c-60e327058ff5', '039a6a76-c5af-11eb-b66c-60e327058ff5', 12, 2),
('aedb4dc4-c4de-11eb-b637-60e327058ff5', '4a85c223-c4dc-11eb-b637-60e327058ff5', 7, 2),
('b15921dd-c348-11eb-ac40-0a0027000015', 'aecf1805-c347-11eb-ac40-0a0027000015', 4, 2),
('b1a0e267-c59d-11eb-b66c-60e327058ff5', '78783eb4-c59c-11eb-b66c-60e327058ff5', 4, 2),
('b21e37e8-c5a3-11eb-b66c-60e327058ff5', 'b87c76f2-c5a2-11eb-b66c-60e327058ff5', 5, 2),
('b2a01e80-c5a7-11eb-b66c-60e327058ff5', 'e1d9c691-c597-11eb-b66c-60e327058ff5', 6, 1),
('b4514cd1-c34f-11eb-ac40-0a0027000015', 'c540ff9f-c34d-11eb-ac40-0a0027000015', 1, 2),
('b4af93b6-c410-11eb-bd8f-60e327058ff5', '5b2262c0-c40f-11eb-bd8f-60e327058ff5', 6, 1),
('b7ce591f-c5a7-11eb-b66c-60e327058ff5', 'e1d9c691-c597-11eb-b66c-60e327058ff5', 2, 2),
('b9c4c821-c59e-11eb-b66c-60e327058ff5', 'b60af114-c59c-11eb-b66c-60e327058ff5', 3, 1),
('bef2fad1-c59e-11eb-b66c-60e327058ff5', 'b60af114-c59c-11eb-b66c-60e327058ff5', 1, 2),
('bfadba72-c5b7-11eb-b66c-60e327058ff5', '9fc74245-c5b5-11eb-b66c-60e327058ff5', 5, 1),
('c0a4114b-c5b7-11eb-b66c-60e327058ff5', '9fc74245-c5b5-11eb-b66c-60e327058ff5', 11, 2),
('c49a6103-c59f-11eb-b66c-60e327058ff5', '0eef4de1-c59e-11eb-b66c-60e327058ff5', 5, 1),
('ca68029e-c596-11eb-b66c-60e327058ff5', '29ae324f-c595-11eb-b66c-60e327058ff5', 6, 1),
('cd49bfe6-c35b-11eb-ac40-0a0027000015', 'd12e7cd6-c35a-11eb-ac40-0a0027000015', 6, 1),
('ced67a2a-c40d-11eb-bd8f-60e327058ff5', '355f855b-c40c-11eb-bd8f-60e327058ff5', 6, 1),
('cfe7969f-c35a-11eb-ac40-0a0027000015', '421c6a8d-c358-11eb-ac40-0a0027000015', 6, 1),
('d2ba9ec1-c407-11eb-bd8f-60e327058ff5', 'fdc9d179-c405-11eb-bd8f-60e327058ff5', 6, 1),
('d2ca89da-c5ac-11eb-b66c-60e327058ff5', '8e625236-c5ab-11eb-b66c-60e327058ff5', 4, 1),
('d2db5285-c5b3-11eb-b66c-60e327058ff5', 'a0a655ea-c5b2-11eb-b66c-60e327058ff5', 4, 1),
('d2e1d6e1-c5b6-11eb-b66c-60e327058ff5', 'd28a7144-c5b4-11eb-b66c-60e327058ff5', 7, 1),
('d3b6cb9e-c5b6-11eb-b66c-60e327058ff5', 'd28a7144-c5b4-11eb-b66c-60e327058ff5', 12, 2),
('d47643ec-c5ae-11eb-b66c-60e327058ff5', 'dc56ccc2-c5ad-11eb-b66c-60e327058ff5', 7, 1),
('d69fd72b-c40b-11eb-bd8f-60e327058ff5', '6a1318cd-c404-11eb-bd8f-60e327058ff5', 6, 1),
('d7b3f778-c5ac-11eb-b66c-60e327058ff5', '8e625236-c5ab-11eb-b66c-60e327058ff5', 9, 2),
('d8e853f3-c5ae-11eb-b66c-60e327058ff5', 'dc56ccc2-c5ad-11eb-b66c-60e327058ff5', 4, 2),
('d906c4f6-c34a-11eb-ac40-0a0027000015', 'be0ca01e-c348-11eb-ac40-0a0027000015', 6, 1),
('d9209589-c5a9-11eb-b66c-60e327058ff5', 'dba9b071-c5a7-11eb-b66c-60e327058ff5', 6, 1),
('d99489b7-c5b3-11eb-b66c-60e327058ff5', 'a0a655ea-c5b2-11eb-b66c-60e327058ff5', 5, 2),
('df93683a-c34a-11eb-ac40-0a0027000015', 'be0ca01e-c348-11eb-ac40-0a0027000015', 11, 2),
('e041f23a-c407-11eb-bd8f-60e327058ff5', '31b1636e-c405-11eb-bd8f-60e327058ff5', 6, 1),
('e3fb4ce8-c435-11eb-bd8f-60e327058ff5', '71affab1-c411-11eb-bd8f-60e327058ff5', 5, 2),
('e442b65d-c4dc-11eb-b637-60e327058ff5', '5c8f74fa-c4d8-11eb-b637-60e327058ff5', 5, 1),
('e52295b7-c4dc-11eb-b637-60e327058ff5', '5c8f74fa-c4d8-11eb-b637-60e327058ff5', 12, 2),
('e8791ae8-c5a6-11eb-b66c-60e327058ff5', 'e670e271-c5a5-11eb-b66c-60e327058ff5', 6, 1),
('ec156646-c5a6-11eb-b66c-60e327058ff5', 'e670e271-c5a5-11eb-b66c-60e327058ff5', 4, 2),
('ec2d222e-c596-11eb-b66c-60e327058ff5', '29ae324f-c595-11eb-b66c-60e327058ff5', 5, 2),
('ec47f22d-c5aa-11eb-b66c-60e327058ff5', '94e9eecd-c5a9-11eb-b66c-60e327058ff5', 6, 1),
('ee870f0b-c5a0-11eb-b66c-60e327058ff5', 'faaadaff-c59f-11eb-b66c-60e327058ff5', 2, 1),
('efd88c08-c5aa-11eb-b66c-60e327058ff5', '94e9eecd-c5a9-11eb-b66c-60e327058ff5', 7, 2),
('f86a0efc-c5a0-11eb-b66c-60e327058ff5', 'faaadaff-c59f-11eb-b66c-60e327058ff5', 3, 2),
('fa68a5cf-c4d0-11eb-b637-60e327058ff5', '1759f889-c4cf-11eb-b637-60e327058ff5', 6, 1),
('faeef8b5-c4de-11eb-b637-60e327058ff5', '3f237925-c4dc-11eb-b637-60e327058ff5', 6, 1),
('fd21ecaa-c407-11eb-bd8f-60e327058ff5', 'c12ec191-c406-11eb-bd8f-60e327058ff5', 6, 1),
('ff09405c-c5b6-11eb-b66c-60e327058ff5', '559de449-c5b3-11eb-b66c-60e327058ff5', 7, 1),
('ff27dfad-c4de-11eb-b637-60e327058ff5', '3f237925-c4dc-11eb-b637-60e327058ff5', 2, 2),
('ffcadd3e-c5a8-11eb-b66c-60e327058ff5', '15614b88-c5a7-11eb-b66c-60e327058ff5', 6, 1),
('fff16e4b-c350-11eb-ac40-0a0027000015', '1e6e263e-c34d-11eb-ac40-0a0027000015', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` char(36) NOT NULL,
  `tahun` smallint(6) NOT NULL,
  `kunci` varchar(10) NOT NULL,
  `nilai` varchar(20) DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_perbaharui` datetime DEFAULT CURRENT_TIMESTAMP,
  `sinkronisasi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `tahun`, `kunci`, `nilai`, `tanggal_dibuat`, `tanggal_perbaharui`, `sinkronisasi`) VALUES
('4e3c8763-c110-11eb-a2cf-fc459686d6e7', 2021, 'NIPD', '20', '2021-05-30 14:28:29', '2021-05-30 14:28:29', '2021-05-30 14:28:29'),
('4e3cc616-c110-11eb-a2cf-fc459686d6e7', 2021, 'PILIH_KK', '2', '2021-05-30 14:28:29', '2021-05-30 14:28:29', '2021-05-30 14:28:29'),
('4e3cc7be-c110-11eb-a2cf-fc459686d6e7', 2021, 'TAMBAH_KK', '0', '2021-05-30 14:28:29', '2021-05-30 14:28:29', '2021-05-30 14:28:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pdb`
--
ALTER TABLE `pdb`
  ADD PRIMARY KEY (`id_pdb`),
  ADD UNIQUE KEY `kun_pdb_nik` (`nik`),
  ADD UNIQUE KEY `kun_pdb_nisn` (`nisn`),
  ADD UNIQUE KEY `kun_pdb_nopes` (`nopes`),
  ADD KEY `ka_pdb_kode_wilayah` (`kode_wilayah`),
  ADD KEY `ka_pdb_id_sp` (`id_sp`),
  ADD KEY `ka_pdb_cita` (`cita`),
  ADD KEY `ka_pdb_hobi` (`hobi`);

--
-- Indexes for table `pdb_berkas`
--
ALTER TABLE `pdb_berkas`
  ADD PRIMARY KEY (`id_pdb_berkas`),
  ADD KEY `kas_pdb_berkas_id_pdb` (`id_pdb`),
  ADD KEY `kas_pdb_berkas_id_berkas` (`id_berkas`);

--
-- Indexes for table `pdb_pilihan`
--
ALTER TABLE `pdb_pilihan`
  ADD PRIMARY KEY (`id_pdb_pilihan`),
  ADD UNIQUE KEY `kun_pdb_pilihan_id_pdb_kk` (`id_pdb`,`id_kk`),
  ADD UNIQUE KEY `kun_pdb_pilihan_id_pdb_pilihan` (`id_pdb`,`pilihan`),
  ADD KEY `ka_pdb_pilihan_id_kk` (`id_kk`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`),
  ADD UNIQUE KEY `kun_tahun_kunci` (`tahun`,`kunci`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pdb`
--
ALTER TABLE `pdb`
  ADD CONSTRAINT `ka_pdb_cita` FOREIGN KEY (`cita`) REFERENCES `kystudio_ref`.`jenis_cita` (`id_cita`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ka_pdb_hobi` FOREIGN KEY (`hobi`) REFERENCES `kystudio_ref`.`jenis_hobi` (`id_hobi`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ka_pdb_id_sp` FOREIGN KEY (`id_sp`) REFERENCES `kystudio_ref`.`satuan_pendidikan` (`id_sp`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ka_pdb_kode_wilayah` FOREIGN KEY (`kode_wilayah`) REFERENCES `kystudio_ref`.`wilayah` (`kode_wilayah`);

--
-- Constraints for table `pdb_berkas`
--
ALTER TABLE `pdb_berkas`
  ADD CONSTRAINT `kas_pdb_berkas_id_berkas` FOREIGN KEY (`id_berkas`) REFERENCES `kystudio_ref`.`berkas` (`id_berkas`),
  ADD CONSTRAINT `kas_pdb_berkas_id_pdb` FOREIGN KEY (`id_pdb`) REFERENCES `pdb` (`id_pdb`);

--
-- Constraints for table `pdb_pilihan`
--
ALTER TABLE `pdb_pilihan`
  ADD CONSTRAINT `ka_pdb_pilihan_id_kk` FOREIGN KEY (`id_kk`) REFERENCES `kystudio_ref`.`kompetensi_keahlian` (`id_kk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ka_pdb_pilihan_id_pdb` FOREIGN KEY (`id_pdb`) REFERENCES `pdb` (`id_pdb`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
