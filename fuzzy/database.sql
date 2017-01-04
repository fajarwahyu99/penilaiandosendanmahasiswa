/*
SQLyog Ultimate v9.50 
MySQL - 5.0.51b-community : Database - ai
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ai` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ai`;

/*Table structure for table `tb_emp` */

DROP TABLE IF EXISTS `tb_emp`;

CREATE TABLE `tb_emp` (
  `id` int(10) NOT NULL auto_increment,
  `nama` varchar(50) default NULL,
  `usia` tinyint(2) default NULL,
  `masakerja` tinyint(2) default NULL,
  `gaji` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tb_emp` */

insert  into `tb_emp`(`id`,`nama`,`usia`,`masakerja`,`gaji`) values (1,'Lia',30,6,750000),(2,'Iwan',48,17,1255000),(3,'Sari',36,14,1500000),(4,'Andi',37,4,1040000),(5,'Budi',42,12,950000),(6,'Amir',39,13,1600000),(7,'Rian',37,5,1250000),(8,'Kiki',32,1,550000),(9,'Alda',35,3,735000),(10,'Yoga',25,2,860000);

/*Table structure for table `tb_kelompok` */

DROP TABLE IF EXISTS `tb_kelompok`;

CREATE TABLE `tb_kelompok` (
  `id` int(10) NOT NULL auto_increment,
  `nama_kelompok` varchar(25) default NULL,
  `field_akses` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_kelompok` */

insert  into `tb_kelompok`(`id`,`nama_kelompok`,`field_akses`) values (1,'Umur','usia'),(2,'Masa Kerja','masakerja'),(3,'Gaji','gaji');

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `id` int(10) NOT NULL auto_increment,
  `nama_kriteria` varchar(30) default NULL,
  `bawah` float(10,2) default NULL,
  `tengah` float(10,2) default NULL,
  `atas` float(10,2) default NULL,
  `kelompok` tinyint(2) default NULL,
  `keterangan` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`id`,`nama_kriteria`,`bawah`,`tengah`,`atas`,`kelompok`,`keterangan`) values (1,'Muda',0.00,30.00,40.00,1,'Darah Muda'),(2,'Parobaya',35.00,45.00,50.00,1,NULL),(3,'Tua',40.00,50.00,99.00,1,NULL),(4,'Baru',0.00,5.00,15.00,2,NULL),(5,'Lama',10.00,25.00,99.00,2,NULL),(6,'Rendah',0.00,300000.00,800000.00,3,NULL),(7,'Sedang',500000.00,1000000.00,1500000.00,3,NULL),(8,'Tinggi',1000000.00,2000000.00,100000000.00,3,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
