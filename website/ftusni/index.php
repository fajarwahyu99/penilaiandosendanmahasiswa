<?php
   //desc : file utama dalam usniweb
   //author : USNI (human@usni.ac.id)
   //date : Juni 2010

  include "config.ini.php";
  include "cekcookie.php";
  include "menu.php";
?>

<HTML>
  <HEAD><TITLE>Universitas Satya Negara Indonesia</TITLE>
  <META content="USNI human@usni.ac.id" name=author>
  <META content="Universitas Satya Negara Indonesia" name=description>

  <?php 
    include "$themedir/main.css"; 
	include "menu.css";
  ?>
  </HEAD>
<BODY <?php echo $body_background; ?>>
  <?php 
	include "$themedir/index.php"; 
  ?>
</BODY>

<?php
  include "disconnectdb.php";
?>