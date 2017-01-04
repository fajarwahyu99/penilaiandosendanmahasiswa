<?php
	session_start();
	if(isset($_SESSION['username'])){
?>
<h1>Selamat Datang <?php echo"<strong>$_SESSION[username]</strong>"; ?> </h1> <?php }?> 


<div id="Top_menu">
        <a class="home" href="index.php?module=home"><span>HOME</span></a>
        <a class="help" href="#"><span>ABOUT</span></a>
		<a href="index.php?module=akundosen"><span>DOSEN</span></a>
		<a href="index.php?module=akunmhs"><span>MAHASISWA</span></a>
		<a href="index.php?module=tambahmatkul"><span>KULIAH</span></a>
        
        <a href="index.php?module=logout"><span>LOGOUT</span></a>
</div>