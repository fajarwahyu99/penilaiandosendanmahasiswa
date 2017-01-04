<?php
  DisplayHeader($fmtPageTitle, $strDeletingFile);
  $toDelete = $_GET['file'];
  $source_dir = $_GET['source_dir'];
  if (file_exists($toDelete)) {
    unlink($toDelete) or die(DisplayHeader($fmtErroMsg, $strCantDeleteFile));
	DisplayItem($fmtMessage, $strDeletingFile, "<p>$strDeletingFile: 
	<code>$toDelete</code><br>$strDeleteSuccess");
	include "lib/file.common.php";
	DisplayDownloadDir($source_dir);
  }
  else DisplayHeader($fmtErrorMsg, $strFileNotExist);
?>