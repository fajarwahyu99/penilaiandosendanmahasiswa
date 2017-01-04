<?php 
	session_start();
	session_destroy();
	echo "<script>alert('Anda Berhasil Keluar');window.location.href='../index.php';</script>";
 ?>