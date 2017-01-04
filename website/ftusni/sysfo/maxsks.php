<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Oktober 2003
  
  // *** Fungsi2 ***
  function GetJurKolom($kdj='', $act='') {
    $s = "select j.Kode, j.Nama_Indonesia, jp.Nama as JEN
	  from jurusan j left outer join jenjangps jp on j.Jenjang=jp.Kode
	  order by j.Kode";
	$r = mysql_query($s) or die(mysql_error());
	$a = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th></th><th class=ttl>Kode</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Jenjang</th><th></th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($kdj == $w['Kode']) {
	    $img1 = "<img src='image/kanan.gif'>";
		$img2 = "<img src='image/kiri.gif'>";
		$cls = "class=nac";
	  }
	  else {
	    $img1 = ""; $img2 = ""; $cls = "class=lst";
	  }
	  $a .= <<<EOF
	    <tr><td>$img1</td>
		<td $cls><a href='sysfo.php?syxec=$act&kdj=$w[Kode]'>$w[Kode]</a></td>
		<td $cls>$w[Nama_Indonesia]</td>
		<td $cls>$w[JEN]</td><td>$img2</td>
		</tr>
EOF;
	}
	$a .= "</table>";
	return $a;
  }
  function GetMaxSKS($kdj='') {
    if (!empty($kdj)) {
	  $s = "select * from maxsks where KodeJurusan='$kdj' and NotActive='N' order by IPSMin";
	  $r = mysql_query($s) or die(mysql_error());
	  $a = "<a href='sysfo.php?syxec=maxsks&md=1'>Tambah</a><br>
	    <table class=basic cellspacing=0 cellpadding=2>
	    <tr><th class=ttl>Dari IPS</th><th class=ttl>Sampai IPS</th><th class=ttl>Max SKS</th></tr>";
	  while ($w = mysql_fetch_array($r)) {
	    $a .= <<<EOF
		<tr><td class=lst>$w[IPSMin]</td><td class=lst>$w[IPSMax]</td><td class=lst>$w[SKSMax]</td>
		<td class=lst><a href='sysfo.php?syxec=maxsks&sksid=$w[ID]&md=0'>Edit</a></td>
		</tr>
EOF;
	  }
	  return $a . '</table><br>';
	}
	else return '';
  }
  function EditMaxSKS($md, $kdj, $sksid) {
    if ($md == 0) {
	  $arrsks = GetFields('maxsks', 'ID', $sksid, '*');
	  $IPSMin = $arrsks['IPSMin'];
	  $IPSMax = $arrsks['IPSMax'];
	  $SKSMax = $arrsks['SKSMax'];
	  if ($arrsks['NotActive'] == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = 'Edit SKS Max';
	}
	else {
	  $IPSMin = '0.00';
	  $IPSMax = '0.00';
	  $SKSMax = 0;
	  $NA = '';
	  $jdl = 'Tambah SKS Max';
	}
	$sid = session_id();
	$a = <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='maxsks'>
	  <input type=hidden name='md' value="$md">
	  <input type=hidden name='sksid' value='$sksid'>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=uline>IPS Min</td><td class=uline><input type=text name='IPSMin' value='$IPSMin' size=10 maxlength=5</td></tr>
	  <tr><td class=uline>IPS Max</td><td class=uline><input type=text name='IPSMax' value='$IPSMax' size=10 maxlength=5</td></tr>
	  <tr><td class=uline>SKS Max</td><td class=uline><input type=text name='SKSMax' value='$SKSMax' size=10 maxlength=5</td></tr>
	  <tr><td class=uline>Not Active</td><td class=uline><input type=checkbox name='NA' value='Y' $NA></td></tr>
	  <tr><td class=uline colspan=2><input type=submit name='prcmaxsks' value='Simpan'>&nbsp;
	    <input type=reset name='reset' value='Reset'>&nbsp;
		<input type=button name='Batal' value='Batal' onClick="location='sysfo.php?syxec=maxsks&PHPSESSID=$sid'"></td></tr>
	  </form></table>
EOF;
    return $a;
  }
  function PrcMaxSKS ($kdj) {
    $IPSMin = $_REQUEST['IPSMin'];
	$IPSMax = $_REQUEST['IPSMax'];
	$SKSMax = $_REQUEST['SKSMax'];
	$sksid = $_REQUEST['sksid'];
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	$md = $_REQUEST['md'];
	if ($md == 0) {
	  $s = "update maxsks set IPSMin='$IPSMin', IPSMax='$IPSMax', SKSMax='$SKSMax', NotActive='$NA'
	    where ID=$sksid";
	}
	else {
	  $s = "insert into maxsks (KodeJurusan, IPSMin, IPSMax, SKSMax, NotActive)
	    values('$kdj', '$IPSMin', '$IPSMax', '$SKSMax', '$NA')";
	}
	mysql_query($s) or die(mysql_error());
	return -1;
  }

function GetDefSKS($kdj='') {
	if (empty($kdj)) return '';
	else {
		$DefSKS = GetaField('jurusan', 'Kode', $kdj, 'DefSKS') +0;
		$a = <<<EOF
		<table class=box cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='maxsks'>
	  <input type=hidden name='kdj' value='$kdj'>
		<tr><td>Default SKS:</td>
		<td><input type=text name='DefSKS' value='$DefSKS' size=5 maxlength=2>
		<input type=submit name='prcdefsks' value='Simpan'>&nbsp;
		<input type=reset name='reset' value='reset'></td></tr>
		</form></table><br>
EOF;
		return $a;
	}
}
function PrcDefSKS($kdj) {
	$DefSKS = $_REQUEST['DefSKS'] +0;
	$s = "update jurusan set DefSKS='$DefSKS' where Kode='$kdj'";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
}

  // *** Parameter ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
  }
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['sksid'])) $sksid = $_REQUEST['sksid']; else $sksid = 0;
  if (isset($_REQUEST['prcmaxsks'])) $md = PrcMaxSKS($kdj);
  if (isset($_REQUEST['prcdefsks'])) PrcDefSKS($kdj);

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Maksimum SKS yg Dpt Diambil');
  $kiri = GetJurKolom($kdj, 'maxsks');
  if ($md == -1) $kanan = GetDefSKS($kdj).GetMaxSKS($kdj);
  else $kanan = GetDefSKS($kdj).EditMaxSKS($md, $kdj, $sksid);
  echo <<<EOF
    <table class=basic cellspacing=0 cellpadding=2>
	<tr><td valign=top style='border-right: 1px dotted silver'>$kiri</td>
	<td valign=top>$kanan</td></tr>
	</table>
EOF;
?>