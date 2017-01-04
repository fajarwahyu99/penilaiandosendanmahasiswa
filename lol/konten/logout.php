<?php
session_start();
unset($_SESSION['username']);

session_destroy();
echo "<script> alert('ANDA BERHASIL KELUAR'); window.location.href='index.php';</script>";
mysql_close();
?>


