<?php
include"../koneksi/koneksi.php";
	$id=$_GET['id'];
	$hapus="delete from alldata where id_dosen='$id'";
	$hasil=mysql_query($hapus);
if($hasil){
	echo"<script>alert('data berhasil dihapus');window.location.href='../indexuser.php?module=daftarclient#pos';</script>";
}
?>