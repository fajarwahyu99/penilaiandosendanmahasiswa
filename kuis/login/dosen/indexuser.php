<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dosen</title>
	<link href="style/style.css" type="text/css" rel="stylesheet" />
</head>

<body>

<?php
session_start();
if(!isset($_SESSION['username']))
?>

	<div id="container">
	  <div id="header">
		  		</div>
			
			<div id="sidebar">
				<h3>navigasi</h3>
				<ul id="navmenu">
					<li><a href="indexuser.php" class="<?php if(!isset($_GET['module'])){
						echo selected;}?>">profil 
				
						<?php echo '<strong>'.$_SESSION['user_dosen'].'</strong>';?></a></li>
					<li><a href="?module=daftarmhs#pos" class="<?php if(($_GET['module']==daftarmhs)){
						echo selected;}?>">List Mahasiswa</a></li>
					<li><a href="?module=daftarnilai#pos" class="<?php if(($_GET['module']==daftarnilai)){
						echo selected;}?>">Lihat Nilai</a></li>
					<li><a href="?module=logout#pos" class="<?php if(($_GET['module']==logout)){
						echo selected;}?>">logout</a></li>
			  </ul>
	  </div>
					
					<div id="page">
					<?php if(isset ($_GET['module']))
						include "konten/$_GET[module].php";
						else
						include "konten/home.php";?>
					</div>
					
					<div id="clear"></div>
					
					<div id="footer">
						<p>Punya Dosen&copy; 2015</p>
	  </div>
						
</div>
</body>
</html>