<?php
include"../koneksi/koneksi.php";
	$id=$_GET['id'];
	$hapus="delete from mhs where id_mhs='$id'";
	$hasil=mysql_query($hapus);
if($hasil){
	echo"<script>alert('data berhasil dihapus');window.location.href='../indexuser.php?module=daftarmhs#pos';</script>";
}
?>