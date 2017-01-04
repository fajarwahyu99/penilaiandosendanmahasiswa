<?php
include "koneksi.php";

$mysql = "INSERT INTO dosen
(nama, username, password, alamat, email, notel) VALUES
('$_POST[nama]', '$_POST[username]', '$_POST[password]', '$_POST[alamat]', '$_POST[email]', '$_POST[notel]')";

if (!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('Sukses Tambah Akun, Anda Baru Bisa Login Setelah Di Setujui Admin');window.location.href='?module=home';</script>";

mysql_close();
?>