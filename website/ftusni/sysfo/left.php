<?php
  // Menu Utama
  if (isset($_SESSION['sudahlogin'])) echo "<center><b>".$_SESSION['ulevel'].". ".$_SESSION['uname']."</b></center>";
  DisplayHeader($fmtMenu_header, $strMenu);
  if (isset($_SESSION['sudahlogin'])) {
    DisplayDetail($fmtMenu_item, 'sysfo.php?logout=1', $strLogout);
    DisplayDetail($fmtMenu_item, 'index.php', $strFrontPage);
    //DisplayDetail($fmtMenu_item, 'sysfo.php', "$strFrontPage $strECampus");
    //DisplayDetail($fmtMenu_item, 'sysfo.php?exec=editpref&act=sysfo.php', $strEditPref);
  }
  else {
    DisplayDetail($fmtMenu_item, 'sysfo.php', $strLogin);
  }
  echo $fmtMenu_footer;

  // Display All Menu
  /*
  $_modul = GetModul($_SESSION['ulevel']);
  for ($i=0; $i < count($_modul); $i++) {
    DisplaySubModul($_modul[$i]);
  }
  */

  echo "<hr><center>
    We use GNU/Linux<br>
	<img src='image/linuxpingo.bmp'>
    </center>";
?>