<?php 
	include "koneksi.php";
	session_start();
	
	$proses = "SELECT * FROM user WHERE (username='$_POST[username]') and (password='$_POST[password]') and terima=TRUE";
	$hasil = mysql_query($proses);
	if(mysql_num_rows($hasil)==1){
		$aray=mysql_fetch_array($hasil);
		$_SESSION['username']=$_POST['username'];
		$_SESSION['status']=$aray['status'];
		
		if($aray['status']=="Dosen"){
			
				echo"<script>alert('Login Berhasil');window.location.href='../index.php';</script>";
				
			}
		else if($aray['status']=="Admin"){
				echo"<script>alert('Login Berhasil');window.location.href='../index.php';</script>";
				}
			
		
		else if($aray['status'] == "Mahasiswa"){
			$_SESSION['id']=$aray['id_user'];
				echo"<script>alert('Login Berhasil');window.location.href='../index.php';</script>";
			}
			
		
	}
	else{
		session_destroy();
		echo "<script>alert('Login Gagal');window.location.href='../index.php';</script>";
	}
?>