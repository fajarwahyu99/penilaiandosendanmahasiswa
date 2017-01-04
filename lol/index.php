<html xmlns="http://wwww.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content="text/html; charset=iso-8859-1"/>
<title>WEB FAJAR</title>

	<link href="style/ce_style.css" type="text/css" rel="stylesheet" />
</head>

<body>

	<div id="page">
<div id="header"></div>
		<div id="cc"><?php if(isset($_GET['module']))
			include"konten/$_GET[module].php";
			else
			include "konten/home.php";?>
		</div>
	
		<div id="cs">
			<h3>Navigasi</h3>
			<ul>
				<li><a href="index.php">HOME</a></li>
				<li><a href="?module=kontak#pos">KONTAK</a></li>
				<li><a href="?module=about#pos">ABOUT</a></li>
			</ul>
		</div>
		
		
			<div id="login"><pre>
<form action="?module=loginproc#pos" method="post">			
USERNAME
<input type="text" name="username"/>

PASSWORD
<input type="password" name="password"/>
<input type="submit" value="LOGIN"/>
</form>
<a href="index2.php"><input type="submit" value="REGISTER"/></a>
</pre>
</div>

		
			<div id="footer">
				<p>&copy; 2015 FAJAR NUGRAHA WAHYU</p>
			</div>

</div>
</body>
</html>