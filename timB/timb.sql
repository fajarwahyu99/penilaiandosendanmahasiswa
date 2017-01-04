-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2015 at 01:20 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timb`
--

-- --------------------------------------------------------

--
-- Table structure for table `matkul`
--

CREATE TABLE IF NOT EXISTS `matkul` (
  `id_matkul` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `sks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matkul`
--

INSERT INTO `matkul` (`id_matkul`, `id_user`, `nama_matkul`, `sks`) VALUES
('001', '115', 'WEB', '3'),
('002', '112', 'KOMDAT', '5'),
('0077', '009', 'Masak', '3');

-- --------------------------------------------------------

--
-- Table structure for table `mhs`
--

CREATE TABLE IF NOT EXISTS `mhs` (
  `id` varchar(100) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `ipk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mhs`
--

INSERT INTO `mhs` (`id`, `nama_mhs`, `fakultas`, `jurusan`, `ipk`) VALUES
('100', 'Fajar Nugraha Wahyu', '', '', 4),
('1114091000013', 'Si Ganteng', '', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `id_nilai` int(10) NOT NULL,
  `id_mhs` varchar(100) NOT NULL,
  `id_matkul` varchar(100) NOT NULL,
  `formatif` int(3) NOT NULL,
  `uts` int(3) NOT NULL,
  `uas` int(3) NOT NULL,
  `nilai` int(3) NOT NULL,
  `huruf` varchar(100) NOT NULL,
  `predikat` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_mhs`, `id_matkul`, `formatif`, `uts`, `uas`, `nilai`, `huruf`, `predikat`) VALUES
(3, '1113091000022', '001', 80, 68, 67, 71, 'B', 'Baik'),
(4, '1113091000022', '002', 80, 80, 80, 80, 'A', 'Sangat Baik'),
(5, '100', '0077', 90, 90, 99, 94, 'A', 'Sangat Baik');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('Admin','Dosen','Mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `email`, `status`) VALUES
('001', 'admin', 'admin', 'admin', 'blabla@gmail.com', 'Admin'),
('009', 'Kita', 'kita', 'kita', 'kita@amail.com', 'Dosen'),
('100', 'Fajar Nugraha Wahyu', 'fafafa', '123', 'fajarwahyu49@gmail.com', 'Mahasiswa'),
('1114091000013', 'Si Ganteng', 'Bit', 'Bit', 'bitbdonk21@gmail.com', 'Mahasiswa'),
('112', 'Umi Masruroh', 'dosen', 'dosen', 'umimasruroh@gmail.com', 'Dosen'),
('115', 'Noval Adiansyah', 'Noval', 'noval', 'novalaldi@yahoo.com', 'Dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matkul`
--
ALTER TABLE `matkul`
  ADD PRIMARY KEY (`id_matkul`);

--
-- Indexes for table `mhs`
--
ALTER TABLE `mhs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
