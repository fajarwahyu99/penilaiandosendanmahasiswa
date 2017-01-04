<?php

function GetSetVar($str, $def='') {
  if (isset($_REQUEST[$str])) {
	  $_SESSION[$str] = $_REQUEST[$str];
	  return $_REQUEST[$str];
	}
	else {
	  if (isset($_SESSION[$str])) return $_SESSION[$str];
	  else {
		  $_SESSION[$str] = $def;
		  return $def;
	  }
	}
}
  function GetUserModul() {
    global $strCantQuery;
	$unip = $_SESSION['unip'];
	$ulevel = $_SESSION['ulevel'];
	$usrid = $_SESSION['uid'];
	$_arr = array();
    $_sql = "select m.GroupModul, m.Level from usermodul um
	  right join modul m on um.ModulID=m.ModulID
	  where m.InMenu='Y' and um.UserID='$usrid' or LOCATE($ulevel, m.Level) group by m.GroupModul";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	for ($i=0; $i < mysql_num_rows($_res); $i++) {
	  $_arr[$i] = mysql_result($_res, $i, 'GroupModul');
	}
	return $_arr;
  }
  // DisplaySubModul
  function DisplaySubModul($gm) {
    global $fmtSysfoMenu_h, $fmtSysfoMenu_i, $fmtSysfoMenu_f;

	$unip = $_SESSION['unip'];
    $nbrw = new newsbrowser;
    $nbrw->query = "select um.*,m.* from usermodul um inner join modul m on um.Modul=m.Modul
	  where m.GroupModul='$gm' and um.Login='$unip' and m.InMenu='Y' and m.web='Y'
	  ";
    $nbrw->headerfmt = DisplayHeader($fmtSysfoMenu_h, $gm, 0);
    $nbrw->detailfmt = DisplayDetail($fmtSysfoMenu_i, "sysfo.php?syxec==Link=", "=Modul=", "",0);
    $nbrw->footerfmt = $fmtSysfoMenu_f;
    echo $nbrw->BrowseNews();  
  }
  // DisplaySubModul
  function DisplaySubModulIcon1($gm) {
    global $fmtMenu_header, $fmtMenu_item, $fmtMenu_footer;

	$unip = $_SESSION['unip'];
    $nbrw = new newsbrowser;
    $nbrw->query = "select um.*,m.* from usermodul um inner join modul m on um.Modul=m.Modul
	  where m.GroupModul='$gm' and um.Login='$unip' and m.InMenu='Y'
	  ";
    $nbrw->headerfmt = DisplayHeader($fmtMenu_header, $gm, 0);
    $nbrw->detailfmt = DisplayDetail($fmtMenu_item, "sysfo.php?syxec==Link=", 
	  "<img src='=ImgLink=' border=0>&nbsp;=Modul=", "=Description=",0);
    $nbrw->footerfmt = $fmtMenu_footer;
    echo $nbrw->BrowseNews();  
  }
  // DisplaySubModul
  function DisplayMenuItem($gm) {
    $_ggl = "<p>Gagal menginisialisasi menu</p><p>Failed to initialised menus</p>";
	$unip = $_SESSION['unip'];
	$usrid = $_SESSION['uid'];
	$ulevel = $_SESSION['ulevel'];
	$_sid = session_id();
	$_arr = array();
//"select * from modul where LOCATE($lvl, Level)>0 and InMenu='Y' order by GroupModul,Modul";
	// ambil default
	$X_qy1 = "select md.* 
	  from modul md left join usermodul um on md.ModulID=um.ModulID and um.UserID='$usrid'
	  where um.ModulID is NULL
	  and LOCATE('$ulevel', md.Level)>0
	  and md.InMenu='Y'
	  and md.web='Y'
	  and md.GroupModul='$gm'
	  order by md.Modul";
	$_qy1 = "select md.* 
	  from modul md
	  where LOCATE('$ulevel', md.Level)>0
	  and md.InMenu='Y'
	  and md.web='Y'
	  and md.GroupModul='$gm'
	  order by md.Modul";
	$_rs1 = mysql_query($_qy1) or die($_ggl . mysql_error());
	for ($i=0; $i < mysql_num_rows($_rs1); $i++) {
	  $__mdl = mysql_result($_rs1, $i, 'Modul');
	  $__lnk = mysql_result($_rs1, $i, 'Link');
	  $__brs = mysql_result($_rs1, $i, 'Baris');
	  $_arr[] = "$__mdl -> sysfo.php?syxec=$__lnk&PHPSESSID=$_sid -> $__brs";
	}
	// ambil menu tambahan
	$_qy1 = "select um.*,m.Modul,m.Baris, m.Link 
	  from usermodul um left outer join modul m on um.ModulID=m.ModulID
	  where um.GroupModul='$gm' and um.UserID='$usrid' and um.Level=$ulevel and m.InMenu='Y' and m.web='Y'";
	$_rs1 = mysql_query($_qy1) or die($_ggl);
	for ($i=0; $i < mysql_num_rows($_rs1); $i++) {
	  $__mdl = mysql_result($_rs1, $i, 'Modul');
	  $__lnk = mysql_result($_rs1, $i, 'Link');
	  $__brs = mysql_result($_rs1, $i, 'Baris');
	  $_arr[] = "$__mdl -> sysfo.php?syxec=$__lnk&PHPSESSID=$_sid -> $__brs";
	}
	sort($_arr);
	AddSubMenu($gm, $_arr);
  }
  // Kampus
  function DisplayCampusList() {
	$unip = $_SESSION['unip'];
    $nbrw = new newsbrowser;
    $nbrw->query = "select * from kampus order by Kampus";
    $nbrw->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Kode</th><th class=ttl>Kampus</th>
	  <th class=ttl>Alamat</th><th class=ttl>Telepon</th>
	  <th class=ttl>Tdk<br>Aktif</th></tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=listofcampus&kd==Kode='>=Kode=</a></td>
	  <td class=lst>=Kampus=</td><td class=lst>=Alamat=</td>
	  <td class=lst>=Telepon=</td><td class=lst align=center><img src='image/book=NotActive=.gif' border=0></td></tr>";
    $nbrw->footerfmt = "</table>";
    echo $nbrw->BrowseNews();  

  }
  function DisplayCampusForm($md, $kd='', $act='listofcampus') {
    global $fmtPageTitle;
    // edit mode
    if ($md==0){
	  $jdl = 'Edit Kampus';
	  $_sql = "select * from kampus where Kode='$kd'";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  $_kode = mysql_result($_res, 0, 'Kode');
	  $_kampus = mysql_result($_res, 0, 'Kampus');
	  $_alamat = mysql_result($_res, 0, 'Alamat');
	  $_telepon = mysql_result($_res, 0, 'Telepon');
	  $_imglink = mysql_result($_res, 0, 'ImgLink');
	  $_notactive = mysql_result($_res, 0, 'NotActive');
	  if ($_notactive=='Y') $_strna ='checked';
	  else $_strna = '';
	  $_strkode = $_kode;
	}
	// insert mode
	elseif ($md==1) {
	  $jdl = 'Tambah Kampus';
	  $_kode = '';
	  $_kampus = '';
	  $_alamat = '';
	  $_telepon = '';
	  $_imglink = '';
	  $_notactive = 'N';
	  $_strna = '';
	  $_strkode = "<input type=text size=12 maxlength=10 name='kode'>";
	}
	$sid = session_id();
	DisplayHeader($fmtPageTitle, $jdl);
	echo "
	  <form action='sysfo.php' method=GET>
	    <input type=hidden name='syxec' value='listofcampus'>
		<input type=hidden name='mode' value=$md>
		<input type=hidden name='oldkode' value='$_kode'>
		<table class=box cellspacing=0 cellpadding=2>
		  <tr><th class=ttl colspan=2>$jdl</th></tr>
		  <tr><td class=lst>Kode</td>
		    <td class=uline>$_strkode</td></tr>
		  <tr><td class=lst>Nama Kampus</td>
		    <td class=uline><input type=text name='kampus' value='$_kampus' size=45 maxlength=100></td></tr>
		  <tr><td class=lst>Alamat</td>
		    <td class=uline><textarea name='alamat' cols=35 rows=4>$_alamat</textarea></td></tr>
		  <tr><td class=lst>Telepon</td>
		    <td class=uline><textarea name='telepon' cols=35 rows=2>$_telepon</textarea></td></tr>
		  <tr><td class=lst>Link Image</td>
		    <td class=uline><input type=text name='imglink' value='$_imglink' size=45 maxlength=100></td></tr>
		  <tr><td class=lst>Tidak Aktif</td>
		    <td class=uline><input type=checkbox name='notactive' value='Y' $_strna></td></tr>
		  <tr><td class=uline colspan=2 align=center>
		    <input type=submit name='prc' value='simpan'>&nbsp;
			<input type=reset name='reset' value='reset'>&nbsp;
			<input type=button name='batal' value='Batal' onClick=\"location='sysfo.php?syxec=$act&PHPSESSID=$sid'\"></td></tr>
	  </table></form>
	  ";
  }
  function ProcessCampusForm() {
    global $strCantQuery;
    $mode = $_REQUEST['mode'];
	$kampus = FixQuotes($_REQUEST['kampus']);
	$alamat = FixQuotes($_REQUEST['alamat']);
	$telepon = FixQuotes($_REQUEST['telepon']);
    $imglink = stripslashes($_REQUEST['imglink']);
	if (isset($_REQUEST['notactive'])) $notactive = $_REQUEST['notactive'];
	else $notactive = 'N';
	if ($mode==0) {
	  $kode = $_REQUEST['oldkode'];
	  $_sql = "update kampus set Kampus='$kampus', Alamat='$alamat',
	    Telepon='$telepon', ImgLink='$imglink', NotActive='$notactive'
		where Kode='$kode'";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	elseif ($mode==1) {
	  $kode = $_REQUEST['kode'];
	  $_sql = "insert into kampus(Kode,Kampus,Alamat,Telepon,ImgLink,NotActive)
	    values ('$kode','$kampus','$alamat','$telepon','$imglink','$notactive')";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
  }
  function DispJadwalMK($thn, $kdj, $jid, $act='mhswnilai') {
    global $strCantQuery, $prn;
	if (!isset($prn)) $prn = 0;
    $s = "select mk.Kode, mk.Nama_Indonesia as MK, j.ID, pr.Nama_Indonesia as PRG
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join program pr on j.Program=pr.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by mk.Kode";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	$opt = '<option></option>';
	for ($i=0; $i < mysql_num_rows($r); $i++) {
	  $mk = mysql_result($r, $i, 'MK');
	  $kod = mysql_result($r, $i, 'Kode');
	  $prg = mysql_result($r, $i, 'PRG');
	  $id = mysql_result($r, $i, 'ID');
	  if ($jid == $id) $opt = "$opt<option value=$id selected>$kod -- $mk ($prg)</option>";
	  else $opt = "$opt<option value=$id>$kod -- $mk ($prg)</option>";
	}
	if ($prn == 0) $str1 = "<select name='jid' onChange='this.form.submit()'>$opt</select>";
	else $str1 = "<b>$kod - $mk</b>";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=lst width=100>Mata Kuliah: </td>
	  <td class=lst>$str1</td></tr>
	  </form></table>";
  }
  function GetMhsw0($nim, $act='mhswipk') {
    global $strCantQuery;
    $s = "select m.*, f.Nama_Indonesia as FAK, j.Nama_Indonesia as JUR, jj.Nama as JEN,
	  concat(d.Name, ', ', d.Gelar) as DSN
	  from mhsw m left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps jj on j.Jenjang=jj.Kode
	  left outer join dosen d on m.DosenID=d.ID
	  where m.NIM='$nim' ";
	$r = mysql_query($s) or die("$strCantQuery: $s <br>" . mysql_error());
	$ret = mysql_num_rows($r);
	if ($ret > 0) {
	  $nme = mysql_result($r, 0, 'Name');
	  $kdf = mysql_result($r, 0, 'KodeFakultas');
	  $fak = mysql_result($r, 0, 'FAK');
	  $kdj = mysql_result($r, 0, 'KodeJurusan');
	  $jur = mysql_result($r, 0, 'JUR');
	  $jen = mysql_result($r, 0, 'JEN');
	  $dsn = mysql_result($r, 0, 'DSN');
	}
	else {
	  $nme = '';
	  $kdf = '';
	  $fak = '';
	  $kdj = '';
	  $jur = '';
	  $jen = '';
	  $dsn = '';
	}
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=ttl>NIM</td><td class=lst><input type=text name='nim' value='$nim' size=20 maxlength=20></td>
	    <td class=basic rowspan=6 align=center valign=bottom><img src='image/tux001.jpg'><br>
		<input type=submit name='GO' value='Refresh'>
	  </td></tr>
	  <tr><td class=ttl>Mahasiswa</td><td class=lst><b>$nme</b></td></tr>
	  <tr><td class=ttl>Fakultas</td><td class=lst>$kdf - $fak</td></tr>
	  <tr><td class=ttl>Jurusan</td><td class=lst>$kdj - $jur</td></tr>
	  <tr><td class=ttl>Jenjang</td><td class=lst>$jen</td></tr>
	  <tr><td class=ttl>Dosen Penasehat</td><td class=lst>$dsn</td></tr>
	  </form></table><br>
EOF;
	return $ret > 0;
  }
function GetMhsw($thn, $nim, $act) {
  global $nme, $kdf, $kdj, $kdp, $did, $ret, $jur, $dsn, $prg;
	function ResetMhsw() {
	  global $nme, $kdf, $kdj, $kdp, $did, $ret, $jur, $dsn, $prg;
    $nme = '';
    $kdf = '';
    $kdj = '';
    $kdp = '';
    $did = '';
    $ret = false;
    $jur = '';
    $dsn = '';
    $prg = '';
	}
	if (!empty($nim)) {
    $arrm = GetFields('mhsw', 'NIM', $nim, 'Name,KodeFakultas,KodeJurusan,DosenID,KodeProgram');
	  if (!empty($arrm)) {
	    $nme = $arrm['Name'];
	    $kdf = $arrm['KodeFakultas'];
	    $kdj = $arrm['KodeJurusan'];
		  $kdp = $arrm['KodeProgram'];
	    $did = $arrm['DosenID'];
		  $ret = true;
	    $jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
		  $arrdsn = GetFields('dosen', 'ID', $did, 'Name,Gelar');
		  $dsn = $arrdsn['Name']. ', '.$arrdsn['Gelar'];
		  $prg = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	  } else ResetMhsw();
	}
	else ResetMhsw();
	$nmthn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, 'Nama');
	if (empty($nmthn)) {
	  $nmthn = '<font color=red><b>Tahun Akademik TIDAK ADA</b></font>';
	  $ret = false;
	}
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=ttl>Tahun Akademik</td><td class=lst><input type=text name='thn' value='$thn' size=5 maxlength=5>$nmthn</td></tr>
	  <tr><td class=ttl>NIM</td><td class=lst><input type=text name='nim' value='$nim' size=20 maxlength=20></td>
	    <td class=basic rowspan=5 valign=bottom align=center><img src='image/tux001.jpg'><br>
		<input type=submit name='GO' value='Refresh'></td></tr>
	  <tr><td class=ttl>Nama</td><td class=lst>$nme</td></tr>
	  <tr><td class=ttl>Jurusan</td><td class=lst>$kdj - $jur</td></tr>
	  <tr><td class=ttl>Program</td><td class=lst>$prg</td></tr>
	  <tr><td class=ttl>Dosen Penasehat</td><td class=lst>$dsn</td></tr>
	  </form></table><br>
EOF;
  return $ret;
}
  function GetLastThn($kdj='') {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from tahun where NotActive='N' and KodeJurusan='$kdj' order by Kode desc limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) {
	  //DisplayHeader($fmtErrorMsg, "Tidak ada tahun akademik yang aktif.");
	  return '0';
	}
	else return mysql_result($r, 0, 'Kode');
  }
  function GetLastBiaya($kdj='') {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from biaya where NotActive='N' and KodeJurusan='$kdj' order by Kode desc limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) return '0';
	else return mysql_result($r, 0, 'Kode');
  }
  function ValidTahunNim($thn, $nim) {
    global $strCantQuery;
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$s = "select * from tahun where Kode='$thn' and KodeJurusan='$kdj' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	return (mysql_num_rows($r) > 0);
  }

function DispOptJdwl0 ($act='jdwlkuliah') {
  global $thn, $kdj, $tab, $prn;
	if (!isset($prn)) $prn = 0;
	/* $ajur = GetFields('jurusan', 'Kode', $kdj, 'Nama_Indonesia, KodeFakultas');
	if (!empty($ajur)) {
	  $kdf = $ajur['KodeFakultas'];
	  $jur = $ajur['Nama_Indonesia'];
	} 
	else { $kdf = ''; $jur = ''; } */
  if (empty($thn)) $thn = GetLastThn($kdj);
	$optjur = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	$nmthn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, 'Nama');
	if (empty($nmthn)) $nmthn = '<font color=red><b>Tahun Akademik TIDAK ADA</b></font>';
	$th_n = substr($thn, 0, 4);
	$th_s = substr($thn, 4, 1);
	if ($prn == 0) {
	  $strthn = "<input type=text name='thn' value='$thn' size=5 maxlength=5>&nbsp;";
	  $strjur = "<select name='kdj'>$optjur</select>";
	  $strsub = "<tr><td class=lst colspan=2><input type=submit name='go' value='Refresh'></td></tr>";
	}
	else {
	  $jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  $strthn = "$thn";
	  $strjur = "$kdj - $jur";
	  $strsub = '';
	}
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='tab' value='$tab'>
	  <tr><th class=ttl colspan=2>Tahun Akademik</th></tr>
	  <tr><td class=lst rowspan=2>Tahun Akademik & Semester</td><td class=lst>$strthn</td></tr>
	  <tr><td class=lst>$nmthn</td></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst>$strjur</td></tr>
	  $strsub
	  </form></table>
EOF;
}
  function GetKur4Jdwl($kdj, $prg='', $act='jdwlkuliah') {
    global $strCantQuery, $fmtErrorMsg, $Sesi, $JmlSesi, $kurid, $nkur, $tkur;
    $s = "select * from kurikulum where KodeJurusan='$kdj' and NotActive='N' order by ID desc limit 1";
	$r = mysql_query($s) or die(DisplayHeader($fmtErrorMsg, "$strCantQuery: $s", 0));
	if (mysql_num_rows($r) == 0) die(DisplayHeader($fmtErrorMsg, "Tidak ada kurikulum aktif.", 0));
	$kurid = mysql_result($r, 0, 'ID');
	$nkur = mysql_result($r, 0, 'Nama');
	$tkur = mysql_result($r, 0, 'Tahun');
	$Sesi = mysql_result($r, 0, 'Sesi');
	$JmlSesi = mysql_result($r, 0, 'JmlSesi');
	//GetOption('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', "$kdj -- $jur", '', 'Kode');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $prg, '', 'Kode');
	return <<<EOF
	  <table class=basic><tr><th class=ttl>Kurikulum</th>
	  <td class=lst>$tkur</td><td class=lst>$nkur</td></tr>
	  <tr><form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <th class=ttl>Program</th>
	  <td class=lst colspan=2><select name='prg' onChange='this.form.submit()'>$optprg</select></td></tr>
	  </form>
	  </table>
EOF;
  }
  function GetLastKur($kdj) {
    global $strCantQuery;
	$s = "select ID from kurikulum where KodeJurusan='$kdj' and NotActive='N' order by ID desc limit 1";
	$r = mysql_query($s) or die (DisplayHeader($fmtErrorMsg, "$strCantQuery: $s", 0));
	if (mysql_num_rows($r) == 0) return 0;
	else return mysql_result($r, 0, 'ID');
  }
function DispJur($kdj, $st, $act='matakuliah') {
	if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
	if ($prn == 0) {
    $optjur = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
    echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='st' value=$st>
	  <tr><td class=lst width=100>Jurusan: </td>
	  <td class=lst><select name='kdj' onChange='this.form.submit()'>$optjur</select></td></tr>
	  </form></table>
EOF;
    }
	else {
	  $jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=uline width=100>Jurusan: </td><td class=uline><b>$kdj - $jur</b></td></tr>
	  </table>
EOF;
	}
}
function DispJurPrg($kdj='', $kdp='', $st, $act='matakuliah') {
	if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
	if ($prn == 0) {
    $optjur = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
    $optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdp, '', 'Kode');
    echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='st' value=$st>
	  <tr><td align=right>Jurusan :</td><td class=uline colspan=2><select name='kdj'>$optjur</select></td></tr>
	  <tr><td align=right>Program :</td><td class=uline><select name='kdp'>$optprg</select></td>
	  <td class=uline><input type=submit name='Refresh' value='Refresh'></td></tr>
	  </form></table><br>
EOF;
    }
	else {
	  $jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=uline width=100>Jurusan: </td><td class=uline><b>$kdj - $jur</b></td></tr>
	  </table><br>
EOF;
	}
}
  function DisplayJurusanChoice($def='', $st=0, $act='matakuliah') {
    global $Language;
	//$defkode = GetaField('jurusan', "Nama_$Language", $def, "Kode");
    $opt = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_$Language)", 'Kode', $def, '', 'Kode');
    echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='st' value=$st>
	  <tr><td class=lst width=100>Jurusan: </td>
	  <td class=lst><select name='kdj' onchange='this.form.submit();'>$opt</select></td></tr>
	  </form></table><br>";
  }
function GetFak($kdf, $act) {
  //GetOption('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', "$kdj -- $jur", '', 'Kode');
  $opt = GetOption2('fakultas', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdf, '', 'Kode');
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=lst width=100>Fakultas</td><td class=lst><select name='kdf' onChange='this.form.submit()'>$opt</select></td></tr>
	  </form></table>
EOF;
}
function DisplayListofFaculty($act='fakjur') {
  global $Language, $kdf;
	$unip = $_SESSION['unip'];
	$s = "select * from fakultas order by Kode";
	$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><td></td><th class=ttl>Kode</th><th class=ttl>Fakultas</th><th class=ttl>NA</th></tr>";
	while ($w = mysql_fetch_array($r)) {
		if ($w['Kode'] == $kdf) {
			$img = "<img src='image/kanan.gif' border=0>";
			$cls = "class=nac";
		}
		else {
			$img = '';
			$cls = 'class=lst';
		}
		echo <<<EOF
		<tr><td>$img</td>
		<td $cls><a href='sysfo.php?syxec=$act&kd=$w[Kode]&kdf=$w[Kode]'>$w[Kode]</a></td>
		<td $cls>$w[Nama_Indonesia]</td>
		<td $cls><img src='image/$w[NotActive].gif' border=0></td></tr>
EOF;
	}
	echo "</table>";
}
  function GetGrade($kdj, $nilai) {
    $mni = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
	$a = "select Nilai,Bobot from nilai where Kode='$mni' and
	  BatasBawah <= $nilai and $nilai <= BatasAtas limit 1";
	$b = mysql_query($a);
	if (mysql_num_rows($b) > 0) return array(mysql_result($b, 0, 'Nilai'), mysql_result($b, 0, 'Bobot'));
	else return array('-', 0);
  }
  function GetBobot($kdj, $grd) {
    $mni = GetaField('jurusan', 'Kode', $kdj, 'KodeNilai');
	$a = mysql_query("select Bobot from nilai where Nilai='$grd' and Kode='$mni'");
	if (mysql_num_rows($a) > 0) return mysql_result($a, 0, 'Bobot');
	else return 0;
  }
  function GetKHSDulu($thn, $nim) {
	global $strCantQuery;
    $s = "select h.*, s.Nama as STAT, s.Nilai as STAT0
	  from khs h left outer join statusmhsw s on h.Status=s.Kode
	  where h.Tahun='$thn' and h.NIM='$nim' limit 1";
	$r = mysql_query($s) or die ("$strCantQuery: $s<br>".mysql_error());
	return $r;
  }
  function ProcessNilaiKHSMhsw($thn, $nim) {
    global $strCantQuery, $fmtErrorMsg;
	// cek KHS
	$vld = ValidTahunNim($thn, $nim);
	if (!$vld) {
	  DisplayHeader($fmtErrorMsg, "Tahun ajaran $thn tidak valid.", 1);
	}
	else {
	  $rt = GetKHSDulu($thn, $nim);
	  if (mysql_num_rows($rt) == 0) {
	    (DisplayHeader($fmtErrorMsg, "Tahun ajaran $thn tidak ada aktivitas.<br>
	    Coba konsultasi dengan penasehat akademis."));
		$vld = false;
	  }
	  else {
	    $khid = mysql_result($rt, 0, 'ID');
	    // hitung nilai
	    $s = "select count(*) as jml, sum(k.Nilai) as tnil, sum(k.Bobot) as tbbt, sum(k.SKS) as tsks,
	    sum(k.Bobot * k.SKS) as _Bobot
	    from krs k left outer join jadwal jd on k.IDJadwal=jd.ID
	    where k.Tahun='$thn' and k.NIM='$nim' and k.Tunda='N' and k.NotActive='N'";
	    $r = mysql_query($s) or die ("$strCantQuery: $s<br>Error: ".mysql_error());
	    $tsks = mysql_result($r, 0, 'tsks')+0;
	    $tnil = mysql_result($r, 0, 'tnil')+0;
	    $jml = mysql_result($r, 0, 'jml')+0;
	    $tbbt = mysql_result($r, 0, '_Bobot')+0;
	    mysql_query("update khs set Nilai=$tnil, Bobot=$tbbt, SKS=$tsks, JmlMK=$jml where ID=$khid") or die(mysql_error());
	  }
	}
	return $vld;
  }
  function isTahunAktif($thn, $kdj) {
    return GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, 'NotActive') == 'N';
  }
  function GetUjianCaption($ujn) {
    if ($ujn == 'UTS') return 'Ujian Tengah Semester'; 
    elseif ($ujn == 'UAS') return 'Ujian Akhir Semester';
    elseif ($ujn == 'SSL') return 'Ujian Susulan';
    else return '';
  }
  function DispOptUjian($ujn, $act='jdwlujian') {
	if (empty($ujn)) $opt0 = 'selected'; else $opt0 = '';
	if ($ujn == 'UTS') $opt1 = 'selected'; else $opt1 = '';
	if ($ujn == 'UAS') $opt2 = 'selected'; else $opt2 = '';
	if ($ujn == 'SSL') $opt3 = 'selected'; else $opt3 = '';
	$opt = "<option value='' $opt0></option>
	  <option value='UTS' $opt1>Ujian Tengah Semester</option>
	  <option value='UAS' $opt2>Ujian Akhir Semester</option>
	  <option value='SSL' $opt3>Ujian Susulan</option>	";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=lst width=100>Jenis Ujian: </td>
	  <td class=lst><select name='ujn' onChange='this.form.submit()'>$opt</select></td></tr>
	  </form></table>";
  }
  function GetLoginDosen($dsn, $act='dosenwali') {
    global $nme, $glr, $kdf, $fak, $prn;
	if (!isset($prn)) $prn = 0;
    function ResetDosen() {
	  global $nme, $glr, $kdf, $fak;
	  $nme = '&nbsp;';
	  $glr = '&nbsp;';
	  $kdf = '&nbsp;';
	  $fak = '&nbsp;';
	  return false;
	}
	
    if ($_SESSION['ulevel'] == 1) $vld = true;
    elseif ($_SESSION['ulevel'] == 3) {
      if ($dsn == $_SESSION['unip']) $vld = true; else $vld = false;
	}
	else $vld = ResetDosen();
	if ($vld && !empty($dsn)) {
	  $r = mysql_query("select concat(d.Name, ', ', d.Gelar) as NM, d.Name,d.Gelar,d.KodeFakultas,
	    concat(f.Kode, ' - ', f.Nama_Indonesia) as FAK
	    from dosen d left outer join fakultas f on d.KodeFakultas=f.Kode
		where d.Login='$dsn' limit 1");
	  if (mysql_num_rows($r) > 0) {
	    $nme = mysql_result($r, 0, 'NM');
	    $glr = mysql_result($r, 0, 'Gelar');
	    $kdf = mysql_result($r, 0, 'KodeFakultas');
	    $fak = mysql_result($r, 0, 'FAK');
	    $vld = true;
	  }
	  else $vld = ResetDosen();
	}
	else $vld = ResetDosen();
	if ($prn == 0) $button = "<tr><td class=lst colspan=2><input type=submit name='GO' value='Refresh'></td></tr>";
	else $button = '';
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=ttl width=100>Kode Dosen</td><td class=lst><input type=text name='dsn' value='$dsn' size=10 maxlength=10></td></tr>
	  <tr><td class=ttl>Nama Dosen</td><td class=lst>$nme</td></tr>
	  <tr><td class=ttl>Fakultas</td><td class=lst>$fak</td></tr>
	  $button
	  </form></table><br>
EOF;
	return $vld && !empty($dsn);
  }
function IsMhswAktif($thn, $nim) {
  global $strCantQuery, $fmtErrorMsg;
  $arrstat = GetFields("mhsw m left outer join statusmhsw sm on m.Status=sm.Kode", 'NIM', $nim, "sm.*");
  if ($arrstat['Keluar'] == 0) {
	  $s = "select s.Nilai, s.Nama
	    from khs h left outer join statusmhsw s on h.Status=s.Kode
	    where h.Tahun='$thn' and h.NIM='$nim' limit 1	";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) {
	    DisplayHeader($fmtErrorMsg, "Tidak ada data untuk tahun <b>$thn</b> dari mahasiswa <b>$nim</b><br>
	    Hubungi Penasehat Akademis.");
	    return false;
	  }
	  else {
	    if (mysql_result($r, 0, 'Nilai') == 1) return true;
	    else {
	      DisplayHeader($fmtErrorMsg, "Mahasiswa <b>$nim</b> tidak aktif untuk tahun ajaran <b>$thn</b>.<br>Status: <b>".
		    mysql_result($r, 0, 'Nama')."</b><br>Jika belum registrasi ulang, silakan registrasi ulang dahulu.<hr size=1 color=silver>
		    Pilihan : <a href='sysfo.php?syxec=mhswherreg&nim=$nim'>Registrasi Ulang</a>");
		  return false;
	    } 
	  }
  }
  else {
	  DisplayHeader($fmtErrorMsg, "Mahasiswa berstatus: <b>$arrstat[Nama]</b>.<br>Tidak dapat mengisi KRS.");
	  return false;
  }
}
  function DispSearchMhsw($srcmhsw, $act='mhswmasterkeu') {
    echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=lst width=100>Cari Mhsw</td><td class=lst><input type=text name='srcmhsw' value='$srcmhsw' size=10 maxlength=10>&nbsp;
	  <input type=submit name='prcsrc' value='Name'>&nbsp;<input type=submit name='prcsrc' value='NIM'></td></tr>
	  </form></table><br>
EOF;
  }
function DispDaftarMhsw($kdj, $prc, $src, $act='mhswmasterkeu') {
  global $strCantQuery, $fmtErrorMsg;
  if (empty($src)) DisplayHeader($fmtErrorMsg, "Tidak ada nilai yg dicari.");
	else {
	  if (empty($prc)) $prc = 'Name';
	  if (empty($kdj)) $strkdj = ''; else $strkdj = "and KodeJurusan='$kdj'";
	  $s = "select m.NIM, m.Name, st.Nama as STAT, st.Nilai as nSTA, st.Keluar as KLR, sta.Nama as STAWAL,
	    m.TahunAkademik, m.KodeBiaya, m.KodeJurusan as kdj, p.Nama_Indonesia as prg
	    from mhsw m left outer join statusmhsw st on m.Status=st.Kode
		  left outer join statusawalmhsw sta on m.StatusAwal=sta.Kode
		  left outer join program p on m.KodeProgram=p.Kode
		  where m.$prc like '%$src%' $strkdj order by m.NIM";
	  $r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	  echo "<table class=basic cellspacing=0 cellpadding=1>
	    <tr><th class=ttl>NIM</th><th class=ttl>Nama Mahasiswa</th>
	    <th class=ttl>Program</th>
			<th class=ttl>Thn<br>Masuk</th><th class=ttl>Master<br>Biaya</th>
			<th class=ttl>Status</th><th class=ttl>St. Awal</th>
			</tr> ";
	  while ($row = mysql_fetch_array($r)) {
	    $thn = StripEmpty($row['TahunAkademik']);
		  $bea = StripEmpty($row['KodeBiaya']);
		  $sta = StripEmpty($row['STAT']);
		  $stawal = StripEmpty($row['STAWAL']);
		  if ($row['KLR'] == 1) $cls = 'class=nac'; else $cls = 'class=lst';
	    echo <<<EOF
		  <tr><td $cls><a href='sysfo.php?syxec=$act&nim=$row[NIM]&md=0&kdj=$row[kdj]'>$row[NIM]</a></td>
		  <td $cls>$row[Name]</td>
		  <td $cls>$row[prg]</td>
		  <td $cls>$thn</td>
		  <td $cls>$bea</td>
		  <td $cls>$sta</td>
		  <td $cls>$stawal</td>
		  </tr>
EOF;
	  }
	  echo "</table>
	    <font class=lst>Total: </font><font class=ttl>".mysql_affected_rows() .'</font>';
	}
}
  function DispHeaderMhsw($nim, $act='mhswkeu', $ext=0) {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select m.NIM, m.Name, m.KodeFakultas, m.KodeJurusan,
	  m.TotalSKS, m.TA, m.IPK, concat(d.Name, ', ', d.Gelar) as DSN,
	  j.Nama_Indonesia as JUR, f.Nama_Indonesia as FAK,
	  je.Nama as JEN, st.Nama as STA, st.Nilai as KLR, sta.Nama as STAW
	  from mhsw m left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode
	  left outer join statusmhsw st on m.Status=st.Kode
	  left outer join statusawalmhsw sta on m.StatusAwal=sta.Kode
	  left outer join dosen d on m.DosenID=d.ID
	  where m.NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$row = mysql_fetch_array($r);
	if ($row['KLR'] == 0) $cls = 'class=nac'; else $cls = 'class=lst';
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Nama</th>
	  <th class=ttl>Fakultas</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Jenjang</th>
	  <th class=ttl>Status</th><th class=ttl>Status Awal</th>
	  <th class=ttl>&nbsp;</th>
	  </tr>
	  <tr><td class=lst>$row[NIM]</td>
	  <td class=lst>$row[Name]</td>
	  <td class=lst>$row[KodeFakultas] - $row[FAK]</td>
	  <td class=lst>$row[KodeJurusan] - $row[JUR]</td>
	  <td class=lst>$row[JEN]</td>
	  <td $cls>$row[STA]</td>
	  <td $cls>$row[STAW]</td>
	  <td class=lst><a href='sysfo.php?syxec=$act&md=-1'>Kembali</td>
	  </tr></table><br>
EOF;
    if ($ext == 1) {
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Dosen Pembimbing</th><th class=ttl>Tot SKS</th><th class=ttl>IPK</th>
	  <th class=ttl>TA</th>
	  </tr>
	  <tr><td class=lst>$row[DSN]</td><td class=lst align=right>$row[TotalSKS]</td><td class=lst align=right>$row[IPK]</td>
	  <td class=lst><img src='image/$row[TA].gif' border=0></td>
	  </tr></table><br>
EOF;
	}
}
function DispBiaya($kdj, $bea, $act, $mdbiaya=0) {
  global $strCantQuery, $fmtErrorMsg;
	$s = "select * from biaya where KodeJurusan='$kdj' order by Kode desc";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if ($mdbiaya==0) $b0 = "<a href='sysfo.php?syxec=$act&bea=&md=1' class=lst>Tambah Master Biaya</a>";
	else $b0 = '';
	$b0 = $b0. "<table class=basic cellspacing=0 cellpadding=1 width=100%>
	  <tr><th class=basic>&nbsp;</th>
	  <th class=ttl>Tahun</th><th class=ttl>Keterangan</th><th class=ttl>na</th>
	  <th class=basic></th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  if ($row['Kode'] == $bea) $pt = "<img src='image/bullet001.gif' border=0>"; else $pt = '&nbsp;';
	  if ($mdbiaya==0) $stred = "<td $cls><a href='sysfo.php?syxec=$act&bea=$row[Kode]&md=0'>ed</a></td>";
	  else $stred = '';
	  $b0 = $b0 . <<<EOF
	  <tr><td width=5>$pt</td>
	  <td $cls><a href='sysfo.php?syxec=$act&bea=$row[Kode]'>$row[Kode]</a></td>
	  <td $cls>$row[Nama]</td><td $cls align=center><img src='image/book$row[NotActive].gif' border=0>
	  $stred</tr>
EOF;
	}
	return $b0 . "</table>
	<table class=basic cellspacing=0 cellpadding=1>
	<tr><td class=lst><b>ed</b></td><td class=basic>edit.</td></tr></table>";
  }
  function ValidMasterBiaya($kdj, $bea) {
    $cek = GetaField('biaya', "KodeJurusan='$kdj' and Kode", $bea, 'Kode');
    return !empty($cek);
  }
  function KenaDenda($thn, $kdj) {
	$arr = GetFields('bataskrs', "KodeJurusan='$kdj' and Tahun", $thn, "Denda,HargaDenda,AkhirBayar,date_format(AkhirBayar,'%Y') as y,date_format(AkhirBayar,'%m') as m,date_format(AkhirBayar, '%d') as d");
	if (!empty($arr) && $arr['Denda'] == 'Y') {
	  $akh = mktime(0,0,0,$arr['m'], $arr['d'], $arr['y']);
	  $skr = mktime(0,0,0, date('m'), date('d'), date('Y'));
	  return date('z', $skr - $akh);
	} else return 0;
  }
  function DisplayListofJurusan($kdf='',$act='fakjur') {
    global $strCantQuery,$Language;

	$unip = $_SESSION['unip'];
	if (empty($kdf)) $strkodefak = '';
	else $strkodefak = "where j.KodeFakultas='$kdf'";
    $nbrw = new newsbrowser;
    $nbrw->query = "select j.*, jj.Nama as JenjangPS from jurusan j left outer join jenjangps jj
	  on j.Jenjang=jj.Kode $strkodefak order by j.Rank";
    $nbrw->headerfmt = "<table class='basic' cellspacing=1 cellpadding=1 width=100%>
	  <tr><th class=ttl>Kode</th><th class=ttl>Jurusan</th><th class=ttl>Jenjang</th>
	  <th class=ttl>Nilai</th><th class=ttl>NA</th></tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=$act&seq=3&kdj==Kode=&kd=$kdf'>=Kode=</td>
	  <td class=lst>=Nama_$Language=</td><td class=lst>=JenjangPS=</td>
	  <td class=lst>=KodeNilai=</td>
	  <td class=lst align=center>=NotActive=</td></tr>";
    $nbrw->footerfmt = "</table>";
    echo $nbrw->BrowseNews();  
  }
  function GetNextNIM($kdj, $kdp='') {
    // ambil prefix
    $_sql = "select * from setupnim";
    $_res = mysql_query($_sql) or die("Gagal");
    $_prefix = mysql_result($_res, 0, "NIMPrefix");
    $_digit = mysql_result($_res, 0, "NIMDigit");
	$subprefix = GetaField('jurusan', 'Kode', $kdj, 'Prefix');
	$prgprefix = GetaField("jurprg", "NotActive='N' and KodeJurusan='$kdj' and KodeProgram", $kdp, 'Prefix');
  
    // ambil nomer terakhir
    $_sql = "select max(NIM) as LastID 
	  from mhsw where NIM like '$_prefix$subprefix$prgprefix%'";
    $_res = mysql_query($_sql) or die("Gagal: $_sql");

    if (mysql_num_rows($_res) == 0) $_last = 0;
    else {
	  $_last = mysql_result($_res, 0, "LastID");
	  //echo "<p><b>_last: $_last</b></p>";
	  $_last = str_replace($_prefix.$subprefix.$prgprefix, '', $_last);
	  //echo "<p><b>_last: $_last</b></p>";
	  settype($_last, 'integer');
	  //echo "<p><b>_last->integer: $_last</b></p>";
	  $_last++;
	  settype($_last, 'string');
	  $_last = str_pad($_last, $_digit, '0', 0);
	  $_last = "$_prefix$subprefix$prgprefix$_last";
      //$_last++;
	}
    return $_last;
  }
  function DispNIMMhsw($nim='', $act='') {
    echo <<<EOF
	  <table class=lst cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=basic width=100>NIM Mahasiswa:</td>
	  <td class=basic><input type=text name='nim' value='$nim' size=20 maxlength=30>
	  <input type=submit name='srcnim' value='Cari'></td></tr>
	  </form></table><br>
EOF;
  }
  function ValidNIM($nim='') {
    $ada = GetaField('mhsw', 'NIM', $nim, 'NIM');
    return (!empty($ada));
  }
  function GetOptStatusMhsw() {
    global $strCantQuery;
    if (isset($_SESSION['PerStatusMhsw'])) $sopt = $_SESSION['PerStatusMhsw']; else $sopt = '';
	$s = "select * from statusmhsw";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$rw = ceil(mysql_num_rows($r) / 2);
	$i = 0;
	$a = '<table class=basic cellspacing=0 cellpadding=2>';
	while ($w = mysql_fetch_array($r)) {
	  if ($i == 0) $a .= '<tr><td>';
	  if ($i == $rw) $a .= '</td><td>';
	  $i++;
	  if (strpos($sopt, "|$w[Kode]|") === false) $sck = '';
	  else $sck = 'checked';
	  $a .= "<input type=checkbox name='PerStatusMhsw[]' value='$w[Kode]' $sck>$w[Nama]<br>";
	}
	return $a . '</td></tr></table>';
  }
function DispOptRpt($rpt='') {
  global $fmtPageTitle;
  if (isset($_REQUEST['param'])) $param = $_REQUEST['param'];
  else $param = 'x';
  $w = GetFields("rptmgr", "Rpt", $rpt, "*");
	if (!empty($w)) {
	  DisplayHeader($fmtPageTitle, "Cetak: ". $w['Nama']);
	  $PerTahun = ''; $PerMhsw = ''; $PerJur = ''; $PerPrg = ''; $PerTglAwal = ''; $PerTglAkhir = '';
	  $PerBulan = ''; $PerStatusMhsw = ''; $PerAngkDari = ''; $PerAngkSampai = ''; $PerJnsByr = '';
	  if ($w['PerTahun'] == 'Y') {
	    if (isset($_SESSION['PerTahun'])) $_PerTahun = $_SESSION['PerTahun']; else $_PerTahun = '';
	    $PerTahun = "<tr><td class=uline>Tahun Ajaran:</td><td class=uline><input type=text name='PerTahun' value='$_PerTahun' size=5 maxlength=5></td></tr>";
	  }
	  if ($w['PerMhsw'] == 'Y') {
	    if (isset($_SESSION['PerMhsw'])) $_PerMhsw = $_SESSION['PerMhsw']; else $_PerMhsw = '';
	    $PerMhsw = "<tr><td class=uline>NIM Mahasiswa:</td><td class=uline><input type=text name='PerMhsw' value='$_PerMhsw' size=20 maxlength=20></td></tr>";
	  }
	  if ($w['PerJur'] == 'Y') {
	    if (isset($_SESSION['PerJur'])) $_PerJur = $_SESSION['PerJur']; else $_PerJur = '';
	    $optjur = GetOption2("jurusan", "concat(Kode, ' -- ', Nama_Indonesia)", "Kode", $_PerJur, '', 'Kode');
		$PerJur = "<tr><td class=uline>Jurusan</td><td class=uline><select name='PerJur'>$optjur</select></td></tr>";
	  }
	  if ($w['PerPrg'] == 'Y') {
	    if (isset($_SESSION['PerPrg'])) $_PerPrg = $_SESSION['PerPrg']; else $_PerPrg = '';
		$optprg = GetOption2("program", "concat(Kode, ' -- ', Nama_Indonesia)", "Nama_Indonesia", $_PerPrg, '', 'Kode');
		$PerPrg = "<tr><td class=uline>Program</td><td class=uline><select name='PerPrg'>$optprg</select></td></tr>";
	  }
	  if ($w['PerJnsByr'] == 'Y') {
	    if (isset($_SESSION['PerJnsByr'])) $_PerJnsByr = $_SESSION['PerJnsByr']; else $_PerJnsByr = '';
		$optbyr = GetOption2("jenisbayar", "Nama", "ID", $_PerJnsByr, '', 'ID');
		$PerJnsByr = "<tr><td class=uline>Jenis Pembayaran</td><td class=uline><select name='PerJnsByr'>$optbyr</select></td></tr>";
	  }
	  if ($w['PerTglAwal'] == 'Y') {
	    if (isset($_SESSION['PTAW_d'])) $PTAW_d = $_SESSION['PTAW_d']; else $PTAW_d = date('d');
	    if (isset($_SESSION['PTAW_m'])) $PTAW_m = $_SESSION['PTAW_m']; else $PTAW_m = date('m');
	    if (isset($_SESSION['PTAW_y'])) $PTAW_y = $_SESSION['PTAW_y']; else $PTAW_y = date('Y');
	    $PerTglAwal = "<tr><td class=uline>Dari Tanggal:</td><td class=uline>
		<input type=text name='PTAW_d' value='$PTAW_d' size=2 maxlength=2>&nbsp;
		<input type=text name='PTAW_m' value='$PTAW_m' size=2 maxlength=2>&nbsp;
		<input type=text name='PTAW_y' value='$PTAW_y' size=4 maxlength=4>&nbsp;
		</td></tr>";
	  }
	  if ($w['PerTglAkhir'] == 'Y') {
	    if (isset($_SESSION['PTAK_d'])) $PTAK_d = $_SESSION['PTAK_d']; else $PTAK_d = date('d');
	    if (isset($_SESSION['PTAK_m'])) $PTAK_m = $_SESSION['PTAK_m']; else $PTAK_m = date('m');
	    if (isset($_SESSION['PTAK_y'])) $PTAK_y = $_SESSION['PTAK_y']; else $PTAK_y = date('Y');
	    $PerTglAkhir = "<tr><td class=uline>Sampai Tanggal:</td><td class=uline>
		<input type=text name='PTAK_d' value='$PTAK_d' size=2 maxlength=2>&nbsp;
		<input type=text name='PTAK_m' value='$PTAK_m' size=2 maxlength=2>&nbsp;
		<input type=text name='PTAK_y' value='$PTAK_y' size=4 maxlength=4>&nbsp;
		</td></tr>";
	  }
	  if ($w['PerBulan'] == 'Y') {
	    if (isset($_SESSION['PerBulan'])) $bln = $_SESSION['PerBulan']; else $bln = 0;
	    $optbln = GetMonthOption($bln);
		$PerBulan = "<tr><td class=uline>Bulan</td><td class=uline><select name='PerBulan'>$optbln</select></td></tr>";
	  }
	  if ($w['PerStatusMhsw'] == 'Y') {
	    $st = GetOptStatusMhsw();
	    $PerStatusMhsw = "<tr><td class=uline>Status Mhsw</td><td class=uline>$st</td></tr>";
	  }
	  if ($w['PerAngkDari'] == 'Y') {
	    if (isset($_SESSION['PerAngkDari'])) $PerAngkDari = $_SESSION['PerAngkDari']; else $PerAngkDari = '';
	    $PerAngkDari = "<tr><td class=uline>Dari Angkatan Mhsw</td>
		<td class=uline><input type=text name='PerAngkDari' value='$PerAngkDari' size=10 maxlength=5></td></tr>";
	  }
	  if ($w['PerAngkSampai'] == 'Y') {
	    if (isset($_SESSION['PerAngkSampai'])) $PerAngkSampai = $_SESSION['PerAngkSampai']; else $PerAngkSampai = '';
	    $PerAngkSampai = "<tr><td class=uline>Sampai Angkatan</td>
		<td class=uline><input type=text name='PerAngkSampai' value='$PerAngkSampai' size=10 maxlength=5></td></tr>";
	  }

	  echo <<<EOF
	  <table class=box cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='rptcall'>
	  <input type=hidden name='rpt' value='$rpt'>
	  <input type=hidden name='param' value='$param'>
	  <tr><td class=uline rowspan=6 align=center><img src='image/printer.gif'><br><img src="image/tux001.jpg"></td><td></td></tr>
	  $PerTahun $PerMhsw $PerJur $PerPrg $PerJnsByr $PerTglAwal $PerTglAkhir $PerBulan $PerStatusMhsw $PerAngkDari $PerAngkSampai
	  <tr><td class=uline colspan=3><input type=submit name='prc' value='Cetak'>&nbsp;
	  <input type=reset name='reset' value='Reset'></td></tr>
	  </form></table>
EOF;
	}
  }
  function UpdateIPK($nim) {
    global $strCantQuery;
	$arr = GetFields('krs', "NotActive='N' and Tunda='N' and NIM", $nim, 'sum(SKS) as TSKS, sum(Bobot*SKS) as TBBT');
	$ipk = $arr['TBBT'] / $arr['TSKS'];
	$s = "update mhsw set IPK='$ipk', TotalSKS='$arr[TSKS]' where NIM='$nim'";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
  }
  function DispHeaderMhsw0($nim='') {
    global $strCantQuery;
	$s = "select m.Name, m.KodeJurusan, m.KodeFakultas, j.Nama_Indonesia as JUR,
	  f.Nama_Indonesia as FAK, p.Nama_Indonesia as PRG, jp.Nama as JEN
	  from mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join program p on m.KodeProgram=p.Kode
	  left outer join jenjangps jp on j.Jenjang=jp.Kode
	  where m.NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) > 0) {
	  $nme = mysql_result($r, 0, 'Name');
	  $jur = mysql_result($r, 0, 'JUR');
	  $prg = mysql_result($r, 0, 'PRG');
	  $jen = mysql_result($r, 0, 'JEN');
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2 bgcolor=white>
	  <tr><td width=100>NIM</td><td>:</td><td class=uline width=250>$nim</td></tr>
	  <tr><td>Nama Mahasiswa</td><td>:</td><td class=uline>$nme</td></tr>
	  <tr><td>Jurusan</td><td>:</td><td class=uline>$jur ($jen)</td></tr>
	  </table>
EOF;
	}
  }
  function GetBentrokJdwlMhsw($r, $arrj, $strs) {
    $hari = GetaField('hari', 'ID', mysql_result($r, 0, 'Hari'), 'Nama');
	$namamk = mysql_result($r, 0, 'NamaMK');
	$jm = mysql_result($r, 0, 'JamMulai');
	$js = mysql_result($r, 0, 'JamSelesai');
    return <<<EOF
	  <li>Error: <b>$arrj[NamaMK]</b><br>
	  Mata kuliah tdk dpt diambil krn bentrok dengan :<br>
	  $strs Bentrok dengan <b>$namamk</b>, Hari: $hari, Jam Mulai: $jm, Jam Selesai: $js<br>&nbsp;</li>
EOF;
  }
  function CekBentrokJdwlMhsw($nim, $thn, $arrj) {
	$stre = '';
	$sm = "select k.*, jd.*
	  from krs k inner join jadwal jd on k.IDJadwal=jd.ID
	  where k.NIM='$nim' and k.Tahun='$thn' and
	  jd.Hari=$arrj[Hari] and
	  jd.JamMulai <= '$arrj[JamMulai]' and '$$arrj[JamMulai]' <= jd.JamSelesai and k.IDJadwal<>$arrj[ID] ";
	$rm = mysql_query($sm) or die(mysql_error());
	if (mysql_num_rows($rm) > 0) $stre .= GetBentrokJdwlMhsw($rm, $arrj, 'Jam Mulai');

	$ss = "select k.*, jd.*
	  from krs k inner join jadwal jd on k.IDJadwal=jd.ID
	  where k.NIM='$nim' and k.Tahun='$thn' and
	  jd.Hari=$arrj[Hari] and
	  jd.JamMulai <= '$arrj[JamSelesai]' and '$$arrj[JamSelesai]' <= jd.JamSelesai and k.IDJadwal<>$arrj[ID] ";	
	$rs = mysql_query($ss) or die(mysql_error());
	if (mysql_num_rows($rs) > 0) $stre .= GetBentrokJdwlMhsw($rs, $arrj, 'Jam Selesai');
	return $stre;
  }
  function UpdateSKSKHS($nim, $thn) {
    global $strCantQuery;
	$jml = GetaField('krs', "NIM='$nim' and Tahun", $thn, 'sum(SKS)') + 0;
	$s = "update khs set SKS=$jml where NIM='$nim' and Tahun='$thn'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
function GetMaxSKSMhsw($nim) {
  global $strCantQuery;
  $defSKS = 22;
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$s = "select Sesi, (Bobot / SKS) as bbt from khs where NIM='$nim' order by Sesi desc limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	if (mysql_num_rows($r) == 0) {
	  $sesi = 0; $bbt = 0;
	}
	else {
	  $sesi = mysql_result($r, 0, 'Sesi');
	  $bbt = mysql_result($r, 0, 'bbt');
	}
	//settype($bbt, 'int');
	$max = GetaField('maxsks', "IPSMIN <= $bbt and $bbt <= IPSMax and KodeJurusan", $kdj, 'SKSMax');
	return $max;
  }
?>