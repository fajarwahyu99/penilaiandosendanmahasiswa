<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003, Happy Easter.
  DisplayHeader($fmtPageTitle, 'Statistik Pendaftaran per Asal Sekolah');
  
  if ($_SESSION['sysfo'] != session_id()) die ($strNotAuthorized);

  // *** Bagian Utama ***
  $__h = 4;
  include "lib/table.common.php";
  $_pref = GetPMBPrefix();
  
  $_sj = "select count(*) as Total from pmb where PMBID like '$_pref%'";
  $_rj = mysql_query($_sj) or die("$strCantQuery: $_sj");
  $__tot = mysql_result($_rj, 0, 'Total');

  echo "<table class=basic width=100% cellpadding=2 cellspacing=0>
    <tr><th class=ttl>Nama Institusi</th><th class=ttl>Kota</th>
	<th class=ttl width=50>Jumlah</th></tr>
	<tr><td class=lst colspan=3></td></tr> ";
  // querying
  $_mainsql = "select SchoolType from pmb group by SchoolType";
  $_main = mysql_query($_mainsql) or die("$strCantQuery: $_mainsql");
  
  for ($i=0; $i < mysql_num_rows($_main); $i++) {
    $__Program = mysql_result($_main, $i, 'SchoolType');
	echo "<tr><th class=ttl align=left colspan=3>$__Program</th>
	  </tr>";
	
	// Asal Sekolah
	$_sqlsek = "select count(PMBID) as Jumlah, FromSchool, SchoolCity from pmb 
	  where SchoolType='$__Program' and PMBID like '$_pref%' group by FromSchool";
	$_ressek = mysql_query($_sqlsek) or die("$strCantQuery: $_sqlsek");
	
	while($row = mysql_fetch_array($_ressek)) {
	  echo "<tr>
	    <td class=lst>&nbsp;&nbsp;$row[FromSchool]</td>
		<td class=lst>$row[SchoolCity]</td>
		<td class=lst align=right>$row[Jumlah]</td>
	    </tr>";
	}
	echo "<tr><td class=lst colspan=3 height=4></td></tr>";
  }  
  echo "</table>";
  echo "<p>Total Pendaftar: $__tot</p>";
?>