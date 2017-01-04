<?php
include"../koneksi/koneksi.php";
$id=$_GET['id'];
$pilih="select * from request where id_client='$id'";
$select = mysql_query($pilih);
$syarat = mysql_fetch_array($select);

$nid = $syarat['id_client'];
$nama = $syarat['nama'];
$user = $syarat['user_client'];
$pass = $syarat['pass_client'];
$email = $syarat['email'];
$matkul = $syarat['matkul'];
$kategori = $syarat['kategori'];

if($syarat['kategori'] == "Mahasiswa"){

$mysql="INSERT INTO mhs
(id_mhs, nama, user_mhs, pass_mhs, status, email, matkul, kategori )
VALUES ('$nid','$nama','$user','$pass','Disetujui','$email','$matkul', '$kategori')";
	
if(!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('data berhasil disetujui');window.location.href='../indexuser.php?module=lihat#pos';</script>";

$hapus="delete from request where id_client='$id'";
$hasil=mysql_query($hapus);
}
else{
	$mysql="INSERT INTO alldata
(id_dosen, nama, user_dosen, pass_dosen, status, email, matkul, kategori )
VALUES ('$nid','$nama','$user','$pass','Disetujui','$email','$matkul', '$kategori')";
	
if(!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('data berhasil disetujui');window.location.href='../indexuser.php?module=lihat#pos';</script>";

$hapus="delete from request where id_client='$id'";
$hasil=mysql_query($hapus);
}
?>