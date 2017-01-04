<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net
  
  // *** Fungsi2 ***
  function DispGroupModul($gm='') {
    global $strCantQuery;
	$s = "select * from groupmodul order by GroupModul";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<a href='sysfo.php?syxec=modgroup&md=1' class=lst>Tambah Group</a>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl width=50>ID</th><th class=ttl width=250>Group Modul</th>
	  <th class=ttl width=10>na</th><th class=ttl>&nbsp;</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  echo <<<EOF
	  <tr><td $cls>$row[GroupModulID]</td>
	  <td $cls><a href='sysfo.php?syxec=modmin&gm=$row[GroupModul]'>$row[GroupModul]</a></td>
	  <td $cls align=center>$row[NotActive]</td>
	  <td $cls><a href='sysfo.php?syxec=modgroup&gm=$row[GroupModulID]&md=0'>edt</td>
	  </tr>
EOF;
	}
	echo "</table><br>
	  <font class=ttl><b>edt</b></font><font class=lst> Edit</font>";
  }
  function EditGroupModul($md, $gm) {
    global $strCantQuery;
	if ($md == 0) {
	  $s = "select * from groupmodul where GroupModulID='$gm' limit 1";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) die ("$strCantQuery -2: $s");
	  $GroupModul = mysql_result($r, 0, 'GroupModul');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $na = 'checked'; else $na = '';
	  $jdl = 'Edit Group Modul';
	  $strgm = "<input type=hidden name='gm' value='$gm'>$gm";
	}
	else {
	  $GroupModul = '';
	  $na = '';
	  $jdl = 'Tambah Group Modul';
	  $strgm = "<input type=text name='gm' size=5 maxlength=5> <font color=red>*)</font>";
	}
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='modgroup'>
	<input type=hidden name='md' value='$md'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>ID</td><td class=lst>$strgm</td></tr>
	<tr><td class=lst>Group Modul</td><td class=lst><input type=text name='GroupModul' value='$GroupModul' size=20 maxlength=20></td></tr>
	<tr><td class=lst>NA</td><td class=lst><input type=checkbox name='na' value='Y' $na></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcgm' value='Simpan'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=modgroup&md=-1&PHPSESSID=$sid'"></td></tr>
	</form>
	</table><br>
	<font class=ttl> *) </font><font class=lst>Biarkan kosong untuk penomoran otomatis</font>
EOF;
  }
  function PrcGM() {
    global $fmtErrorMsg, $strCantQuery;
    $md = $_REQUEST['md'];
	$gm = $_REQUEST['gm'];
	$GroupModul = FixQuotes($_REQUEST['GroupModul']);
	if (isset($_REQUEST['na'])) $na = $_REQUEST['na']; else $na = 'N';
	if ($md == 0) {
	  mysql_query("update groupmodul set GroupModul='$GroupModul', NotActive='$na' where GroupModulID='$gm'") or
	    die(DisplayHeader($fmtErrorMsg, 'Tidak dapat mengubah data.<br>'.mysql_error(), 0));
	}
	else {
	  mysql_query("insert into groupmodul (GroupModulID, GroupModul, NotActive)
	  values ('$gm', '$GroupModul', '$na') ") or 
	    die(DisplayHeader($fmtErrorMsg, 'Tidak dapat menambahkan data. Gunakan ID lain.<br>'. mysql_error(), 0));
	}
    return -1;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['gm'])) $gm = $_REQUEST['gm']; else $gm = '';
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Administrasi Group Modul');
  if (isset($_REQUEST['prcgm'])) $md = PrcGM();
  if ($_SESSION['ulevel'] != 1) die (DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
  if ($md == -1) DispGroupModul($gm);
  else EditGroupModul($md, $gm);
?>