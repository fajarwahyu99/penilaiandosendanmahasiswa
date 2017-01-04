<?php
session_start();
include "koneksi/koneksi.php";

	$select = mysql_query("SELECT * FROM admin where (user_admin='".$_POST['username']."') and (pass_admin='".$_POST['password']."')");
	$select2 = mysql_query("SELECT * FROM request where (user_client='".$_POST['username']."') and (pass_client='".$_POST['password']."')");
	$select3 = mysql_query("SELECT * FROM alldata where (user_dosen='".$_POST['username']."') and (pass_dosen='".$_POST['password']."')");
	$select4 = mysql_query("SELECT * FROM mhs where (user_mhs='".$_POST['username']."') and (pass_mhs='".$_POST['password']."')");

	$row = mysql_num_rows($select);
	$row2 = mysql_num_rows($select2);
	$row3 = mysql_num_rows($select3);
	$row4 = mysql_num_rows($select4);
	
	if($row==1)
	{
		$_SESSION['user_admin'] = $_POST['username'];
		$_SESSION['pass_admin'] = $_POST['password'];
		echo "<script>alert('Selamat Datang $_SESSION[user_admin]'); window.location.href='login/admin/indexuser.php';</script>";
	}

	else if($row2==1)
	{
		$_SESSION['user_client'] = $_POST['username'];
		$_SESSION['pass_client'] = $_POST['password'];
		$syarat = mysql_fetch_array($select2);
		if($syarat['status'] == "Belum disetujui")
		{
			echo "<script>alert('Maaf anda belum disetujui oleh admin, silahkan menunggu selama 24 jam, terimakasih'); window.location.href='index.php';</script>";
		}
		else
		{
			echo"<script>alert('Anda belum terdaftar sebagai member, silahkan melakukan pendaftaran'); window.location.href='index.php';</script>";
		}
	}
	
	else if($row3==1)
	{
		$_SESSION['user_dosen'] = $_POST['username'];
		$_SESSION['pass_dosen'] = $_POST['password'];
		$syarat = mysql_fetch_array($select3);
		$date = date('Y-m-d');
		$syaratmasuk = $syarat['id_dosen'];
		if($syarat['status'] == "Disetujui"){
			if($syarat['logindate'] == $date){
				if ($syarat['count'] < 3) {
					echo "<script>alert('Selamat Datang $_SESSION[user_dosen]'); window.location.href='login/dosen/indexuser.php';</script>";
						$now = $syarat['count'] + 1;
						$update = mysql_query("UPDATE alldata set count='$now' where id_dosen='$syaratmasuk'");
					}
					else{
						echo "<script>alert('Gagal login! Anda sudah login 3 kali dalam sehari'); window.location.href='index.php';</script>";
					}
			}
			else{
				echo "<script>alert('Selamat Datang $_SESSION[user_dosen]'); window.location.href='login/dosen/indexuser.php';</script>";
				$now = 1;
				$update = mysql_query("UPDATE alldata set count='$now', logindate='$date' where id_dosen='$syaratmasuk'");
			}
		}	
		else
		{
			echo"<script>alert('Maaf, permintaan anda belum disetujui'); window.location.href='index.php';</script>";
		}
		
	}
	else if($row4==1)
	{
		$_SESSION['user_mhs'] = $_POST['username'];
		$_SESSION['pass_mhs'] = $_POST['password'];
		$syarat = mysql_fetch_array($select4);
		$date = date('Y-m-d');
		$syaratmasuk = $syarat['id_mhs'];
		if($syarat['status'] == "Disetujui"){
			if($syarat['logindate'] == $date){
				if ($syarat['count'] < 1) {
					echo "<script>alert('Selamat Datang $_SESSION[user_mhs]'); window.location.href='login/mhs/indexuser.php';</script>";
						$now = $syarat['count'] + 1;
						$update = mysql_query("UPDATE mhs set count='$now' where id_mhs='$syaratmasuk'");
					}
					else{
						echo "<script>alert('Gagal login! Anda sudah login hari ini'); window.location.href='index.php';</script>";
					}
			}
			else{
				echo "<script>alert('Selamat Datang $_SESSION[user_mhs]'); window.location.href='login/mhs/indexuser.php';</script>";
				$now = 1;
				$update = mysql_query("UPDATE mhs set count='$now', logindate='$date' where id_mhs='$syaratmasuk'");
			}
		}	
		else
		{
			echo"<script>alert('Maaf, permintaan anda belum disetujui'); window.location.href='index.php';</script>";
		}
		
	}
	else{ 
		echo "<script>alert('Anda belum terdaftar'); window.location.href='index.php';</script>";
	}
?>