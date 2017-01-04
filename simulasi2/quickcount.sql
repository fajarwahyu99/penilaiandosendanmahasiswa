-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2016 at 11:51 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quickcount`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_suara`
--

CREATE TABLE `data_suara` (
  `id_datasuara` int(10) NOT NULL,
  `id_wilayah` varchar(10) NOT NULL,
  `total_DPT` int(10) NOT NULL,
  `pengguna_hakpilih` int(10) NOT NULL,
  `suara_k1` int(10) NOT NULL,
  `suara_k2` int(10) NOT NULL,
  `suara_k3` int(10) NOT NULL,
  `suara_sah` int(10) NOT NULL,
  `suara_tdksah` int(10) NOT NULL,
  `total_suara` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_suara`
--

INSERT INTO `data_suara` (`id_datasuara`, `id_wilayah`, `total_DPT`, `pengguna_hakpilih`, `suara_k1`, `suara_k2`, `suara_k3`, `suara_sah`, `suara_tdksah`, `total_suara`) VALUES
(1, '', 0, 0, 0, 0, 0, 0, 0, 0),
(2, '', 0, 0, 0, 0, 0, 0, 0, 0),
(3, '', 0, 0, 0, 0, 0, 0, 0, 0),
(4, '', 12356, 5769, 4778, 46976, 35689, 356, 578, 5768),
(5, '', 1257, 927372, 97235274, 865452, 92732745, 476, 8246, 2486),
(6, '', 2313, 13223, 2312, 312, 2133, 311, 3133, 3131),
(7, '', 123, 123, 123, 13, 123, 123, 13, 123),
(8, '', 432, 323, 1233, 1332, 23212, 2331, 22321, 1221),
(9, '', 14578, 13, 2454, 2453, 253, 25254, 2543, 265);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_hitung`
--

CREATE TABLE `hasil_hitung` (
  `id_hasilhitung` int(11) NOT NULL,
  `t_s1` bigint(200) NOT NULL,
  `t_s2` bigint(200) NOT NULL,
  `t_s3` bigint(200) NOT NULL,
  `p_s1` varchar(200) NOT NULL,
  `p_s2` varchar(200) NOT NULL,
  `p_s3` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_hitung`
--

INSERT INTO `hasil_hitung` (`id_hasilhitung`, `t_s1`, `t_s2`, `t_s3`, `p_s1`, `p_s2`, `p_s3`) VALUES
(1, 33276, 130914, 241726, '8.2', '32.25', '59.55');

-- --------------------------------------------------------

--
-- Table structure for table `relawan`
--

CREATE TABLE `relawan` (
  `id_relawan` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `wilayah` varchar(50) NOT NULL,
  `no_telp` int(15) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relawan`
--

INSERT INTO `relawan` (`id_relawan`, `nama`, `wilayah`, `no_telp`, `username`, `password`, `id`) VALUES
(1, 'sarah khairun', 'tangerang', 8797, 'sarah', 'sarah', 101),
(2, 'rosyida', 'bekasi', 89854, 'ocid', 'ocid', 102),
(4, 'wisi', 'ciputat', 78968745, 'eja', 'eja', 235),
(5, 'ocid', 'ciputat', 895764, 'ocid', 'ocid', 109);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `wilayah` varchar(50) NOT NULL,
  `telp` int(15) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `wilayah`, `telp`, `username`, `password`, `status`) VALUES
(1, 'rahmat hidayat', 'tangerang', 875788754, 'admin', 'admin', 'admin'),
(2, 'syinsyina ', 'tangerang', 8968818, 'syina', 'syina', 'relawan');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id_wilayah` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `jml_DPT` int(10) NOT NULL,
  `hakpilih` int(10) NOT NULL,
  `s1` int(10) NOT NULL,
  `s2` int(10) NOT NULL,
  `s3` int(10) NOT NULL,
  `suara_sah` int(10) NOT NULL,
  `suara_tdksah` int(10) NOT NULL,
  `total_suara` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id_wilayah`, `kecamatan`, `jml_DPT`, `hakpilih`, `s1`, `s2`, `s3`, `suara_sah`, `suara_tdksah`, `total_suara`) VALUES
('01', 'ciputat', 92516, 55179, 4317, 16936, 33236, 50913, 3137, 53556),
('02', 'ciputat timur', 124947, 64630, 5776, 16878, 39558, 62101, 2591, 64429),
('03', 'pamulang', 212586, 124663, 8792, 44152, 66355, 221207, 4190, 123391),
('04', 'pondok aren', 199486, 117621, 9550, 31126, 71415, 110029, 3687, 114590),
('05', 'serpong', 101459, 79473, 4841, 21822, 31162, 51910, 1653, 58635),
('06', 'serpong utara', 0, 0, 0, 0, 0, 0, 0, 0),
('07', 'setu', 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wilayah_kel`
--

CREATE TABLE `wilayah_kel` (
  `id_wilayahkel` varchar(50) NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `jml_DPTkel` int(10) NOT NULL,
  `hakpilih_kel` int(10) NOT NULL,
  `s1_kel` int(10) NOT NULL,
  `s2_kel` int(10) NOT NULL,
  `s3_kel` int(10) NOT NULL,
  `suara_sahkel` int(10) NOT NULL,
  `suara_tdksahkel` int(10) NOT NULL,
  `total_suarakel` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah_kel`
--

INSERT INTO `wilayah_kel` (`id_wilayahkel`, `kelurahan`, `jml_DPTkel`, `hakpilih_kel`, `s1_kel`, `s2_kel`, `s3_kel`, `suara_sahkel`, `suara_tdksahkel`, `total_suarakel`) VALUES
('011', 'ciputat', 17277, 10599, 861, 3364, 5889, 9980, 335, 10323),
('012', 'jombang', 235, 213, 13, 134, 43, 64, 765, 643),
('013', 'cipayung', 16713, 10557, 678, 3780, 5649, 10007, 426, 10552),
('014', 'sawah', 1213, 234, 455, 565, 766, 78, 89, 98),
('015', 'sawah baru', 19289, 10794, 780, 2620, 6846, 9075, 339, 9424),
('016', 'serua', 25236, 14927, 1053, 4132, 9276, 14116, 795, 14681),
('017', 'serua indah', 12553, 7855, 477, 2341, 4767, 7593, 388, 7835),
('021', 'cempaka putih', 17297, 9574, 780, 2283, 6141, 9212, 647, 9566),
('022', 'cireundeu', 18973, 9694, 949, 2667, 5678, 9300, 395, 9788),
('023', 'pisangan', 28454, 13120, 1463, 3148, 8075, 12686, 427, 13119),
('024', 'pondok ranji', 20058, 11203, 714, 3280, 6925, 10794, 318, 11103),
('025', 'rempoa', 21777, 11374, 1003, 2989, 6920, 10912, 462, 11314),
('026', 'rengas', 18388, 9665, 867, 2511, 5819, 9197, 342, 9539),
('031', 'bambu apus', 17707, 10558, 547, 3790, 5903, 10236, 318, 10558),
('032', 'benda baru', 28629, 16833, 1110, 6627, 8913, 16654, 435, 17088),
('033', 'kedaung', 36923, 19988, 1618, 6819, 10547, 18981, 715, 19699),
('034', 'pamulang barat', 35280, 21214, 1823, 6226, 11710, 19775, 684, 20469),
('035', 'pamulang timur', 19980, 12540, 1014, 3774, 7048, 113836, 539, 12375),
('036', 'pondok benda', 32598, 19562, 1223, 8309, 9485, 18912, 535, 19569),
('037', 'pondok cabe ilir', 26375, 14631, 784, 4806, 8390, 13980, 593, 14429),
('038', 'pondok cabe udik', 15094, 9337, 673, 3801, 4359, 8833, 371, 9204),
('041', 'jurangmangu barat', 26211, 14626, 1299, 3848, 9018, 14274, 535, 14615),
('0410', 'pondok karya', 18172, 10034, 1056, 2721, 5588, 9463, 404, 9778),
('0411', 'pondok pucung', 17827, 10917, 943, 3069, 6122, 9147, 250, 10212),
('042', 'jurangmangu timur', 21548, 11561, 938, 2947, 7311, 11205, 355, 11550),
('043', 'parigi baru', 8270, 6240, 279, 1892, 3841, 6021, 122, 6134),
('044', 'parigi lama', 12050, 7598, 353, 2868, 4108, 7088, 137, 7261),
('045', 'pondok aren', 21589, 12665, 902, 2664, 8610, 11746, 349, 12675),
('046', 'pondok betung', 26789, 14891, 1767, 3360, 8828, 13955, 727, 14682),
('047', 'pondok jaya', 7242, 4015, 329, 1225, 2370, 3924, 104, 4028),
('048', 'pondok kacang barat', 14351, 8358, 605, 1874, 5610, 8089, 269, 8358),
('049', 'pondok kacang timur', 25437, 16716, 1079, 4658, 10009, 15117, 435, 15297),
('051', 'buaran', 11200, 7596, 239, 3866, 3256, 7361, 235, 7596),
('052', 'ciater', 16479, 9836, 407, 4130, 5124, 9451, 157, 9822),
('053', 'cilenggang', 7010, 4524, 203, 1470, 2758, 4431, 93, 4323),
('054', 'lengkong gudang', 7722, 4775, 353, 1422, 2851, 4626, 149, 4775),
('055', 'lengkong gudang timur', 7385, 4694, 432, 1701, 2319, 4452, 142, 4594),
('056', 'lengkong wetan', 7301, 4128, 266, 1262, 2509, 4037, 141, 4128),
('057', 'rawa buntu', 20386, 9973, 1643, 3356, 4353, 9059, 275, 9443),
('058', 'rawa mekar jaya', 10992, 26282, 722, 2176, 3201, 6099, 194, 6293),
('059', 'serpong', 12984, 7665, 576, 2439, 4791, 2394, 267, 7661),
('061', 'jelupang', 0, 0, 0, 0, 0, 0, 0, 0),
('062', 'lengkong karya', 0, 0, 0, 0, 0, 0, 0, 0),
('063', 'paku jaya', 0, 0, 0, 0, 0, 0, 0, 0),
('064', 'pakualam', 0, 0, 0, 0, 0, 0, 0, 0),
('065', 'pakulonan', 0, 0, 0, 0, 0, 0, 0, 0),
('066', 'pondok jagung', 0, 0, 0, 0, 0, 0, 0, 0),
('067', 'pondok jagung timur', 0, 0, 0, 0, 0, 0, 0, 0),
('071', 'babakan', 0, 0, 0, 0, 0, 0, 0, 0),
('072', 'bhakti jaya', 0, 0, 0, 0, 0, 0, 0, 0),
('073', 'kademangan', 0, 0, 0, 0, 0, 0, 0, 0),
('074', 'kranggan', 0, 0, 0, 0, 0, 0, 0, 0),
('075', 'muncul', 0, 0, 0, 0, 0, 0, 0, 0),
('076', 'setu', 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_suara`
--
ALTER TABLE `data_suara`
  ADD PRIMARY KEY (`id_datasuara`);

--
-- Indexes for table `hasil_hitung`
--
ALTER TABLE `hasil_hitung`
  ADD PRIMARY KEY (`id_hasilhitung`);

--
-- Indexes for table `relawan`
--
ALTER TABLE `relawan`
  ADD PRIMARY KEY (`id_relawan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- Indexes for table `wilayah_kel`
--
ALTER TABLE `wilayah_kel`
  ADD PRIMARY KEY (`id_wilayahkel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_suara`
--
ALTER TABLE `data_suara`
  MODIFY `id_datasuara` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `relawan`
--
ALTER TABLE `relawan`
  MODIFY `id_relawan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
