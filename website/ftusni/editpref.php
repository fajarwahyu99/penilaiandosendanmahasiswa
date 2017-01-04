<?php
   //Author : USNI (human@usni.ac.id), Juni 2010
  function DisplayMaxRowForm($link='editpref', $act='index.php') {
    global $strChangeMaxRowTo, $maxrow;
	$optmr = GetNumberOption(10, 100, $maxrow, 10);
    echo "<form action='$act' method=GET>
	  <input type=hidden name='exec' value='$link'>
	  <input type=hidden name='act' value='$act'>
	  <table class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>Baris/Row</th></tr>
	  <tr><td class=lst>$strChangeMaxRowTo</td><td class=lst><select name='maxrow' onChange='this.form.submit()'>$optmr</select></td></tr>
	  </table></form>";
  }
  
  DisplayHeader($fmtPageTitle, $strEditPref);
  include "lib/table.common.php";

  if (isset($_REQUEST['act'])) $act = $_REQUEST['act'];
  else $act = 'index.php';
  if (isset($_GET['submit'])) ProcessEditAdmin(0);
  DisplayEditAdminForm(0, $_SESSION['unip'], $_SESSION['ulevel'], $link='editpref', $act);
  DisplayMaxRowForm('editpref', $act);
?>