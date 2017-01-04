<html xmlns="http://www.w3.org/199/xhtml">
<head>
<meta http-equiv="Conten-Type" content="text/html; charshet=iso-8859-1"/>
<title>Mia Rahmania</title>
<link href="style/ce_style.css" rel="stylesheet" type="text/css" />
</head>
<?php
	session_start();
	if(isset($_SESSION['username'])){
?>

<body>
<div id="page">
	<div id="header"></div>
	<div id="cc"><?php if(isset($_GET['module']))
			include "kontendosen/$_GET[module].php";
		else
			include "kontendosen/home.php";?></div>
	<div id="cs">
	<ul>
	<li><a href="?module=home">HOME</a></li>
	<li><a href="?module=inputnilai#pos">INPUT NILAI</a></li>
	<li><a href="?module=tabelnilai#pos">TABEL NILAI</a></li>
	<li><a href="logout.php">logout</a><li>
	</ul></div>
	
	<div id="footer">mia rahmania</div>
</div>
</body>

<?php
}else{	
	echo"<script>alert('Halaman gagal dimuat, Silahkan login terlebih dahulu');window.location.href='index.php';</script>";
}
?>
<html>
	