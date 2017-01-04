<?php
include('config.php');

//tangkap data dari form
$id = $_POST['id'];
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$kodecabang = $_POST['kodecabang'];
$kodeproduk = $_POST['kodeproduk'];
$namaproduk = $_POST['namaproduk'];
$jumlah = $_POST['jumlah'];
$pendapatan = $_POST['pendapatan'];

//update data di database sesuai user_id
$query = mysql_query("update penjualan set tahun='$tahun', bulan='$bulan', kodecabang='$kodecabang', kodeproduk='$kodeproduk', namaproduk='$namaproduk', jumlah='$jumlah', pendapatan='$pendapatan' where id='$id'") or die(mysql_error());

if ($query) {
	header('location:view.php?message=success');
}
?>