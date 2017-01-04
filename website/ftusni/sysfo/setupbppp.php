<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  // Versi 2: pengganti setupbppp.old.php


  // *** Fungsi2 ***
function GetBPPKiri($nma='') {
  global $strCantQuery;
  if (!empty($_SESSION['thn'])) $strwhr = "where Tahun='$_SESSION[thn]'"; else $strwhr = '';
	$s = "select * from bpppokok $strwhr group by Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th></th><th class=ttl>Tahun</th><th class=ttl>Nama</th><th class=ttl>lihat</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Nama'] == $nma) {
	    $cls = 'class=nac'; 
		  $blti = "<img src='image/kanan.gif' border=0>";
		  $blta = "<img src='image/kiri.gif' border=0>";
	  }
	  else {
	    $cls = 'class=uline';
		  $blti = ''; $blta = '';
	  }
	  $a .= "<tr><td>$blti</td>
	    <td $cls>$w[Tahun]</td>
	    <td $cls>$w[Nama]</td>
	    <td $cls align=center><a href='sysfo.php?syxec=setupbppp&nma=$w[Nama]&thn=$w[Tahun]&ID=$w[ID]'><img src='image/wajik.gif' border=0 title='Edit'></a></td>
		<td>$blta</td></tr>
	  ";
	}
	return $a . "</table>";
}
function GetBPPKanan($thn='', $nma='') {
  global $strCantQuery;
	$s = "select * from bpppokok where Tahun='$thn' and Nama='$nma' order by MinSKS";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = "<a href='sysfo.php?syxec=setupbppp&mda=1&nma=$nma'>Tambah Biaya BPP Pokok</a><br>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Edit</th><th class=ttl>Dari<br>SKS</th><th class=ttl>Sampai<br>SKS</th>
	  <th class=ttl colspan=2>Biaya</th><th class=ttl>NA</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=uline';
	  $w['Biaya'] = number_format($w['Biaya'], 0, ',', '.');
	  $a .= "<tr>
	    <td $cls align=center><a href='sysfo.php?syxec=setupbppp&mda=0&bpd=$w[ID]&nma=$nma'><img src='image/edit.png' border=0 title='Edit'></a></td>
	    <td $cls>$w[MinSKS]</td><td $cls>$w[MaxSKS]</td>
	    <td $cls>Rp.</td><td $cls>$w[Biaya]</td>
		  <td $cls align=center><img src='image/book$w[NotActive].gif' border=0></td>
		  </tr>";
	}
	return $a . "</table>";
}

  function GetNamaBPP($nma) {
    $r = mysql_query("select Nama from bpppokok group by Nama") or die('Tidak dapat menjalankan query');
	$a = "<option value=''></option>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Nama'] == $nma) $a .= "<option value='$w[Nama]' selected>$w[Nama]</option>";
	  else $a .= "<option value='$w[Nama]'>$w[Nama]</option>";
	}
	return $a;
}
function BPPForm($mda, $thn='', $nma='', $bpd=0) {
  global $strCantQuery;
	if ($mda == 0) {
	  $s = "select * from bpppokok where ID=$bpd limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $nma = mysql_result($r, 0, 'Nama');
	  $thn = mysql_result($r, 0, 'Tahun');
	  $MinSKS = mysql_result($r, 0, 'MinSKS');
	  $MaxSKS = mysql_result($r, 0, 'MaxSKS');
	  $Biaya = mysql_result($r, 0, 'Biaya');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = 'Edit BPP Pokok';
	}
	else {
		$nma = '';
	  $MinSKS = 0;
	  $MaxSKS = 0;
	  $Biaya = 0;
	  $NA = '';
	  $jdl = 'Tambah BPP Pokok';
	}
	$opt = GetNamaBPP($nma);
	$sid = session_id();
	$a = <<<EOF
	<table class=basic cellspacing=0 cellpadding=1>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='setupbppp'>
	<input type=hidden name='mda' value=$mda>
	<input type=hidden name='bpd' value=$bpd>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=uline>Nama BPP Pokok</td><td class=uline><input type=radio name='pki' value='Y' checked>
	  <select name='nma'>$opt</select></td></tr>
	<tr><td class=uline>Nama BPP Pokok baru</td><td class=uline><input type=radio name='pki' value='N'>
	  <input name='nma1' value='$nma' size=35 maxlength=50></td></tr>
	<tr><td class=uline>Tahun</td><td class=uline><input type=text name='thn' value='$thn'></td></tr>
	<tr><td class=uline>Dari SKS</td><td class=uline><input type=text name='MinSKS' value=$MinSKS size=5 maxlength=5></td></tr>
	<tr><td class=uline>Sampai SKS</td><td class=uline><input type=text name='MaxSKS' value=$MaxSKS size=5 maxlength=5></td></tr>
	<tr><td class=uline>Biaya</td><td class=uline><input type=text name='Biaya' value=$Biaya size=15 maxlength=20></td></tr>
	<tr><td class=uline>Tidak Aktif</td><td class=uline><input type=checkbox name='NA' value='Y' $NA></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcbppp' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name=batal value='Batal' onClick='location="sysfo.php?syxec=setupbppp&nma=$nma&PHPSESSID=$sid"'></td></tr>
	</form></table>
EOF;
  return $a;
}
function PrcBPPP() {
  $mda = $_REQUEST['mda'];
	$nma = $_REQUEST['nma'];
	$bpd = $_REQUEST['bpd'];
	$pki = $_REQUEST['pki'];
	$thn = $_REQUEST['thn'];
	if ($pki == 'Y') $Nama = $nma; else $Nama = $_REQUEST['nma1'];
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	$MinSKS = $_REQUEST['MinSKS'];
	$MaxSKS = $_REQUEST['MaxSKS'];
	$Biaya = $_REQUEST['Biaya'];
	if ($mda == 1) $s = "insert into bpppokok(Tahun, Nama, MinSKS, MaxSKS, Biaya, NotActive) values
	  ('$thn', '$Nama', $MinSKS, $MaxSKS, $Biaya, '$NA')";
	else $s = "update bpppokok set Tahun='$thn', Nama='$Nama', MinSKS=$MinSKS, MaxSKS=$MaxSKS, Biaya=$Biaya,
	  NotActive='$NA' where ID=$bpd";
	$r = mysql_query($s) or die("$s");
	return -1;
}
function DispBPPPThn($thn='') {
	global $prn;
	if ($prn == 0) {
	  echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='setupbppp'>
	  <tr><td class=uline>Tahun</td><td class=uline><input type=text name='thn' value='$thn' size=7 maxlength=5>
	  <input type=submit name='prcbpppthn' value='Refresh'></td></tr>
	  </form></table><br>
EOF;
  }
  else {
	  echo "Tahun: <b>$thn</b><br>";
  }
}
  
  // *** Parameter2 ***
$thn = GetSetVar('thn', '');
  if (isset($_REQUEST['mdi'])) $mdi = $_REQUEST['mdi']; else $mdi = -1;
  if (isset($_REQUEST['mda'])) $mda = $_REQUEST['mda']; else $mda = -1;
  if (isset($_REQUEST['nma'])) $nma = $_REQUEST['nma']; else $nma = '';
  if (isset($_REQUEST['bpd'])) $bpd = $_REQUEST['bpd']; else $bpd = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Setup BPP Pokok');
  DispBPPPThn($thn);
  if (isset($_REQUEST['prcbppp'])) $mda = PrcBPPP();
  if ($mdi == -1) $ki = GetBPPKiri($nma);
  if ($mda == -1) $ka = GetBPPKanan($thn, $nma);
  else $ka = BPPForm($mda, $thn, $nma, $bpd);
  echo <<<EOF
  <table class=basic cellspacing=0 cellpadding=2>
  <tr><td class=basic style='border-right:1px solid silver' valign=top>$ki</td>
  <td class=basic valign=top>$ka</td></tr>
  </table>
EOF;
?>