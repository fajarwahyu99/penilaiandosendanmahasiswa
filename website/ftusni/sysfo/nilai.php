<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003


  // *** Kumpulan Fungsi ***
  function GetMasterNilai($mni) {
    $s = "select Kode from nilai group by Kode";
	$r = mysql_query($s) or die(mysql_error());
	$opt = "<option></option>";
	while ($w = mysql_fetch_array($r)) {
	  if ($mni == $w['Kode']) $opt .= "<option selected>$w[Kode]</option>";
	  else $opt .= "<option>$w[Kode]</option>";
	}
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='nilai'>
	<tr><td class=lst width=100>Master Nilai</td><td class=lst><select name='mni' onChange='this.form.submit()'>$opt</select></td></tr>
	</form></table>
EOF;
  }
  function DispNilai($mni) {
	$lvl = $_SESSION['ulevel'];
	if ($lvl == 1) $strdel = "<td class=lst><a href='sysfo.php?syxec=nilai&mni=$mni&nid==ID=&del=1'>del</td>";
	else $strdel = '';
	echo "<a href='sysfo.php?syxec=nilai&mni=$mni&md=1'>Tambah Nilai</a>";
	$n = new NewsBrowser;
	$n->query = "select * from nilai where Kode='$mni' order by BatasAtas desc";
	$n->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Nilai</th><th class=ttl>Bobot</th>
	  <th class=ttl>Batas Atas</th><th class=ttl>Batas Bawah</th><th class=ttl>Keterangan</th></tr>";
	$n->detailfmt = "<tr><td class=lst><a href='sysfo.php?syxec=nilai&mni=$mni&md=0&nid==ID=&ni==Nilai='>=Nilai=</a></td>
	  <td class=lst align=right>=Bobot=</td>
	  <td class=lst align=right>=BatasAtas=</td><td class=lst align=right>=BatasBawah=</td>
	  <td class=lst>=Keterangan=</td>$strdel</tr>";
	$n->footerfmt = "</table>";
	echo $n->BrowseNews();
  }
  function FormNilai($md=1, $mni='', $nid=0) {
    global $strCantQuery;
    if ($md==0) {
	  $s = "select * from nilai where ID='$nid' limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $ni = mysql_result($r, 0, 'Nilai');
	  $ba = mysql_result($r, 0, 'BatasAtas');
	  $bb = mysql_result($r, 0, 'BatasBawah');
	  $bt = mysql_result($r, 0, 'Bobot');
	  $ket = mysql_result($r, 0, 'Keterangan');
	  $strni = "<input type=hidden name='ni' value='$ni'>$ni";
	  $jdl = 'Edit Nilai';
	} else { 
	  $strni = "<input type=text name='ni' value='' size=5 maxlength=5>";
	  $ket = '';
	  $ba = 0; $bb = 0; $bt = 0;
	  $jdl = 'Tambah Nilai'; }
	$sid = session_id();
    echo <<<EOF
	  <form name='frmnilai' action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='nilai'>
	  <input type=hidden name='md' value=$md>
	  <input type=hidden name='nid' value=$nid>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>$jdl</th><td class=basic></td></tr>
	  <tr><td class=lst>Master Nilai</td><td class=lst><input type=text name='mni' value='$mni' size=30 maxlength=50></td></tr>
	  <tr><td class=lst>Nilai</td><td class=lst>$strni</td>
	    <td class=basic rowspan=5 valign=bottom align=center><img src='image/tux001.jpg'><br>
		  <input type=submit name='prc' value='Simpan'> 
		  <input type=reset name='reset' value='Reset'>
		  <input type=button name='btl' value='Batal' onClick="location='sysfo.php?syxec=nilai&mni=$mni&PHPSESSID=$sid'">
		  </td></tr>
	  <tr><td class=lst>Bobot</td><td class=lst><input type=text name='bt' value=$bt size=6 maxlength=6></td></tr>
	  <tr><td class=lst>Batas Atas</td><td class=lst><input type=text name='ba' value=$ba size=6 maxlength=6></td></tr>
	  <tr><td class=lst>Batas Bawah</td><td class=lst><input type=text name='bb' value=$bb size=6 maxlength=6></td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst><input type=text name='ket' value='$ket' size=40 maxlength=50></td></tr>
	  </table></form>
EOF;
  }
  function PrcNilai() {
    global $md, $kdf, $fmtErrorMsg;
	$nid = $_REQUEST['nid'];
	$ni = $_REQUEST['ni'];
	$ba = $_REQUEST['ba'];
	$bb = $_REQUEST['bb'];
	$bt = $_REQUEST['bt'];
	$mni = $_REQUEST['mni'];
	$ket = FixQuotes($_REQUEST['ket']);
	if (!empty($ni)) {
	  if ($md == 0) {
	    $s = "update nilai set Kode='$mni', Bobot=$bt, BatasAtas=$ba, BatasBawah=$bb, Keterangan='$ket' where ID='$nid'";
		$r = mysql_query($s) or die("$strCantQuery: $s");
		$md = -1;
	  }
	  else {
	    // Cek dulu ah
		$sc = "select Nilai from nilai where Nilai='$ni' and Kode='$mni'";
		$rc = mysql_query($sc) or die("$strCantQuery: $sc");
		if (mysql_num_rows($rc)==0) {
	      $s = "insert into nilai (Kode, Nilai, Bobot, BatasAtas, BatasBawah, Keterangan)
		    values('$mni', '$ni', $bt, $ba, $bb, '$ket')";
		  $r = mysql_query($s) or die("$strCantQuery: $s");
		  $md = -1;
		} else (DisplayHeader($fmtErrorMsg, "Tidak dapat disimpan. Nilai <b>$ni</b> sudah ada."));
	  }
	} else (DisplayHeader($fmtErrorMsg, 'Tidak dapat disimpan. Ada data yang kurang.'));
  }
  function PrcDel() {
    global $kdf, $strNotAuthorized, $strCantQuery;
	if ($_SESSION['ulevel'] == 1) {
	  $nid = $_REQUEST['nid'];
	  $s = "delete from nilai where ID=$nid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else DisplayHeader($fmtErrorMsg, $strNotAuthorized);
  }

  // *** PARAMETER ***
  if (isset($_REQUEST['mni'])) {
    $mni = $_REQUEST['mni'];
	$_SESSION['mni'] = $mni;
  } else { if (isset($_SESSION['mni'])) $mni = $_SESSION['mni']; else $mni = ''; }

  if (isset($_REQUEST['ni'])) $ni = $_REQUEST['ni']; else $ni = '';
  if (isset($_REQUEST['nid'])) $nid = $_REQUEST['nid']; else $nid = 0;
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Master Nilai');
  if (isset($_REQUEST['prc'])) PrcNilai();
  if (isset($_REQUEST['del'])) PrcDel();
  GetMasterNilai($mni);
  //GetFak($kdf, 'nilai');
  if ($md >= 0) FormNilai($md, $mni, $nid);
  if (!empty($mni)) DispNilai($mni);
?>