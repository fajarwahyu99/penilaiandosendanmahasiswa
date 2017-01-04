<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** FUngsi2 ***
  function DispFromTo($from, $to, $act) {
    global $prn;
	if (!isset($prn)) $prn = 0;
	$af = explode('-', $from);
	$fy = GetNumberOption(1992, 2010, $af[0]);
	$fm = GetNumberOption(1, 12, $af[1]);
	$fd = GetNumberOption(1, 31, $af[2]);
	$at = explode('-', $to);
	$ty = GetNumberOption(1992, 2010, $at[0]);
	$tm = GetNumberOption(1, 12, $at[1]);
	$td = GetNumberOption(1, 31, $at[2]);
	if ($prn == 0)
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><th class=ttl colspan=2>Tanggal Laporan</th><tr>
	  <tr><td class=lst>Dari tanggal</td><td class=lst><select name='fd'>$fd</select>&nbsp;<select name='fm'>$fm</select>&nbsp;<select name='fy'>$fy</select></td></tr>
	  <tr><td class=lst>Sampai tanggal</td><td class=lst><select name='td'>$td</select>&nbsp;<select name='tm'>$tm</select>&nbsp;<select name='ty'>$ty</select></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='go' value='Buat Laporan'></td></tr>
	  </form></table>
EOF;
    else {
	  $af = explode('-', $from);
	  $at = explode('-', $to);
	  $tf = $af[2].'-'.$af[1].'-'.$af[0];
	  $tt = $at[2].'-'.$at[1].'-'.$at[0];
	  echo "<p><center><b>Dari tanggal $tf sampai $tt</b></center></p>";
	}
  }
  function LapTerima($from, $to) {
    global $strCantQuery, $prn;
	if (!isset($prn)) $prn = 0;
	$s = "select b.*, date_format(b.Tanggal, '%d-%m-%Y') as tgl, m.Name, jb.Nama as JENBYR
	  from bayar b left outer join mhsw m on b.NIM=m.NIM
	  left outer join jenisbayar jb on b.JenisBayar=jb.ID
	  where b.Tanggal >= '$from 00:00:00' and '$to 23:59:59' >= b.Tanggal
	  order by b.Tanggal, b.NIM";
	$r = mysql_query($s) or die("$strCantQuery: $s <br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl># Trx</th>
	  <th class=ttl>Tanggal</th><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th><th class=ttl>Pembayaran</th>
	  <th class=ttl>Jenis Bayar</th><th class=ttl>Jml Bayar</th><th class=ttl>Denda</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['Denda'] == 'Y') {
	    $clsd = 'class=lst'; 
	  }else {
	    $clsd = 'class=lst';
	  }
	  $jml = number_format($row['Kali'] * $row['Jumlah'], 2, ',', '.');
	  $dnd = number_format(($row['HariDenda']-$row['HariBebas']) * $row['HargaDenda'], 2, ',', '.');
	  echo <<<EOF
	  <tr><td class=lst>$row[ID]</td>
	  <td class=lst>$row[tgl]</td><td class=lst>$row[NIM]</td><td class=lst>$row[Name]</td>
	  <td class=lst>$row[NamaBayar]</td>
	  <td class=lst>$row[JENBYR] - $row[BuktiBayar]</td>
	  <td class=lst align=right>$jml</td>
	  <td $clsd align=right>$dnd</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
  }
  function RekapTerima($from, $to) {
    global $strCantQuery;
	$s = "select sum(Kali*Jumlah) as BYR, sum((HariDenda-HariBebas)*HargaDenda) as DND
	  from bayar where Tanggal >= '$from 00:00:00' and '$to 23:59:59' >= Tanggal";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$byr = mysql_result($r, 0, 'BYR');
	if (empty($byr)) $byr = 0;
	$dnd = mysql_result($r, 0, 'DND');
	if (empty($dnd)) $dnd = 0;
	$tot = $byr + $dnd;
	$byr = number_format($byr, 2, ',', '.');
	$dnd = number_format($dnd, 2, ',', '.');
	$tot = number_format($tot, 2, ',', '.');
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=ttl>Total Pembayaran</td><td class=lst align=right>$byr</td></tr>
	<tr><td class=ttl>Total Denda</td><td class=lst align=right>$dnd</td></tr>
	<tr><td class=lst>Grand Total</td><td class=ttl align=right>$tot</td></tr>
	</table>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['go'])) {
    $go = $_REQUEST['go'];
	$fy = $_REQUEST['fy']; $fm = $_REQUEST['fm']; $fd = $_REQUEST['fd'];
	$ty = $_REQUEST['ty']; $tm = $_REQUEST['tm']; $td = $_REQUEST['td'];
	$from = "$fy-$fm-$fd";
	$to = "$ty-$tm-$td";
	$_SESSION['from'] = $from;
	$_SESSION['to'] = $to;
  } else {
    unset($go);
	if (isset($_SESSION['from']) && isset($_SESSION['to'])) {
	  $from = $_SESSION['from'];
	  $to = $_SESSION['to'];
	}
	else {
	  $from = date('Y').'-'.date('m').'-'.date('d');
	  $to = date('Y').'-'.date('m').'-'.date('d');
	}
  }
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Laporan Penerimaan');
  DispFromTo($from, $to, 'lappterima');
  if (isset($go)) {
	if ($prn == 0) {
	  $sid = session_id();
	  SimplePrinter("print.php?print=sysfo/lappterima.php&fy=$fy&fm=$fm&fd=$fd&ty=$ty&tm=$tm&td=$td&prn=1&go=1&PHPSESSID=$sid", "Cetak Laporan");
	}
    LapTerima($from, $to);
	RekapTerima($from, $to);
  }
?>