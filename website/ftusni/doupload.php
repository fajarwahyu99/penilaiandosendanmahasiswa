<?php
  $the_file = $_FILES['userfile']['name'];
  $tmp_file = $_FILES['userfile']['tmp_name'];
  $ukuran = $_FILES['userfile']['size'];
  $DestinationDir = $_POST['DestinationDir'];
  //echo $ukuran;
  if ($ukuran == 0) {
    DisplayHeader($fmtErrorMsg, "<p>File: <b>$the_file</b><br>
	  $strSize: $ukuran<br>
	  <br>$strZeroFileSize<br>
	  $strOr<br>
	  $strOverLimitFileSize</p>");
  }
  else {
    if (file_exists("$DestinationDir$the_file")) {
      DisplayHeader($fmtErrorMsg, "<p>File: <b>$the_file</b><br>$strFileAlreadyExist</p>");
    }
    else {
      move_uploaded_file($tmp_file, "$DestinationDir$the_file") or die ("$strUploadFailed");
	  DisplayItem($fmtMessage, $strProcessDone,
	    "File: <b>$the_file</b><br>$strUploadSuccess");
    }
  }
  include "lib/file.common.php";
  DisplayUploadForm($DestinationDir);
?>