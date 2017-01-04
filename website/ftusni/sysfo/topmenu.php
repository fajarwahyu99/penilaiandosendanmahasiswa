<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003

  $sid = session_id();
  $agent = $_SERVER['HTTP_USER_AGENT'];
  if (strpos($agent, 'Win') === false) $strpos = 'absolute'; else $strpos = 'relative';
  echo "<div style='position: $strpos; height:18;'>";
  include "start.menu.js";
  
  // Display All Menu
  $_modul = GetUserModul();
  $_modul[] = '';
  StartMenu($_modul);
  // Buat menu utama

  for ($i=0; $i < count($_modul)-1; $i++) {
    DisplayMenuItem($_modul[$i]);
  }
  
  DisplayThemeMenu('sysfo.php');
  EndMenu();
  include "end.menu.js";
  echo "</div>";
?>