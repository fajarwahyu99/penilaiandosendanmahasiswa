<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // *** FUngsi2 ***
  function DispDaftarJadwalMK($thn, $kdj) {
    global $strCantQuery;
	$s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN,
	  m.Nama_Indonesia as NMK, p.Nama_Indonesia as PRG
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join matakuliah m on j.IDMK=m.ID
	  left outer join program p on j.Program=p.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by j.KodeMK";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>Program</th>
	  <th class=ttl>SKS</th><th class=ttl>Dosen</th><th class=ttl>file</th><tr>";
	while ($w = mysql_fetch_array($r)) {
	  echo "<tr><td class=lst>$w[KodeMK]</td>
	  <td class=lst>$w[NMK]</td><td class=lst>$w[PRG]</td>
	  <td class=lst>$w[SKS]</td><td class=lst>$w[DSN]</td>
	  <td class=lst align=center><a href='sysfo.php?syxec=filenilai&mid=$w[ID]'><img src='image/disket.gif' border=0></a></td>
	  </tr>";
	}
	echo "</table>";
  }
  function GetNilaiMhsw($jid) {
    global $strCantQuery;
	$s = "select k.*
	  from krs k 
	  where k.IDJadwal=$jid order by k.NIM";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$h = '';
	$n = 0;
	while ($w = mysql_fetch_array($r)) {
	  $n++;
	  $w['Hadir'] += 0;
	  $w['NilaiMID'] += 0;
	  $w['NilaiUjian'] += 0;
	  for ($i=1; $i < 6; $i++) $w["Tugas$i"] += 0;
	  $h .= "$n=$w[NIM]|$w[Hadir]|$w[NilaiMID]|$w[Tugas1]|$w[Tugas2]|$w[Tugas3]|$w[Tugas4]|$w[Tugas5]|$w[NilaiUjian]|\r\n";
	}
	return $h;
  }
  function GetNamaMhsw($jid) {
    $s = "select k.NIM, m.Name
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid order by k.NIM ";
	$r = mysql_query($s) or die(mysql_error());
	$h = '';
	while ($w = mysql_fetch_array($r)) {
	  $h .= "$w[NIM]=$w[Name]\r\n";
	}
	return $h;
  }
  function GetMasterNilai($kdj) {
    global $strCantQuery;
    $knil = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
	$s = "select * from nilai where Kode='$knil' and NotActive='N' order by BatasAtas desc";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = "JML=".mysql_num_rows($r)."\r\n";
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $w['BatasAtas'] += 0; $w['BatasBawah'] += 0; $w['Bobot'] += 0;
	  $w['BatasAtas'] = number_format($w['BatasAtas'], 2, ',', '.');
	  $w['BatasBawah'] = number_format($w['BatasBawah'], 2, ',', '.');
	  $a .= "$cnt=$w[Nilai]|$w[Bobot]|$w[BatasAtas]|$w[BatasBawah]|\r\n";
	}
	return $a;
  }
  function BuatFileNilai($mid) {
    global $strCantQuery;
	$s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN,
	  m.Nama_Indonesia as NMK, p.Nama_Indonesia as PRG, jr.Nama_Indonesia as JUR
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  left outer join matakuliah m on j.IDMK=m.ID
	  left outer join program p on j.Program=p.Kode
	  where j.ID=$mid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$w = mysql_fetch_array($r);
	$m = GetNilaiMhsw($w['ID']);
	$nm = GetNamaMhsw($w['ID']);
	$nmfile = "sysfo/temp/$w[KodeMK]-$w[IDDosen].nil";
	if (file_exists($nmfile)) unlink($nmfile);
	$f = fopen($nmfile, "w");
	$mhsw = GetaField("krs", "IDJadwal", $mid, "count(ID)");
	$NIL = GetMasterNilai($w['KodeJurusan']);
	$w['PersenHadir'] += 0;
	$w['PersenTugas'] += 0;
	$w['JumlahTugas'] += 0;
	$w['PersenMID'] += 0;
	$w['PersenUjian'] += 0;
	// data
	$dat = <<<EOF
[GENERAL]
JID=$w[ID]
MID=$w[IDMK]
DID=$w[IDDosen]
Mata Kuliah=$w[KodeMK] - $w[NMK]
SKS=$w[SKS]
Dosen=$w[DSN]
Password=$w[PasswordNilai]
Jurusan=$w[KodeJurusan] - $w[JUR]
Program=$w[Program] - $w[PRG]
Mhsw=$mhsw

[NILAI]
$NIL

[PERSENTASE]
PersenHadir=$w[PersenHadir]
PersenTugas=$w[PersenTugas]
JumlahTugas=$w[JumlahTugas]
PersenMID=$w[PersenMID]
PersenUjian=$w[PersenUjian]

[MHSW]
$m

[NAMA]
$nm
EOF;
	fwrite($f, $dat);
	fclose($f);
	echo <<<EOF
	<script language=JavaScript>
	<!--
	  wnd = window.open("dl.php?fl=$nmfile");
	-->
	</script>
EOF;
  }
  
  // *** PARAMETER ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Buat File Nilai utk Dosen");
  DispOptJdwl0('filenilai');
  echo "<br>";
  if (!empty($thn) && !empty($kdj)) DispDaftarJadwalMK($thn, $kdj);
  if (isset($_REQUEST['mid'])) BuatFileNilai($_REQUEST['mid']);
?>