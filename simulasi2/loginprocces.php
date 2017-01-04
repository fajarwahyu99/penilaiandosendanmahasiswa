<?php 
	include "konten/koneksi.php";
	session_start();
	
	$proses = "SELECT * FROM user WHERE (username='$_POST[username]') and (password='$_POST[password]')";

	$hasil = mysql_query($proses);
	if(mysql_num_rows($hasil)==1){
		$aray=mysql_fetch_array($hasil);
		$_SESSION['username']=$_POST['username'];
		$_SESSION['status']=$aray['status'];
		if($aray['status'] == "relawan")
			{

			echo"<script>alert('Login Berhasil');window.location.href='konten/indexrelawan.php';</script>";
			}
	else if($aray['status'] == "admin")
			{
			echo"<script>alert('Login Berhasil');window.location.href='konten/indexAdmin.php';</script>";
			}
			else{
		session_destroy();
		echo "<script>alert('Login Gagal');window.location.href='index.php';</script>";
	}
	}
?>