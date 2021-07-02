-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 12:16 AM
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
-- Database: `kystudio_ref`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id_berkas` tinyint(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT NULL,
  `tanggal_perbarui` timestamp NULL DEFAULT NULL,
  `sinkronisasi` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`id_berkas`, `nama`, `tanggal_dibuat`, `tanggal_perbarui`, `sinkronisasi`) VALUES
(1, 'Surat Keterangan Lulus (SKL)', NULL, NULL, NULL),
(2, 'Salinan NISN', NULL, NULL, NULL),
(3, 'Salinan Asli Kartu Keluarga', NULL, NULL, NULL),
(4, 'Salinan Asli Akte Kelahiran', NULL, NULL, NULL),
(5, 'Rapor Teregalisir', NULL, NULL, NULL),
(6, 'Pas Foto 3x4 Latar Biru', NULL, NULL, NULL),
(7, 'Ijazah Terelagisir', NULL, NULL, NULL),
(8, 'Surat Pernyataan Bebas Narkoba', NULL, NULL, NULL),
(9, 'Salinan Sertifikat Prestasi', NULL, NULL, NULL),
(10, 'Salinan Kartu PIP/DTKS', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD UNIQUE KEY `kun_berkas_nama` (`nama`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
