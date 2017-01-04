<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  

  // *** Fungsi2 ***
function GetFldKewajiban() {
	global $Kali;
  $s = "select * from setupkeuwajib where Kali='$Kali' order by Rank";
	$r = mysql_query($s) or die(mysql_error());
	$hsl = array();
	while ($w = mysql_fetch_array($r)) {
	  $hsl[] = $w['Nama'];
	}
	return $hsl;
}
function GetDispFields($arr, $wd) {
    $ret = '';
    for ($i=0; $i < sizeof($arr); $i++) {
	  $ret .= "<th class=ttl align=center $wd>$arr[$i]</th>";
	  //echo $arr[$i];
	}
	return $ret;
}
function GetKewajiban($nim, $thn, $arr) {
	global $Kali;
  $ret = '';
	for ($i=0; $i < sizeof($arr); $i++) {
	  $tmp = GetaField("biayamhsw", "Tahun='$thn' and NIM='$nim' and NamaBiaya", $arr[$i], "(Kali * Jumlah * Biaya) as TOT");
	  $tmp = NUMI($tmp);
	  $ret .= "<td class=lst align=right>$tmp</td>";
	}
	return $ret;
}
function CetakKewajibanMhsw($PerTahun, $PerJur, $PerPrg) {
  $wd = 'width=85';
  if (empty($PerJur)) $filterjur = ''; else $filterjur = "and m.KodeJurusan='$PerJur'";
  if (empty($PerPrg)) $filterprg = ''; else $filterprg = "and m.KodeProgram='$PerPrg'";
	$ArrField = GetFldKewajiban();
	$DispField = GetDispFields($ArrField, $wd);
	$JmlField = sizeof($ArrField);
    $s = "select k.*
	  from khs k left outer join mhsw m on k.NIM=m.NIM
	  where k.Tahun='$PerTahun' $filterjur $filterprg";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	$nmr = 0;
	$gbia = 0; $gpot = 0; $gbyr = 0; $gtrk = 0; $ghut = 0;
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl rowspan=2>#</th><th class=ttl rowspan=2 $wd>NIM</th>
	  <th class=ttl colspan=$JmlField>Perincian</th>
	  <th class=ttl rowspan=2 $wd>Total Biaya</th>
	  <th class=ttl rowspan=2 $wd>Total Potongan</th>
	  <th class=ttl rowspan=2 $wd>Total Pembayaran</th>
	  <th class=ttl rowspan=2 $wd>Total Penarikan</th>
	  <th class=ttl rowspan=2 $wd>Total Kekurangan</th>
	  </tr>
	  <tr>$DispField</tr>";
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  $wjb = GetKewajiban($w['NIM'], $PerTahun, $ArrField);
	  $tbia = GetaField("biayamhsw", "Tahun='$PerTahun' and Kali=1 and NIM", $w['NIM'], "sum(Kali*Jumlah*Biaya) as TOT");
	  $tpot = GetaField("biayamhsw", "Tahun='$PerTahun' and Kali=-1 and NIM", $w['NIM'], "sum(Kali*Jumlah*Biaya) as TOT");
	  $tbyr = GetaField("bayar", "Tahun='$PerTahun' and Kali=1 and NIM", $w['NIM'], "sum(Kali*Jumlah) as BYR");
	  $ttrk = GetaField("bayar", "Tahun='$PerTahun' and Kali=-1 and NIM", $w['NIM'], "sum(Kali*Jumlah) as BYR");
	  $thut = ($tbia+$tpot)-($tbyr+$ttrk);
	  // grand total
	  $gbia += $tbia;
	  $gpot += $tpot;
	  $gbyr += $tbyr;
	  $gtrk += $ttrk;
	  $ghut += $thut;
	  // Tampilan
	  $sisa = NUMI($thut);
	  $sbia = NUMI($tbia);
	  $spot = NUMI($tpot);
	  $sbyr = NUMI($tbyr);
	  $strk = NUMI($ttrk);
	  
	  echo <<<EOF
	  <tr><td class=nac>$nmr</td>
	  <td class=lst>$w[NIM]</td>
	  $wjb
	  <td class=lst align=right $wd>$sbia</td>
	  <td class=lst align=right $wd>$spot</td>
	  <td class=lst align=right $wd>$sbyr</td>
	  <td class=lst align=right $wd>$strk</td>
	  <td class=lst align=right $wd>$sisa</td>
	  </tr>
EOF;
	}
	$gbia = NUMI($gbia);
	$gpot = NUMI($gpot);
	$gbyr = NUMI($gbyr);
	$gtrk = NUMI($gtrk);
	$ghut = NUMI($ghut);
	$jml = $JmlField +2;
	echo "<tr><td colspan=$jml align=right>Summary:&nbsp;</td>
	  <td class=ttl align=right>$gbia</td>
	  <td class=ttl align=right>$gpot</td>
	  <td class=ttl align=right>$gbyr</td>
	  <td class=ttl align=right>$gtrk</td>
	  <td class=ttl align=right>$ghut</td>";
	echo "</table><br>";
}

function CetakHeaderKewajibanMhsw($PerTahun, $PerJur, $PerPrg) {
	global $Kali;
  if (empty($PerJur)) $strjur = 'Semua Jurusan'; else $strjur = $PerJur;
  if (empty($PerPrg)) $strprg = 'Semua Program'; else $strprg = $PerPrg;
  if ($Kali == 1) $jdl = 'Laporan Kewajiban Mahasiswa';
  elseif ($Kali == -1) $jdl = 'Laporan Potongan Mahasiswa';
	echo <<<EOF
	<center><b>$jdl</b><br>
	Tahun Akademik: <b>$PerTahun</b></center><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=basic>Jurusan :&nbsp;</td><td class=uline>$strjur</td></tr>
	<tr><td class=basic>Program :&nbsp;</td><td class=uline>$strprg</td></tr>
	</table><br>
EOF;
}
function CetakFooterKewajibanMhsw() {
  $tgl = date('d M Y, H:i:s');
	echo "Oleh: $_SESSION[uname], $tgl";
}

// *** Parameter ***
$Kali = GetSetVar('param', 1);
if (isset($_REQUEST['PerJur'])) $PerJur = $_REQUEST['PerJur']; else $PerJur = '';
if (isset($_REQUEST['PerPrg'])) $PerPrg = $_REQUEST['PerPrg']; else $PerPrg = '';
if (isset($_REQUEST['PerTahun'])) $PerTahun = $_REQUEST['PerTahun']; else $PerTahun = '';
if (isset($_REQUEST['PerTglAwal'])) $PerTglAwal = $_REQUEST['PerTglAwal']; else $PerTglAwal = '';
if (isset($_REQUEST['PerTglAkhir'])) $PerTglAkhir = $_REQUEST['PerTglAkhir']; else $PerTglAkhir = '';
  
// *** Bagian Utama ***
CetakHeaderKewajibanMhsw($PerTahun, $PerJur, $PerPrg);
CetakKewajibanMhsw($PerTahun, $PerJur, $PerPrg);
CetakFooterKewajibanMhsw();
?>