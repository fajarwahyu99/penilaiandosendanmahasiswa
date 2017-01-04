<html xmlns="http://www.w3.org/199/xhtml">
<head>
<meta http-equiv="Conten-Type" content="text/html; charshet=iso-8859-1"/>
<title>FAJAR NUGRAHA</title>
<link href="style/ce_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="page">
	<div id="header">
	</div>
	<div id="cc"><?php if(isset($_GET['module']))
			include "home/$_GET[module].php";
		else
			include "home/home.php";?></div>
	<div id="cs">
		<ul>
		<li><a href="?module=home">LOGIN</a></li>
		<li><a href="?module=tambahdosen">REGISTER DOSEN</a></li>
		<li><a href="?module=tambahmhs">REGISTER MAHASISWA</a></li>
		</ul>
	</div>
		
	<div id="footer">mia rahmania</div>
</div>
</body>
<html>
	