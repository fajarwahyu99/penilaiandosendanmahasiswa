<?php 
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
  
  function DisplayUploadForm($Destination_dir) {
    global $Max_File_Size, $strFileName, $strMaxSize, $strUploadFile, 
	  $strNotes, $strFileUploadNotes, $strUploadDestination;
	echo "<p>$strUploadDestination: <code>$Destination_dir</code><br>
	  $strMaxSize: <code>$Max_File_Size</code></p>";
    echo "<form enctype='multipart/form-data' method=POST action='index.php'>
      <input type=hidden name='exec' value='doupload'>
	  <input type=hidden name='DestinationDir' value='$Destination_dir'>
	  <input type=hidden name='MAX_FILE_SIZE' value=$Max_File_Size>
      $strFileName: <input type=file name='userfile' size=30><hr>
	  <input type=submit value='$strUploadFile'>
	  </form>";

    echo "<p><b>$strNotes :</b><br>";
    echo "<blockquote>".DisplayHeader($strFileUploadNotes, $Destination_dir,0).
	  "</blockquote></p>";
  }
 
  function DisplayDownloadDir($Source_dir) {
    global $strDirectory, $strFileName, $strDate, $strSize;
	global $fileadmin_level;
    $fl = "";
    $dr = dir ($Source_dir);
    echo "$strDirectory: <b>$Source_dir</b><br>";
    echo "<table class=basic width=100% cellspacing=1 cellpadding=2>
      <tr><th class=ttl colspan=2 align=left>$strFileName</th>
	  <th class=ttl align=left>$strDate</th>
	  <th class=ttl align=right>$strSize</th></tr>";
    while ($isi = $dr->read()) {
      if ($isi != "." and $isi != "..") {
        //echo "$Download_dir$isi<br>";
        $sz = number_format(filesize("$Source_dir$isi"), 0, ',', '.');
	    $dt = date('d-M-y', fileatime("$Source_dir$isi"));
        $fl = "$fl $isi - $sz<br>";
		
		if (strpos($fileadmin_level, $_SESSION['ulevel']) === false)
		  $str_link = "<img src='image/fileshare.gif'>";
		else
		  $str_link = 
		    "<a href='index.php?exec=delete&source_dir=$Source_dir&file=$Source_dir$isi'>
		    <img src='image/filedelete.gif' border=0></a>";
	    echo "<tr><td class=lst width=5>$str_link
	      <td class=lst><a href='./$Source_dir$isi'>$isi</a></td>
		  <td class=lst>$dt</td>
	      <td class=lst align=right>$sz</td></tr>";
	  }
    }
    $dr->close();
    echo "</table>";
  }

?>
