<?php
  // Author: E. Setio Dewo
  include "config.ini.php";
  include "cekcookie.php";
  
?>
<HTML>
  <HEAD>
    <TITLE>Print</TITLE>
  </HEAD>
  <?php 
    include "printer.css"; ?>
<BODY onload="javascript:window.print()">

<?php
  include_once "sysfo/sysfo.common.php";
  
  if (isset($_REQUEST['print'])) {
    $print = $_REQUEST['print'];
    include "$print";
  }
  else die (DisplayHeader($fmtErrorMsg, $strNoDataTobePrint));
  
  include "disconnectdb.php";
?>
</BODY>
</HTML>