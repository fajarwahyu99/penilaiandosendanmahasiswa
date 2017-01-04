<?php
include"koneksi.php";

$mysql="INSERT INTO register
(namadepan, namabelakang, username, password, usia, jk, ttl, email, notel) VALUES
('$_POST[namadepan]','$_POST[namabelakang]','$_POST[username]','$_POST[password]','$_POST[usia]','$_POST[jk]','$_POST[ttl]','$_POST[email]','$_POST[notel]')";

if(!mysql_query($mysql))
	die (mysql_error());

echo"<script>alert('Selamat,  anda telah terdaftar');window.location.href='index.php';</script>";

mysql_close();
?>