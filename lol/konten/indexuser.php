<?php

session_start();
if(!isset($_SESSION['username']))
	
?>

SELAMAT DATANG <?php echo'<strong>'.$_SESSION['username'].'</strong>';?><br>

<a href="view.php">Lihat Data ADMINISTRATOR </a><br><br><br>
<a href='?module=logout#pos'>KELUAR</a>