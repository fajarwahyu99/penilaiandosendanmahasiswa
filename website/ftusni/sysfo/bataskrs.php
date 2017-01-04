<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
function GetTahun($thn, $kdj, $kdp) {
	global $strCantQuery;
	$s = "select *,
	  DATE_FORMAT(b.krsm, '%d') as km_d, DATE_FORMAT(b.krsm, '%m') as km_m, DATE_FORMAT(b.krsm, '%Y') as km_y,
	  DATE_FORMAT(b.krss, '%d') as ks_d, DATE_FORMAT(b.krss, '%m') as ks_m, DATE_FORMAT(b.krss, '%Y') as ks_y,
	  DATE_FORMAT(b.MulaiBayar, '%d') as mb_d, DATE_FORMAT(b.MulaiBayar, '%m') as mb_m, DATE_FORMAT(b.MulaiBayar, '%Y') as mb_y,
	  DATE_FORMAT(b.AkhirBayar, '%d') as ab_d, DATE_FORMAT(b.AkhirBayar, '%m') as ab_m, DATE_FORMAT(b.AkhirBayar, '%Y') as ab_y,
		DATE_FORMAT(b.Absen, '%d') as abs_d, DATE_FORMAT(b.Absen, '%m') as abs_m, DATE_FORMAT(b.Absen, '%Y') as abs_y,
		DATE_FORMAT(b.Tugas, '%d') as tgs_d, DATE_FORMAT(b.Tugas, '%m') as tgs_m, DATE_FORMAT(b.Tugas, '%Y') as tgs_y,
		DATE_FORMAT(b.UTS, '%d') as uts_d, DATE_FORMAT(b.UTS, '%m') as uts_m, DATE_FORMAT(b.UTS, '%Y') as uts_y,
		DATE_FORMAT(b.UAS, '%d') as uas_d, DATE_FORMAT(b.UAS, '%m') as uas_m, DATE_FORMAT(b.UAS, '%Y') as uas_y,
		j.Nama_Indonesia as JUR, p.Nama_Indonesia as PRG
	    from bataskrs b left outer join jurusan j on b.KodeJurusan=j.Kode
	    left outer join program p on b.KodeProgram=p.Kode
	    where b.Tahun='$thn' and b.KodeJurusan='$kdj' and b.KodeProgram='$kdp' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	return $r;
}
function DispBatasForm($md=0, $thn, $kdj, $kdp) {
  global $strCantQuery, $fmtErrorMsg;
	$r = GetTahun($thn, $kdj, $kdp);
	if (mysql_num_rows($r) == 0) {
		$jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
		$prg = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
		DisplayHeader($fmtErrorMsg, "Kalendar Tahun Akademik untuk <br>Jurusan : <b>$kdj - $jur</b><br>
		  Program : <b>$kdp - $prg</b><br>
		  Belum dibuat.<hr size=1 color=silver>
		  Option: <a href='sysfo.php?syxec=bataskrs&md=1&thn=$thn&kdj=$kdj&kdp=$kdp&md=1'>Buat Kalendar</a><br>");
	}
	else {
		CekBatasKRS($thn, $kdj, $kdp);
		$w = mysql_fetch_array($r);
		DispKalendar($md, $thn, $kdj, $kdp, $w);
	}
}
/*
	  mysql_query("insert into bataskrs values ('$thn', '$kdj', now(), now(), now(), now(), now(), now(),
	  'N', 0, 'N', now(), now(), now(), now(), now() )") or die(mysql_error());
	  $r = GetTahun($thn, $kdj);
*/
function KalendarBaru($thn, $kdj, $kdp) {
	$w = array();
	$w['Tahun'] = $thn;
	$w['kdj'] = $kdj; $w['JUR'] = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	$w['kdp'] = $kdp; $w['PRG'] = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	$w['km_d'] = date('d'); $w['km_m'] = date('m'); $w['km_y'] = date('Y');
	$w['ks_d'] = date('d'); $w['ks_m'] = date('m'); $w['ks_y'] = date('Y');
	$w['mb_d'] = date('d'); $w['mb_m'] = date('m'); $w['mb_y'] = date('Y');
	$w['ab_d'] = date('d'); $w['ab_m'] = date('m'); $w['ab_y'] = date('Y');
	$w['abs_d'] = date('d'); $w['abs_m'] = date('m'); $w['abs_y'] = date('Y');
	$w['tgs_d'] = date('d'); $w['tgs_m'] = date('m'); $w['tgs_y'] = date('Y');
	$w['uts_d'] = date('d'); $w['uts_m'] = date('m'); $w['uts_y'] = date('Y');
	$w['uas_d'] = date('d'); $w['uas_m'] = date('m'); $w['uas_y'] = date('Y');
	$w['Denda'] = ''; $w['HargaDenda'] = '0';
	return $w;
}
function DispKalendar($md=0, $thn, $kdj, $kdp, $w) {
	$thn = $w['Tahun'];
	// mulai KRS
	$km_d = $w['km_d'];	$km_m = $w['km_m'];	$km_y = $w['km_y'];
	// selesai KRS
	$ks_d = $w['ks_d'];	$ks_m = $w['ks_m'];	$ks_y = $w['ks_y'];
	// mulai pembayaran
	$mb_d = $w['mb_d'];	$mb_m = $w['mb_m'];	$mb_y = $w['mb_y'];
	// akhir pembayaran
	$ab_d = $w['ab_d'];	$ab_m = $w['ab_m'];	$ab_y = $w['ab_y'];
	// akhir absen
	$abs_d = $w['abs_d'];	$abs_m = $w['abs_m'];	$abs_y = $w['abs_y'];
	// akhir tugas
	$tgs_d = $w['tgs_d'];	$tgs_m = $w['tgs_m'];	$tgs_y = $w['tgs_y'];
	// akhir uts
	$uts_d = $w['uts_d'];	$uts_m = $w['uts_m'];	$uts_y = $w['uts_y'];
	// akhir uas
	$uas_d = $w['uas_d'];	$uas_m = $w['uas_m'];	$uas_y = $w['uas_y'];
	// Denda
  if ($w['Denda'] == 'Y') $Denda = 'checked'; else $Denda = '';
	$HargaDenda = $w['HargaDenda'];

	// Nama Jurusan & Program
	$jur = $w['JUR'];
	$prg = $w['PRG'];

	$opt_km_d = GetNumberOption(1, 31, $km_d);
	$opt_km_m = GetMonthOption($km_m);
	$opt_km_y = GetNumberOption(2003, 2010, $km_y);

	$opt_ks_d = GetNumberOption(1, 31, $ks_d);
	$opt_ks_m = GetMonthOption($ks_m);
	$opt_ks_y = GetNumberOption(2003, 2010, $ks_y);

	$opt_mb_d = GetNumberOption(1, 31, $mb_d);
	$opt_mb_m = GetMonthOption($mb_m);
	$opt_mb_y = GetNumberOption(2003, 2010, $mb_y);

	$opt_ab_d = GetNumberOption(1, 31, $ab_d);
	$opt_ab_m = GetMonthOption($ab_m);
	$opt_ab_y = GetNumberOption(2003, 2010, $ab_y);
	// Absen
	$opt_abs_d = GetNumberOption(1, 31, $abs_d);
	$opt_abs_m = GetMonthOption($abs_m);
	$opt_abs_y = GetNumberOption(2003, 2010, $abs_y);
	// Tugas
	$opt_tgs_d = GetNumberOption(1, 31, $tgs_d);
	$opt_tgs_m = GetMonthOption($tgs_m);
	$opt_tgs_y = GetNumberOption(2003, 2010, $tgs_y);
	// UTS
	$opt_uts_d = GetNumberOption(1, 31, $uts_d);
	$opt_uts_m = GetMonthOption($uts_m);
	$opt_uts_y = GetNumberOption(2003, 2010, $uts_y);
	// UAS
	$opt_uas_d = GetNumberOption(1, 31, $uas_d);
	$opt_uas_m = GetMonthOption($uas_m);
	$opt_uas_y = GetNumberOption(2003, 2010, $uas_y);

	$snm = session_name(); $sid = session_id();
	echo <<<EOF
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='bataskrs'>
	  <input type=hidden name='Tahun' value='$thn'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='kdp' value='$kdp'>
	  <input type=hidden name='md' value='$md'>
	  
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td colspan=2><br><b class=ttl>Batas</th></tr>
	  <tr><td align=right>Tahun Akademik :</td><td class=uline><b>$thn</td></tr>
	  <tr><td align=right>Jurusan :</td><td class=uline><b>$jur</td></tr>
	  <tr><td align=right>Program :</td><td class=uline><b>$prg</td></tr>

	  <tr><td colspan=2><br><b class=ttl>Kartu Rencana Studi</b></td></tr>
	  <tr><td align=right>Mulai pengisian KRS :</td><td class=uline><select name='km_d'>$opt_km_d</select>
	    <select name='km_m'>$opt_km_m</select> <select name='km_y'>$opt_km_y</select></td></tr>
	  <tr><td align=right>Akhir pengisian KRS :</td><td class=uline><select name='ks_d'>$opt_ks_d</select>
	    <select name='ks_m'>$opt_ks_m</select> <select name='ks_y'>$opt_ks_y</select></td></tr>

	  <tr><td  colspan=2><br><b class=ttl>Batas Akhir Penilaian</th></tr>
	  <tr><td align=right>Batas Akhir Nilai Absen :</td><td class=uline><select name='abs_d'>$opt_abs_d</select>
	    <select name='abs_m'>$opt_abs_m</select> <select name='abs_y'>$opt_abs_y</select></td></tr>
	  <tr><td align=right>Batas Akhir Nilai Tugas :</td><td class=uline><select name='tgs_d'>$opt_tgs_d</select>
	    <select name='tgs_m'>$opt_tgs_m</select> <select name='tgs_y'>$opt_tgs_y</select></td></tr>
	  <tr><td align=right>Batas Akhir Nilai UTS :</td><td class=uline><select name='uts_d'>$opt_uts_d</select>
	    <select name='uts_m'>$opt_uts_m</select> <select name='uts_y'>$opt_uts_y</select></td></tr>
	  <tr><td align=right>Batas Akhir Nilai UAS :</td><td class=uline><select name='uas_d'>$opt_uas_d</select>
	    <select name='uas_m'>$opt_uas_m</select> <select name='uas_y'>$opt_uas_y</select></td></tr>

	  <tr><td  colspan=2><br><b class=ttl>Waktu Pembayaran</th></tr>
	  <tr><td align=right>Mulai Pembayaran :</td><td class=uline><select name='mb_d'>$opt_mb_d</select>
	    <select name='mb_m'>$opt_mb_m</select> <select name='mb_y'>$opt_mb_y</select></td></tr>
	  <tr><td align=right>Akhir Pembayaran :</td><td class=uline><select name='ab_d'>$opt_ab_d</select>
	    <select name='ab_m'>$opt_ab_m</select> <select name='ab_y'>$opt_ab_y</select></td></tr>
	  <tr><td align=right>Ada denda jika terlambat :</td><td class=uline><input type=checkbox name='Denda' value='Y' $Denda></td></tr>
	  <tr><td align=right>Besar denda per hari</td><td class=uline><input type=text name='HargaDenda' value='$HargaDenda' size=10 maxlength=10></td></tr>

	  <tr><td colspan=2><hr size=1 color=silver></td></tr>
	  <tr><td colspan=2 align=center><input type=submit name='prc' value='Simpan'>
	    <input type=reset name=reset value='Reset'>
	    <input type=button name=cancel value='Batal' onClick="location='sysfo.php?syxec=bataskrs&$snm=$sid'"></td></tr>
	  </table></form>
EOF;
}
function PrcBatas() {
  global $strCantQuery;
  $md = $_REQUEST['md'];
    $km_d = $_REQUEST['km_d']; $km_m = $_REQUEST['km_m']; $km_y = $_REQUEST['km_y'];
    $ks_d = $_REQUEST['ks_d']; $ks_m = $_REQUEST['ks_m']; $ks_y = $_REQUEST['ks_y'];
    $krsm = "$km_y-$km_m-$km_d";
    $krss = "$ks_y-$ks_m-$ks_d";

    $mb_d = $_REQUEST['mb_d']; $mb_m = $_REQUEST['mb_m']; $mb_y = $_REQUEST['mb_y'];
    $ab_d = $_REQUEST['ab_d']; $ab_m = $_REQUEST['ab_m']; $ab_y = $_REQUEST['ab_y'];
    $MulaiBayar = "$mb_y-$mb_m-$mb_d";
    $AkhirBayar = "$ab_y-$ab_m-$ab_d";
    
    $abs_d = $_REQUEST['abs_d']; $abs_m = $_REQUEST['abs_m']; $abs_y = $_REQUEST['abs_y'];
    $Absen = "$abs_y-$abs_m-$abs_d";
    $tgs_d = $_REQUEST['tgs_d']; $tgs_m = $_REQUEST['tgs_m']; $tgs_y = $_REQUEST['tgs_y'];
    $Tugas = "$tgs_y-$tgs_m-$tgs_d";
    $uts_d = $_REQUEST['uts_d']; $uts_m = $_REQUEST['uts_m']; $uts_y = $_REQUEST['uts_y'];
    $UTS = "$uts_y-$uts_m-$uts_d";
    $uas_d = $_REQUEST['uas_d']; $uas_m = $_REQUEST['uas_m']; $uas_y = $_REQUEST['uas_y'];
    $UAS = "$uas_y-$uas_m-$uas_d";
	$thn = $_REQUEST['Tahun'];
	$kdj = $_REQUEST['kdj']; $kdp = $_REQUEST['kdp'];
	if (isset($_REQUEST['Denda'])) $Denda = $_REQUEST['Denda']; else $Denda = 'N';
	$HargaDenda = $_REQUEST['HargaDenda'];
	if ($md == 0) {
	  $s = "update bataskrs set krsm='$krsm', krss='$krss',
	    MulaiBayar='$MulaiBayar', AkhirBayar='$AkhirBayar',
	    Absen='$Absen', Tugas='$Tugas',
	    UTS='$UTS', UAS='$UAS',
	    Denda='$Denda', HargaDenda='$HargaDenda'
	    where Tahun='$thn' and 
	    KodeJurusan='$kdj' and KodeProgram='$kdp' limit 1";
  }
  else {
	  $s = "insert into bataskrs (Tahun, KodeJurusan, KodeProgram,
	    krsm, krss, MulaiBayar, AkhirBayar,
	    Absen, Tugas, UTS, UAS,
	    Denda, HargaDenda) values ('$thn', '$kdj', '$kdp',
	    '$krsm', '$krss', '$MulaiBayar', '$AkhirBayar',
	    '$Absen', '$Tugas', '$UTS', '$UAS',
	    '$Denda', '$HargaDenda')";
  }
	$r = mysql_query($s) or die("$strCantQuery: $s");
	//echo "<p>$s</p>";
}
function CekBatasKRS($thn, $kdj, $kdp) {
	global $fmtErrorMsg;
	$msg = '';
	$arr = GetFields('bataskrs', "KodeJurusan='$kdj' and KodeProgram='$kdp' and Tahun", $thn, '*');
	if ($arr['krsm'] > $arr['krss']) 
	  $msg .= "Tanggal mulai pengisian KRS tidak boleh lebih dari pada akhir KRS<hr size=1 color=red>";
	if ($arr['MulaiBayar'] > $arr['AkhirBayar'])
	  $msg .= "Tanggal mulai pembayaran tidak boleh lebih dari pada akhir pembayaran<hr size=1 color=red>";
	
	if (!empty($msg)) DisplayHeader($fmtErrorMsg, $msg);
}


  // *** BAGIAN UTAMA ***
$kdj = GetSetVar('kdj');
$kdp = GetSetVar('kdp');
if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = 0;

DisplayHeader($fmtPageTitle, 'Batas Waktu KRS, Penilaian & Pembayaran');
if (isset($_REQUEST['prc'])) PrcBatas();
DispJurPrg($kdj, $kdp, 0, 'bataskrs');
$thn = GetLastThn($kdj);
if (!empty($kdj) && !empty($kdp) && !empty($thn)) 
  if ($md == 0) DispBatasForm($md, $thn, $kdj, $kdp);
  elseif ($md == 1) {
	  $w = KalendarBaru($thn, $kdj, $kdp);
	  DispKalendar($md, $thn, $kdj, $kdp, $w);
  }
?>