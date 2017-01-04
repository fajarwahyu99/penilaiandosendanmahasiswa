<?php
unset($_SESSION['username']);
session_destroy();
echo"<script>alert('Anda Berhasil keluar'); window.location.href='http://localhost/kuis/index.php';</script>";
mysql_close();
?>