<?php
include"../formuin/koneksi.php";
$id=$_GET['id'];
$hapus="delete from register where id='id' ";
$hasil=mysql_query($hapus);
if($hasil){
	echo"<script>alert('DATA BERHASIL DIHAPUS');window.location.href='lihat.php';</script>";
}?>