<?php
include"koneksi.php";
$id=$_GET['id'];
$hapus="delete from dosen where id='$id'";
$hasil=mysql_query($hapus);
$hapus2="delete from mata_kuliah where id_dosen='$id'";
$hasil2=mysql_query($hapus2);
if($hapus){
echo"<script>alert('Data Berhasil di Hapus');window.location.href='?module=tabeldosen';</script>";
}?>