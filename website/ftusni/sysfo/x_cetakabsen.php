<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function GetCaptionUjian($ujn='') {
    if (empty($ujn)) return 'Kuliah';
	elseif ($ujn == 'UTS') return 'Ujian Tengah Semester';
	elseif ($ujn == 'UAS') return 'Ujian Akhir Semester';
	elseif ($ujn == 'SSL') return 'Ujian Susulan';
  }
  function GetOptAbsen($ujn) {
    if (empty($ujn)) $str0 = 'selected'; else $str0 = '';
	if ($ujn == 'UTS') $str1 = 'selected'; else $str1 = '';
	if ($ujn == 'UAS') $str2 = 'selected'; else $str2 = '';
	if ($ujn == 'SSL') $str3 = 'selected'; else $str3 = '';
	$opt = "
	  <option value='' $str0>Absen Kuliah</option>
	  <option value='UTS' $str1>Ujian Tengah Semester</option>
	  <option value='UAS' $str2>Ujian Akhir Semester</option>
	  <option value='SSL' $str3>Ujian Susulan</option>
	  ";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='cetakabsen'>
	  <tr><td class=lst width=100>Jenis Absen: </td>
	  <td class=lst><select name='ujn' onChange='this.form.submit()'>$opt</select></td></tr>
	  </form></table>";
  }

  function GetJdwlDetail($thn, $kdj, $jid=0, $ujn='') {
    global $strCantQuery;
	if ($jid > 0) $strjid = "and j.ID=$jid"; else $strjid = "";
	if (empty($ujn)) {
	  $s = "select j.ID, j.Tunda, mk.Kode, mk.Nama_Indonesia as MK, pr.Nama_Indonesia as PRG,
	  jr.Nama_Indonesia as JUR,
	  hr.Nama as HR, TIME_FORMAT(JamMulai, '%H:%i') as ML, TIME_FORMAT(JamSelesai, '%H:%i') as SL,
	  j.KodeKampus as KMPS, KodeRuang as RNG, j.Tanggal as TGL,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  left outer join hari hr on j.Hari=hr.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' $strjid
	  order by j.Hari, j.JamMulai
	  ";
	}
	else {
	  $_kmps = $ujn.'Kampus';
	  $_tgl = $ujn.'Tanggal';
	  $_rng = $ujn.'Ruang';
	  $_ml = $ujn.'Mulai';
	  $_sl = $ujn.'Selesai';
	  $s = "select j.ID, j.Tunda, mk.Kode, mk.Nama_Indonesia as MK, pr.Nama_Indonesia as PRG,
	  jr.Nama_Indonesia as JUR,
	  hr.Nama as HR, TIME_FORMAT($_ml, '%H:%i') as ML, TIME_FORMAT($_sl, '%H:%i') as SL,
	  $_kmps as KMPS, $_rng as RNG, DATE_FORMAT($_tgl, '%d-%m-%Y') as TGL,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  left outer join hari hr on hr.ID=DAYOFWEEK($_tgl)
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' $strjid
	  order by $_tgl, $_ml
	  ";
	}
	$r = mysql_query($s) or die("$strCantQuery; $s<br>".mysql_error());
	return $r;
  }
  function DispJdwlKuliah ($thn, $kdj, $ujn='') {
	$sid = session_id();
	$r = GetJdwlDetail($thn, $kdj, 0, $ujn);
	echo "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>KodeMK</th>
	  <th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Program</th>
	  <th class=ttl>Hari</th>
	  <th class=ttl>Jam</th>
	  <th class=ttl>Kampus</th>
	  <th class=ttl>Ruang</th>
	  <th class=ttl>Dosen</th>
	  <th class=ttl>Absen</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  $jid = $row['ID'];
	  $kmk = $row['Kode'];
	  $MK = $row['MK'];
	  $PRG = $row['PRG'];
	  if (empty($KL)) $KL = '&nbsp;';
	  $HR = $row['HR']; $HR = StripEmpty($HR);
	  $ML = $row['ML']; 
	  $SL = $row['SL'];
	  $kmps = $row['KMPS']; $kmps = StripEmpty($kmps);
	  $rng = $row['RNG']; $rng = StripEmpty($rng);
	  $dsn = $row['DSN'];
	  $tnd = $row['Tunda'];
	  if (!empty($ujn)) $tgl = $row['TGL']; else $tgl = '';
	  if ($tnd == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  $prn = GetPrinter("print.php?print=sysfo/cetakabsen.php&jid=$jid&prn=1&ujn=$ujn&PHPSESSID=$sid");
	  echo <<<EOF
	    <tr><td $cls>$kmk</td>
		<td $cls>$MK</td>
		<td $cls>$PRG</td>
		<td $cls>$tgl $HR</td>
		<td $cls>$ML - $SL</td>
		<td $cls>$kmps</td><td $cls>$rng</td>
		<td $cls>$dsn</td>
		<td $cls align=center>$prn</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  function DaftarAbsen($thn, $kdj, $jid, $ujn) {
    global $strCantQuery;
	$r = GetJdwlDetail($thn, $kdj, $jid, $ujn);
	$jid = mysql_result($r, 0, 'ID');
	$kmk = mysql_result($r, 0, 'Kode');
	$MK = mysql_result($r, 0, 'MK');
	$PRG = mysql_result($r, 0, 'PRG');
	$HR = mysql_result($r, 0, 'HR');
	$ML = mysql_result($r, 0, 'ML'); $SL = mysql_result($r, 0, 'SL');
	$kmps = mysql_result($r, 0, 'KMPS'); $rng = mysql_result($r, 0, 'RNG');
	$dsn = mysql_result($r, 0, 'DSN');
	$tnd = mysql_result($r, 0, 'Tunda');
	$jur = mysql_result($r, 0, 'JUR');
	if (!empty($ujn)) $tgl = mysql_result($r, 0, 'TGL'); else $tgl = '&nbsp;';
	$tgl = StripEmpty($tgl);
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=3>
	  <tr><td class=ttl>Jurusan</td><td class=lst>$kdj - $jur</td><td class=ttl>Ruang - Kampus</td><td class=lst>$rng - $kmps</td></tr>
	  <tr><td class=ttl>Mata Kuliah</td><td class=lst>$kmk - $MK</td><td class=ttl>Waktu Ujian</td><td class=lst>$HR, $ML - $SL</td></tr>
	  <tr><td class=ttl>Dosen Pengampu</td><td class=lst>$dsn</td><td class=ttl>Tanggal</td><td class=lst>$tgl</td></tr>
	  <tr><td class=ttl>Paraf Dosen</td><td class=lst>&nbsp</td><td class=ttl>Program</td><td class=lst>$PRG</td></tr>
	  </table><br>
EOF;
    $s = "select k.ID, k.NIM, m.Name as NME, k.Tunda
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid
	  order by k.NIM ";
	$t = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic width=100% cellspacing=0 cellpadding=3>
	  <tr><th class=ttl>#</th>
	  <th class=ttl>NIM</th><th class=ttl>Nama</th><th class=ttl>Tanda Tangan</th>
	  </tr>";
	$i = 0;
	while ($row = mysql_fetch_array($t)) {
	  $i++;
	  $nim = $row['NIM']; $nme = $row['NME'];
	  $tnd = $row['Tunda'];
	  if ($tnd == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  echo <<<EOF
	    <tr><td $cls>$i</td>
		<td $cls>$nim</td><td $cls>$nme</td>
		<td $cls>&nbsp;</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  
  
  // *** PARAMETER ***
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
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
  if (isset($_REQUEST['go'])) {
    $thn = $_REQUEST['th_n'].$_REQUEST['th_s'];
	$_SESSION['thn'] = $thn;
  }
  if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
  if (isset($_REQUEST['ujn'])) {
    $ujn = $_REQUEST['ujn']; $_SESSION['ujn'] = $ujn;
  }
  else {
    if (isset($_SESSION['ujn'])) $ujn = $_SESSION['ujn']; else $ujn = '';
  }
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Absensi ".GetCaptionUjian($ujn));
  if ($jid == 0) DispOptJdwl0('cetakabsen');
  if ($prn == 0) GetOptAbsen($ujn);
  if (!empty($thn) && !empty($kdj) && $jid==0) {
    DispJdwlKuliah($thn, $kdj, $ujn);
  }
  if ($jid > 0) {
    DaftarAbsen($thn, $kdj, $jid, $ujn);
  }
?>