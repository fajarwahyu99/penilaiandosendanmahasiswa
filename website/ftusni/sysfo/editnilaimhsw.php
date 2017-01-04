<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  
  // *** FUngsi2 ***
  function GetUrutkan($nim, $urt, $act) {
    $okodemk = ''; $otahun = ''; $osesi = ''; $oksg = ''; $omatamk = '';
	switch($urt) {
	  case 'KodeMK' : $okodemk = 'selected'; break;
	  case 'Tahun' : $otahun = 'selected'; break;
	  case 'Sesi' : $osesi = 'selected'; break;
	  case 'NamaMK' : $omatamk = 'selected'; break;
	  default : $oksg = 'selected';
	}
    $opturt = "<option value='' $oksg></option>
	  <option value='KodeMK' $okodemk>Kode Mata Kuliah</option>
	  <option value='NamaMK' $omatamk>Nama Mata Kuliah</option>
	  <option value='Tahun' $otahun>Tahun Akademik</option>
	  <option value='Sesi' $osesi>Semester/Cawu</option>";
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='$act'>
	<input type=hidden name='nim' value='$nim'>
	<tr><td class=lst width=150>Urut berdasarkan:</td>
	<td class=lst><select name='urteditmk' onChange="this.form.submit()">$opturt</select></td></tr>
	</form></table>
EOF;
  }
  function GetNilaiMhsw($nim, $urt='') {
    global $strCantQuery;
	if (!empty($urt)) $ord = "order by $urt asc";
	else $ord = "order by KodeMK";
	$s = "select * from krs where NIM='$nim' $ord";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	echo "<a href='sysfo.php?syxec=editnilaimhsw&md=1'>Tambah Mata Kuliah</a> | 
	  <a href='sysfo.php?syxec=mhswmkwajib&nim=$nim'>Lihat Mata Kuliah Wajib</a>";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>SKS</th><th class=ttl>Nilai</th>
	  <th class=ttl>Grade</th><th class=ttl>Bobot</th>
	  <th class=ttl>Tahun</th><th class=ttl>Smt</th>
	  <th class=ttl>Setr</th><th class=ttl>NA</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  echo <<<EOF
	  <tr><td $cls><a href='sysfo.php?syxec=editnilaimhsw&md=0&kid=$w[ID]'>$w[KodeMK]</a></td>
	  <td $cls>$w[NamaMK]</td>
	  <td $cls align=right>$w[SKS]</td><td $cls align=right>$w[Nilai]</td>
	  <td $cls>$w[GradeNilai]</td><td $cls align=right>$w[Bobot]</td>
	  <td $cls>$w[Tahun]</td><td $cls align=right>$w[Sesi]</td>
	  <td $cls align=center><img src='image/$w[Setara].gif'>
	  <td $cls align=center><img src='image/book$w[NotActive].gif'>
	  </td>
	  </tr>
EOF;
	}
	echo "</table><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=ttl>Setr</td><td class=lst>Hasil penyetaraan</td></tr>
	<tr><td class=ttl>Smt</td><td class=lst>Semester/Cawu</td></tr>
	<tr><td class=ttl>NA</td><td class=lst>NotActive/Tidak Aktif</td></tr>
	</table><br>";
  }
  function UpdateNilaiMhsw($nim, $sks, $ipk) {
    mysql_query("update mhsw set TotalSKS=$sks, IPK=$ipk where NIM='$nim'");
  }
  function DispSummaryNilaiMhsw($nim) {
    global $strCantQuery;
    $s = "select sum(Bobot * SKS) as bbt, sum(SKS) as sks from krs where NIM='$nim' and NotActive='N'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$arr = mysql_fetch_assoc($r);
	if ($arr['sks'] == 0) $ipk = 0;
	else $ipk = $arr['bbt'] / $arr['sks'];
	UpdateNilaiMhsw($nim, $arr['sks'], $ipk);
	$arr['sks'] = number_format($arr['sks'], 2, ',', '.');
	$arr['bbt'] = number_format($arr['bbt'], 2, ',', '.');
	$ipk = number_format($ipk, 2, ',', '.');
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><th class=ttl colspan=2>Summary Nilai Mahasiswa</th></tr>
	<tr><td class=lst>Total Bobot * SKS</td><td class=lst align=right>$arr[bbt]</td></tr>
	<tr><td class=lst>Total SKS</td><td class=lst align=right>$arr[sks]</td></tr>
	<tr><td class=lst>IPK</td><td class=lst align=right>$ipk</td></tr>
	</table>
EOF;
  }
  function GetRangeNilai($kdj) {
    global $strCantQuery;
    //$kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	$nil = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
    $s = "select * from nilai where Kode='$nil' order by BatasAtas desc";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	$t = "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>Grade</th><th class=ttl>Bobot</th>
	  <th class=ttl>Bts Atas</th><th class=ttl>Bts Bwh</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $t .= "<tr>
	    <td class=lst>$w[Nilai]</td><td class=lst align=right>$w[Bobot]</td>
		<td class=lst align=right>$w[BatasAtas]</td><td class=lst align=right>$w[BatasBawah]</td></tr>";
	}
	return $t . "</table>";
  }
  function EditNilaiMhsw($md, $nim, $kid) {
    global $strCantQuery, $fmtErrorMsg;
	$arr = GetFields('mhsw', 'NIM', $nim, 'KodeJurusan,KodeFakultas');
	$kdf = $arr['KodeFakultas'];
	$kdj = $arr['KodeJurusan'];
	if ($md == 0) {
	  $s = "select * from krs where ID=$kid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) die(DisplayHeader($fmtErrorMsg, "Data tidak ditemukan.", 0));
	  $Tahun = mysql_result($r, 0, 'Tahun');
	  $Sesi = mysql_result($r, 0, 'Sesi');
	  $KodeMK = mysql_result($r, 0, 'KodeMK');
	  $NamaMK = mysql_result($r, 0, 'NamaMK');
	  $OptMK = "<tr><td class=lst>Kode Mata Kuliah</td><td class=lst><input type=text name='KodeMK' value='$KodeMK' size=10 maxlength=10></td></tr>
	    <tr><td class=lst>Nama Mata Kuliah</td><td class=lst><input type=text name='NamaMK' value='$NamaMK' size=40 maxlength=100></td></tr>";
	  $SKS = mysql_result($r, 0, 'SKS');
	  $Status = mysql_result($r, 0, 'Status');
	  $Tanggal = mysql_result($r, 0, 'Tanggal');
	  $Nilai = mysql_result($r, 0, 'Nilai');
	  $Grade = mysql_result($r, 0, 'GradeNilai');
	  $Bobot = mysql_result($r, 0, 'Bobot');
	  if (mysql_result($r, 0, 'Setara') == 'Y') $Setara = 'checked'; else $Setara = '';
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $NA = 'checked'; else $NA = '';
	  $MKSetara = mysql_result($r, 0, 'MKSetara');
	  $SKSSetara = mysql_result($r, 0, 'SKSSetara');
	  $GradeSetara = mysql_result($r, 0, 'GradeSetara');
	  $jdl = 'Edit Mata Kuliah Mahasiswa';
	}
	else {
	  $Tahun = GetLastThn($kdj);
	  $Sesi = 0;
	  $KodeMK = '';
	  $NamaMK = '';
	  $kurid = GetLastKur($kdj);
	  $Opt01 = GetOption2('matakuliah', "concat(Kode, ' -- ', Nama_Indonesia, ' -- ', SKS)", 
	    "Kode", '', "KurikulumID=$kurid", 'ID');
	  $OptMK = "<tr><td class=lst>Mata Kuliah</td><td class=lst><select name='IDMK'>$Opt01</select></td></tr>";
	  $SKS = '';
	  $Status = '';
	  $Nilai = 0;
	  $Grade = '';
	  $Bobot = 0;
	  $NA = '';
	  $Setara = '';
	  $MKSetara = '';
	  $SKSSetara = 0;
	  $GradeSetara = '';
	  $jdl = 'Tambah Mata Kuliah Mahasiswa';
	}
	$rangenilai = GetRangeNilai($kdj);
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='editnilaimhsw'>
	<input type=hidden name='nim' value='$nim'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='kid' value='$kid'>
	<tr><th class=ttl colspan=2>$jdl</th><th class=basic></th></tr>
	<tr><td class=lst>Tahun Akademik</td><td class=lst><input type=text name='Tahun' value='$Tahun' size=5 maxlength=5></td>
	<td class=basic rowspan=14 valign=top>$rangenilai</td></tr>
	<tr><td class=lst>Sesi/Semester/Cawu</td><td class=lst><input type=text name='Sesi' value='$Sesi' size=5 maxlength=2></td></tr>
	$OptMK
	<tr><td class=lst>SKS</td><td class=lst><input type=text name='SKS' value='$SKS' size=3 maxlength=3></td></tr>
	<tr><td class=lst>Nilai</td><td class=lst><input type=text name='Nilai' value=$Nilai size=10 maxlength=10></td></tr>
	<tr><td class=lst>Grade</td><td class=lst>$Grade</td></tr>
	<tr><td class=lst>Bobot</td><td class=lst>$Bobot</td></tr>
	<tr><td class=lst>NotActive</td><td class=lst><input type=checkbox name='NA' value='Y' $NA></td></tr>
	<tr><th class=ttl colspan=2>Penyetaraan</th></tr>
	<tr><td class=lst>Mata Kuliah Penyetaraan</td><td class=lst><input type=checkbox name='Setara' value='Y' $Setara><td></tr>
	<tr><td class=lst>Nama Mata Kuliah Asli</td><td class=lst><input type=text name='MKSetara' value='$MKSetara' size=40 maxlength=100></td></tr>
	<tr><td class=lst>SKS Asli</td><td class=lst><input type=text name='SKSSetara' value='$SKSSetara' size=5 maxlength=3></td></tr>
	<tr><td class=lst>Grade</td><td class=lst><input type=text name='GradeSetara' value='$GradeSetara' size=5 maxlength=3></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcmk' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name='Balik' value='Batal' onClick="location='sysfo.php?syxec=editnilaimhsw&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcMataKuliah() {
    global $strCantQuery;
    $md = $_REQUEST['md'];
	$kid = $_REQUEST['kid'];
	$nim = $_REQUEST['nim'];
	$arr = GetFields('mhsw', 'NIM', $nim, 'KodeFakultas,KodeJurusan');
	$Tahun = $_REQUEST['Tahun'];
	$Sesi = $_REQUEST['Sesi'];
	$SKS = $_REQUEST['SKS'];
	$Nilai = $_REQUEST['Nilai'];
	$arrgr = GetGrade($arr['KodeJurusan'], $Nilai);
	$Grade = $arrgr[0];
	$Bobot = $arrgr[1];
	if (isset($_REQUEST['Setara'])) $Setara = $_REQUEST['Setara']; else $Setara = 'N';
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	$MKSetara = $_REQUEST['MKSetara'];
	$SKSSetara = $_REQUEST['SKSSetara'];
	$GradeSetara = $_REQUEST['GradeSetara'];
	
	if ($md == 0) {
	  $KodeMK = FixQuotes($_REQUEST['KodeMK']);
	  $NamaMK = FixQuotes($_REQUEST['NamaMK']);
	  $s = "update krs set Tahun='$Tahun', Sesi='$Sesi', SKS='$SKS', Nilai='$Nilai',
	    GradeNilai='$Grade', Bobot='$Bobot', KodeMK='$KodeMK', NamaMK='$NamaMK',
		Setara='$Setara', MKSetara='$MKSetara', SKSSetara='$SKSSetara', 
		GradeSetara='$GradeSetara', NotActive='$NA' where ID=$kid  ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else {
	  $IDMK = $_REQUEST['IDMK'];
	  $arrmk = GetFields('matakuliah', 'ID', $IDMK, "Kode,Nama_Indonesia");
	  $KodeMK = $arrmk['Kode']; $NamaMK = $arrmk['Nama_Indonesia'];
	  $s = "insert into krs(NIM, Tahun, Sesi, IDMK, KodeMK, NamaMK, SKS, Tanggal, Nilai,
	    GradeNilai, Bobot, Setara, MKSetara, SKSSetara, GradeSetara, NotActive)
	    values('$nim', '$Tahun', '$Sesi', $IDMK, '$KodeMK', '$NamaMK', $SKS, now(),
		'$Nilai', '$Grade', '$Bobot', '$Setara', '$MKSetara', '$SKSSetara', 
		'$GradeSetara', '$NA')";
	  $r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	}
	return -1;
  }

  // *** Parameter2 ***
  $nim = GetSetVar('nim');
  $urteditmk = GetSetVar('urteditmk');
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['kid'])) $kid = $_REQUEST['kid']; else $kid = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Edit Nilai Mahasiswa');
  if ($_SESSION['ulevel'] > 3) die(DisplayHeader($fmtError, 'Anda tidak berhak menjalankan modul ini.', 0));
  DispNIMMhsw($nim, 'editnilaimhsw');
  if (!empty($nim) && ValidNIM($nim)) {
    if (isset($_REQUEST['prcmk'])) $md = PrcMataKuliah();
    if ($md == -1) {
	  DispHeaderMhsw($nim, 'editnilaimhsw', 0);
      GetUrutkan($nim, $urteditmk, 'editnilaimhsw');
      GetNilaiMhsw($nim, $urteditmk);
	  DispSummaryNilaiMhsw($nim);
	} else EditNilaiMhsw($md, $nim, $kid);
  }
?>