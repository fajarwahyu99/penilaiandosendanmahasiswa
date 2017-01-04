<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function GoKHS($thn, $nim) {
    global $strCantQuery, $strPending;
	$s = "select j.Tunda as tndj, j.AlasanTunda as alsj, mk.Kode, mk.Nama_Indonesia as MK,
	  mk.SKS, j.KodeFakultas, k.Bobot,
	  concat(ds.Name, ', ', ds.Gelar) as DS, k.Nilai, k.GradeNilai,
	  k.Tunda as tndk, k.AlasanTunda as alsk, k.Setara, k.NotActive
	  from krs k left outer join jadwal j on k.IDJadwal=j.ID
	  left outer join matakuliah mk on k.IDMK=mk.ID
	  left outer join dosen ds on k.IDDosen=ds.ID
	  where k.Tahun='$thn' and k.NIM='$nim' order by mk.Kode";
	$r = mysql_query($s) or die ("$strCantQuery: $s<br>Pesan:" . mysql_error());
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Dosen</th><th class=ttl>Nilai</th><th class=ttl>Bobot</th><th class=ttl>SKS</th>
	  <th class=ttl>N*SKS</th><th class=ttl>Stat</th><th class=ttl>Setr</th><th class=ttl>NA</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  $tndj = $row['tndj'];
	  $alsj = $row['alsj'];
	  $grd = $row['GradeNilai'];
	  $kdf = $row['KodeFakultas'];
	  $kod = $row['Kode'];
	  $MK = $row['MK'];
	  $sks = $row['SKS'];
	  $DS = $row['DS'];
	  $nil = $row['Nilai'];
	  $bobot = $row['Bobot'];
	  $_bbt = number_format($bobot, 2, ',', '');
	  $tndk = $row['tndk'];
	  $alsk = $row['alsk'];
	  $strbbt = $sks * $bobot;
	  if ($tndk == 'Y') $strtndk = "<a href='javascript:alert(\"$alsk\")'>$strPending</a>";
	  else $strtndk = "--";
	  if ($row['NotActive'] == 'Y') $cna = 'class=nac'; else $cna = 'class=lst';
	  
	  if ($tndj == 'Y' || $tndk == 'Y') {
	    $cls = 'class=wrn'; 
		$grd = "--";
	  }
	  else {
	    $cls = $cna;
	  }
	  if ($tndj == 'Y') $strtndj = "<a href='javascript:alert(\"$alsj\")'>$strPending</a>";
	  else $strtndj = $grd;

	  echo <<<EOF
	    <tr><td $cna>$kod</td><td $cls>$MK</td>
		<td $cna>$DS</td><td $cna align=center>$strtndj</td>
		<td $cna align=right>$_bbt</td>
		<td $cna align=right>$sks</td>
		<td $cna align=right>$strbbt</td>
		<td $cls align=center>$strtndk</td>
		<td $cna align=center><img src='image/$row[Setara].gif' border=0></td>
		<td $cna align=center><img src='image/$row[NotActive].gif' border=0></td>
		</tr>
EOF;
	}
	echo "</table>";
  }

  function GetKHS($thn, $nim) {
    global $strCantQuery;
	$vld = ProcessNilaiKHSMhsw($thn, $nim);
	if ($vld) {
	  $r = GetKHSDulu($thn, $nim);
	  $sesi = mysql_result($r, 0, 'Sesi');
	  $stat = mysql_result($r, 0, 'STAT');
	  if (mysql_result($r, 0, 'STAT0') == 0) $cls = 'class=nac'; else $cls = 'class=lst';
	  $nil = mysql_result($r, 0, 'Nilai');
	  $grd = mysql_result($r, 0, 'GradeNilai');
	  $sks = mysql_result($r, 0, 'SKS');
	  $bbt = mysql_result($r, 0, 'Bobot');
	  $jml = mysql_result($r, 0, 'JmlMK');
	  if ($sks == 0) $ips = 0; else $ips = $bbt / $sks;
	  $ips = number_format($ips, 2, ',', '');
	  $bbt = number_format($bbt, 2, ',', '');
	  $nil = number_format($nil, 2, ',', '');
	  echo <<<EOF
	    <table class=basic cellspacing=1 cellpadding=2>
	    <tr><th class=ttl colspan=7>Nilai Rata-rata :: $thn</th></tr>
	    <tr><th class=ttl>Semester</th><th class=ttl>Status</th><th class=ttl>Nilai</th>
	    <th class=ttl>Bobot</th><th class=ttl>SKS</th><th class=ttl>Jml MK</th><th class=ttl>IP Smt</th></tr>
	  
	    <tr><td class=lst align=right>$sesi</td><td $cls>$stat</td><td class=lst align=right>$nil</td>
	    <td class=lst align=right>$bbt</td><td class=lst align=right>$sks</td>
	    <td class=lst align=right>$jml</td><td class=lst align=right>$ips</td></tr>
	    </table><br>
EOF;
    }
	return $vld;
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
$thn = GetSetVar('thn');


  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Kartu Hasil Studi');
  
  if (strpos('14', $_SESSION['ulevel']) === false) die($strNotAuthorized.' #1');
  $valid = GetMhsw($thn, $nim, 'mhswkhs');
  if ($valid) {
    if (($_SESSION['ulevel'] == 4 && $_SESSION['unip'] == $nim) || $_SESSION['ulevel'] == 1) {
	  if (GetKHS($thn, $nim)) GoKHS($thn, $nim);
	  //if ($md == -1) GoKRS($nim);
	  //else KRSForm($thn, $nim);
	}
	else die(DisplayHeader($fmtErrorMsg, "$strNotAuthorized", 0));
  }

?>