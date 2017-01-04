<html xmlns="http://wwww.w3.org/1999/xhtml">
<head>
<title>ADMIN</title>

	<link href="style/style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="container">
		<div id="header">
		
		</div>

		<div id="sidebar">
			<h3>navigasi</h3>
			<ul id="navmenu">
				<li><a href="index.php">HOME</a></li>
				<li><a href="?module=kontak#pos">KONTAK</a></li>
				<li><a href="?module=about#pos">ABOUT</a></li>
			</ul>
					<div id="login"><pre>
<form action="?module=loginproc#pos" method="post">			
USERNAME
<input type="text" name="username"/>

PASSWORD
<input type="password" name="password"/>
<input type="submit" value="LOGIN"/>
</form>
<a href="index1.php"><input type="submit" value="REGISTER"/></a>
</pre>
</div>
		</div>
		

			<div id="page">
			<center><h1>Form Input Data</h1>


<form name="input_data" action="insert.php" method="post">
<table border="0" cellpadding="5" cellspacing="0">
    <tbody>
    	<tr>
        	<td>Username</td>
        	<td>:</td>
        	<td><input type="text" name="username" maxlength="20" required="required" /></td>
        </tr>
    	<tr>
        	<td>Password</td>
        	<td>:</td>
        	<td><input type="password" name="password" required="required" /></td>
        </tr>
		<tr>
        	<td>Nama Lengkap</td>
        	<td>:</td>
        	<td><input type="text" name="namalengkap" required="required" /></td>
        </tr>
		<tr>
        	<td>Email</td>
        	<td>:</td>
        	<td><input type="email" name="email" required="required" /></td>
        </tr>
        <tr>
        	<td align="right" colspan="3"><input type="submit" name="submit" value="Simpan" /></td>
        </tr>
    </tbody>
</table>
</form>
<a href="view.php"><input type="submit" value="LIHAT DATA"/></a>
<a href='?module=logout#pos'><input type="submit" value="KELUAR"/></a>
</center>
		</div>

			<div id="clear"></div>
		
			<div id="footer">
				<p>&copy; 2010</p>
			</div>

</div>
</body>
</html>
