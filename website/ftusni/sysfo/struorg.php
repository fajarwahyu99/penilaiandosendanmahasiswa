<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** Fungsi2 ***
  function GetNamaPT() {
    $r = mysql_query("select * from identitas limit 1") or die ('Tabel identitas belum diisi.');
	if (mysql_num_rows($r) > 0) return mysql_result($r, 0, 'Nama');
	else return '';
  }
  function DispOrgMbr($org) {
    if ($_SESSION['ulevel'] == 1) $stred = "<td class=nac><a href='sysfo.php?syxec=struorg&md=0&mid==ID='>=Rank=</a></td>";
	else $stred = '';
    $og = new NewsBrowser;
	$og->query = "select * from orgmbr where OrgID=$org order by Rank";
	$og->headerfmt = "<table class=basic cellspacing=0 cellpadding=2 bgcolor=white>";
	$og->detailfmt = "<tr>$stred
	  <td class=uline>=Jabatan=</td><td width=3>:</td><td class=uline>=Nama=</td></tr>";
	$og->footerfmt = "</table><br>";
	echo $og->BrowseNews();
  }
  function DispStrukturOrg() {
    global $strCantQuery;
	$s = "select * from org order by ID";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	while ($row = mysql_fetch_array($r)) {
	  $id = $row['ID'];
	  echo "<table class=ttl cellspacing=0 cellpadding=2 width=100%><tr><td><b>$row[Nama]</b></td></tr></table>";
	  DispOrgMbr($id);
	}
  }
  function DispStruForm($md, $mid) {
    global $strCantQuery;
    if ($md == 0) {
	  $s = "select * from orgmbr where ID=$mid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $org = mysql_result($r, 0, 'OrgID');
	  $nme = mysql_result($r, 0, 'Nama');
	  $jbt = mysql_result($r, 0, 'Jabatan');
	  $rnk = mysql_result($r, 0, 'Rank');
	  $jdl = 'Edit Anggota';
	}
	else {
	  $org = 0;
	  $nme = '';
	  $jbt = '';
	  $rnk = 0;
	  $jdl = 'Tambah Anggota';
	}
    $opt = GetOption2('org', 'Nama', 'ID', $org, '', 'ID');
	$sid = session_id();
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='struorg'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='mid' value='$mid'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Organisasi</td><td class=lst><select name='org'>$opt</select></td></tr>
	<tr><td class=lst>Jabatan</td><td class=lst><input type=text name='jbt' size=40 maxlength=100 value='$jbt'></td></tr>
	<tr><td class=lst>Nama</td><td class=lst><input type=text name='nme' size=40 maxlength=100 value='$nme'></td></tr>
	<tr><td class=lst>Urutan</td><td class=lst><input type=text name='rnk' size=3 maxlength=3 value='$rnk'></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcmbr' value='Simpan'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=struorg&PHPSESSID=$sid'">&nbsp;
	  <input type=button name='del' value='Hapus' onClick="location='sysfo.php?syxec=struorg&del=$mid&PHPSESSID=$sid'">
	</td></tr>
	</form></table>
EOF;
  }
  function PrcMbr() {
    global $strCantQuery;
	$org = $_REQUEST['org'];
	$jbt = FixQuotes($_REQUEST['jbt']);
	$nme = FixQuotes($_REQUEST['nme']);
	$rnk = FixQuotes($_REQUEST['rnk']);
	$md = $_REQUEST['md'];
	if ($md == 0) {
	  $mid = $_REQUEST['mid'];
	  $s = "update orgmbr set OrgID=$org, Nama='$nme', Jabatan='$jbt', Rank='$rnk' where ID=$mid";
	}
	else {
	  $s = "insert into orgmbr (OrgID, Nama, Jabatan, Rank) values ($org, '$nme', '$jbt', '$rnk')";
	}
	$r = mysql_query($s) or die ("$strCantQuery: $s <br>".mysql_error());
	return -1;
  }
  function DelMbr($mid) {
    $r = mysql_query("delete from orgmbr where ID=$mid");
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['mid'])) $mid = $_REQUEST['mid']; else $mid = 0;
  
  // *** Bagian Utama ***
  $nmpt = GetNamaPT();
  DisplayHeader($fmtPageTitle, "Struktur Organisasi $nmpt");
  if (isset($_REQUEST['prcmbr'])) $md = PrcMbr();
  if (isset($_REQUEST['del'])) DelMbr($_REQUEST['del']);
  if ($md == -1 && $prn == 0 && $_SESSION['ulevel'] == 1)
    echo "<a href='sysfo.php?syxec=struorg&md=1' class=lst>Tambah Anggota</a><br>";
  if ($md != -1 && $_SESSION['ulevel'] == 1) DispStruForm($md, $mid);
  if ($md == -1 && !empty($nmpt)) DispStrukturOrg();
?>