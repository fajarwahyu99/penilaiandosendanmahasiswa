<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  $nr = "\n";
  
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
	  jr.Nama_Indonesia as JUR, je.Nama as JEN, j.SKS,
	  hr.Nama as HR, TIME_FORMAT(JamMulai, '%H:%i') as ML, TIME_FORMAT(JamSelesai, '%H:%i') as SL,
	  j.KodeKampus as KMPS, KodeRuang as RNG, j.Tanggal as TGL,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  left outer join hari hr on j.Hari=hr.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  left outer join jenjangps je on jr.Jenjang=je.Kode
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
	  jr.Nama_Indonesia as JUR, je.Nama as JEN, j.SKS,
	  hr.Nama as HR, TIME_FORMAT($_ml, '%H:%i') as ML, TIME_FORMAT($_sl, '%H:%i') as SL,
	  $_kmps as KMPS, $_rng as RNG, DATE_FORMAT($_tgl, '%d-%m-%Y') as TGL,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  left outer join hari hr on hr.ID=DAYOFWEEK($_tgl)
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  left outer join jenjangps je on jr.Jenjang=je.Kode
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
	  $prn = "<a href='sysfo.php?syxec=cetakabsen&jid=$jid&ujn=$ujn&ctk=1'><img src='image/printer.gif' border=0></a>";
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
  function CetakHeader($f, $thn, $kdj, $jid, $ujn, $hal=1) {
    global $nr;
	$r = GetJdwlDetail($thn, $kdj, $jid, $ujn);
	$jid = mysql_result($r, 0, 'ID');
	$kmk = mysql_result($r, 0, 'Kode');
	$MK = mysql_result($r, 0, 'MK');
	$PRG = mysql_result($r, 0, 'PRG');
	$HR = mysql_result($r, 0, 'HR');
	$ML = mysql_result($r, 0, 'ML'); $SL = mysql_result($r, 0, 'SL');
	$kmps = mysql_result($r, 0, 'KMPS'); $rng = mysql_result($r, 0, 'RNG');
	$sks = mysql_result($r, 0, 'SKS');

	$dsn = mysql_result($r, 0, 'DSN');
	$tnd = mysql_result($r, 0, 'Tunda');
	$jur = mysql_result($r, 0, 'JUR');
	$jen = mysql_result($r, 0, 'JEN');
	$nmthn = GetaField("tahun", "KodeJurusan='$kdj' and Kode", $thn, 'Nama');
	if (!empty($ujn)) $tgl = mysql_result($r, 0, 'TGL'); else $tgl = '';
	fwrite($f, chr(15) . "\n\r\n\r\n\r\n\r\n\r");
	if (empty($ujn)) $berlaku = str_pad(date('d-m-Y'), 40, ' ');
	else $berlaku = str_pad(' ', 40, ' ');
	fwrite($f, str_pad("Program   : $PRG", 50, ' ') . $berlaku . $nr);
	fwrite($f, str_pad("                 $nmthn", 86, ' ') . "$HR - $tgl $nr");
	fwrite($f, str_pad("                 $jur - ($jen)", 86, ' ') . "$ML - $SL $nr");
	fwrite($f, str_pad("                 $kmk - $MK ($sks)", 86, ' ') . "$kmps - $rng $nr");
	fwrite($f, str_pad("                 $dsn", 86, ' ') . "$hal");
	fwrite($f, "$nr $nr $nr $nr $nr");
  }
  function DaftarAbsen($thn, $kdj, $jid, $ujn) {
    global $strCantQuery, $nr;

	$targ = "sysfo/temp/absen.$jid.txt";
	if (file_exists($targ)) unlink($targ);
	$f = fopen($targ, "w");
	
    $s = "select k.ID, k.NIM, m.Name as NME, k.Tunda
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid
	  order by k.NIM ";
	$t = mysql_query($s) or die("$strCantQuery: $s");
	$brs = 0;
	$hal = 0;
	$maxbrs = 50;
	while ($w = mysql_fetch_array($t)) {
	  $brs++;
	  if ($brs > $maxbrs) $brs = 1;
	  if ($brs == 1) {
	    $hal++;
	    CetakHeader($f, $thn, $kdj, $jid, $ujn, $hal);
	  }
	  $arr = GetFields("khs", "NIM", $w['NIM'], "sum(Biaya) as TBiaya, sum(Bayar) as TBayar");
	  if (($arr['TBiaya'] - $arr['TBayar']) > 0) $htg = "Hutang"; else $htg = '';
	  fwrite($f, str_pad($brs, 3, ' ') . str_pad($w['NIM'], 15, ' ') . str_pad($w['NME'], 50, ' ') . 
	    str_pad($htg, 7, ' ') . $nr);
	}
	
	  // tulis
	  fclose($f);
	  echo <<<EOF
	  <SCRIPT LANGUAGE=JavaScript>
	  <!---
	    window.open("$targ");
	  -->
	  </SCRIPT>
EOF;
  }
  
  
  // *** PARAMETER ***
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$ujn = GetSetVar('ujn');
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
if (isset($_REQUEST['ctk'])) DaftarAbsen($thn, $kdj, $jid, $ujn);
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Absensi ".GetCaptionUjian($ujn));
  DispOptJdwl0('cetakabsen');
  GetOptAbsen($ujn);
  if (!empty($thn) && !empty($kdj)) {
    DispJdwlKuliah($thn, $kdj, $ujn);
  }
?>