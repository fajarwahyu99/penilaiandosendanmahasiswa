<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003
  
  // *** Fungsi2 ***
function Jadwal($thn, $kdj, $prg='') {
  global $strCantQuery, $prn;
	if (!isset($prn)) $prn = 0;
	function HitungMhsw($jid) {
	  global $strCantQuery;
	  $s = "select count(*) as JML from krs where IDJadwal=$jid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  return mysql_result($r, 0, 'JML');
	}
	if (!empty($prg)) $strprg = "and jd.Program='$prg'";
	else $strprg = '';
	if ($prn == 0) {
	  $sid = session_id();
	  echo "<a href='sysfo.php?syxec=jdwlkuliah&md=1' class=lst>Tambah Jadwal</a> | ";
	  SimplePrinter("print.php?print=sysfo/jdwlkuliah.php&prn=1&PHPSESSID=$sid", 'Cetak Jadwal');
	}
	$s = "select jd.ID, jd.KodeRuang, jd.Tahun, jd.KodeFakultas, jd.KodeJurusan,
	  jd.IDMK, jd.KodeMK, jd.SKS, jd.Global, jd.Program, jd.JamMulai, jd.JamSelesai,
	  jd.KodeKampus, jd.KodeRuang,
	  TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,
	  jd.Global, h.Nama as HR, mk.ID as MKID, mk.Kode as KodeMK, mk.Nama_Indonesia as MK, mk.SKS, 
	  concat(d.Name, ', ', d.Gelar) as Dosen, pr.Nama_Indonesia as PRG, r.Kapasitas
	  from jadwal jd left outer join hari h on jd.Hari=h.ID
	  left outer join matakuliah mk on jd.IDMK=mk.ID
	  left outer join dosen d on jd.IDDosen=d.ID
	  left outer join program pr on jd.Program=pr.Kode
	  left outer join ruang r on jd.KodeRuang=r.Kode
	  where jd.Tahun='$thn' and jd.KodeJurusan='$kdj' $strprg
	  order by jd.Hari, jd.JamMulai";

	$r = mysql_query($s) or die ("$strCantQuery: $s<br>".mysql_error());
	if ($prn == 0) $strkaps0 = "<th class=ttl>Kaps</th> <th class=ttl>Mhsw</th>"; else $strkaps0 = '';
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <th class=ttl>Hari</th>
	  <th class=ttl>Ruang</th><th class=ttl>Kampus</th>
	  <th class=ttl>Jam</th>
	  <th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Glob</th>
	  <th class=ttl>Program</th>
	  <th class=ttl>SKS</th>
	  <th class=ttl>Dosen</th>
	  $strkaps0
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  $hr = $row['HR'];
	  $rng = $row['KodeRuang'];
	  $kmps = $row['KodeKampus'];
	  $jm = $row['jm']; $js = $row['js'];
	  $jid = $row['ID'];
	  $kmk = $row['KodeMK'];
	  $mk = $row['MK'];
	  $kl = $row['PRG'];
	  if (empty($kl)) $kl = '&nbsp;';
	  $sks = $row['SKS'];
	  $dsn = $row['Dosen'];
	  $kps = $row['Kapasitas'];
	  $mhsw = HitungMhsw($jid);
	  if ($prn == 0) {
	    $strkaps = "<td class=lst align=right>$kps</td>
		<td class=lst align=right><a href='sysfo.php?syxec=jdwlkuliah&md1=0&jid=$row[ID]&mkid=$row[MKID]'>$mhsw</a></td>";
	  }
	  else {
	    $strkaps = '';
	  }
	  echo <<<EOF
		<tr><td class=ttl>$hr</td>
	    <td class=lst>$rng</td><td class=lst>$kmps</td>
	    <td class=lst>$jm-$js</td>
	    <td class=lst><a href='sysfo.php?syxec=jdwlkuliah&md=0&jid=$jid'>$kmk</a></td>
	    <td class=lst>$mk</td>
		<td class=lst><img src='image/$row[Global].gif' border=0></td>
	    <td class=lst>$kl</td>
	    <td class=lst align=right>$sks</td> 
	    <td class=lst>$dsn</td>
		$strkaps
	  </tr>
EOF;
	}
	echo "</table>";
}
function JadwalForm($thn, $kdj, $md, $kurid, $jid) {
  global $strCantQuery;
	if ($md == 0) {
	  $s = "select *,TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js
	    from jadwal where ID=$jid limit 1";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  $thn = mysql_result($r, 0, 'Tahun');
	  $kdf = mysql_result($r, 0, 'KodeFakultas');
	  $kdj = mysql_result($r, 0, 'KodeJurusan');
	  $IDMK = mysql_result($r, 0, 'IDMK');
	  $IDDosen = mysql_result($r, 0, 'IDDosen');
	  $Program = mysql_result($r, 0, 'Program');
	  $Hari = mysql_result($r, 0, 'Hari');
	  $JamMulai = mysql_result($r, 0, 'jm');
	  $JamSelesai = mysql_result($r, 0, 'js');
	  //$KodeKampus = mysql_result($r, 0, 'KodeKampus');
	  $KodeRuang = mysql_result($r, 0, 'KodeRuang');
	  $jdl = 'Edit Jadwal';
	  $Rencana = mysql_result($r, 0, 'Rencana');
	  $Realisasi = mysql_result($r, 0, 'Realisasi');
	  if (mysql_result($r, 0, 'Global') == 'Y') $glob = 'checked'; else $glob = '';
	  $ada = GetaField("krs", "IDJadwal", $jid, "count(ID)")+0;
	  if ($ada > 1) $ro = "<tr><th class=wrn colspan=2>Tidak dpt Diubah krn sudah ada mhsw yg mengambil</th></tr>";
	  else $ro = '';
	}
	elseif ($md == 1) {
	  $kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	  $IDMK = 0;
	  $IDDosen = 0;
	  $Program = '';
	  $Hari = 1;
	  $JamMulai = '06:00';
	  $JamSelesai = '07:00';
	  //$KodeKampus = '';
	  $KodeRuang = '';
	  $jdl = 'Tambah Jadwal';
	  $Rencana = 0;
	  $Realisasi = 0;
	  $glob = '';
	  $ro = '';
	}
	else {
	  $kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	  $IDMK = $_REQUEST['IDMK'];
	  $IDDosen = $_REQUEST['IDDosen'];
	  $Program = $_REQUEST['Program'];
	  $Hari = $_REQUEST['Hari'];
	  $JamMulai = $_REQUEST['JamMulai'];
	  $JamSelesai = $_REQUEST['JamSelesai'];
	  if (isset($_REQUEST['KodeRuang'])) $KodeRuang = $_REQUEST['KodeRuang'];
	  else $KodeRuang = '';
	  $jdl = "Penjadwalan Gagal";
	  $Rencana = $_REQUEST['Rencana'];
	  $Realisasi = $_REQUEST['Realisasi'];
	  if (isset($_REQUEST['glob']) && $_REQUEST['glob'] == 'Y') $glob = 'checked'; else $glob='';
	  $ro = '';
	}
	$oHari = $Hari;
	$ojm = $JamMulai;
	$ojs = $JamSelesai;
	//function GetOption($_table, $_field, $_order='', $_default='', $_where='', $_value='') {
	$sid = session_id();
	$optmk = GetOption2('matakuliah', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $IDMK, "KurikulumID=$kurid", 'ID');
	$optds = GetOption2('dosen', "concat(Name, ' (', Login, ')')", 'Name', $IDDosen, "KodeFakultas='$kdf'", 'ID');
	$optrg = GetOption2('ruang', "concat(KodeKampus, ' -- ', Kode)", 'KodeKampus,Kode', $KodeRuang, '', 'Kode');
	$opthr = GetOption2('hari', 'Nama', 'ID', $Hari, '', 'ID');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $Program, '', 'Kode');
	echo <<<EOF
	  <form name=f1 action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='jdwlkuliah'>
	  <input type=hidden name='md' value='$md'>
	  <input type=hidden name='thn' value='$thn'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='jid' value='$jid'>
	  <table class=basic cellspacing=1 cellpadding=2>$ro
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=lst>Mata Kuliah</td><td class=lst><select name='IDMK'>$optmk</select></td></tr>
	  <tr><td class=lst>Ditawarkan Global</td><td class=lst><input type=checkbox name='glob' value='Y' $glob> Semua Jurusan dpt Mengambil</td></tr>
	  <tr><td class=lst>Dosen</td><td class=lst><select name='IDDosen'>$optds</select></td></tr>
	  <tr><td class=lst>Ruang</td><td class=lst><select name='KodeRuang'>$optrg</select></td></tr>
	  <tr><td class=lst>Program</td><td class=lst><select name='Program'>$optprg</select></td></tr>
	  <tr><td class=lst>Hari</td><td class=lst><select name='Hari'>$opthr</select></td></tr>
	  <tr><td class=lst>Jam Mulai</td><td class=lst><input type=text name='JamMulai' value='$JamMulai' size=6 maxlength=5></td></tr>
	  <tr><td class=lst>Jam Selesai</td><td class=lst><input type=text name='JamSelesai' value='$JamSelesai' size=6 maxlength=5></td></tr>
	  <tr><td class=lst>Rencana Tatap Muka</td><td class=lst><input type=text name='Rencana' value='$Rencana' size=3 maxlength=3></td></tr>
	  <tr><td class=lst>Realisasi Tatap Muka</td><td class=lst><input type=text name='Realisasi' value='$Realisasi' size=3 maxlength=3></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcjdwl' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='reset'>&nbsp;
	  <input type=button name='balik' value='Kembali' onClick="location='sysfo.php?syxec=jdwlkuliah&PHPSESSID=$sid'">&nbsp;
	  <input type=button name='prcdel' value='Hapus' onClick="location='sysfo.php?syxec=jdwlkuliah&del=$jid&PHPSESSID=$sid'">
	  </td></tr>
	  </table></form>
EOF;
}
function GetErrorRuang($r, $msg) {
  for ($i=0; $i < mysql_num_rows($r); $i++) {
	  $strmk = GetFields('matakuliah', 'ID', mysql_result($r, $i, 'IDMK'), 'Kode,Nama_Indonesia');
	  $str1 = "<li>$msg<br>". 
	    GetaField('hari', 'ID', mysql_result($r, $i, 'Hari'), 'Nama'). ' '.
	    mysql_result($r, $i, 'JamMulai').' - '.mysql_result($r, $i, 'JamSelesai'). ' : '.
	    $strmk['Kode'] . ' - '. $strmk['Nama_Indonesia'] . ' dari '.
		mysql_result($r, $i, 'KodeFakultas') . ' : ' . mysql_result($r, $i, 'KodeJurusan').
		'</li>';
	}
	return $str1;
}
function CheckRuang ($jid, $kdk, $kdr, $hr, $jm, $js) {
  global $strCantQuery, $fmtErrorMsg;
	$sm = "select * from jadwal where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari='$hr' and
	  JamMulai <= '$jm:00' and '$jm:00' <= JamSelesai and ID<>'$jid' ";
	$rm = mysql_query($sm) or die ("$strCantQuery: $sm");
	$hm = mysql_num_rows($rm);
	if ($hm > 0) $str1 = GetErrorRuang($rm, '<b>Jam Mulai Bentrok.</b>');
	else $str1 = '';
	
	$ss = "select * from jadwal where KodeKampus='$kdk' and KodeRuang='$kdr' and Hari=$hr and
	  JamMulai <= '$js' and '$js' <= JamSelesai and ID<>$jid ";
	$rs = mysql_query($ss) or die ("$strCantQuery: $ss");
	$hs = mysql_num_rows($rs);
	if ($hs > 0) $str2 = GetErrorRuang($rs, '<b>Jam Selesai Bentrok.</b>');
	else $str2 = '';
	
	if (!($hm == 0 && $hs ==0))	DisplayHeader($fmtErrorMsg, "Tidak dapat dijadwalkan di <b>$kdk - $kdr</b>.<br>
	  Ruang telah dipakai oleh : <br><ul> $str1 $str2 </ul>");

	return ($hm == 0) && ($hs == 0);
}
function PrcJdwl($kdj) {
  global $strCantQuery, $fmtErrorMsg, $md, $strTahunNotActive, $thn;
	//$thn = $_REQUEST['thn'];
	if (!isTahunAktif($thn, $kdj)) {
	  DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	  $md = -1;
	}
	else {
    $md = $_REQUEST['md'];

	$kdj = $_REQUEST['kdj'];
	$kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	$jid = $_REQUEST['jid'];
	$IDMK = $_REQUEST['IDMK'];
	$arrmk = GetFields('matakuliah', 'ID', $IDMK, 'Kode, SKS, Nama_Indonesia');
	$KDMK = $arrmk['Kode'];
	$SKS = $arrmk['SKS'];
	$IDDosen = $_REQUEST['IDDosen'];
	$Program = $_REQUEST['Program'];
	$KodeRuang = $_REQUEST['KodeRuang'];
	$KodeKampus = GetaField('ruang', 'Kode', $KodeRuang, 'KodeKampus');
	$Hari = $_REQUEST['Hari'];
	$jm = $_REQUEST['JamMulai'];
	$js = $_REQUEST['JamSelesai'];
	$unip = $_SESSION['unip'];
	$Rencana = $_REQUEST['Rencana'];
	$Realisasi = $_REQUEST['Realisasi'];
	if (isset($_REQUEST['glob'])) $glob = $_REQUEST['glob']; else $glob = 'N';
	if (CheckRuang($jid, $KodeKampus, $KodeRuang, $Hari, $jm, $js)) {
	  if ($md == 0 || $md == 2) {
	    $s = "update jadwal set IDMK='$IDMK', IDDosen='$IDDosen', Global='$glob', Program='$Program', Hari='$Hari', JamMulai='$jm', JamSelesai='$js', 
	      KodeKampus='$KodeKampus', KodeRuang='$KodeRuang', Rencana='$Rencana', Realisasi='$Realisasi'
		  where ID=$jid  "; 
	  }
	  elseif ($md == 1 || $md == 3) {
	    $s = "insert into jadwal (Tahun, KodeFakultas, KodeJurusan, IDMK, KodeMK, NamaMK, 
		  Global, SKS, SKSHonor, IDDosen, Program, Hari, 
		  JamMulai, JamSelesai, KodeKampus, KodeRuang, unip, Tanggal, Rencana, Realisasi) 
		  values ('$thn', '$kdf', '$kdj', '$IDMK', '$KDMK', '$arrmk[Nama_Indonesia]', 
		  '$glob', '$SKS', '$SKS', '$IDDosen', '$Program', '$Hari', '$jm',
		  '$js', '$KodeKampus', '$KodeRuang', '$unip', now(), '$Rencana', '$Realisasi')  "; 
	  }
	  $r = mysql_query($s) or die ("$strCantQuery: $s<br>".mysql_error());
	  $md = -1;
	}
	else {
	  if ($md == 0) $md = 2;
	  elseif ($md == 1) $md = 3;
	}
	}
}
function HeaderJadwal($jid) {
  global $strCantQuery, $fmtErrorMsg;
	$s0 = "select j.*, mk.Kode as KMK, mk.Nama_Indonesia, concat(ds.Name, ', ', ds.Gelar) as DSN,
	  hr.Nama as HR, time_format(j.JamMulai, '%H:%i') as MUL, time_format(j.JamSelesai, '%H:%i') as SEL,
	  r.Kapasitas, pr.Nama_Indonesia as PRG
	  from jadwal j left join matakuliah mk on j.IDMK=mk.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join hari hr on j.Hari=hr.ID
	  left outer join ruang r on j.KodeRuang=r.Kode
	  left outer join program pr on j.Program=pr.Kode
	  where j.ID=$jid limit 1";
	$r0 = mysql_query($s0) or die ("$strCantQuery: $s0<br>".mysql_error());
	$kmk = mysql_result($r0, 0, 'KMK');
	$mk = mysql_result($r0, 0, 'Nama_Indonesia');
	$dsn = mysql_result($r0, 0, 'DSN');
	$hr = mysql_result($r0, 0, 'HR');
	$mul = mysql_result($r0, 0, 'MUL');
	$sel = mysql_result($r0, 0, 'SEL');
	$kmp = mysql_result($r0, 0, 'KodeKampus');
	$rng = mysql_result($r0, 0, 'KodeRuang');
	$kap = mysql_result($r0, 0, 'Kapasitas');
	$prg = mysql_result($r0, 0, 'PRG');
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=ttl>Mata Kuliah</td><td class=lst>$kmk - $mk</td></tr>
	  <tr><td class=ttl>Program</td><td class=lst>$prg</td></tr>
	  <tr><td class=ttl>Dosen Pengampu</td><td class=lst>$dsn</td></tr>
	  <tr><td class=ttl>Jadwal</td><td class=lst>$hr, $mul - $sel</td></tr>
	  <tr><td class=ttl>Kampus - Ruang</td><td class=lst>$kmp - $rng</td></tr>
	  <tr><td class=ttl>Kapasitas Ruang</td><td class=lst>$kap</td></tr>
	  </table><br>
EOF;
}
function JadwalMhsw($jid, $thn) {
  global $strCantQuery, $fmtErrorMsg;
	HeaderJadwal($jid);
	$idmk = GetaField('jadwal', 'ID', $jid, 'IDMK');
	$ada = GetaField('jadwal', "Tahun='$thn' and ID<>$jid and IDMK", $idmk, 'ID');
	if (!empty($ada)) {
	  $opt = '' ;//GetOption2("jadwal j left outer join program pr on j.Kelas=pr.Kode", 'pr.Nama_Indonesia', 'j.Kelas',
	  //$jid, "j.IDMK=$idmk and j.Tahun='$thn'", 'j.ID', 1);
	}

	$s = "select k.*, m.Name
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid order by k.NIM";
	$r = mysql_query($s) or die("$strCantQuery: $s <br>".mysql_error());
	$nmr = 0;
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Pindah</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $nmr++;
	  if (!empty($ada))
	    $strchg = "<form action='sysfo.php' method=GET>
		  <input type=hidden name='syxec' value='jdwlkuliah'>
		  <input type=hidden name='jid' value=$jid>
		  <input type=hidden name='kid' value=$row[ID]>
		  <input type=hidden name='md1' value=0>
		  <input type=hidden name='prcchg' value=1>
		  <td class=lst><select name='chg' onChange='this.form.submit()'>$opt</select></td></form>";
	  else $strchg = '<td class=lst>&nbsp;</td>';

	  echo <<<EOF
	    <tr><td class=lst>$nmr</td>
		<td class=lst>$row[NIM]</td><td class=lst>$row[Name]</td>
		$strchg
		</tr>
EOF;
	}
	echo "</table>";
}
function PrcChg() {
  global $strCantQuery, $fmtErrorMsg;
  $jid = $_REQUEST['jid'];
	$kid = $_REQUEST['kid'];
	$chg = $_REQUEST['chg'];
	if ($chg > 0) {
	$arr = GetFields('jadwal', 'ID', $chg, 'Tahun,ID,IDMK,IDDosen');
	$s = "update krs set Tahun='$arr[Tahun]', IDJadwal=$arr[ID],
	  IDMK=$arr[IDMK], IDDosen=$arr[IDDosen] where ID=$kid";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	}
}
function PrcDel() {
	global $fmtErrorMsg;
  $del = $_REQUEST['del'];
  $s = "select count(*) as JML from krs where IDJadwal='$del'";
  $r = mysql_query($s) or die("Query gagal: $s<br>".mysql_error());
  $w = mysql_fetch_array($r);
  
  if (($w['JML']+0) > 0) {
	  $IDMK = GetaField('jadwal', 'ID', $del, 'IDMK');
	  $MK = GetaField('matakuliah', 'ID', $IDMK, "concat(Kode, ' - ', Nama_Indonesia)");
	  DisplayHeader($fmtErrorMsg, "Proses Hapus Dibatalkan.<hr size=1 color=silver>
	    Mata kuliah <b>$MK</b> tidak dapat dihapus<br>
      karena telah ada mahasiswa yang mengambilnya.<br>
      Jumlah mahasiswa yg telah mengambil KRS mata kuliah ini: <b class=box>$w[JML]</b><hr size=1 color=silver>
      Pilihan: <a href='sysfo.php?syxec=jdwlkuliah&md1=0&jid=$del'>Lihat mhsw yg mengambil</a>");
  }
  else mysql_query("delete from jadwal where ID=$del");
}
  
  // *** Bagian Utama ***
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
  if (isset($_REQUEST['prg'])) {
    $prg = $_REQUEST['prg'];
	$_SESSION['prg'] = $prg;
  }
  else {
    if (isset($_SESSION['prg'])) $prg = $_SESSION['prg'];
	else $prg = '';
  }
  if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['md1'])) $md1 = $_REQUEST['md1']; else $md1 = -1;
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

  DisplayHeader($fmtPageTitle, 'Jadwal Kuliah');
  if (isset($_REQUEST['prcjdwl'])) PrcJdwl($kdj);
  if (isset($_REQUEST['prcchg'])) PrcChg();
  if (isset($_REQUEST['del'])) PrcDel();
  DispOptJdwl0();
  echo "<br>";
  if (!empty($thn) && !empty($kdj)) {
	if ($md1 == -1) {
	  if ($prn == 0) echo GetKur4Jdwl($kdj, $prg);
	  if ($md == -1) Jadwal($thn, $kdj, $prg);
	  else JadwalForm($thn, $kdj, $md, $kurid, $jid);
	} else JadwalMhsw($jid, $thn);
  }
?>