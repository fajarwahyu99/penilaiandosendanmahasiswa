<?php
  DisplayHeader($fmtPageTitle, $strDownload);
  include "lib/file.common.php";
  if (isset($_REQUEST['dir'])) $dir = $_REQUEST['dir'];
  else $dir = $Download_dir;
  if (substr($dir, -1) != '/' && substr($dir, -1) != '\\') $dir = "$dir/";
  DisplayDownloadDir($dir);
?>
