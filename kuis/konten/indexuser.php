<?php
session_start();
if(!isset($_SESSION['username']))
?>
<marquee><h3>Selamat Datang <?php echo '<strong>'.$_SESSION['username'].'</strong>';?></h3></marquee> <a href="?module=logout#pos">keluar</a>