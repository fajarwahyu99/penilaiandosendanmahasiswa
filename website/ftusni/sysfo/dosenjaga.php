<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function DispJadwalJaga($thn, $ujn, $dsn) {
    global $strCantQuery;
	$_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$_kmp = $ujn.'Kampus';
	$_rng = $ujn.'Ruang';
	$s = "select DATE_FORMAT(j.$_tgl, '%d-%m-%y') as TGL, TIME_FORMAT(j.$_mul, '%H:%i') as MUL, 
	  h.Nama as HR,
	  TIME_FORMAT(j.$_sel, '%H:%i') as SEL, j.$_kmp, j.$_rng,
	  mk.Kode, mk.Nama_Indonesia as MK, mk.SKS
	  from pengawasujian p left outer join jadwal j on p.IDJadwal=j.ID
	  left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join hari h on h.ID=DAYOFWEEK(j.$_tgl)
	  where j.Tahun='$thn' and p.Login='$dsn' and p.UJN='$ujn' order by j.$_tgl, j.$_mul";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>Hari</th><th class=ttl>Tanggal</th>
	  <th class=ttl>Kampus</th><th class=ttl>Ruang</th>
	  <th class=ttl>Jam</th>
	  <th class=ttl>Kode</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  echo <<<EOF
	    <tr><td class=lst>$row[HR]</td>
		<td class=lst>$row[TGL]</td>
		<td class=lst>$row[$_kmp]</td>
		<td class=lst>$row[$_rng]</td>
		<td class=lst>$row[MUL] - $row[SEL]</td>
		<td class=lst>$row[Kode]</td>
		<td class=lst>$row[MK]</td>
		<td class=lst align=right>$row[SKS]</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  
  
  // *** PARAMETER ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$dsn = GetSetVar('dsn');
if ($_SESSION['ulevel'] == 3) {
  $dsn = $_SESSION['unip'];
  $_SESSION['dsn'] = $dsn;
}
$ujn = GetSetVar('ujn');
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** BAGIAN UTAMA ***
  $jdl = GetUjianCaption($ujn);
  DisplayHeader($fmtPageTitle, "Jadwal Jaga $jdl");
  DispOptJdwl0('dosenjaga');
  echo "<br>";
  $vld = GetLoginDosen($dsn, 'dosenjaga');
  if ($vld) {
    if ($prn == 0) DispOptUjian($ujn, 'dosenjaga');
	if (!empty($thn) && !empty($kdj) && !empty($ujn)) {
	  if ($prn == 0) {
	    $sid = session_id();
	    DisplayPrinter("print.php?print=sysfo/dosenjaga.php&prn=1&PHPSESSID=$sid");
	  } else echo "<br>";
	  DispJadwalJaga($thn, $ujn, $dsn);
	}
    //GetMyMhsw($dsn);
  }
  else DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas data dosen dengan login <b>$dsn</b>.<br>");
?>