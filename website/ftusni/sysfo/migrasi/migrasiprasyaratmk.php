<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net
  

  // *** Fungsi2 ***
  function MigrasiPrasyaratMK() {
    $s = "select * from _prasyaratmk order by KodeMK";
	$r = mysql_query($s) or die(mysql_error());
	echo "<ul>";
	while ($w = mysql_fetch_array($r)) {
	  echo "<li><b>$w[KodeMK]</b><br>";
	  for ($i = 1; $i <= 4; $i++) {
	    if (!empty($w["Pra$i"]) && isset($w["Pra$i"])) {
		  $pra = "Pra$i";
		  $IDMK = GetaField('matakuliah', 'Kode', $w['KodeMK'], 'ID');
		  $PraID = GetaField('matakuliah', 'Kode', $w[$pra], 'ID');
		  $sp = "insert into prasyaratmk (IDMK, KodeMK, PraID, PraKodeMK)
		    values ($IDMK, '$w[KodeMK]', $PraID, '$w[$pra]')";
		  $rp = mysql_query($sp) or die(mysql_error());
		  echo "Prasyarat ke-$i : $w[$pra] sudah disisipkan.<br>";
		}
	  }
	}
	echo "</ul>";
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Migrasi Prasyarat Mata Kuliah');
  MigrasiPrasyaratMK();

?>