<?php
include "koneksi.php";

$mysql = "INSERT INTO mata_kuliah
(id_dosen, pelajaran, jam, tempat) VALUES
('$_POST[id_dosen]', '$_POST[pelajaran]', '$_POST[jam]', '$_POST[tempat]')";

if (!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('Sukses Tambah Akun');window.location.href='?module=tabelmatakuliah';</script>";

mysql_close();
?>