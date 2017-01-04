-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2015 at 05:04 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ais`
--
CREATE DATABASE IF NOT EXISTS `ais` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ais`;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE IF NOT EXISTS `dosen` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'nonaktif',
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `notel` varchar(100) NOT NULL,
  `tanggal_login` date NOT NULL,
  `total_login` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nama`, `username`, `password`, `status`, `alamat`, `email`, `notel`, `tanggal_login`, `total_login`) VALUES
(1, 'asep', 'asep', 'asep', 'aktif', 'jl. mangga no.2', 'asep@yahoo.co.id', '081808909366', '2015-11-29', 3),
(5, 'yudith', 'yudith', 'yudith', 'aktif', 'jl.apel no.3', 'yudith@yahoo.co.id', '0987456', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nim` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`) VALUES
(1, '11140910000017', 'mia'),
(2, '11140910000006', 'febri');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE IF NOT EXISTS `mata_kuliah` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(100) NOT NULL,
  `pelajaran` varchar(100) NOT NULL,
  `jam` time NOT NULL,
  `tempat` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id`, `id_dosen`, `pelajaran`, `jam`, `tempat`) VALUES
(1, 1, 'metode numerik', '10:00:00', 'lab apl 2'),
(5, 5, 'Matematika Dasar', '09:00:00', 'Theater Lt.5');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(100) NOT NULL,
  `id_matkul` int(100) NOT NULL,
  `id_mahasiswa` int(100) NOT NULL,
  `nilai` int(100) NOT NULL,
  `huruf` varchar(100) NOT NULL,
  `predikat` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `id_dosen`, `id_matkul`, `id_mahasiswa`, `nilai`, `huruf`, `predikat`) VALUES
(9, 5, 5, 1, 100, 'A', 'Sangat Baik'),
(10, 5, 5, 2, 90, 'A', 'Sangat Baik'),
(13, 1, 1, 1, 80, 'A', 'Sangat Baik'),
(14, 1, 1, 2, 30, 'E', 'Sangat Buruk'),
(15, 6, 6, 1, 80, 'A', 'Sangat Baik'),
(16, 6, 6, 2, 20, 'E', 'Sangat Buruk');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
