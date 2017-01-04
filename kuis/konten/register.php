<?php
include "../koneksi/koneksi.php";

$mysql = "INSERT INTO request
(id_client, nama, user_client, pass_client, kategori, email, matkul ) VALUES
 ('$_POST[id_client]','$_POST[nama]','$_POST[user_client]','$_POST[pass_client]','$_POST[kategori]','$_POST[email]','$_POST[matkul]')";

if(!mysql_query($mysql))
die (mysql_error());

echo"<script>alert('Selamat anda telah terdaftar, verifikasi akan dilakukan selama 24 jam, terima kasih');
window.location.href='../index.php';</script>";

mysql_close();
?>