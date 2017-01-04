<?php 
	include "koneksi.php";
	session_start();
	
	$proses = "SELECT * FROM user WHERE (username='$_POST[username]') and (password='$_POST[password]')";
	$hasil = mysql_query($proses);
	if(mysql_num_rows($hasil)==1){
		$aray=mysql_fetch_array($hasil);
		$_SESSION['username']=$_POST['username'];
		$_SESSION['status']=$aray['status'];
		$_SESSION['id']=$aray['id_user'];
		if($aray['status']=="Dosen")
			{
				echo"<script>alert('Login Berhasil');window.location.href='../home.php';</script>";
			}
			
	
	else if($aray['status'] == "Admin")
			{
			echo"<script>alert('Login Berhasil');window.location.href='../home.php';</script>";
			}
			
	else if($aray['status'] == "Mahasiswa"){
		
				echo"<script>alert('Login Berhasil');window.location.href='../home.php';</script>";
			}
			
			}
	else{
		session_destroy();
		echo "<script>alert('Login Gagal');window.location.href='../home.php';</script>";
	}
?>