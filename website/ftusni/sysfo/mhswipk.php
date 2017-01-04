<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
  function FormAddSesi($nim) {
	if ($_SESSION['ulevel']==3 && $_SESSION['uid']==$did || $_SESSION['ulevel']==1) {
      $ssi = mysql_result(mysql_query("select max(Sesi) as ssi from khs where NIM='$nim'"), 0, 'ssi')+1;
	  $maxsks = GetMaxSKSMhsw($nim);
	  echo "<table class=basic cellspacing=1 cellpadding=2>
	    <form action='sysfo.php' method=POST>
		<input type=hidden name='syxec' value='mhswipk'>
		<input type=hidden name='nim' value='$nim'>
		<tr><th class=ttl colspan=6>Tambah Sesi Baru</th><td class=basic></td></tr>
		<td class=ttl>Tahun Ajaran</td><td class=lst><input type=text name='thn' value='' size=5 maxlength=5></td>
		<td class=ttl>Sesi/Semester</td><td class=lst><input type=text name='ssi' value='$ssi' size=5 maxlength=5></td>
		<td class=ttl>Max SKS</td><td class=lst><input type=text name='maxsks' value='$maxsks' size=5 maxlength=5></td>
		<td class=basic rowspan=2><input type=submit name='prcaddssi' value='Tambah'></td></tr>
		</form></table><br>";
	}
  }
  function GoRekapKHS($nim) {
    global $strCantQuery;
	FormAddSesi($nim);
	$s = "select k.*, m.DosenID, sm.Nama as STA, sm.Nilai as ACTIVE
	  from khs k inner join mhsw m on k.NIM=m.NIM
	  left outer join statusmhsw sm on k.Status=sm.Kode
	  where k.NIM='$nim' order by k.Tahun";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>Tahun<br>Ajaran</th>
	  <th class=ttl>Master<br>Biaya</th>
	  <th class=ttl>Sesi</th><th class=ttl>Max SKS</th>
	  <th class=ttl>Status Mhsw</th>
	  <th class=ttl>Juml.<br>MK</th><th class=ttl>Juml.<br>SKS</th><th class=ttl>Nilai<br>Total</th>
	  <th class=ttl>Bobot</th><th class=ttl>IPS</th>
	  </tr>	";
	while ($row = mysql_fetch_array($r)) {
	  $thn = $row['Tahun'];
	  $ssi = $row['Sesi'];
	  $sta = $row['Status'];
	  $nil = $row['Nilai'];
	  $grd = $row['GradeNilai'];
	  $bbt = $row['Bobot'];
	  $_bbt = number_format($bbt, 2, ',', '');
	  $sks = $row['SKS'];
	  $jml = $row['JmlMK'];
	  if ($sks == 0) $ips = 0; else $ips = $bbt / $sks;
	  $ips = number_format($ips, 2, ',', '');
	  $did = $row['DosenID'];
	  $maxsks = $row['MaxSKS'];
	  $sta = $row['STA'];
	  $status = $row['Status'];
	  $active = $row['ACTIVE'];
	  if ($active == 1) $cls = "class=lst"; else $cls = "class=nac";
	  //GetOption2('fakultas', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdf, '', 'Kode');
	  $optsta = GetOption2('statusmhsw', 'Nama', 'Nama', $status, '', 'Kode');
	  if ($_SESSION['ulevel']==3 && $_SESSION['uid']==$did || $_SESSION['ulevel']==1) {
	    $strssi = "<form action='sysfo.php' method=POST>
		  <input type=hidden name='syxec' value='mhswipk'>
		  <input type=hidden name='thn' value='$thn'>
		  <input type=hidden name='nim' value='$nim'>
		  <td $cls><input type=text name='ssi' value='$ssi' size=3 maxlength=3></td>
		  <td $cls><input type=text name='maxsks' value='$maxsks' size=3 maxlength=3>
		  <input type=submit name='prcssi' value='Ubah'></td>
		  </form>";
	  }
	  else $strssi = "<td class=lst>$ssi</td><td class=lst align=right>$maxsks</td>";
	  echo "<tr>
	    <td $cls><a href='sysfo.php?syxec=mhswkhs&thn=$thn&nim=$nim'>$thn</a></td>
		<td $cls>$row[KodeBiaya]</td>
		$strssi
		<td $cls>$sta</td>
		<td $cls align=right>$jml</td>
		<td $cls align=right>$sks</td>
		<td $cls align=right>$nil</td>
		<td $cls align=right>$_bbt</td>
		<td $cls align=right>$ips</td>
	    </tr>";
	}
	echo "</table>";
  }
  function PrcSesi() {
    $thn = $_REQUEST['thn'];
	$nim = $_REQUEST['nim'];
    $maxsks = $_REQUEST['maxsks'];
	$ssi = $_REQUEST['ssi'];
	mysql_query("update khs set MaxSKS=$maxsks, Sesi='$ssi' where NIM='$nim' and Tahun='$thn'");
  }
  function PrcAddSesi() {
    global $fmtErrorMsg, $strCantQuery;
    $thn = $_REQUEST['thn'];
	$nim = $_REQUEST['nim'];
	$ssi = $_REQUEST['ssi'];
	if (!empty($thn)) {
	  $ada = GetaField('khs', "NIM='$nim' and Tahun", $thn, 'Tahun');
	  if (!empty($ada)) DisplayHeader($fmtErrorMsg, "Tahun ajaran $thn dan Sesi/Semester $ssi sudah ada.");
	  else {
	    $bea = GetaField('mhsw', 'NIM', $nim, 'KodeBiaya');
	    $s = "insert into khs (NIM, Tahun, KodeBiaya, Sesi, Status) values ('$nim', '$thn', '$bea', '$ssi', 'A')";
	    $r = mysql_query($s) or die ("$strCantQuery: $s");
	  }
	}
  }
  function x_GoIPK($nim) {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select sum(h.Bobot) as BBT, sum(h.SKS) as SKS
	  from khs h
	  where h.NIM='$nim' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) > 0) {
	  $sks = mysql_result($r, 0, 'SKS');
	  $bbt = mysql_result($r, 0, 'BBT');
	  if ($sks == 0) $ipk = 0; else $ipk = $bbt/$sks;
	  echo <<<EOF
	    <br>
	    <table class=basic cellspacing=0 cellpadding=2>
		<tr><td class=ttl>Total SKS</td><td class=lst align=right>$sks</tr>
		<tr><td class=ttl>Index Prestasi Kumulatif</td><td class=lst align=right>$ipk</td></tr>
		</table>
EOF;
	}
  }
  function GoIPK($nim) {
    global $strCantQuery;
	$arr = GetFields("khs", "NIM", $nim, "sum(Bobot) as BBT, sum(SKS) as SKS");
	if (!empty($arr)) {
	  $sks = $arr['SKS']; $bbt = $arr['BBT'];
	  if ($sks == 0) $ipk = 0; else $ipk = $bbt/$sks;
	  $ipk = number_format($ipk, 2, ',', '');
	  $r = mysql_query("update mhsw set TotalSKS='$sks', IPK='$ipk' where NIM='$nim'") or die("$strCantQuery. Func GoIPK.");
	  echo <<<EOF
	    <br>
	    <table class=basic cellspacing=0 cellpadding=2>
		<tr><td class=ttl>Total SKS</td><td class=lst align=right>$sks</tr>
		<tr><td class=ttl>Index Prestasi Kumulatif</td><td class=lst align=right>$ipk</td></tr>
		</table>
EOF;
	}
  }
  
  // *** PARAMETER2 ***
  if (isset($_REQUEST['nim'])) {
    $nim = $_REQUEST['nim'];
	$_SESSION['nim'] = $nim;
  }
  else {
	if ($_SESSION['ulevel'] == 4) $nim = $_SESSION['unip'];
	else {
      if (isset($_SESSION['nim'])) $nim = $_SESSION['nim'];
	  else $nim = '';
	}
  }
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Index Prestasi Kumulatif");

  if (strpos('1234', $_SESSION['ulevel']) === false) die($strNotAuthorized.' #1');
  $valid = GetMhsw0($nim, 'mhswipk');
  if ($valid) {
    if (isset($_REQUEST['prcssi'])) PrcSesi();
	if (isset($_REQUEST['prcaddssi'])) PrcAddSesi();
    if (($_SESSION['ulevel'] == 4 && $_SESSION['unip'] == $nim) || $_SESSION['ulevel'] == 1 || $_SESSION['ulevel'] == 3) {
	  GoRekapKHS($nim);
	  GoIPK($nim);
	}
	else die(DisplayHeader($fmtErrorMsg, "$strNotAuthorized", 0));
  }
?>