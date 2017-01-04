<?php
  DisplayHeader($fmtPageTitle, 'Fakultas');

  function PrintDisplayFakultas() {
    global $strCantQuery;
	$_sfak = "select Kode, Nama_Indonesia from fakultas";
	$_rfak = mysql_query($_sfak) or die("$strCantQuery: $_sfak");
	if (mysql_num_rows($_rfak)==0) die ("Tidak ada data");
	
	echo "<table class='basic' cellspacing=0 cellpadding=1 width=100%>";
	for ($i=0; $i < mysql_num_rows($_rfak); $i++) {
	  $kd = mysql_result($_rfak, $i, 'Kode');
	  $nm = mysql_result($_rfak, $i, 'Nama_Indonesia');
	  echo "<tr><th class='menuheader'>$kd</th><th class='menuheader'>Fakultas $nm</th>
	    <th class='menuheader'>na</td></tr>";
	  $sql = "select * from jurusan where KodeFakultas='$kd' order by Rank";
	  
	  $jrs = new newsbrowser;
	  $jrs->query = $sql;
	  $jrs->headerfmt = "";
	  $jrs->detailfmt = "<tr><td class='whitebackground'>=Kode=</td><td class='whitebackground'>=Nama_Indonesia=</td>
	    <td class='whitebackground' align=center>=NotActive=</td></tr>";
	  $jrs->footerfmt = "<tr class='whitebackground'><td colspan=2 height=2></td></tr>";
	  echo $jrs->BrowseNews();
	}
	echo "</table>";
  }
  
  PrintDisplayFakultas();
?>