<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** Fungsi2 ***
  function DispJenisBayar() {
    global $strCantQuery;
	$s = "select * from jenisbayar order by Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if ($_SESSION['ulevel'] == 1)
	  echo "<a href='sysfo.php?syxec=jnsbyr&md=1' class=lst>Tambah Jenis Pembayaran</a><br>";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>ID</th><th class=ttl>Jenis</th><th class=ttl>Tunai/Bank</th>
	  <th class=ttl>Keterangan</th><th class=ttl>NA</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  if ($row['Tunai'] == 'Y') $cash = 'Tunai'; else $cash = 'Bank';
	  echo <<<EOF
	  <tr><td class=nac>$row[ID]</td><td $cls><a href='sysfo.php?syxec=jnsbyr&md=0&jid=$row[ID]'>$row[Nama]</a></td>
	  <td $cls>$cash</td><td $cls>$row[Keterangan]</td><td $cls>$row[NotActive]</td></tr>
EOF;
	}
	echo "</table>";
  }
  function DispJenisbayarForm($md=0, $jid=0) {
    global $strCantQuery;
	if ($md == 0) {
	  $s = "select * from jenisbayar where ID=$jid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) die("Data tidak ditemukan.");
	  $Nama = mysql_result($r, 0, 'Nama');
	  $Tunai = mysql_result($r, 0, 'Tunai');
	  $Ket = mysql_result($r, 0, 'Keterangan');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = 'Edit Jenis Bayar';
	}
	else {
	  $Nama = ''; $Tunai = 'Y'; $Ket = ''; $NA = '';
	  $jdl = 'Tambah Jenis Bayar';
	}
	$cy = ''; $cn = '';
	if ($Tunai == 'Y') $cy = 'checked'; else $cn = 'checked';
	$sid = session_id();
	echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='jnsbyr'>
	  <input type=hidden name='md' value='$md'>
	  <input type=hidden name='jid' value=$jid>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=lst>Nama</td><td class=lst><input type=text name='Nama' value='$Nama' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Jenis Bayar</td><td class=lst><input type=radio name='Tunai' value='Y' $cy>Tunai &nbsp;
	  <input type=radio name='Tunai' value='N' $cn>Bank</td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst><input type=text name='Ket' value='$Ket' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Tidak Aktif</td><td class=lst><input type=checkbox name='NA' value='Y' $NA></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcjnsbyr' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name='Batal' value='Batal' onClick="location='sysfo.php?syxec=jnsbyr&PHPSESSID=$sid'"></td></tr>
	  </form></table>
EOF;
  }
  function PrcJenisBayar() {
    global $strCantQuery;
	$jid = $_REQUEST['jid'];
    $md = $_REQUEST['md'];
	$Nama = FixQuotes($_REQUEST['Nama']);
	$Tunai = $_REQUEST['Tunai'];
	$Ket = FixQuotes($_REQUEST['Ket']);
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	if ($md == 0) $s = "update jenisbayar set Nama='$Nama', Tunai='$Tunai', Keterangan='$Ket', NotActive='$NA'
	  where ID=$jid";
	else $s = "insert into jenisbayar (Nama, Tunai, Keterangan, NotActive) values
	  ('$Nama', '$Tunai', '$Ket', '$NA')";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	return -1;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Jenis Pembayaran");
  if (isset($_REQUEST['prcjnsbyr'])) $md = PrcJenisBayar();
  if ($md == -1) DispJenisBayar();
  else DispJenisBayarForm($md, $jid);
?>