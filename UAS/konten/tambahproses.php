<?php
include "koneksi.php";
$mysql= "INSERT INTO user
(id_user, nama, username, password, email, status) VALUES
('$_POST[id_user', '$_POST[nama]','$_POST[username]','$_POST[password]','$_POST[email]','$_POST[status]')";
if{$_POST['status']=="Mahasiswa"){
$tambah_mhs = mysql_query("INSERT INTO mhs (id,nama_mhs) value ($_POST[id_user]','$_POST[nama]')");}
if(!mysql_query($mysql))
die (mysql_error());
echo"<script>alert(Selamat, Akun Tersebut Sudah Bisa Digunakan');window.location.href='?module=home';</script>";
mysql_close();
?>