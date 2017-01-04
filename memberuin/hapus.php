<?php 

	include "koneksi.php";
	$id=$_GET['id'];
	$hapus= "DELETE FROM register WHERE id='$id'";
	$hasil = mysql_query($hapus);

	if($hapus){
		echo "<script> alert('data berhasil di hapus'); window.location.href='module/lihat.php'; </script>";
	}
 ?>