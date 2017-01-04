<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003

  // *** Fungsi2 ***
  function GetNilai2($nim) {
    global $strCantQuery;
/*	$s = "select k.*, jmk.Kode as KJMK, jmk.Nama as NJMK
	  from krs k left outer join matakuliah mk on k.IDMK=mk.ID
	  left outer join jenismatakuliah jmk on mk.KodeJenisMK=jmk.Kode
	  where k.NIM='$nim' and k.NotActive='N' order by jmk.Rank, k.KodeMK";
	  */
	$s = "select k.*, mk.KodeJenisMK as KJMK
	  from krs k left outer join matakuliah mk on k.IDMK=mk.ID
	  where k.NIM='$nim' and k.NotActive='N' order by mk.KodeJenisMK, k.KodeMK";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$kjmk = '';
	$no = 0;
	$arr = array();
	while ($w = mysql_fetch_array($r)) {
	  if ($kjmk <> $w['KJMK']) {
	    $kjmk = $w['KJMK'];
		$no = 0;
		$arr[] = "<tr><td class=uline colspan=5 align=center>$kjmk</td></tr>";
	  }
	  $no++;
	  $arr[] = <<<EOF
	  <tr><td class=lst>$no</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td>
	  <td class=lst align=center>$w[SKS]</td><td class=uline align=center>$w[GradeNilai]</td></tr>
EOF;
	}
	$stg = ceil((sizeof($arr)-1) / 2);
	echo "<table class=basic cellspacing=0 cellpadding=2 width=100%>";
	for ($i=0; $i<sizeof($arr); $i++) {
	  if ($i == 0) {
	    echo "<tr><td class=basic width=50% valign=top>
	    <table class=box cellspacing=0 cellpadding=2 width=100%>
	    <tr><th class=lst>No.</th><th class=lst>Kode</th><th class=lst>Mata Kuliah</th>
	    <th class=lst>SKS</th><th class=uline>Nilai</th></tr>";
	  }
	  echo $arr[$i];
	  if ($i == $stg) {
	    echo "</table>
		</td><td class=basic valign=top>
	    <table class=box cellspacing=0 cellpadding=2 width=100%>
	    <tr><th class=lst>No.</th><th class=lst>Kode</th><th class=lst>Mata Kuliah</th>
	    <th class=lst>SKS</th><th class=uline>Nilai</th></tr>";
	  }
	}
	echo "</table></td></tr></table>";
  }
  function CetakHeader() {
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td width=50%>No.: 001/MAN/STIE-S/07/2003</td>
	<td align=right>F-PK-S.1.1-07<br>Revisi: 02</td></tr>
	</table>
	<center><font size=+1><b>KARTU HASIL STUDI</b></font></center><br>
EOF;
  }
  function GetNilai($kdj) {
    $knil = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
	$r = mysql_query("select * from nilai where Kode='$knil' order by BatasAtas desc");
	$a = '';
	while ($w = mysql_fetch_array($r)) {
	  $w['Bobot'] += 0;
	  $a .= "$w[Nilai]=$w[Bobot]&nbsp;";
	}
	return $a;
  }
  function CetakFooter($nim, $kdj) {
    $nil = GetNilai($kdj);
	$dat = GetFields('krs', "NotActive='N' and NIM", $nim, "sum(SKS) as kmu, sum(SKS*Bobot) as bbt");
	$kmu = $dat['kmu'];
	$bbt = $dat['bbt'];
	if ($bbt == 0) $IPK = 0;
	else $IPK = $bbt / $kmu;
	$IPK = number_format($IPK, 2, ',', '.');
    echo <<<EOF
    <table class=basic cellspacing=0 cellpadding=2 width=100%>
    <tr><td width=50% class=box>Keterangan:<br>
    Nilai: $nil<br><br>
    Kredit Kumulatif: $kmu<br>
    Index Prestasi Kumulatif: $IPK</td>
    <td align=center>
    Jakarta, $tgl<br>Ketua<br><br><br>
    Dr. Yos E. Susanto, Ph.D.
    </td></tr>
    </table>
EOF;
  }
  function CetakTranskrip($nim) {
    CetakHeader();
	$smt = GetFields('krs', 'NIM', $nim, 'MAX(Sesi) as mx');
	echo "<center>Semester 1 s/d semester $smt[mx]</center><br>";
    $dat = GetFields('mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode', 
	'NIM', $nim, "m.Name,date_format(m.TglLahir, '%d %M %Y') as TglLahir,m.TempatLahir,m.KodeJurusan,j.Nama_Indonesia,je.Nama as JEN");
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td class=basic width=50% valign=top>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td>Nama</td><td>: $dat[Name]</td></tr>
	  <tr><td>Tempat/Tgl.Lahir</td><td>: $dat[TempatLahir], $dat[TglLahir]</td></tr>
	  <tr><td>Nomer Pokok</td><td>: $nim</td></tr>
	  </table>
	</td>
	<td class=basic valign=top>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td>Program Studi</td><td>: $dat[KodeJurusan] - $dat[Nama_Indonesia]</td></tr>
	  <tr><td>Jenjang Pendidikan</td><td>: $dat[JEN]</td></tr>
	  </table>
	</td></tr>
	</table>
EOF;
	GetNilai2($nim);
	CetakFooter($nim, $dat['KodeJurusan']);
  }
  
  // *** Bagian Utama ***
  if (isset($_REQUEST['PerMhsw'])) $nim = $_REQUEST['PerMhsw']; else $nim = '';
  CetakTranskrip($nim);
?>