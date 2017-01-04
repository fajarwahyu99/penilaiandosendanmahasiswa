<?php
include"koneksi.php";
$id=$_GET['id'];
$hapus="delete from wilayah_kel where id_wilayahkel='$id'";
$hasil=mysql_query($hapus);
if($hasil){
echo"<script>alert('Data Berhasil Dihapus');window.location.href='indexAdmin.php?module=rekap';</script>";
}?>