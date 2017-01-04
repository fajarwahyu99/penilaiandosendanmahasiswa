<?php
//panggil file config.php untuk menghubung ke server
include('config.php');

//tangkap data dari form
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$kodecabang = $_POST['kodecabang'];
$kodeproduk = $_POST['kodeproduk'];
$namaproduk = $_POST['namaproduk'];
$jumlah = $_POST['jumlah'];
$pendapatan = $_POST['pendapatan'];

//simpan data ke database
$query = mysql_query("insert into penjualan values('', '$tahun', '$bulan', '$kodecabang', '$kodeproduk', '$namaproduk', '$jumlah', '$pendapatan')") or die(mysql_error());

if ($query) {
	header('location:index.php?message=success');
}
?>