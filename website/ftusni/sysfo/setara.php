<?php
// Author: E. Setio Dewo, setio_dewo@telkom.net, Februari 2004

// *** FUNCTION ***
function DispSetaraMhsw($nim) {
	$s = "select k.*
	  from krs k
	  where k.NIM='$nim' and k.Setara='Y' order by k.KodeMK";
	$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
	$nmr = 0;
	echo <<<EOF
	  <p><a href='sysfo.php?syxec=setara&md=1'>Tambah MK Penyetaraan</a></p>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>#</th><th class=ttl colspan=2>Thn Akd.</th>
	  <th class=ttl colspan=3>Mata Kuliah</th>
	  <th class=ttl>Nilai</th><th class=ttl>NA</th></tr>
EOF;
	while ($w = mysql_fetch_array($r)) {
		$nmr++;
		if ($w['NotActive'] == 'Y') {
			$cls = 'class=nac';
		}
		else {
			$cls = 'class=lst';
		}
		echo <<<EOF
		<tr><td class=nac>$nmr</td>
		<td $cls><a href='sysfo.php?syxec=setara&md=0&ID=$w[ID]'><img src='image/edit.png' border=0></a></td>
		<td $cls>$w[Sesi]</td><td $cls>$w[Tahun]</td>
		<td $cls>$w[KodeMK]</td><td $cls>$w[NamaMK]</td><td $cls>$w[SKS]</td>
		<td $cls align=center>$w[GradeNilai]</td>
		<td $cls><img src='image/book$w[NotActive].gif'></td>
		</tr>
EOF;
	}
	echo "</table>";
}
function EditSetaraMhsw($md, $nim) {
	if ($md == 0) {
		$ID = $_REQUEST['ID'];
		$s = "select ID, NIM, Tahun, Sesi, IDMK, SKS, GradeNilai, MKSetara, SKSSetara, GradeSetara
		  from krs where ID='$ID'";
		$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
		$w = mysql_fetch_array($r);
		$Tahun = $w['Tahun'];
		$Sesi = $w['Sesi'];
		$IDMK = $w['IDMK'];
		$SKS = $w['SKS'];
		$GradeNilai = $w['GradeNilai'];
		$MKSetara = $w['MKSetara'];
		$SKSSetara = $w['SKSSetara'];
		$GradeSetara = $w['GradeSetara'];
		$jdl = 'Edit Penyetaraan';
	}
	else {
		$arrkrs = GetFields('krs', 'NIM', $nim, 'max(Sesi) as Sesi, max(Tahun) as Tahun');
		if (!empty($arrkrs)) {
			$Tahun = $arrkrs['Tahun']; $Sesi = $arrkrs['Sesi'];
			//echo "$Tahun : $Sesi";
		} else {
			$Tahun = 'EMPTY'; $Sesi = 1;
		}
		$ID = 0;
		$IDMK = 0;
		$SKS = 0;
		$GradeNilai = '';
		$MKSetara = '';
		$SKSSetara = 0;
		$GradeSetara = '';
		$jdl = 'Tambah Penyetaraan';
	}
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$knil = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
	//GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	$kurid = GetLastKur($kdj);
	$optMK = GetOption2('matakuliah', "concat(Kode, ' - ', Nama_Indonesia, ' - ', SKS)", 'Kode', $IDMK, "KurikulumID='$kurid' and KodeJurusan='$kdj'", 'ID');
	$optNILA = GetOption2('nilai', "concat(Nilai, ' (', BatasAtas, ' - ', BatasBawah, ')')", 'BatasAtas desc', $GradeSetara, "Kode='$knil'", 'Nilai');
	$optNIL = GetOption2('nilai', "concat(Nilai, ' (', BatasAtas, ' - ', BatasBawah, ')')", 'BatasAtas desc', $GradeNilai, "Kode='$knil'", 'Nilai');
	$optthn = GetOption2('khs', "concat(Sesi, ' - ', Tahun)", 'Sesi', $Tahun, "NIM='$nim'", 'Tahun');
	$snm = session_name(); $sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='setara'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='ID' value='$ID'>
	<input type=hidden name='nim' value='$nim'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><th class=ttl colspan=2>Mata Kuliah Asal</th></tr>
	<tr><td class=uline align=right>Dari Mata Kuliah :</td><td class=uline><input type=text name='MKSetara' value='$MKSetara' size=30 maxlength=50></td></tr>
	<tr><td class=uline align=right>SKS :</td><td class=uline><input type=text name='SKSSetara' value='$SKSSetara' size=5 maxlength=2></td></tr>
	<tr><td class=uline align=right>Nilai Asli :</td><td class=uline><input type=text name='GradeSetara' value='$GradeSetara' size=5 maxlength=2></td></tr>
	<tr><th class=ttl colspan=2>Disetarakan Menjadi</th></tr>
	<tr><td class=uline align=right>Sem. - Tahun Akd. :</td><td class=uline><select name='Tahun'>$optthn</select></td></tr>
	<tr><td class=uline align=right>Mata Kuliah :</td><td class=uline><select name='IDMK'>$optMK</select></td></tr>
	<tr><td class=uline align=right>SKS :</td><td class=uline>$SKS</td></tr>
	<tr><td class=uline align=right>Nilai :</td><td class=uline><select name='GradeNilai'>$optNIL</select></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcstr' value='Simpan'>&nbsp;
	<input type=reset name='reset' value='Reset'>&nbsp;
	<input type=button name='cancel' value='Kembali' onClick="location='sysfo.php?syxec=setara&nim=$nim&$snm=$sid'"></td></tr>
	</form></table>
EOF;
}
function GetKodeNilai($nim, $gn) {
	$s = "select j.KodeNilai, n.Nilai, n.BatasAtas, n.Bobot
	  from mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join nilai n on j.KodeNilai=n.Kode
	  where m.NIM='$nim' and n.Nilai='$gn'";
	$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
	$arr = array('KodeNilai'=>mysql_result($r, 0, 'KodeNilai'),
	  'GradeNilai'=>mysql_result($r, 0, 'Nilai'),
	  'Bobot'=>mysql_result($r, 0, 'Bobot'),
	  'BatasAtas'=>mysql_result($r, 0, 'BatasAtas'));
	return $arr;
}
function PrcSetara() {
	$md = $_REQUEST['md'];
	$nim = $_REQUEST['nim'];
	$MKSetara = $_REQUEST['MKSetara'];
	$SKSSetara = $_REQUEST['SKSSetara']+0;
	$GradeSetara = $_REQUEST['GradeSetara'];
	$Tahun = $_REQUEST['Tahun'];
	$Sesi = GetaField('khs', "Tahun='$Tahun' and NIM", $nim, 'Sesi');
	// Ambil MK
	$IDMK = $_REQUEST['IDMK'];
	$arrmk = GetFields('matakuliah', 'ID', $IDMK, 'Kode, Nama_Indonesia, SKS');
	$KodeMK = $arrmk['Kode']; $NamaMK = $arrmk['Nama_Indonesia']; $SKS = $arrmk['SKS'];
  // Ambil Nilai
	$GradeNilai = $_REQUEST['GradeNilai'];
	$arrnil = GetKodeNilai($nim, $GradeNilai);
	
	if ($md == 0) {
		$ID = $_REQUEST['ID'];
		$s = "update krs set Tahun='$Tahun', Sesi='$Sesi', 
		  IDMK='$IDMK', KodeMK='$KodeMK', NamaMK='$NamaMK', SKS='$SKS', 
		  unip='$_SESSION[unip]', Nilai='$arrnil[BatasAtas]',
		  GradeNilai='$arrnil[GradeNilai]', Bobot='$arrnil[Bobot]', Setara='Y',
		  MKSetara='$MKSetara', SKSSetara='$SKSSetara', GradeSetara='$GradeSetara'
		  where ID='$ID'";
	}
	else {
		$s = "insert into krs (NIM, Tahun, Sesi, IDMK, KodeMK, NamaMK, SKS,
		  unip, Nilai, GradeNilai, Bobot, Setara,
		  MKSetara, SKSSetara, GradeSetara) values
		  ('$nim', '$Tahun', '$Sesi', '$IDMK', '$KodeMK', '$NamaMK', '$SKS',
		  '$_SESSION[unip]', '$arrnil[BatasAtas]', 
		  '$arrnil[GradeNilai]', '$arrnil[Bobot]', 'Y',
		  '$MKSetara', '$SKSSetara', '$GradeSetara')";
	}
	$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
	return -1;
}

// *** PARAMETER ****
$nim = GetSetVar('nim');
if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

// *** PRC ***
if (isset($_REQUEST['prcstr'])) $md = PrcSetara();

// *** MAIN ***
DisplayHeader($fmtPageTitle, 'Penyetaraan');
if ($prn == 0 && $_SESSION['ulevel'] < 3) {
  DispNIMMhsw($nim, 'setara');
}
if (ValidNIM($nim)) {
	if ($md == -1)	DispSetaraMhsw($nim);
	else EditSetaraMhsw($md, $nim);
}
elseif (!empty($nim)) DisplayHeader($fmtErrorMsg, "Mahasiswa dengan NIM <b>$nim</b> tidak ditemukan.");
?>