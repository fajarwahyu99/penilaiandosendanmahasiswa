<html xmlns="http://www.w3.org/199/xhtml">
<head>
<meta http-equiv="Conten-Type" content="text/html; charshet=iso-8859-1"/>
<title>Mia Rahmania</title>
<link href="style/ce_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
	<div id="header"></div>
	<div id="cc"><?php if(isset($_GET['module']))
			include "konten/$_GET[module].php";
		else
			include "konten/home.php";?></div>
	<div id="cs">
	<ul>
	<li><a href="?module=home">HOME</a></li>
	<li><a href="?module=tambahdosen">TAMBAH DOSEN</a></li>
	<li><a href="?module=tabeldosen#pos">TABEL DOSEN</a></li>
	<li><a href="?module=tambahmatkul#pos">TAMBAH MATA KULIAH</a></li>
	<li><a href="?module=tabelmatakuliah#pos">TABEL MATA KULIAH</a></li>
	<li><a href="logout.php">LOGOUT</a><li>
	</ul></div>
	
	<div id="footer">mia rahmania</div>
</div>
</body>
<html>
	