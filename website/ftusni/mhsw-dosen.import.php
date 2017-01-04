<?php
  include "connectdb.php";
  
  echo "<p>Starting conversion</p>";
  $s = "select ID, OldID, Name from dosen order by ID";
  $r = mysql_query($s) or die(mysql_error());
  $i=0; $tot=0;
  while ($arr=mysql_fetch_row($r)) {
    $aid = $arr[0];
	$oid = $arr[1];
	$nma = $arr[2];
	$i++;
	
	$res = mysql_query("update mhsw set DosenID=$aid where K_DOSEN='$oid'") or die(mysql_error());
	$tot = mysql_affected_rows($res);
	echo "$i. $nma, jumlah yang diubah=$tot <br>";
  }
    
  include "disconnectdb.php";


?>