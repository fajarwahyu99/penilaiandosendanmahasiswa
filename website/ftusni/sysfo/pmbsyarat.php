<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003


  // *** Fungsi2 ***
  function DispCheckListPMB($sta='') {
    global $strCantQuery;
	if (!empty($sta)) $strsta = "where StatusAwal like '%$sta%'"; else $strsta = '';
	$s = "select * from pmbsyarat $strsta order by Rank";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if ($_SESSION['ulevel'] <=2)
	  echo "<a href='sysfo.php?syxec=pmbsyarat&md=1' class=lst>Tambah Persyaratan</a>";
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Kode</th>
	  <th class=ttl>Nama</th><th class=ttl>Status Mhsw</th><th class=ttl>NA</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  $st = explode(',', $row['StatusAwal']);
	  $strst = '';
	  for ($i=0; $i < sizeof($st); $i++) {
	    if (!empty($st[$i])) $strst .= GetaField('statusawalmhsw', 'Kode', $st[$i], 'Nama') . ', ';
	  }
	  echo <<<EOF
	  <tr><td class=ttl>$row[Rank]</td><td $cls>$row[Kode]</td>
	  <td $cls><a href='sysfo.php?syxec=pmbsyarat&md=0&pid=$row[ID]'>$row[Nama]</a></td>
	  <td $cls>$strst</td><td $cls align=center>$row[NotActive]</td>
	  <td class=lst><a href='sysfo.php?syxec=pmbsyarat&delsya=$row[ID]'><img src='image/del.gif' border=0></a></tr>
EOF;
	}
	echo "</table>";
  }
  function GetCheckList($Stat) {
    global $strCantQuery;
    $s = "select * from statusawalmhsw";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	$jml = mysql_result(mysql_query("select count(*) as jml from statusawalmhsw"), 0, 'jml') +0;
	$res = "<input type=hidden name='jml' value=$jml>";
	while ($row = mysql_fetch_array($r)) {
	  if (strpos($Stat, $row['Kode']) === false) $strck = '';
	  else $strck = 'checked';
	  $res .= "<input type=checkbox name=check[] value='$row[Kode]' $strck>&nbsp;$row[Nama]<br>";
	}
	return $res;
  }
  function DispFormCheckListPMB($md, $pid) {
    global $strCantQuery;
	if ($md == 0) {
	  $s = "select * from pmbsyarat where ID=$pid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) die ("Data tidak ditemukan.");
	  $Rank = mysql_result($r, 0, 'Rank');
	  $Kode = mysql_result($r, 0, 'Kode');
	  $Nama = mysql_result($r, 0, 'Nama');
	  $Stat = mysql_result($r, 0, 'StatusAwal');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $na = 'checked'; else $na = '';
	  $jdl = 'Edit Persyaratan';
	}
	else {
	  $Rank = mysql_result(mysql_query("select Rank from pmbsyarat order by Rank desc limit 1"), 0, 'Rank') +1;
	  $Kode = '';
	  $Nama = ''; $Stat = ''; $na = '';
	  $jdl = 'Tambah Persyaratan';
	}
	$checklist = GetCheckList($Stat);
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='pmbsyarat'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='pid' value='$pid'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Urutan</td><td class=lst><input type=text name='Rank' value='$Rank' size=4 maxlength=3></td></tr>
	<tr><td class=lst>Kode</td><td class=lst><input type=text name='Kode' value='$Kode' size=10 maxlength=10></td></tr>
	<tr><td class=lst>Persyaratan</td><td class=lst><input type=text name='Nama' value='$Nama' size=30 maxlength=50></td></tr>
	<tr><td class=lst>Untuk mahasiswa</td><td class=lst>$checklist</td></tr>
	<tr><td class=lst>Not Active</td><td class=lst><input type=checkbox name='na' value='Y' $na></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcsya' value='Simpan'>&nbsp;
	<input type=reset name='reset' value='Reset'>&nbsp;
	<input type=button name='Batal' value='Batal' onClick="location='sysfo.php?syxec=pmbsyarat&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function GetSyaratPMB($cek, $jml, &$StatusAwal, &$PMBKurang) {
    if (EmptyArray($cek)) {
	  $PMBSyarat = ''; $PMBKurang = $jml;
	}
	else {
	  $r = mysql_query("select * from statusawalmhsw") or die("Tidak dapat menjalankan query.".mysql_error());
	  $sya = '';
	  $PMBKurang = 0;
	  $strcek = '';
	  for ($i=0; $i < $jml; $i++) {
	    if (isset($cek[$i])) $strcek .= "$cek[$i],";
	  }
	  while ($row = mysql_fetch_array($r)) {
	    if (strpos($strcek, $row['Kode']) === false) {}
		else{
		  $sya .= "$row[Kode],";
		  $PMBKurang++;
		}
	  }
	  //echo "asli: $strcek <br> dari fungsi: <b>$sya - $PMBKurang</b><br>";
	  $StatusAwal = $sya;
	  $PMBKurang = $jml - $PMBKurang;
	}
  }
  function PrcSyaratPMB() {
    global $strCantQuery;
    $md = $_REQUEST['md'];
	$pid = $_REQUEST['pid'];
	$Rank = $_REQUEST['Rank'];
	$Kode = $_REQUEST['Kode'];
	$Nama = FixQuotes($_REQUEST['Nama']);
	$cek = $_REQUEST['check'];
	$jml = $_REQUEST['jml'];
	if (isset($_REQUEST['na'])) $na = $_REQUEST['na']; else $na = 'N';
	GetSyaratPMB($cek, $jml, $StatusAwal='', $PMBKurang=0);
	if ($md == 0)
	  $s = "update pmbsyarat set Rank='$Rank', Kode='$Kode', Nama='$Nama', StatusAwal='$StatusAwal', NotActive='$na'
	    where ID=$pid";
	elseif ($md == 1)
	  $s = "insert into pmbsyarat(Rank, Kode, Nama, StatusAwal, NotActive) values
	    ('$Rank', '$Kode', '$Nama', '$StatusAwal', '$na')";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	return -1;
  }
  function DelSyaratPMB($pid=0) {
    mysql_query("delete from pmbsyarat where ID='$pid'");
  }
  function OptStatusAwal($sta='') {
    $opt = GetOption2('statusawalmhsw', 'Nama', 'Nama', $sta, '', 'Kode');
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='pmbsyarat'>
	<tr><td class=lst width=100>Status Mhsw</td>
	<td class=lst><select name='sta' onChange='this.form.submit()'>$opt</select></td></tr>
	</form></table>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['pid'])) $pid = $_REQUEST['pid']; else $pid = 0;
  if (isset($_REQUEST['sta'])) $sta = $_REQUEST['sta']; else $sta = '';
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Setup Persyaratan Penerimaan Mahasiswa");
  if (isset($_REQUEST['prcsya'])) $md = PrcSyaratPMB();
  if (isset($_REQUEST['delsya'])) DelSyaratPMB($_REQUEST['delsya']);
  if ($md == -1) {
    OptStatusAwal($sta);
    DispCheckListPMB($sta);
  }
  else DispFormCheckListPMB($md, $pid);
?>