<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNCTION ***
  function DispNilaiMhsw($jid) {
    global $strCantQuery;
	$s = "select k.*, m.Name
	  from krs k inner join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid 
	  order by k.NIM ";
	$r = mysql_query($s) or die ("$strCantQuery: $s.<br>".mysql_error());
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Nama Mahasiswa</th>
	  <th class=ttl>Nilai Akhir</th><th class=ttl>Grade</th><th class=ttl>Bobot</th>
	  <th class=ttl>Status</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $nim = $row['NIM'];
	  $nme = $row['Name'];
	  $nil = $row['Nilai'];
	  $grd = $row['GradeNilai'];
	  $bbt = $row['Bobot'];
	  $tnd = $row['Tunda'];
	  if ($tnd == 'Y') { $cls = 'class=nac'; $strtnd = 'Ditahan'; }
	  else { $cls = 'class=lst'; $strtnd = '-'; }
	  echo "<tr><td $cls>$nim</td><td $cls>$nme</td>
	    <td $cls align=right>$nil</td><td $cls>$grd</td>
		<td $cls align=right>$bbt</td><td $cls align=center>$strtnd</td></tr>";
	}
	echo "</table>";
  }
  function DispDetNilaiMhsw($jid) {
    global $strCantQuery;
	$nli = new NewsBrowser;
	$nli->query = "select k.*, m.Name
	  from krs k inner join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid 
	  order by k.NIM ";
	$nli->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Nama Mahasiswa</th><th class=ttl>Hadir</th>
	  <th class=ttl>Tgs 1</th><th class=ttl>Tgs 2</th><th class=ttl>Tgs 3</th>
	  <th class=ttl>Tgs 4</th><th class=ttl>Tgs 5</th>
	  <th class=ttl>Mid</th><th class=ttl>Ujian</th>
	  <th class=ttl>&nbsp;</th></tr>";
	$nli->detailfmt = "<tr><form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhswnilai'>
	  <input type=hidden name='jid' value=$jid>
	  <input type=hidden name='kid' value==ID=>
	  <td class=lst>=NIM=</td><td class=lst>=Name=</td>
	  <td class=lst><input type=hidden name='Hadir' value='=Hadir=' size=3 maxlength=5>=Hadir=</td>
	  <td class=lst><input type=text name='Tugas1' value='=Tugas1=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='Tugas2' value='=Tugas2=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='Tugas3' value='=Tugas3=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='Tugas4' value='=Tugas4=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='Tugas5' value='=Tugas5=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='mid' value='=NilaiMID=' size=3 maxlength=5></td>
	  <td class=lst><input type=text name='ujn' value='=NilaiUjian=' size=3 maxlength=5></td>
	  <td class=lst><input type=submit name='prcnil' value='Simpan'></td>
	  </form></tr>";
	$nli->footerfmt = "</table>";
	echo $nli->BrowseNews();
  }  
  function PrcNilai($kdj) {
    Global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	$jid = $_REQUEST['jid'];
	$kid = $_REQUEST['kid'];
	$hdr = $_REQUEST['Hadir'];
	$tg1 = $_REQUEST['Tugas1'];
	$tg2 = $_REQUEST['Tugas2'];
	$tg3 = $_REQUEST['Tugas3'];
	$tg4 = $_REQUEST['Tugas4'];
	$tg5 = $_REQUEST['Tugas5'];
	$mid = $_REQUEST['mid'];
	$ujn = $_REQUEST['ujn'];
	$s = "update krs set Hadir=$hdr, Tugas1=$tg1, Tugas2=$tg2, Tugas3=$tg3, Tugas4=$tg4, Tugas5=$tg5,
	  NilaiMid=$mid, NilaiUjian=$ujn where ID=$kid";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	}
  }
  function DispPersentaseNilai($jid) {
    Global $strCantQuery;
	$s = "select PersenHadir, PersenTugas, PersenMID, PersenUjian, JumlahTugas
	  from jadwal
	  where ID=$jid limit 1";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	$ph = mysql_result($r, 0, 'PersenHadir');
	$pt = mysql_result($r, 0, 'PersenTugas');
	$pm = mysql_result($r, 0, 'PersenMID');
	$pu = mysql_result($r, 0, 'PersenUjian');
	$jt = mysql_result($r, 0, 'JumlahTugas');
	echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhswnilai'>
	  <input type=hidden name='jid' value=$jid>
	  <tr><th class=ttl colspan=3>Persentase Nilai</th></tr>
	  <tr><td class=lst>Kehadiran/Absensi</td><td class=lst><input type=text name='ph' value='$ph' size=5 maxlength=5>%</td>
	    <td class=lst rowspan=5 align=center><image src='image/tux001.jpg'><br>
		<input type=submit name='prcpersen' value='Simpan'>&nbsp;<input type=reset name=reset value='Reset'>
	  </td></tr>
	  <tr><td class=lst>Tugas-tugas</td><td class=lst><input type=text name='pt' value='$pt' size=5 maxlength=5>%</td></tr>
	  <tr><td class=lst>Mid Semester</td><td class=lst><input type=text name='pm' value='$pm' size=5 maxlength=5>%</td></tr>
	  <tr><td class=lst>Ujian Semester</td><td class=lst><input type=text name='pu' value='$pu' size=5 maxlength=5>%</td></tr>
	  <tr><td class=lst>Jumlah Tugas</td><td class=lst><input type=text name='jt' value='$jt' size=5 maxlength=5></td></tr>
	  </table>
EOF;
  }
  function PrcPersen($kdj) {
    Global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	$jid = $_REQUEST['jid'];
	$ph = $_REQUEST['ph'];
	$pt = $_REQUEST['pt'];
	$pm = $_REQUEST['pm'];
	$pu = $_REQUEST['pu'];
	$jt = $_REQUEST['jt'];
	if ($ph + $pt + $pm + $pu == 100) {
	  $s = "update jadwal set PersenHadir=$ph, PersenTugas=$pt, PersenMID=$pm, PersenUjian=$pu,
	    JumlahTugas=$jt
	    where ID=$jid ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else DisplayHeader($fmtErrorMsg, "Jumlah persentase nilai tidak 100%. Perubahan tidak disimpan.");
	}
  }
  function PrcAbsen($kdj) {
    Global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	$sa = "select * from absensi where NotActive='N'";
	$ra = mysql_query($sa) or die("$strCantQuery: $sa");
	$arra = array();
	for ($i=0; $i < mysql_num_rows($ra); $i++) {
	  $arra[mysql_result($ra, $i, 'Kode')] = mysql_result($ra, $i, 'Nilai');
	}
	
	$jid = $_REQUEST['jid'];
	$s = "select * from jadwal where ID=$jid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$hdr = 0;
	while ($row = mysql_fetch_array($r)) {
	  for ($i=1; $i <= 20; $i++) {
	    if ($row["hd_$i"] == 1) $hdr++;
	  }
	}
	echo "<table class=basic cellspacing=1 cellpadding=2><tr><th class=ttl>Jumlah Tatap Muka</th>
	  <td class=lst>$hdr</td></tr></table>";
	$sam = "select * from krs where IDJadwal=$jid";
	$ram = mysql_query($sam) or die("$strCantQuery: $sam");
	while ($row = mysql_fetch_array($ram)) {
	  $mhs = 0;
	  $krs = $row['ID'];
	  for ($i=1; $i <= 20; $i++) {
	    if (!empty($row["hr_$i"])) {
	      $tmp = $arra[$row["hr_$i"]];
		  $mhs = $mhs + $tmp;
		}
	  }
	  if ($hdr == 0) $Hadir = 0; else $Hadir = $mhs/$hdr*100;
	  mysql_query("update krs set Hadir=$Hadir where ID=$krs") or die("$strCantQuery");
	}
	}
  }
  function PrcNilaiMhsw($kdj) {
    Global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
    $jid = $_REQUEST['jid'];
	$arrprs = GetFields('jadwal', 'ID', $jid, 'PersenHadir,PersenTugas,PersenMID,PersenUjian,JumlahTugas,KodeFakultas');
	$phdr = $arrprs['PersenHadir'];
	$ptgs = $arrprs['PersenTugas'];
	$pmid = $arrprs['PersenMID'];
	$pujn = $arrprs['PersenUjian'];
	$jtgs = $arrprs['JumlahTugas'];
	$kdf = $arrprs['KodeFakultas'];
	
	$s = "select * from krs where IDJadwal=$jid and Setara='N'";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	while ($row = mysql_fetch_array($r)) {
	  $kid = $row['ID'];
	  $nhdr = $row['Hadir'];
	  $nmid = $row['NilaiMID'];
	  $nujn = $row['NilaiUjian'];
	  $_tgs = 0;
	  for ($i=1; $i <= $jtgs; $i++) $_tgs = $_tgs + $row["Tugas$i"];
	  if ($jtgs == 0) $ntgs = 0; else $ntgs = $_tgs / $jtgs;
	  $nilai = ($nhdr * $phdr / 100) + ($ntgs * $ptgs / 100) + 
	    ($nmid * $pmid / 100) + ($nujn * $pujn / 100);
	  $agrd = GetGrade($kdj, $nilai);
	  $grade = $agrd[0];
	  $bobot = $agrd[1];
	  $snil = "update krs set Nilai=$nilai, GradeNilai='$grade', Bobot=$bobot where ID=$kid";
	  $rnil = mysql_query($snil) or die ("$strCantQuery: $s");
	}
	}
  }

  // *** PARAMETER ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$jid = GetSetVar('jid', 0);
$mdn = GetSetVar('mdn', 0);
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Nilai Mahasiswa');
  DispOptJdwl0('mhswnilai');
  echo "<br>";
  DispJadwalMK($thn, $kdj, $jid, 'mhswnilai');
  
  if ($jid > 0) {
    $did = GetaField('jadwal', 'ID', $jid, 'IDDosen');
    if (($_SESSION['ulevel'] == 3 && $_SESSION['uid'] == $did) || $_SESSION['ulevel'] == 1) {
	}
	else die(DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas mata kuliah ini.", 0));
  }

  if ($jid > 0) {
    if (isset($_REQUEST['prcnil'])) PrcNilai($kdj);
    if (isset($_REQUEST['prcpersen'])) PrcPersen($kdj);
    if (isset($_REQUEST['processnilai'])) PrcNilaiMhsw($kdj);
    if (isset($_REQUEST['prcabsen'])) PrcAbsen($kdj);
	if ($prn == 0) {
	  $sid = session_id();
      echo "
	    <a href='sysfo.php?syxec=mhswnilai&mdn=2&jid=$jid' class=lst>Persentase Nilai</a> |
	    <a href='sysfo.php?syxec=mhswnilai&mdn=1&jid=$jid' class=lst>Detil Nilai</a>	|
	    <a href='sysfo.php?syxec=mhswnilai&mdn=0&jid=$jid' class=lst>Nilai Akhir</a> |
	    <a href='sysfo.php?syxec=mhswnilai&prcabsen=1&jid=$jid' class=lst>Proses Absensi</a> |
	    <a href='sysfo.php?syxec=mhswnilai&processnilai=1&jid=$jid' class=lst>Proses Nilai</a> |
	    ";
	  SimplePrinter("print.php?print=sysfo/mhswnilai.php&prn=1&PHPSESSID=$sid", 'Cetak Nilai Akhir');
	}
    if ($mdn == 0) DispNilaiMhsw($jid);
    if ($mdn == 1) DispDetNilaiMhsw($jid);
	if ($mdn == 2) DispPersentaseNilai($jid);
  }
?>