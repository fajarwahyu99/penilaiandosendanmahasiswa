<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>kuis</title>
	<link href="style/style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="container">
	  <div id="header">
		  		</div>
			
			<div id="sidebar">
				<h1>Login</h1>
				<ul id="navmenu">
					
<form action="?module=loginproc#pos" method="post">
  <pre>
  username
  <input type="text" name="username" />
  Password
  <input type="password" name="password" />
  <input type="submit" value="login" />
  
  <a href="?module=formulir#pos" class="<?php if(($_GET['module']==formulir))?>"> Buat akun anda!</a>
  </pre></form>
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
						<p>iskandar LVID &copy2015</p>
	  </div>
						
</div>
</body>
</html>