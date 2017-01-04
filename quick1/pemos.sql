-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 01, 2016 at 05:56 PM
-- Server version: 5.7.13-log
-- PHP Version: 5.6.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemos`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussion_topics`
--

CREATE TABLE `discussion_topics` (
  `login_id` int(11) NOT NULL,
  `charac` varchar(255) NOT NULL,
  `stat_us` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discussion_topics`
--

INSERT INTO `discussion_topics` (`login_id`, `charac`, `stat_us`) VALUES
(1, '2vgq', 'tidak'),
(2, 'ash4', 'tidak'),
(3, 'eyg2', 'tidak'),
(4, 'u1oh', 'tidak'),
(5, 'ziez', 'tidak');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `no_urut` int(11) NOT NULL,
  `siswa_nis` int(20) NOT NULL,
  `siswa_nama` varchar(50) NOT NULL,
  `siswa_kelas` varchar(10) NOT NULL,
  `tot_su` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`no_urut`, `siswa_nis`, `siswa_nama`, `siswa_kelas`, `tot_su`) VALUES
(1, 20042000, 'M Ghazi Muharam', 'HYDRATES', 541),
(2, 1234, 'M Iqbal Geutama', 'HYDRATES', 51),
(3, 12345, 'Muhammad Ghifari K', 'NECCESITY', 31),
(4, 123456, 'Faiz Azhanzi Yazid', 'GVM', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion_topics`
--
ALTER TABLE `discussion_topics`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`no_urut`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion_topics`
--
ALTER TABLE `discussion_topics`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `no_urut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
