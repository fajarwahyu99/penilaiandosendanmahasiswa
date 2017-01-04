<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003

  function GetTabelNilai($kdj) {
    global $strCantQuery;
	$brs = 4;
	$knil = GetaField("jurusan", "Kode", $kdj, "KodeNilai");
	$s = "select * from nilai where Kode='$knil' order by Nilai";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$cnt = mysql_num_rows($r);
	$col = ceil($cnt / $brs);
	$_col = $col -1;
	$a = "<table class=basic cellspacing=4 cellpadding=0 align=right>
	  <tr><td class=basic valign=top rowspan=$cnt>Nilai: &nbsp;</td>";
	$kol = 0;
	$cntbrs = 0;
	while ($w = mysql_fetch_array($r)) {
	  if ($cntbrs == 0) $a .= "<td valign=top><pre>";
	  if (!empty($w['Keterangan'])) $ket = ": $w[Keterangan]"; else $ket = '';
	  $nil = str_pad($w['Nilai'], 2, ' ');
	  $a .= "$nil = $w[Bobot]$ket<br>";
	  $cntbrs++;
	  if ($cntbrs == $brs) {
	    $a .= "</pre></td>";
		$cntbrs = 0;
		$kol++;
	  }
	}
	return $a . "M  = Mundur<br>T  = Tunda</pre></td></tr></table>";
  }
  function CetakDetailKHS($thn, $nim) {
    global $strCantQuery;
	$s = "select * from krs where NIM='$nim' and tahun='$thn' order by KodeMK";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=1 width=100%>
	  <tr><th class=ttl rowspan=2>No.</th>
	  <th class=ttl rowspan=2>KMK</th>
	  <th class=ttl rowspan=2>Mata Kuliah</th>
	  <th class=ttl rowspan=2>HDR</th>
	  <th class=ttl rowspan=2>UTS</th>
	  <th class=ttl colspan=4>Tugas</th>
	  <th class=ttl rowspan=2>UAS</th>
	  <th class=ttl rowspan=2>Nilai<br>Akhir</th>
	  <th class=ttl rowspan=2>Grade<br>(K)</th>
	  <th class=ttl rowspan=2>SKS<br>(N)</th>
	  <th class=ttl rowspan=2>NxK</th>
	  <th class=ttl rowspan=2>Keterangan</th>
	  </tr>
	  <tr><th class=ttl>Ke1</th><th class=ttl>Ke2</th><th class=ttl>Ke3</th><th class=ttl>Ke4</th></tr>";
	$n = 0;
	$TSKS = 0; $TNK = 0;
	while ($w = mysql_fetch_array($r)) {
	  $n++;
	  if ($w['Tunda'] == 'Y') $strtnd = "T : $w[AlasanTunda]"; else $strtnd = '&nbsp;';
	  $NK = $w['Bobot'] * $w['SKS'];
	  $TNK += $NK;
	  $TSKS += $w['SKS'];
	  $hdr = ceil($w['Hadir']);
	  $mid = ceil($w['NilaiMID']);
	  $tg1 = ceil($w['Tugas1']);
	  $tg2 = ceil($w['Tugas2']);
	  $tg3 = ceil($w['Tugas3']);
	  $tg4 = ceil($w['Tugas4']);
	  $ujn = ceil($w['NilaiUjian']);
	  $nil = ceil($w['Nilai']);
	  echo "<tr><td class=lst>$n</td><td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td>
	    <td class=lst align=right>$hdr</td><td class=lst align=right>$mid</td>
		<td class=lst align=right>$tg1</td><td class=lst align=right>$tg2</td>
		<td class=lst align=right>$tg3</td><td class=lst align=right>$tg4</td>
		<td class=lst align=right>$ujn</td><td class=lst align=right>$nil</td>
		<td class=lst align=center>$w[GradeNilai]</td><td class=lst align=right>$w[SKS]</td>
		<td class=lst align=right>$NK</td><td class=lst>$strtnd</td>
		</tr>";
	}
	echo "<tr><td class=basic colspan=12 align=right>Total:&nbsp;</td>
	<td class=ttl align=right>$TSKS</td><td class=ttl align=right>$TNK</td><td></td></tr>
	</table>";
	if ($TSKS == 0) $IPS = 0;
	else $IPS = number_format($TNK/$TSKS, 2, ',', '.');
	echo "IP Semester: <b>$IPS</b><br>";
  }
  function CetakFooterKHS($nim) {
    $tgl = date('d-m-Y');
	UpdateIPK($nim);
	$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'KodeJurusan,IPK,TotalSKS');
	$arr = GetFields('jurusan', 'Kode', $arrmhsw['KodeJurusan'], 'TTJabatan1,TTJabatan2,TTPejabat1,TTPejabat2');
    echo <<<EOF
	IP Kumulatif: <b>$arrmhsw[IPK]</b><br>
	Jml. Kredit Kumulatif: <b>$arrmhsw[TotalSKS]</b><br>
	<table class=basic cellspacing=0 cellpadding=0 width=100%>
	<tr><td class=basic width=50%>Mengetahui,</td><td class=basic align=right>Jakarta, $tgl<br>Bag. Adm. Akademik</td></tr>
	<tr><td class=basic><br><u>$arr[TTPejabat1]</u><br>$arr[TTJabatan1]</td>
	<td class=basic align=right><br><u>$arr[TTPejabat2]</u><br>$arr[TTJabatan2]</td></tr>
	</table>
EOF;
  }
  function cetakkhs() {
    $amhsw = GetFields('mhsw', 'NIM', $_REQUEST['PerMhsw'], 'Name,KodeFakultas,KodeJurusan,KodeProgram');
	$Fak = GetaField('fakultas', 'Kode', $amhsw['KodeFakultas'], 'Nama_Indonesia');
	$ajur = GetFields("jurusan j left outer join jenjangps jp on j.Jenjang=jp.Kode", 
	  "j.Kode", $amhsw['KodeJurusan'], 'j.Nama_Indonesia as JUR, j.Sesi, j.MaxWaktu, jp.Nama as JEN');
	$Prg = GetaField('program', 'Kode', $amhsw['KodeProgram'], 'Nama_Indonesia');
	$strThn = GetaField('tahun', "KodeJurusan='$amhsw[KodeJurusan]' and Kode", $_REQUEST['PerTahun'], 'Nama');
	if (empty($strThn)) $strThn = $_REQUEST['PerTahun'];
	$TabelNilai = GetTabelNilai($amhsw['KodeJurusan']);
	// CETAK HEADER
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td valign=top>
	<font size=+1><b>STIE SUPRA</b></font><br><b>Universitas Satya Negara Indonesia</b><br>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td>Program</td><td>: $Prg</td></tr>
	  <tr><td>Cawu/Semester</td><td>: $strThn</td></tr>
	  <tr><td>NIM</td><td>: $_REQUEST[PerMhsw]</td></tr>
	  <tr><td>Nama Mahasiswa</td><td>: $amhsw[Name]</td></tr>
	  <tr><td>Jurusan</td><td>: $ajur[JUR] ($ajur[JEN])</td></tr>
	  <tr><td>Batas Studi</td><td>: $ajur[MaxWaktu] $ajur[Sesi]</td></tr>
	  </table>
	</td>
	<td valign=top align=right>
	  F-PK-S.1.1-05<br>Revisi: 01<br>
	  <font size=+1>KHS</font><br><b>KARTU HASIL STUDI</b><br>
	  $TabelNilai
	</td></tr>
	</table>
EOF;
    CetakDetailKHS($_REQUEST['PerTahun'], $_REQUEST['PerMhsw']);
	CetakFooterKHS($_REQUEST['PerMhsw']);
  }

  // *** Bagian Utama ***
  cetakkhs();
?>