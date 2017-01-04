<?php
include "koneksi.php";

$mysql = "INSERT INTO mahasiswa
(nama, username, password) VALUES
('$_POST[nama]', '$_POST[username]', '$_POST[password]')";

if (!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('Sukses Tambah Akun');window.location.href='?module=tabeldosen';</script>";

mysql_close();
?>