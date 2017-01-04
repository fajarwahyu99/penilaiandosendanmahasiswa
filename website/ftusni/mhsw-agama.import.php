<?php
  include "connectdb.php";
  
  $s = "select AgamaID, Agama from agama order by AgamaID";
  $r = mysql_query($s) or die(mysql_error());
  for ($i=0; $i < mysql_num_rows($r); $i++) {
    $aid = mysql_result($r, $i, 'AgamaID');
	$agm = mysql_result($r, $i, 'Agama');
	
	$res = mysql_query("update mhsw set AgamaID=$aid where Agama='$agm'") or die(mysql_error());
	$tot = mysql_num_rows($res);
	echo "$i. $agm, jumlah yang diubah=$tot <br>";
  }
    
  include "disconnectdb.php";


?>