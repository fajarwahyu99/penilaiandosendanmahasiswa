<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
  function DispJagaUjian0($thn, $kdj, $ujn) {
    global $strCantQuery;
	$_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$_kmp = $ujn.'Kampus';
	$_rng = $ujn.'Ruang';

	$s = "select j.ID, j.$_tgl, j.$_kmp, j.$_rng,
	  TIME_FORMAT($_mul, '%H:%i') as MUL, TIME_FORMAT($_sel, '%H:%i') as SEL,
	  mk.Kode, mk.Nama_Indonesia as MK, pr.Nama_Indonesia as PRG
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by j.$_tgl, j.$_mul	";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=7>Jadwal</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $sd = "select concat(d.Name, ', ', d.Gelar) as DSN
	    from pengawasujian p left outer join dosen d on p.Login=d.Login
		where p.IDJadwal=$row[ID] and p.UJN='$ujn' order by d.Name ";
	  $rd = mysql_query($sd) or die("$strCantQuery: $sd<br>".mysql_error());
	  $jaga = '';
	  while ($arj = mysql_fetch_array($rd)) {
	    $jaga = $jaga . "<li>$arj[DSN]</li>";
	  }
	  if (!empty($jaga)) $jaga = "<ol>$jaga</ol>";
	  echo <<<EOF
	    <tr><td class=ttl>$row[$_tgl]</td><td class=lst>$row[MUL] - $row[SEL]</td>
		<td class=lst>$row[$_kmp]</td><td class=lst>$row[$_rng]</td>
		<td class=lst>$row[Kode]</td><td class=lst>$row[MK]</td><td class=lst>$row[PRG]</td></tr>
		<tr><td class=basic colspan=6>$jaga</td></tr>
EOF;
	}
	echo "</table>";
  }
  function GetJagaMK($thn, $kdj, $ujn, $dsn) {
    global $strCantQuery;
	$_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$_kmp = $ujn.'Kampus';
	$_rng = $ujn.'Ruang';

	$s = "select mk.Kode, mk.Nama_Indonesia as MK, j.ID, h.Nama as HR, pr.Nama_Indonesia as PRG,
	  DATE_FORMAT(j.$_tgl, '%d-%m-%Y') as TGL, j.$_kmp, j.$_rng,
	  TIME_FORMAT(j.$_mul, '%H:%i') as MUL, TIME_FORMAT(j.$_sel, '%H:%i') as SEL
	  from pengawasujian p left outer join jadwal j on p.IDJadwal=j.ID
	  left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join hari h on h.ID=DAYOFWEEK(j.$_tgl)
	  left outer join program pr on j.Program=pr.Kode
	  where p.Login='$dsn' and p.UJN='$ujn' order by j.$_tgl, j.$_mul";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	$cont = '<table class=basic cellspacing=0 cellpadding=1>';
	$cnt = 0;
	while ($row = mysql_fetch_array($r)) {
	  $cnt++;
	  $cont = $cont. "<tr><td class=basic width=14>&nbsp</td>
	    <td class=ttl width=12>$cnt</td>
		<td class=lst width=50>$row[HR]</td>
	    <td class=lst width=80>$row[TGL]</td>
		<td class=lst width=90>$row[MUL] - $row[SEL]</td>
	    <td class=lst width=60>$row[Kode]</td>
		<td class=lst width=200>$row[MK]</td><td class=lst>$row[PRG]</td><tr>";
	}
	return $cont. '</table>';
  }
  function DispJagaUjian1($thn, $kdj, $ujn) {
    global $strCantQuery;
	$s0 = "select concat(ds.Name, ', ', ds.Gelar) as DSN, p.Login
	  from pengawasujian p left outer join jadwal j on p.IDJadwal=j.ID
	  left outer join dosen ds on p.Login=ds.Login
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' and p.UJN='$ujn' group by ds.Name";
	$r0 = mysql_query($s0) or die("$strCantQuery: $s0<br>".mysql_error());
	$cnt = 0;
	while ($rw0 = mysql_fetch_array($r0)) {
	  $cnt++;
	  $jdwl = GetJagaMK($thn, $kdj, $ujn, $rw0['Login']);
	  echo <<<EOF
	    <table class=basic cellspacing=0 cellpadding=2>
	    <tr><td class=ttl width=12>$cnt</td><td class=ttl width=300>$rw0[DSN]<td></tr></table>
		$jdwl<br>
EOF;
	}
  }
  function DispOptJagaUjian($jgm) {
    if ($jgm == 0) $strjg0 = 'checked'; else $strjg0 = '';
    if ($jgm == 1) $strjg1 = 'checked'; else $strjg1 = '';
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=lst width=100>Mode Penyajian:</td>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='cetakjagaujian'>
	  <td class=lst><input type=radio name='jgm' value='0' $strjg0 onClick='this.form.submit()'>Per Mata Kuliah</td>
	  <td class=lst><input type=radio name='jgm' value='1' $strjg1 onClick='this.form.submit()'>Per Dosen</td></tr>
	  </form></table>
EOF;
  }
  
  
  // *** PARAMETER2 ***
  if (isset($_REQUEST['thn'])) {
    $thn = $_REQUEST['thn'];
	$_SESSION['thn'] = $thn;
  } else { if (!empty($_SESSION['thn'])) $thn = $_SESSION['thn']; else $thn = '';  }
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj']; 
	$_SESSION['kdj'] = $kdj;
  } 
  else {
    if (!empty($_SESSION['kdj'])) $kdj = $_SESSION['kdj'];
	else $kdj = '';
  }
  if (isset($_REQUEST['ujn'])) {
    $ujn = $_REQUEST['ujn'];
	$_SESSION['ujn'] = $ujn;
  }
  else {
    if (isset($_SESSION['ujn'])) $ujn = $_SESSION['ujn']; else $ujn = '';
  }
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  if (isset($_REQUEST['go'])) {
    $thn = $_REQUEST['th_n'].$_REQUEST['th_s'];
	$_SESSION['thn'] = $thn;
  }
  if (isset($_REQUEST['jgm'])) {
    $jgm = $_REQUEST['jgm'];
	$_SESSION['jgm'] = $jgm;
  }
  else {
    if (isset($_SESSION['jgm'])) $jgm = $_SESSION['jgm']; else $jgm = 0;
  }

  
  // *** BAGIAN UTAMA ***
  $jdl = GetUjianCaption($ujn);
  DisplayHeader($fmtPageTitle, "Pengawas $jdl");
  DispOptJdwl0('cetakjagaujian');
  echo "<br>";
  if ($prn == 0) {
    $sid = session_id();
    DisplayPrinter("print.php?print=sysfo/cetakjagaujian.php&prn=1&PHPSESSID=$sid");
    DispOptUjian($ujn, 'cetakjagaujian');
	DispOptJagaUjian($jgm);
  }
  if (!empty($thn) && !empty($kdj) && !empty($ujn)) {
    if ($jgm == 0) DispJagaUjian0($thn, $kdj, $ujn);
	else DispJagaUjian1($thn, $kdj, $ujn);
  }

?>