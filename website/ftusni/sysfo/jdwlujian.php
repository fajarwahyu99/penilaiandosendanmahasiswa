<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
  function DispJadwalUjian($thn, $kdj, $ujn, $jdl) {
    global $strCantQuery;
	$_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$_kmps = $ujn.'Kampus';
	$_rng = $ujn.'Ruang';
	$s = "select j.ID, j.IDDosen, j.IDMK, pr.Nama_Indonesia as PRG,
	  j.$_tgl, h.Nama as HR, j.Tunda,
	  DATE_FORMAT(j.$_tgl, '%d-%m-%Y') as tgl, 
	  TIME_FORMAT(j.$_mul, '%H:%i') as mul, TIME_FORMAT(j.$_sel, '%H:%i') as sel,
	  j.$_kmps, j.$_rng,
	  mk.Kode as KMK, mk.Nama_Indonesia as MK, mk.SKS,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join program pr on j.Program=pr.Kode
	  left outer join hari h on DAYOFWEEK(j.$_tgl)=h.ID
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj'
	  order by j.$_tgl, j.$_mul
	  ";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=9>Jadwal $jdl</th></tr>
	  <tr>
	  <th class=ttl>Tanggal</th>
	  <th class=ttl>Hari</th>
	  <th class=ttl>Jam</th>
	  <th class=ttl>Ruang</th><th class=ttl>Kampus</th>
	  <th class=ttl>Kode MK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Program</th><th class=ttl>SKS</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  $jid = $row['ID'];
	  $did = $row['IDDosen'];
	  $KMK = $row['KMK'];
	  $MK = $row['MK'];
	  $sks = $row['SKS'];
	  $dsn = $row['DSN'];
	  $prg = $row['PRG']; $prg = StripEmpty($prg);
	  $tgl = $row['tgl']; $tgl = StripEmpty($tgl);
	  $mul = $row['mul'];
	  $sel = $row['sel'];
	  $kmps = $row[$_kmps]; $kmps = StripEmpty($kmps);
	  $rng = $row[$_rng]; $rng = StripEmpty($rng);
	  $atgl = getdate();
	  $hr = $row['HR']; $hr = StripEmpty($hr);
	  $tnd = $row['Tunda'];
	  if ($tnd == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';

	  if ($_SESSION['ulevel'] == 1 || $_SESSION['ulevel'] == 2) 
	    $strmk = "<a href='sysfo.php?syxec=jdwlujian&ujn=$ujn&jid=$jid'>$KMK</a>";
	  else $strmk = $KMK;
	  echo <<<EOF
	  	<tr><td $cls>$tgl</td><td $cls>$hr</td>
		<td $cls>$mul - $sel</td>
		<td $cls>$rng</td>
		<td $cls>$kmps</td>
		<td $cls>$strmk</td>
		<td $cls>$MK</td>
		<td $cls>$prg</td>
		<td $cls>$sks</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  function EditJadwalUjian($jid, $ujn, $jdl) {
    global $strCantQuery, $prn;
	if (!isset($prn)) $prn = 0;
	$_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$_kmps = $ujn.'Kampus';
	$_rng = $ujn.'Ruang';
	$s = "select DATE_FORMAT(j.$_tgl, '%d-%m-%Y') as tgl,
	  TIME_FORMAT(j.$_mul, '%H:%i') as mul, TIME_FORMAT(j.$_sel, '%H:%i') as sel,
	  j.$_kmps as kmps, j.$_rng as rng, concat(ds.Name, ', ', ds.Gelar) as dsn,
	  mk.Kode, mk.Nama_Indonesia as MK, mk.SKS
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  where j.ID=$jid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$tgl = mysql_result($r, 0, 'tgl');
	$mul = mysql_result($r, 0, 'mul');
	$sel = mysql_result($r, 0, 'sel');
	$kmps = mysql_result($r, 0, 'kmps');
	$rng = mysql_result($r, 0, 'rng');
	$kmk = mysql_result($r, 0, 'Kode');
	$mk = mysql_result($r, 0, 'MK');
	$sks = mysql_result($r, 0, 'SKS');
	$dsn = mysql_result($r, 0, 'dsn');
	if (empty($mul)) $mul = '00:00';
	if (empty($sel)) $sel = '00:00';
	if (empty($tgl)) $tgl = date('d-m-Y');
	$atgl = explode('-', $tgl);
	$tgld = $atgl[0]; $tglm = $atgl[1]; $tgly = $atgl[2];
	//GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	$optrng = GetOption2('ruang', "concat(KodeKampus, ' -- ', Kode)", 'Kode', $rng, '', 'Kode');
	$sid = session_id();
	if ($prn == 0) $button = <<<EOF
	<input type=submit name='prcjdwl' value='Simpan'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name=balik value='Kembali' onClick="location='sysfo.php?syxec=jdwlujian&PHPSESSID=$sid'">
EOF;
	else $button = '';
	return <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2 width=100%>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='jdwlujian'>
	  <input type=hidden name='jid' value='$jid'>
	  <input type=hidden name='ujn' value='$ujn'>
	  <tr><th class=ttl colspan=2>Edit $jdl</th></tr>
	  <tr><td class=lst>Mata Kuliah</td><td class=lst>$kmk - $mk - $sks SKS</td></tr>
	  <tr><td class=lst>Dosen</td><td class=lst>$dsn</td></tr>
	  <tr><td class=lst>Tanggal</td><td class=lst>
	    <input type=text name='tgld' value='$tgld' size=2 maxlength=2>
		<input type=text name='tglm' value='$tglm' size=2 maxlength=2>
		<input type=text name='tgly' value='$tgly' size=4 maxlength=4>
	  </td></tr>
	  <tr><td class=lst>Jam mulai</td><td class=lst><input type=text name='mul' value='$mul' size=5 maxlength=5></td></tr>
	  <tr><td class=lst>Jam Selesai</td><td class=lst><input type=text name='sel' value='$sel' size=5 maxlength=5></td></tr>
	  <tr><td class=lst>Ruang Ujian</td><td class=lst><select name='rng'>$optrng</select></td></tr>
	  <tr><td class=lst colspan=2>$button</td></tr>
	  </form></table>
EOF;
  }
  function GetErrorRuang($r, $ujn, $msg) {
	    $_tgl = $ujn.'Tanggal';
	    $_mul = $ujn.'Mulai';
	    $_sel = $ujn.'Selesai';
	    $_kmps = $ujn.'Kampus';
	    $_rng = $ujn.'Ruang';

    for ($i=0; $i < mysql_num_rows($r); $i++) {
	  $strmk = GetFields('matakuliah', 'ID', mysql_result($r, $i, 'IDMK'), 'Kode,Nama_Indonesia');
	  $str1 = "<li>$msg<br>". 
	    mysql_result($r, $i, $_tgl). ' '.
	    mysql_result($r, $i, $_mul).' - '.mysql_result($r, $i, $_sel). ' : '.
	    $strmk['Kode'] . ' - '. $strmk['Nama_Indonesia'] . ' dari '.
		mysql_result($r, $i, $_kmps) . ' : ' . mysql_result($r, $i, $_rng).
		'</li>';
	}
	return $str1;
  }
  function CheckRuang ($jid, $ujn, $kdk, $kdr, $tgl, $jm, $js) {
    global $strCantQuery, $fmtErrorMsg;
	    $_tgl = $ujn.'Tanggal';
	    $_mul = $ujn.'Mulai';
	    $_sel = $ujn.'Selesai';
	    $_kmps = $ujn.'Kampus';
	    $_rng = $ujn.'Ruang';
	$sm = "select * from jadwal where $_kmps='$kdk' and $_rng='$kdr' and $_tgl='$tgl' and
	  $_mul <= '$jm:00' and '$jm:00' <= $_sel and ID<>$jid ";
	$rm = mysql_query($sm) or die ("$strCantQuery: $sm");
	$hm = mysql_num_rows($rm);
	if ($hm > 0) $str1 = GetErrorRuang($rm, $ujn, '<b>Jam Mulai Bentrok.</b>');
	else $str1 = '';
	
	$ss = "select * from jadwal where $_kmps='$kdk' and $_rng='$kdr' and $_tgl='$tgl' and
	  $_mul <= '$js' and '$js' <= $_sel and ID<>$jid ";
	$rs = mysql_query($ss) or die ("$strCantQuery: $ss");
	$hs = mysql_num_rows($rs);
	if ($hs > 0) $str2 = GetErrorRuang($rs, $ujn, '<b>Jam Selesai Bentrok.</b>');
	else $str2 = '';
	
	if (!($hm == 0 && $hs ==0))	DisplayHeader($fmtErrorMsg, "Tidak dapat dijadwalkan di <b>$kdk - $kdr</b>.<br>
	  Ruang telah dipakai oleh : <br><ul> $str1 $str2 </ul>");
	return ($hm == 0) && ($hs == 0);
  }
  function PrcJdwlUjian($kdj) {
    global $strCantQuery, $fmtErrorMsg, $thn, $strTahunNotActive;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
    $jid = $_REQUEST['jid'];
	$ujn = $_REQUEST['ujn'];
	if (isset($_REQUEST['tgld'])) $tgld = $_REQUEST['tgld']; else $tgld = '00';
	if (isset($_REQUEST['tglm'])) $tglm = $_REQUEST['tglm']; else $tglm = '00';
	if (isset($_REQUEST['tgly'])) $tgly = $_REQUEST['tgly']; else $tgly = '0000';
	$tgl = "$tgly-$tglm-$tgld";
	if (isset($_REQUEST['mul'])) $mul = $_REQUEST['mul']; else $mul = '00:00';
	if (isset($_REQUEST['sel'])) $sel = $_REQUEST['sel']; else $sel = '00:00';
	$rng = $_REQUEST['rng'];
	$kmps = GetaField('ruang', 'Kode', $rng, 'KodeKampus');
	
	if ($tgl == '0000-00-00') {
	  DisplayHeader($fmtErrorMsg, "Tanggal yang dimasukkan tidak valid.");
	  return $jid;
	}
	else {
	  if (CheckRuang ($jid, $ujn, $kmps, $rng, $tgl, $mul, $sel)) {
	    $_tgl = $ujn.'Tanggal';
	    $_mul = $ujn.'Mulai';
	    $_sel = $ujn.'Selesai';
	    $_kmps = $ujn.'Kampus';
	    $_rng = $ujn.'Ruang';
	    $s = "update jadwal set $_tgl='$tgl', $_mul='$mul', $_sel='$sel', $_kmps='$kmps', $_rng='$rng'
	      where ID=$jid ";
	    $r = mysql_query($s) or die("$strCantQuery: $s");
	    //return 0;
		return $jid;
	  }
	  else return $jid;
	}
	}
  }
  function EditPengawasUjian($jid, $ujn) {
    global $strCantQuery, $prn;
	if (!isset($prn)) $prn = 0;
	if ($prn == 0)
	$_1 = <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='jdwlujian'>
	  <input type=hidden name='jid' value='$jid'>
	  <input type=hidden name='ujn' value='$ujn'>
	  <tr><th class=ttl colspan=2>Tambahkan Pengawas</th></tr>
	  <tr><td class=lst width=100>Kode Login</td>
	  <td class=lst><input type=text name='_log' size=10 maxlength=10>&nbsp;<input type=submit name='prcawas' value='Simpan'>
	  </td></tr>
	  </form></table><br>
EOF;
    else $_1 = '';
	$s = "select p.*, concat(d.Name, ', ', d.Gelar) as DSN
	  from pengawasujian p left outer join dosen d on p.Login=d.Login
	  where p.IDJadwal=$jid";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$_2 = "<table class=basic cellspacing=0 cellpadding=2 width=100%>
	  <tr><th class=ttl colspan=3>Pengawas Ujian</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>Kode</th><th class=ttl>Nama</th></tr>";
	$_3 = '';
	$cnt = 0;
	
	while ($row = mysql_fetch_array($r)) {
	  $cnt++;
	  if ($prn == 0) $strdel = "<td><a href='sysfo.php?syxec=jdwlujian&jid=$jid&pid=$row[ID]'>Del</a></td>";
	  else $strdel = '';
	  $_3 = $_3 . <<<EOF
	    <tr><td class=lst>$cnt</td>
		<td class=lst>$row[Login]</td><td class=lst>$row[DSN]</td>
		$strdel</tr>
EOF;
	}
	$_4 = "</table>";
	return $_1.$_2.$_3.$_4;
  }
  function CekAwasUjian($jid, $ujn, $log) {
    global $fmtErrorMsg, $strCantQuery;
    $_tgl = $ujn.'Tanggal';
	$_mul = $ujn.'Mulai';
	$_sel = $ujn.'Selesai';
	$arr = GetFields('jadwal', 'ID', $jid, "$_tgl, $_mul, $_sel");
	
	$tgl = $arr[$_tgl];
	$mul = $arr[$_mul];
	$sel = $arr[$_sel];
	$str = '';
	// Cek tahap 1
    $s1 = "select j.$_tgl, j.$_mul, j.$_sel, mk.Kode, mk.Nama_Indonesia as MK
	  from pengawasujian p inner join jadwal j on p.IDJadwal=j.ID
	  left outer join matakuliah mk on j.IDMK=mk.ID
	  where p.Login='$log' and j.ID<>$jid and p.UJN='$ujn'
	  and j.$_tgl='$tgl' and j.$_mul <= '$mul' and '$mul' <= j.$_sel";
	$r1 = mysql_query($s1) or die("$strCantQuery: $s1".mysql_error());
	if (mysql_num_rows($r1) > 0) $str = $str. "<li>Jam Mulai Jadwal <b>$log</b> bentrok dengan <b>".mysql_result($r1, 0, 'Kode').
	  " -> ". mysql_result($r1, 0, 'MK')."</b></li>";
	// Cek tahap 2
    $s2 = "select j.$_tgl, j.$_mul, j.$_sel, mk.Kode, mk.Nama_Indonesia as MK
	  from pengawasujian p inner join jadwal j on p.IDJadwal=j.ID
	  left outer join matakuliah mk on j.IDMK=mk.ID
	  where p.Login='$log' and j.ID<>$jid and p.UJN='$ujn'
	  and j.$_tgl='$tgl' and j.$_mul <= '$sel' and '$sel' <= j.$_sel";
	$r2 = mysql_query($s2) or die("$strCantQuery: $s1");
	if (mysql_num_rows($r2) > 0) $str = $str. "<li>Jam Selesai Jadwal <b>$log</b> bentrok dengan <b>".mysql_result($r2, 0, 'Kode').
	  " -> ". mysql_result($r2, 0, 'MK')."</b></li>";
	if (!empty($str)) DisplayHeader($fmtErrorMsg, $str);
	return empty($str);
  }
  function PrcAwas() {
    global $strCantQuery, $fmtErrorMsg;
    $_log = FixQuotes($_REQUEST['_log']);
	$jid = $_REQUEST['jid'];
	$ujn = $_REQUEST['ujn'];
	$cekid = GetaField('dosen', 'Login', $_log, 'ID');
	if (empty($cekid)) DisplayHeader($fmtErrorMsg, "Tidak ada user dengan login <b>$_log</b>");
	else {
	  $c1 = GetaField('pengawasujian', "IDJadwal=$jid and Login", $_log, 'ID');
	  if (!empty($c1)) DisplayHeader($fmtErrorMsg, "Pengawas <b>$_log</b> sudah didaftar.");
	  else {
	    if (CekAwasUjian($jid, $ujn, $_log)) {
	      $s = "insert into pengawasujian (IDJadwal, Login, UJN, Honor) values ($jid, '$_log', '$ujn', 0)";
	      $r = mysql_query($s) or die("$strCantQuery: $s");
		}
	  }
	}
  }
  function DelPID() {
    $pid = $_REQUEST['pid'];
	mysql_query("delete from pengawasujian where ID=$pid");
  }
  
  // *** PARAMETER ***
$ujn = GetSetVar('ujn');
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

  // *** BAGIAN UTAMA ***
  $jdl = GetUjianCaption($ujn);
  DisplayHeader($fmtPageTitle, "Jadwal $jdl");
  if (isset($_REQUEST['prcjdwl'])) $jid = PrcJdwlUjian($kdj);
  if (isset($_REQUEST['prcawas'])) PrcAwas();
  if (isset($_REQUEST['pid'])) DelPID();
  DispOptJdwl0('jdwlujian');
  if ($prn == 0) DispOptUjian($ujn);
  if (!empty($thn) && !empty($kdj) && !empty($ujn)) {
    if ($prn == 0) {
      $sid = session_id();
      //$prn = GetPrinter("print.php?print=sysfo/cetakabsen.php&jid=$jid&PHPSESSID=$sid");
	  if ($jid == 0) DisplayPrinter("print.php?print=sysfo/jdwlujian.php&prn=1&PHPSESSID=$sid");
	  else DisplayPrinter("print.php?print=sysfo/jdwlujian.php&prn=1&jid=$jid&PHPSESSID=$sid");
    }

    if ($jid > 0) {
	  $strEditJadwalUjian = EditJadwalUjian($jid, $ujn, $jdl);
	  $strEditPengawasUjian = EditPengawasUjian($jid, $ujn);
	  echo <<<EOF
	    <table class=basic cellspacing=1 cellpadding=2 width=100%>
		<tr><td class=basic valign=top width=50%>$strEditJadwalUjian</td>
		<td class=basic valign=top>$strEditPengawasUjian</td></tr>
		</table>
EOF;
	}
	else DispJadwalUjian($thn, $kdj, $ujn, $jdl);
  }
?>