<?php
include "koneksi.php";
$mysql = "INSERT INTO user
(id_user, nama, username, password, email, notel, alamat, status) VALUES
('$_POST[id_user]', '$_POST[nama]','$_POST[username]','$_POST[password]','$_POST[email]','$_POST[notel]','$_POST[alamat]','$_POST[status]')";
if($_POST['status']=="Mahasiswa"){
$tambah_mhs = mysql_query("INSERT INTO mhs (id,nama_mhs) value ('$_POST[id_user]','$_POST[nama]')");}
if(!mysql_query($mysql))
die (mysql_error());
echo"<script>alert('SELAMAT AKUN SUDAH TEREGISTRASI');window.location.href='?module=awal';</script>";
mysql_close();
?>