<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003


  // *** Fungsi2 ***
function DispKalendarAkademik($thn, $kdj) {
  global $strCantQuery;
	$s = "select date_format(krsm, '%d %M %Y') as krsm, date_format(krss, '%d %M %Y') as krss,
	  date_format(Absen, '%d %M %Y') as abs, date_format(Tugas, '%d %M %Y') as tgs,
	  date_format(MulaiBayar, '%d %M %Y') as byrm, date_format(AkhirBayar, '%d %M %Y') as byrs,
	  date_format(UTS, '%d %M %Y') as uts, date_format(UAS, '%d %M %Y') as uas,
	  Denda
	  from bataskrs where Tahun='$thn' and KodeJurusan='$kdj' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Denda'] == 'Y') $strdnd = "<br><font color=red>*) Ada Denda !!!</font>"; else $strdnd = '';
	  echo <<<EOF
	  <br><table class=box cellspacing=0 cellpadding=2>
	  <tr><th class=uline colspan=2>Tahun Ajaran: $thn</th></tr>
	  <tr><th class=ttl colspan=2>Kalendar Akademik: $kdj - $jur</th></tr>
	  <tr><td class=uline>Pengisian KRS</td><td class=uline>: $w[krsm] s/d $w[krss]</td></tr>
	  <tr><td class=uline>Pembayaran</td><td class=uline>: $w[byrm] s/d $w[byrs] $strdnd</td></tr>
	  <tr><td class=uline>Akhir perkuliahan</td><td class=uline>: $w[abs]</td></tr>
	  <tr><td class=uline>Akhir pengumpulan tugas</td><td class=uline>: $w[tgs]</td></tr>
	  <tr><td class=uline>UTS sampai dengan</td><td class=uline>: $w[uts]</td></tr>
	  <tr><td class=uline>UAS sampai dengan</td><td class=uline>: $w[uas]</td></tr>
	  </table>
EOF;
	}
}

  // *** Parameter2 ***
if (isset($_REQUEST['kdj'])) {
  $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
}
else {
  if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
}

// *** Bagian Utama ***
DisplayHeader($fmtPageTitle, "Kalendar Akademik");
DispJur($kdj, 0, 'kalakd');
$thn = GetLastThn($kdj);
if (!empty($kdj) && !empty($thn)) DispKalendarAkademik($thn, $kdj);

?>