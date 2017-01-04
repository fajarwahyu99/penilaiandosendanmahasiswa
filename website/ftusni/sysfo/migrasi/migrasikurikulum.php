<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // Fungsi2
  function InsertMK($w) {
    global $strCantQuery;
	$s = "insert into matakuliah (Kode, Nama_Indonesia, Nama_English, KurikulumID,
	  KodeFakultas, KodeJurusan,
	  SKS, SKSTatapMuka, SKSPraktikum, SKSPraktekLap, KodeJenisMK, Sesi, NotActive)
	  values('$w[KodeMK]', '$w[Nama_Indonesia]', '$w[Nama_English]', 0,
	  '$w[KodeFakultas]', '$w[KodeJurusan]',
	  '$w[SKS]', '$w[SKS]', '$w[SKSPT]', '$w[SKSPL]', '$w[NAKUR]', '$w[Sesi]', 'N')";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
  }
  function MigrasiDataKurikulum(){
    $s = "select k.*, m.*
	  from _kur k left join _mk m on m.KodeMK=k.KodeMK order by m.KodeMK";
	$r = mysql_query($s) or die(mysql_error());
	echo "<table class=basic>";
	$nm = array();
	echo "<tr>";
	for ($j=0; $j < mysql_num_fields($r); $j++) {
	  $tmp = mysql_field_name($r, $j);
	  $nm[] = $tmp;
	  echo "<th class=ttl>$tmp</th>";
	}
	echo "</tr>";
	while ($w = mysql_fetch_array($r)) {
	  InsertMK($w);
	  echo "<tr>";
	  for ($i = 0; $i < mysql_num_fields($r) ; $i++) {
	    echo "<td class=lst>" . $w[$nm[$i]] . "</td>";
	  }
	  echo "</tr>";
	}
	echo "</table>";
  }
  // Utama
  DisplayHeader($fmtPageTitle, 'Migrasi Data Kurikulum & Mata Kuliah');
  MigrasiDataKurikulum();
?>