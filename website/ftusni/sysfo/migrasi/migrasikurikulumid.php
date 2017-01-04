<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  

  // *** Fungsi2 ***
  function MasukkanKurikulumID() {
    global $strCantQuery;
	$s = "select * from kurikulum order by KodeJurusan";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  echo "<tr><td class=lst>$w[ID]</td>
	    <td class=lst>$w[Nama]</td>
		<td class=lst>$w[KodeJurusan]</td>
		</tr> ";
	  mysql_query("update matakuliah set KurikulumID=$w[ID] where KodeJurusan='$w[KodeJurusan]'");
	}
	echo "</table>";
  }
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Migrasi Kurikulum, Masukkan ID Kurikulum');
  MasukkanKurikulumID();


?>