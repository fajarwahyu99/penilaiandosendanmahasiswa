-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2014 at 02:41 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `kuliah`
--

CREATE TABLE IF NOT EXISTS `kuliah` (
  `kode` int(100) NOT NULL,
  `nipdosen` int(100) NOT NULL,
  `matkul` varchar(100) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuliah`
--

INSERT INTO `kuliah` (`kode`, `nipdosen`, `matkul`) VALUES
(111, 11, 'Sistem Operasi'),
(222, 22, 'Matematika Dasar'),
(444, 33, 'Matematika Diskrit');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `nim` int(50) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `kode_matkul` int(100) NOT NULL,
  `nilai` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_mhs`, `kode_matkul`, `nilai`) VALUES
(7, 'Herza', 222, '90'),
(22, 'Kurnia', 0, '67'),
(23, 'Aulia', 222, '90'),
(24, 'Adit', 123, '60'),
(44, 'Atqia', 123, '80'),
(55, 'Rosyida', 222, '88'),
(56, 'Imelda', 0, '87'),
(111, 'Sarah', 222, '60');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `nip` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `ttl` varchar(50) NOT NULL,
  `notelp` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Dosen',
  `jumlahlogin` int(50) DEFAULT '0',
  `jumlahedit` int(50) NOT NULL DEFAULT '0',
  `terima` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nip`, `nama`, `ttl`, `notelp`, `alamat`, `username`, `password`, `status`, `jumlahlogin`, `jumlahedit`, `terima`) VALUES
(11, 'Rahmat', '123', '456', 'jalan melati', 'rahmat', 'rahmat', 'Dosen', 2, 0, 1),
(22, 'Suci', 'hjgutu', '767688', 'ghjfgh', 'suci', 'suci', 'Dosen', 0, 0, 0),
(33, 'Rahmat Hidayat Kartolo', '12345', '12345', '45678', 'dayat', 'dayat', 'Dosen', 0, 0, 0),
(12345, 'Sarah', 'Jakarta, 12 Maret 1970', '081234567890', 'Jalan Mawar 1 no 5', 'Sarah', '12345', 'Admin', 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
