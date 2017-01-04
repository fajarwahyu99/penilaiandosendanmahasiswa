<?php
  DisplayHeader ($fmtPageTitle, $strUploadFile);
  include "lib/file.common.php";
  if (isset($_REQUEST['dir'])) $dir = $_REQUEST['dir'];
  else $dir = $Upload_dir;
  if (substr($dir, -1) != '/' && substr($dir, -1) != '\\') $dir = "$dir/";
  DisplayUploadForm($dir);
?>