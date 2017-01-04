<?php
session_start();
include "koneksi.php";

$login= mysql_query("select * from user where (username='".$_POST['username']."') and (password = '".$_POST['password']."')");
$logindosen= mysql_query("select * from dosen where (username='".$_POST['username']."') and (password = '".$_POST['password']."')");

$rowcount= mysql_num_rows($login);
$rowcount2= mysql_num_rows($logindosen);

if($rowcount==1){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];

	echo"<script>alert('Anda berhasil masuk');window.location.href='indexadmin.php';</script>";
}
else if($rowcount2=1){
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	
	$hasil = mysql_fetch_array($logindosen);
	$date = date('Y-m-d');
	if ($hasil['status'] == "aktif"){
		if ($hasil['tanggal_login'] == $date)
		{
			if ($hasil['total_login'] < 3)
			{
				echo "<script>alert('Selamat Datang $_SESSION[username]'); window.location.href='indexdosen.php';</script>";
				$now = $hasil['total_login'] + 1;
				$update = mysql_query("UPDATE dosen set total_login='$now'");
			}
			else{
				echo "<script>alert('Gagal login! Anda sudah login 3 kali dalam sehari'); window.location.href='index.php';</script>";
			}
		}
		else{
			echo "<script>alert('Selamat Datang $_SESSION[username]'); window.location.href='indexdosen.php';</script>";
			$now = 1;
			$update = mysql_query("UPDATE dosen set total_login='$now', tanggal_login='$date'");
		}
	}
	else{
		echo "<script>alert('Gagal login! Anda Belum di setujui Admin'); window.location.href='?module=home';</script>";
	}
}
else {
	echo"<script>alert('Anda gagal masuk');window.location.href='?module=home';</script>";
}
?>