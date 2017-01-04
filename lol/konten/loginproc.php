<?php
session_start();
include"koneksi/koneksi.php";

$login = mysql_query("select * from user where (username='".$_POST['username']."') and (password = '".$_POST['password']."')");
$rowcount = mysql_num_rows($login);

if($rowcount==1){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	echo "<script> alert('ANDA BERHASIL MASUK'); window.location.href='?module=indexuser#pos';</script>";
}
else {
	echo "<script> alert('ANDA GAGAL MASUK'); window.location.href='?module=kontak#pos';</script>";
}
	?>