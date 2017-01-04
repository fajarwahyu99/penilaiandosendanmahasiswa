<?php
  // desc : file utama dalam usniweb
  // author : USNI (human@usni.ac.id)
  // date : Juni 2010

  include "config.ini.php";
  include "cekcookie.php";
  include "menu.php";
  if (isset($_GET['kam'])) {
    $kam = $_GET['kam'];
	WriteCookie('kam', $kam);
  }
  else {
    if (!empty($_COOKIE['kam'])) {
	  $kam = $_COOKIE['kam'];
	  WriteCookie('kam', $kam);
	}
	else $kam = '';
  }
?>

<HTML>
  <HEAD><TITLE>Universitas Satya Negara Indonesia</TITLE>
  <script language="JavaScript" src="CascadeMenu.js"></script>
  <META content="USNI human@usni.co.id" name=author>
  <META content="Universitas Satya Negara Indonesia" name=description>
  </HEAD>
  <?php 
    include "$themedir/main.css"; 
	include "menu.css";
  ?>
	
<BODY <?php echo $body_background; ?>>
  <?php
    if ($exec == 'login.php') DisplayLoginForm('sysfo.php');
	else {
    if ($_SESSION['sysfo'] == SESSION_ID())
	  include "sysfo/index.php";
	else {
	  DisplayItem($fmtMessage, "Selamat datang di e-Campus<br>",
	    "Diperlukan login untuk masuk ke Sistem Informasi Perkuliahan Fakultas Teknik USNI.<br>
		$strMenu : <a href='sysfo.php?exec=login' class=lst>$strLogin</a> |
		<a href='index.php' class=lst>$strFrontPage</a>
	    ");
	}
	}
  ?>
</BODY>

<?php
  include "disconnectdb.php";
?>