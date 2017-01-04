<?php
  // Author : E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispHeaderByr() {
    echo "<tr><th class=ttl>#</th><th class=ttl>Slip</th><th class=ttl>Tanggal</th><th class=ttl>NIM</th>
	<th class=ttl>Mahasiswa</th><th class=ttl>Pembayaran</th><th class=ttl>Jumlah</th>
	</tr>";
  }
  function DispSubTotal($tot) {
	$_tot = number_format($tot, 0, ',', '.');
	echo "<tr><td class=basic colspan=6 align=right><b>Total: </td><td class=ttl align=right>$_tot</td></tr>";
  }
  function DispDetailTerima($prg, $byr=0, $awal, $akhir) {
    if (!empty($prg)) $_prg = "and m.KodeProgram='$prg'"; else $_prg = '';
	if ($byr == 0) $_byr = ''; else $_byr = "and b.JenisBayar=$byr";
    $s = "select b.*, date_format(b.Tanggal, '%d-%m-%Y') as TGL,
	  m.Name as MHSW, m.KodeProgram, jb.Nama as JNSBYR
	  from bayar b left outer join mhsw m on b.NIM=m.NIM
	  left outer join jenisbayar jb on b.JenisBayar=jb.ID
	  where b.NotActive='N' $_prg $_byr
	  and '$awal 00:00:00' <= b.Tanggal and b.Tanggal <= '$akhir 23:59:59'
	  order by b.JenisBayar";
	$r = mysql_query($s) or die(mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>";
	$_jnsbyr = 0;
	$subtot = 0;
	$grandtot = 0;
	while ($w = mysql_fetch_array($r)) {
	  if ($_jnsbyr != $w['JenisBayar']) {
	    if ($_jnsbyr != 0) DispSubTotal($subtot);
	    $_jnsbyr = $w['JenisBayar'];
		echo "<tr><td class=uline colspan=6><b>$w[JNSBYR]</td></tr>";
		DispHeaderByr();
		$subtot = 0;
	  }
	  $subtot += $w['Jumlah'];
	  $grandtot += $w['Jumlah'];
	  $Jumlah = number_format($w['Jumlah'], 0, ',', '.');
	  echo <<<EOF
	  <tr><td class=lst>$w[ID]</td>
	  <td class=lst>$w[BuktiBayar]</td>
	  <td class=lst>$w[TGL]</td>
	  <td class=lst>$w[NIM]</td>
	  <td class=lst>$w[MHSW]</td>
	  <td class=lst>$w[NamaBayar]</td>
	  <td class=lst align=right>$Jumlah</td>
	  </tr>
EOF;
	}
	DispSubTotal($subtot);
	$_grandtot = number_format($grandtot, 0, ',', '.');
	echo "</table><br>";
	echo "Grand Total: Rp. <b><u>$_grandtot</u></b>";
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['PerPrg'])) $PerPrg = $_REQUEST['PerPrg']; else $PerPrg = '';
  if (isset($_REQUEST['PerJnsByr'])) $PerJnsByr = $_REQUEST['PerJnsByr']; else $PerJnsByr = 0;
  $PerTglAwal = $_REQUEST['PerTglAwal'];
  $PerTglAkhir = $_REQUEST['PerTglAkhir'];
  
  // Bagian Utama
  DisplayHeader($fmtPageTitle, "Laporan Penerimaan");
  if (empty($PerPrg)) $strprg = 'Semua Program'; 
  else {
    $strprg = "$PerPrg - ".GetaField('program', 'Kode', $PerPrg, 'Nama_Indonesia');
  }
  echo "<center><b>Tanggal: $PerTglAwal s/d $PerTglAkhir<br>
    Program: $strprg</b></center>";
  DispDetailTerima($PerPrg, $PerJnsByr, $PerTglAwal, $PerTglAkhir);

?>