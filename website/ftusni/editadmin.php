<?php
  //Author :  Author: USNI, human@usni.ac.id, Juni 2010

  // *** Bagian Utama ***
  include "lib/table.common.php";
  if ($_SESSION['ulevel'] <> 1) die (DisplayHeader($fmtErrorMsg, $strNotAuthorized));

  if (!isset($_REQUEST['lvl'])) $lvl = 1;
  else $lvl = $_REQUEST['lvl'];
  DisplayHeader($fmtPageTitle, "$strEditSekretaris Fakultas - $strLevel: $lvl");
  if (!isset($_GET['mode'])) $mode = -1;
  else $mode = $_GET['mode'];
  
  if (!isset($_GET['sr'])) $sr = 0;
  else $sr = $_GET['sr'];

  if (!isset($_GET['submit'])) {
    if ($mode == -1) DisplayListofUser($lvl);
    else {
      if (!isset($_GET['Login']) and ($mode==-1)) die 
	    (DisplayHeader($fmtErrorMsg, $strNotAuthorized));
	  $login = $_REQUEST['Login'];
      DisplayEditAdminForm($mode, $login, $lvl);
    }
  }
  else { 
    ProcessEditAdmin($mode);
	DisplayItem($fmtMessage, $strEditAdmin, $strEditAdminSuccess);
	DisplayListofUser($lvl);
  }
?>