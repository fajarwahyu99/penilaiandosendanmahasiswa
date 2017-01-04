<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  include "class/tab.class.php";

  // *** Fungsi2 ***
function DisplaySearchMhsw() {
  global $nilai, $kdj, $kdp, $src;
	$sid = session_id();
	echo "<table class=basic cellspacing=0 cellpadding=3>";
    echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhsw'>
	  <tr><td class=uline>Cari Mahasiswa: </td>
	  <td class=uline><input type=text name='nilai' value='$nilai' size=10 maxlength=20>
	  <input type=submit name='src' value='Name'>
	  <input type=submit name='src' value='NIM'>
	  <input type=button name='_none' value='Semua' onClick='location=\"sysfo.php?syxec=mhsw&_none=1&kdj=&kdp=&PHPSESSID=$sid\"'>
	  </td></tr></form>";

	$optjur = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode,Nama_Indonesia', $kdj, '', 'Kode');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Nama_Indonesia, Kode', $kdp, '', 'Kode');
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhsw'>
	  <tr><td class=uline>Jurusan: </td><td class=uline><select name='kdj' onChange='this.form.submit()'>$optjur</select>
	  </td></tr></form>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhsw'>
	  <tr><td class=uline>Program: </td><td class=uline><select name='kdp' onChange='this.form.submit()'>$optprg</select>
	  </td></tr></form>
	  ";
	echo "</table><br>";
  }
  function DisplayMhsw($sr=0) {
    global $maxrow, $strPage, $kdj, $kdp, $src, $nilai;
	$urlnilai = urlencode($nilai);
    $pagefmt = "<a href='sysfo.php?syxec=mhsw&nilai=$urlnilai&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";

	$strwhr = "where NIM<>'' ";
	if (!empty($src) && !empty($nilai)) {
	  $strwhr .= "and m.$src like '%$nilai%' ";
	}
	if (!empty($kdj)) {
	  $strwhr .= "and m.KodeJurusan='$kdj' ";
	}
	if (!empty($kdp)) {
	  $strwhr .= "and m.KodeProgram='$kdp' ";
	}

    $lister = new lister;
    $lister->tables = "mhsw m
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join program p on m.KodeProgram=p.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode
	  left outer join dosen d on m.DosenID=d.ID
	  left outer join statusmhsw stm on m.Status=stm.Kode
	  $strwhr order by m.NIM,m.Name";
	//echo $lister->tables;
    $lister->fields = "m.*, j.Nama_Indonesia as jur, je.Nama as jen, concat(d.Name,', ',d.Gelar) as Dosen,
	  stm.Nama as STT, p.Nama_Indonesia as prg";
    $lister->startrow = $sr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=3>
      <tr>
	  <th class=ttl>#</th>
	  <th class=ttl>NIM</th>
	  <th class=ttl>Nama</th>
	  <th class=ttl colspan=2>Jurusan</th>
	  <th class=ttl>Program</th>
	  <th class=ttl>Status</th>
	  <th class=ttl>Dosen</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <th class=ttl width=18 align=right>=NOMER=</th>
	  <td class=lst><a href='sysfo.php?syxec=mhsw&sr=$sr&nim==NIM='>=NIM=</a></td>
	  <td class=lst>=Name=</td>
	  <td class=lst>=jen=</td><td class=lst>=jur=</td><td class=lst>=prg=</td>
	  <td class=lst>=STT=</td>
	  <td class=lst>=Dosen=</td>
	  </tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $Total = $lister->MaxRowCount;
    $usrlist = 
    $lister->ListIt () .
	  "Total: $Total<br>  $strPage: $halaman</p>";
    echo $usrlist;
  }
  function DispHdrMhsw($nim='') {
    global $strCantQuery, $strNotAuthorized;
    $s = "select m.NIM, m.NIRM, m.Name, m.KodeJurusan, 
	  j.Nama_Indonesia as jur, je.Nama as jen
	  from mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode
	  where m.NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) die ("Data tidak ditemukan");
	$NIRM = mysql_result($r, 0, 'NIRM');
	$Name = mysql_result($r, 0, 'Name');
	$kdj = mysql_result($r, 0, 'KodeJurusan');
	$jur = mysql_result($r, 0, 'jur');
	$jen = mysql_result($r, 0, 'jen');
	echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>Adm. Mahasiswa NIM: $nim</th></tr>
	  <tr><td class=lst>NIM & NIRM</td><td class=lst>$nim | $NIRM</td></tr>
	  <tr><td class=lst>Nama</td><td class=lst><b>$Name</b></td></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst>$jen | $jur</td></tr>
	  </table><br>
EOF;
}
function DispTabMhsw($tab=0, $nim) {
  global $kdj, $strCantQuery, $fmtErrorMsg;
	$arr = array('Data Pribadi', 
	  'Data Orang Tua', 
	  'Akademik',
	  'Asal Sekolah');
	if ($tab==0) $content = FormMhsw($nim);
	elseif ($tab == 1) $content = GetMhsw1($nim);
	elseif ($tab == 2) $content = GetMhsw2($nim);
	elseif ($tab == 3) $content = GetMhsw3($nim);
	else $content = DisplayHeader($fmtErrorMsg, 'Data tidak ada atau modul belum berfungsi.', 0);
	DisplayTab($arr, $tab, $content, 'sysfo.php', "syxec=mhsw&nim=$nim");
  //function DisplayTab($arrt, $aidx=0, $content='', $action='', $extra='') {
}
function FormMhsw($nim) {
  global $fmtErrorMsg, $strCantQuery, $Student_MinYear, $Student_MaxYear;
	$s = "select *, DATE_FORMAT(TglLahir, '%d') as hh, DATE_FORMAT(TglLahir, '%m') as bb, DATE_FORMAT(TglLahir, '%Y') as tt
	  from mhsw where NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$strL = ''; $strP = '';
	if (mysql_result($r, 0, 'Sex') == 'L') $strL = 'checked'; else $strP = 'checked';
	$TempatLahir = mysql_result($r, 0, 'TempatLahir');
	$hh = mysql_result($r, 0, 'hh'); $bb = mysql_result($r, 0, 'bb'); $tt = mysql_result($r, 0, 'tt');
	// opsi utk tgl lahir
	$opthh = GetNumberOption(1, 31, $hh);
	$optbb = GetMonthOption($bb);
	$opttt = GetNumberOption($Student_MinYear, $Student_MaxYear, $tt);

	//$SID = mysql_result($r, 0, 'SID');
	$Name = mysql_result($r, 0, 'Name');
	$Email = mysql_result($r, 0, 'Email');
	$Alamat1 = mysql_result($r, 0, 'Alamat1');
	$Alamat2 = mysql_result($r, 0, 'Alamat2');
	$RT = mysql_result($r, 0, 'RT');
	$RW = mysql_result($r, 0, 'RW');
	$Kota = mysql_result($r, 0, 'Kota');
	$KodePos = mysql_result($r, 0, 'KodePos');
	$Phone = mysql_result($r, 0, 'Phone');
	$agm = mysql_result($r, 0, 'AgamaID');
	$optagm = GetOption2('agama', 'Agama', 'Agama', $agm, '', 'AgamaID');
	$WargaNegara = mysql_result($r, 0, 'WargaNegara');
    return <<<EOF
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhsw'>
	  <input type=hidden name='nim' value='$nim'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>NIM: $nim</th></tr>
	  <tr><td class=lst>Student ID</td><td class=lst><input type=text name='SID' value='$SID' size=30 maxlength=20></td></tr>
	  <tr><td class=lst>Nama</td><td class=lst><input type=text name='Name' value='$Name' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Tempat Lahir</td><td class=lst><input type=text name='TempatLahir' value='$TempatLahir' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Tgl Lahir</td><td class=lst><select name='hh'>$opthh</select>&nbsp;<select name='bb'>$optbb</select>&nbsp;<select name='tt'>$opttt</select></td></tr>
	  </td></tr>
	  <tr><td class=lst>Jenis Kelamin</td><td class=lst><input type=radio name='Sex' value='L' $strL>Laki-laki
	    <input type=radio name='Sex' value='P' $strP>Perempuan </td></tr>
	  <tr><td class=lst>Agama</td><td class=lst><select name='AgamaID'>$optagm</select></td></tr>
	  <tr><td class=lst>Alamat</td><td class=lst>
	    <input type=text name='Alamat1' value='$Alamat1' size=40 maxlength=100><br>
		<input type=text name='Alamat2' value='$Alamat2' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>RT/RW</td><td class=lst>
	    <input type=text name='RT' value='$RT' size=10 maxlength=4> <input type=text name='RW' value='$RW' size=10 maxlength=4></td></tr>
	  <tr><td class=lst>Kota</td><td class=lst><input type=text name='Kota' value='$Kota' size=20 maxlength=50></td></tr>
	  <tr><td class=lst>Kode Pos</td><td class=lst><input type=text name='KodePos' value='$KodePos' size=20 maxlength=10></td></tr>
	  <tr><td class=lst>Telepon</td><td class=lst><input type=text name='Phone' value='$Phone' size=20 maxlength=30></td></tr>
	  <tr><td class=lst>E-mail</td><td class=lst><input type=text name='Email' value='$Email' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Warga Negara</td><td class=lst><input type=text name='WargaNegara' value='$WargaNegara' size=40 maxlength=30></td></tr>
	  
	  <tr><td class=lst colspan=2 align=center><input type=submit name='prc0' value='Simpan'>&nbsp;<input type=reset name=reset value='Reset'></td></tr>
	  </table></form>
EOF;
}
function PrcMhsw0() {
  global $strCantQuery;
  $SID = $_REQUEST['SID'];
  $nim = $_REQUEST['nim'];
	$Name = FixQuotes($_REQUEST['Name']);
	$Sex = $_REQUEST['Sex'];
	$TempatLahir = FixQuotes($_REQUEST['TempatLahir']);
	$hh = $_REQUEST['hh']; $bb = $_REQUEST['bb']; $tt = $_REQUEST['tt'];
	$TglLahir = "$tt-$bb-$hh";
	$Email = FixQuotes($_REQUEST['Email']);
	$AgamaID = $_REQUEST['AgamaID'];
	$Alamat1 = FixQuotes($_REQUEST['Alamat1']);
	$Alamat2 = FixQuotes($_REQUEST['Alamat2']);
	$RT = FixQuotes($_REQUEST['RT']); $RW = FixQuotes($_REQUEST['RW']);
	$Kota = FixQuotes($_REQUEST['Kota']);
	$KodePos = FixQuotes($_REQUEST['KodePos']);
	$Phone = FixQuotes($_REQUEST['Phone']);
	$WargaNegara = FixQuotes($_REQUEST['WargaNegara']);
	
	$s = "update mhsw set SID='$SID', Name='$Name', TempatLahir='$TempatLahir', TglLahir='$TglLahir', Sex='$Sex',
	  AgamaID='$AgamaID', Email='$Email', Alamat1='$Alamat1', Alamat2='$Alamat2', RT='$RT', RW='$RW',
	  Kota='$Kota', KodePos='$KodePos', Phone='$Phone', WargaNegara='$WargaNegara'
	  where nim='$nim'	";
	$r = mysql_query($s) or die ("$strCantQuery: $s");	
  }
  function GetMhsw1($nim) {
    global $strCantQuery;
	$s = "select NamaOT, PekerjaanOT, AlamatOT1, AlamatOT2, RTOT, RWOT, KotaOT,
	  TelpOT, EmailOT, KodePosOT 
	  from mhsw where NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	
	$NamaOT = mysql_result($r, 0, 'NamaOT');
	$PekerjaanOT = mysql_result($r, 0, 'PekerjaanOT');
	$AlamatOT1 = mysql_result($r, 0, 'AlamatOT1');
	$AlamatOT2 = mysql_result($r, 0, 'AlamatOT2');
	$RTOT = mysql_result($r, 0, 'RTOT');
	$RWOT = mysql_result($r, 0, 'RWOT');
	$KotaOT = mysql_result($r, 0, 'KotaOT');
	$TelpOT = mysql_result($r, 0, 'TelpOT');
	$EmailOT = mysql_result($r, 0, 'EmailOT');
	$KodePosOT = mysql_result($r, 0, 'KodePosOT');
	
	return <<<EOF
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='mhsw'>
	  <input type=hidden name='nim' value='$nim'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>NIM: $nim</th></tr>
	  <tr><td class=lst>Nama Orang Tua</td><td class=lst><input type=text name='NamaOT' value='$NamaOT' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Pekerjaan</td><td class=lst><input type=text name='PekerjaanOT' value='$PekerjaanOT' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Alamat</td><td class=lst><input type=text name='AlamatOT1' value='$AlamatOT1' size=40 maxlength=100><br>
	    <input type=text name='AlamatOT2' value='$AlamatOT2' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>RT/RW</td><td class=lst><input type=text name='RTOT' value='$RTOT' size=4 maxlength=4>&nbsp;<input type=text name='RWOT' value='$RWOT' size=4 maxlength=4></td></tr>
	  <tr><td class=lst>Kota</td><td class=lst><input type=text name='KotaOT' value='$KotaOT' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Kode Pos</td><td class=lst><input type=text name='KodePosOT' value='$KodePosOT' size=15 maxlength=10></td></tr>
	  <tr><td class=lst>Telepon</td><td class=lst><input type=text name='TelpOT' value='$TelpOT' size=20 maxlength=30></td></tr>
	  <tr><td class=lst>E-mail</td><td class=lst><input type=text name='EmailOT' value='$EmailOT' size=40 maxlength=50></td></tr>
	  
	  <tr><td class=lst colspan=2 align=center><input type=submit name='prc1' value='Simpan'>&nbsp;<input type=reset name=reset value='Reset'></td></tr>
	  
	  </table></form>
EOF;
  }
  function PrcMhsw1() {
    global $strCantQuery;
	$nim = $_REQUEST['nim'];
	$NamaOT = FixQuotes($_REQUEST['NamaOT']);
	$PekerjaanOT = FixQuotes($_REQUEST['PekerjaanOT']);
	$AlamatOT1 = FixQuotes($_REQUEST['AlamatOT1']);
	$AlamatOT2 = FixQuotes($_REQUEST['AlamatOT2']);
	$RTOT = FixQuotes($_REQUEST['RTOT']);
	$RWOT = FixQuotes($_REQUEST['RWOT']);
	$KotaOT = FixQuotes($_REQUEST['KotaOT']);
	$KodePosOT = FixQuotes($_REQUEST['KodePosOT']);
	$TelpOT = FixQuotes($_REQUEST['TelpOT']);
	$EmailOT = FixQuotes($_REQUEST['EmailOT']);
	$s = "update mhsw set NamaOT='$NamaOT', PekerjaanOT='$PekerjaanOT',
	  AlamatOT1='$AlamatOT1', AlamatOT2='$AlamatOT2', RTOT='$RTOT', RWOT='$RWOT', KotaOT='$KotaOT',
	  KodePosOT='$KodePosOT', TelpOT='$TelpOT', EmailOT='$EmailOT'
	  where NIM='$nim'	";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function GetMhsw2($nim) {
    global $fmtErrorMsg, $strCantQuery, $Student_MinYear, $Student_MaxYear;
	$s = "select m.*, DATE_FORMAT(m.TglLulus, '%d-%m-%Y') as TL,
	  jj.Nama as JEN, f.Nama_Indonesia as FAK
	  from mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps jj on j.Jenjang=jj.Kode
	  left outer join fakultas f on m.KodeFakultas=f.Kode
	  where m.NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	
	$TahunAkademik = mysql_result($r, 0, 'TahunAkademik');
	$KodeFakultas = mysql_result($r, 0, 'KodeFakultas');
	$Fakultas = mysql_result($r, 0, 'FAK');
	$KodeJurusan = mysql_result($r, 0, 'KodeJurusan');
	$Jenjang = mysql_result($r, 0, 'JEN');
	$optjur = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'KodeFakultas,Nama_Indonesia', 
	  $KodeJurusan, "KodeFakultas='$KodeFakultas'", 'Kode');
	
	$DosenID = mysql_result($r, 0, 'DosenID');
	$KodeProgram = mysql_result($r, 0, 'KodeProgram');
	$Status = mysql_result($r, 0, 'Status');
	$StatusAwal = mysql_result($r, 0, 'StatusAwal');
	$TglLulus = mysql_result($r, 0, 'TL');
	$optst = GetOption2('statusmhsw', 'Nama', 'Nama', $Status, '', 'Kode');
	$optsta = GetOption2('statusawalmhsw', 'Nama', 'Nama', $StatusAwal, '', 'Kode');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode,Nama_Indonesia', $KodeProgram, "", 'Kode');
	$optdsn = GetOption2('dosen', "concat(Name, ', ', Gelar)", 'Name', $DosenID, "", 'ID');

	$KodeProgram = mysql_result($r, 0, 'KodeProgram');
	return <<<EOF
	  <form name='f1' action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='mhsw'>
	  <input type=hidden name='nim' value='$nim'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>NIM: $nim</th></tr>
	  <tr><td class=lst>Tahun Akademik/Angkatan&nbsp;</td><td class=lst><b>$TahunAkademik</td></tr>
	  <tr><td class=lst>Fakultas</td><td class=lst>$Fakultas</td></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst><select name='kdj'>$optjur</select></td></tr>
	  <tr><td class=lst>Jenjang Pendidikan</td><td class=lst>$Jenjang</td></tr>
	  <tr><td class=lst>Status Awal Mahasiswa</td><td class=lst><select name='StatusAwal'>$optsta</select></td></tr>
	  <tr><td class=lst>Status Kemahasiswaan</td><td class=lst><select name='Status'>$optst</select></td></tr>
	  <tr><td class=lst>Tanggal Lulus</td><td class=lst>$TglLulus</td></tr>
	  <tr><td class=lst>Dosen Pembimbing</td><td class=lst><select name='Dosen'>$optdsn</select></td></tr>
	  <tr><td class=lst>Program</td><td class=lst><select name='KodeProgram'>$optprg</select></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prc2' value='Simpan'>&nbsp;<input type=reset name=reset value='Reset'></td></tr>
	  
	  </table></form>
EOF;
  }
  function PrcMhsw2() {
    global $strCantQuery, $kdj;
	$nim = $_REQUEST['nim'];
	$kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	$KodeProgram = $_REQUEST['KodeProgram'];
	$Status = $_REQUEST['Status'];
	$StatusAwal = $_REQUEST['StatusAwal'];
	$DosenID = $_REQUEST['Dosen'];
	
	$s = "update mhsw set KodeFakultas='$kdf', KodeJurusan='$kdj', KodeProgram='$KodeProgram',
	  Status='$Status', StatusAwal='$StatusAwal', DosenID='$DosenID'
	  where NIM='$nim' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function GetMhsw3($nim) {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from mhsw where NIM='$nim' limit 1";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	
	$AsalSekolah = mysql_result($r, 0, 'AsalSekolah');
	$propid = mysql_result($r, 0, 'PropSekolah');
	$JenisSekolah = mysql_result($r, 0, 'JenisSekolah');
	//	$optjur = GetOption('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'KodeFakultas,Nama_Indonesia', $defj, '', 'Kode');
	$optjs = GetOption('schooltype', 'SchoolType', 'Rank', $JenisSekolah, '', 'SchoolType');
	$LulusSekolah = mysql_result($r, 0, 'LulusSekolah');
	$IjazahSekolah = mysql_result($r, 0, 'IjazahSekolah');
	$NilaiSekolah = mysql_result($r, 0, 'NilaiSekolah');
	$optprop = GetOption2('prop', 'Nama', 'Nama', $propid, '', 'ID');
	return <<<EOF
	  <form name='f1' action='sysfo.php'>
	  <input type=hidden name='syxec' value='mhsw'>
	  <input type=hidden name='nim' value='$nim'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><td class=lst>Asal Sekolah</td><td class=lst><input type=text name='AsalSekolah' value='$AsalSekolah' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Propinsi</td><td class=lst><select name='propid'>$optprop</select></td></tr>
	  <tr><td class=lst>Jenis Sekolah</td><td class=lst><select name='JenisSekolah'>$optjs</select></td></tr>
	  <tr><td class=lst>Tahun Lulus</td><td class=lst><input type=text name='LulusSekolah' value='$LulusSekolah' size=5 maxlength=5></td></tr>
	  <tr><td class=lst>No. Ijazah</td><td class=lst><input type=text name='IjazahSekolah' value='$IjazahSekolah' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Nilai</td><td class=lst><input type=text name='NilaiSekolah' value='$NilaiSekolah' size=10 maxlength=7></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prc3' value='Simpan'>&nbsp;<input type=reset name=reset value='Reset'></td></tr>
	  
	  </table></form>
EOF;
  }
  function PrcMhsw3() {
    global $strCantQuery;
	$nim = $_REQUEST['nim'];
	$AsalSekolah = FixQuotes($_REQUEST['AsalSekolah']);
	$propid = $_REQUEST['propid'];
	$JenisSekolah = FixQuotes($_REQUEST['JenisSekolah']);
	$LulusSekolah = FixQuotes($_REQUEST['LulusSekolah']);
	$IjazahSekolah = FixQuotes($_REQUEST['IjazahSekolah']);
	$NilaiSekolah = FixQuotes($_REQUEST['NilaiSekolah']);
	
	$s = "update mhsw set AsalSekolah='$AsalSekolah', PropSekolah='$propid', JenisSekolah='$JenisSekolah',
	  LulusSekolah='$LulusSekolah', IjazahSekolah='$IjazahSekolah', NilaiSekolah='$NilaiSekolah'
	  where NIM='$nim' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }

  // *** Parameter2 ***
$kdj = GetSetVar('kdj');
$kdp = GetSetVar('kdp');
  // Mode Pencarian
  if (isset($_REQUEST['src'])) {
    $src = $_REQUEST['src']; 
	$_SESSION['mhswsrc'] = $src;
  }
  else {
    if (!empty($_SESSION['mhswsrc'])) $src = $_SESSION['mhswsrc'];
    else $src = '';
  }
  // Nilai Pencarian
  if (isset($_REQUEST['nilai'])) {
    $nilai = $_REQUEST['nilai'];
	$_SESSION['mhswnilai'] = $nilai;
  }
  else {
    if (!empty($_SESSION['mhswnilai'])) $nilai = $_SESSION['mhswnilai'];
    else $nilai = '';
  }
  if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
  // Reset Pencarian
  if (isset($_REQUEST['_none'])) {
    $_SESSION['mhswsrc'] = ''; $_SESSION['mhswnilai'] = '';
	$src = ''; $nilai = '';
  }
  if (isset($_REQUEST['nim'])) $nim = $_REQUEST['nim']; else $nim='';
  //$nim = GetSetVar('nim');
  if (isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
	$_SESSION['mhswtab'] = $tab;
  } 
  else {
    if (isset($_SESSION['mhswtab'])) $tab = $_SESSION['mhswtab'];
	else $tab = 0;
  }
  // *** PROSES ***
  if (isset($_REQUEST['prc0'])) PrcMhsw0();
  if (isset($_REQUEST['prc1'])) PrcMhsw1();
  if (isset($_REQUEST['prc2'])) PrcMhsw2();
  if (isset($_REQUEST['prc3'])) PrcMhsw3();

  // *** Bagian Utama ***
DisplayHeader($fmtPageTitle, 'Daftar Mahasiswa');
DisplaySearchMhsw();
if (empty($nim)) DisplayMhsw($sr);
else {
  DispHdrMhsw($nim);
	DispTabMhsw($tab, $nim);
}
?>