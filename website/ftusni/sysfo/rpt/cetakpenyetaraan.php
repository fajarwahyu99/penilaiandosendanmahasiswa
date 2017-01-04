<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003

  // *** FUngsi ***
  function CetakHeader($r) {
	$nim = mysql_result($r, 0, 'NIM');
	$nma = mysql_result($r, 0, 'Name');
	$fak = mysql_result($r, 0, 'FAK');
	$jur = mysql_result($r, 0, 'JUR');
	$jen = mysql_result($r, 0, 'JEN');
	$tgl = date('d-m-Y');
	$jam = date('H:i:s');
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=0 width=100%>
	<tr><td class=basic align=right>F-PK-S.1.1-04<br>Revisi: 01</td></tr>
	</table>
	<center><b>KARTU HASIL PENYETARAAN</b></center><br>
	<table class=basic cellspacing=0 cellpadding=0 width=100%>
	<tr><td>
	  <table class=basic cellspacing=0 cellpadding=0>
	  <tr><td colspan=2>STIE SUPRA</td></tr>
	  <tr><td>NIM Mahasiswa</td><td>: $nim</td></tr>
	  <tr><td>Nama</td><td>: $nma</td></tr>
	  <tr><td>Fak/Jurusan</td><td>: $fak/$jur ($jen)</td></tr>
	  </table>
	</td><td align=right>
	  <table class=basic cellspacing=0 cellpadding=0>
	  <tr><td>Tanggal</td><td>: $tgl</td></tr>
	  <tr><td>Jam</td><td>: $jam</td></tr>
	  <tr><td>Halaman</td><td>: 1</td></tr>
	  </table>
	</td></tr>
	</table><br>
EOF;
  }
  function CetakDetailPenyetaraan($nim) {
    global $strCantQuery;
	$s = "select k.*
	  from krs k
	  where Setara='Y' and NIM='$nim' order by KodeMK";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$cnt = 0;
	$tsks = 0; $tmutu = 0;
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>No.</th><th class=ttl>Kode MK</th><th class=ttl>Nama Mata Kuliah</th>
	  <th class=ttl>SKS</th><th class=ttl>H. Mutu</th><th class=ttl>Nilai Mutu</th>
	  <th class=ttl>Sem/Tahun</th><th class=ttl>Keterangan</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $nilaimutu = number_format($w['SKS'] * $w['Bobot'], 0, ',', '.');
	  $tsks += $w['SKS'];
	  $tmutu += $nilaimutu;
	  echo <<<EOF
	  <tr><td class=uline>$cnt</td><td class=uline>$w[KodeMK]</td>
	  <td class=uline>$w[NamaMK]</td><td class=uline align=right>$w[SKS]</td>
	  <td class=uline align=center>$w[GradeNilai]</td><td class=uline align=right>$nilaimutu&nbsp;</td>
	  <td class=uline>$w[Sesi]/$w[Tahun]</td><td class=uline>&nbsp;NP&nbsp;</td></tr>
EOF;
	}
	$tgl = date('d-m-Y');
	if ($tsks == 0) $ipk = 0;
	else $ipk = number_format($tmutu / $tsks, 2, ',', '.');
	echo "<tr><td class=uline colspan=3 align=right>Jumlah: &nbsp;</td>
	<td class=uline align=right><b>$tsks</td><td class=uline>&nbsp;</td>
	<td class=uline align=right><b>$tmutu&nbsp;</td>
	<td class=uline colspan=2>&nbsp;</td></tr>
	</table><br>
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td class=basic width=50%>IP Kumulatif: $ipk</td>
	<td class=basic align=right>Jakarta, $tgl</td></tr>
	</table><br>";
  }
  function CetakFooter($kdj='') {
    $arr = GetFields('jurusan', 'Kode', $kdj, 'TTJabatan1,TTJabatan2,TTPejabat1,TTPejabat2');
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td width=30% align=center>Mengetahui,</td><td></td><td width=30% align=center>Adm. Akademik,<br><br><br></td></tr>
	<tr><td align=center><u>$arr[TTPejabat1]</u><br>$arr[TTJabatan1]</td><td></td>
	<td align=center><u>$arr[TTPejabat2]</u><br>$arr[TTJabatan2]</td></tr>
	</table>
EOF;
  }
  function cetakpenyetaraan($nim='') {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select m.NIM, m.Name, m.KodeJurusan, m.KodeFakultas, m.KodeProgram,
	  j.Nama_Indonesia as JUR, f.Nama_Indonesia as FAK, je.Nama as JEN
	  from mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode
	  where m.NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	if (mysql_num_rows($r) > 0) {
	  CetakHeader($r);
	  CetakDetailPenyetaraan($nim);
	  CetakFooter(mysql_result($r, 0, 'KodeJurusan'));
	}
	else DisplayHeader($fmtErrorMsg, "Mahasiswa dengan NIM: <b>$nim</b> tidak ditemukan.");
  }
  
  // *** Parameter2 ***
  $nim = $_REQUEST['PerMhsw'];

  // *** Bagian Utama ***
  cetakpenyetaraan($nim);
?>