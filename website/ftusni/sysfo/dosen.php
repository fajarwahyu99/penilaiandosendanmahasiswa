<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2002

function DisplaySearchDosen($usr) {
  global $nilai, $kdf, $srcdsnval;
  $optkdf = GetOption2('fakultas', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdf, '', 'Kode');
	$sid = session_id();
    echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='usr' value='$usr'>
	  <tr><td class=uline width=100>
	  Cari $usr: </td>
	  <td class=uline>
	  <input type=text name='srcdsnval' value='$srcdsnval' size=20 maxlength=20>
	  <input type=submit name='srcdsnmod' value='Name'>
	  <input type=button name='All' value='All' onClick='location=\"sysfo.php?syxec=dosen&usr=$usr&usrid=-1&srcdsnmod=&srcdsnval=&kdj=&PHPSESSID=$sid\"'>
	  </td></tr></form>
	  
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='kdf' value='$kdf'>
	  <tr><td class=uline>Fakultas</td>
	  <td class=uline><select name='kdf' onChange='this.form.submit()'>$optkdf</select></td></tr>
	  </table>";
}

function DisplayUserList() {
  global $usr, $usrsr, $strPage, $maxrow, $strwhr, $SearchMode, $nilai, $kdf;
  if (isset($_SESSION['srcdsnmod']) && isset($_SESSION['srcdsnval'])) $strnme = "and Name like '%$_SESSION[srcdsnval]%' ";
  else $strnme = '';
  if (isset($kdf) && !empty($kdf)) $strkdf = "and KodeFakultas='$kdf' "; else $strkdf = '';
  //if (empty($strwhr))
	$urlnilai = urlencode($nilai);
    $pagefmt = "<a href='sysfo.php?syxec=dosen&usr=$usr&$SearchMode=1&nilai=$urlnilai&usrsr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
  
    $lister = new lister;
    $lister->tables = "$usr where Name <> '' $strnme $strkdf order by Name,Login";
	//echo $lister->tables;
    $lister->fields = "* ";
    $lister->startrow = $usrsr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=2>
      <tr>
	  <th class=ttl>#</th><th class=ttl>Nama</th>
	  <th class=ttl>Gelar</th>
	  <th class=ttl>Login</th>
	  <th class=ttl>Email</th><th class=ttl>Phone</th>
	  <th class=ttl>NA</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class=nac width=18 align=right>=NOMER=</td>
	  <td class='lst'>
	  <a href='sysfo.php?syxec=dosen&usrsr=$usrsr&usr=$usr&usrnip==Login=&usrid==ID=&$SearchMode=1&nilai=$urlnilai'>=Name=</a></td>
	  <td class=lst>=Gelar=</td>
	  <td class='lst'>=Login=</td>
	  <td class=lst>=Email=</td>
	  <td class=lst>=Phone=</td>
	  <td class='lst'><center><img src='image/book=NotActive=.gif' border=0></td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<p>$strPage: $halaman<br>".
    $lister->ListIt () .
	  "$strPage: $halaman</p>";
    echo $usrlist;
  }
  function DisplayUserBrief($usr, $usrid) {
    global $strCantQuery;
	echo <<<EOF
      <script>
      <!--
      function remote(){
        win2=window.open("sysfo/perguruantinggi.php?_kode=KodePT&_nilai=NamaPT","","width=600,height=600,scrollbars,status")
        win2.creator=self
	  }
	  //-->
	  </script>
EOF;

	if ($usrid == 0) {
	  $Name = '';
	  $Gelar = '';
	  $Email = '';
	  $Phone = '';
	  $NotActive = '';
	}
	else {
      $_sql = "select * from $usr where ID=$usrid";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  $Name = mysql_result($_res, 0, 'Name');
	  $Gelar = mysql_result($_res, 0, 'Gelar');
	  $Email = mysql_result($_res, 0, 'Email');
	  $Phone = mysql_result($_res, 0, 'Phone');
	  if (mysql_result($_res, 0, 'NotActive') == 'Y') $NotActive='checked';
	  else $NotActive = '';
	}
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='usrid' value='$usrid'>
	  <tr><th colspan=2 class=ttl>Admin. $usr: $usrid</th><td class=basic></tr></tr>
	  <tr><td class=lst>Nama & Gelar</td><td class=lst><input type=text name='Name' value='$Name' size=25 maxlength=50>
	    <input type=text name='Gelar' value='$Gelar' size=15 maxlength=100></td>
	    <td class=basic rowspan=3 valign=bottom align=center><img src='image/tux001.jpg' border=0><br>
		<input type=submit name='prc' value='Simpan'>
		<input type=reset name=reset value='Reset'>
		</td></tr>
	  <tr><td class=lst>Telp. & Email</td><td class=lst><input type=text name='Phone' value='$Phone' size=20 maxlength=30> <input type=text name='Email' value='$Email' size=20 maxlength=50></td></tr>

	  <tr><td class=lst>Tdk Aktif</td><td class=lst><input type=checkbox name='NotActive' value='Y' $NotActive></td></tr>
	  </form></table>";
  }
  function ProcessUserBrief() {
    global $strCantQuery;
    $usr = $_REQUEST['usr'];
	$usrid = $_REQUEST['usrid'];
	$Name = FixQuotes($_REQUEST['Name']);
	$Gelar = FixQuotes($_REQUEST['Gelar']);
	$Email = FixQuotes($_REQUEST['Email']);
	$Phone = FixQuotes($_REQUEST['Phone']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	if ($usrid==0) {
	  $_sql = "insert into $usr (Name, Gelar, Email, Phone, NotActive) values
	    ('$Name', '$Gelar', '$Email', '$Phone', '$NotActive')";
	}
	else {
	  $_sql = "update $usr set Name='$Name', Gelar='$Gelar', Email='$Email', Phone='$Phone',
	    NotActive='$NotActive' where ID=$usrid";
	}
	mysql_query($_sql) or die("$strCantQuery: $_sql");
  }
  function GetDosenContent($usr, $usrid, $dsntab) {
    if ($dsntab == 0) return GetDosenData($usr, $usrid);
	elseif ($dsntab == 1) return GetDosenProfile($usr, $usrid);
	elseif ($dsntab == 2) return GetDosenAkademic($usr, $usrid);
	elseif ($dsntab == 3) return GetDosenRiset($usr, $usrid);
  }
  function GetDosenData($usr, $usrid) {
    global $strCantQuery, $Student_MinYear, $Student_MaxYear;
    $_sql = "select *, DATE_FORMAT(TglLahir, '%d') as hh, DATE_FORMAT(TglLahir, '%m') as bb,
	  DATE_FORMAT(TglLahir, '%Y') as tt from $usr where ID=$usrid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$TempatLahir = mysql_result($_res, 0, 'TempatLahir');
	
	$hh = mysql_result($_res, 0, 'hh');
	$bb = mysql_result($_res, 0, 'bb');
	$tt = mysql_result($_res, 0, 'tt');
	// opsi utk tgl lahir
	$opthh = GetNumberOption(1, 31, $hh);
	$optbb = GetMonthOption($bb);
	$opttt = GetNumberOption($Student_MinYear, $Student_MaxYear, $tt);

	$strsy = ''; $strsx = '';
	if (mysql_result($_res, 0, 'Sex') == 'L') $strsy = 'checked';
	else $strsx = 'checked';

	$AgamaID = mysql_result($_res, 0, 'AgamaID');
	$KTP = mysql_result($_res, 0, 'KTP');
	$Alamat1 = mysql_result($_res, 0, 'Alamat1');
	$Alamat2 = mysql_result($_res, 0, 'Alamat2');
	$Kota = mysql_result($_res, 0, 'Kota');
	$Negara = mysql_result($_res, 0, 'Negara');
	$Propinsi = mysql_result($_res, 0, 'Propinsi');
	$KodePos = mysql_result($_res, 0, 'KodePos');
	$Description = mysql_result($_res, 0, 'Description');
	
	$strAgama = GetaField('agama', 'AgamaID', $AgamaID, 'Agama');
	$optagama = GetOption('agama', 'Agama', 'Agama', $strAgama, '', 'AgamaID');
    return <<<EOF
	  <table class=basic width=100% cellspacing=0 cellpadding=2 border=0>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='usrid' value='$usrid'>
	  <tr><td class=lst>Tempat Lahir</td><td><input type=text name='TempatLahir' value='$TempatLahir' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Tanggal Lahir</td><td><select name='hh'>$opthh</select> <select name='bb'>$optbb</select> <select name='tt'>$opttt</select></td></tr>
	  <tr><td class=lst>Jenis Kelamin</td><td>
	    <input type=radio name='Sex' value='L' $strsy>Laki-laki
	    <input type=radio name='Sex' value='P' $strsx>Perempuan</td></tr>
	  <tr><td class=lst>Agama</td><td><select name='AgamaID'>$optagama</select></td></tr>
	  <tr><td class=lst>KTP</td><td><input type=text name='KTP' value='$KTP' size=40 maxlength=100></td></tr>
	  
	  <tr><td colspan=2 height=10></td></tr>
	  <tr><td class=lst>Alamat 1</td><td><input type=text name='Alamat1' value='$Alamat1' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Alamat 2</td><td><input type=text name='Alamat2' value='$Alamat2' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Kota</td><td><input type=text name='Kota' value='$Kota' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Propinsi</td><td><input type=text name='Propinsi' value='$Propinsi' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Negara</td><td><input type=text name='Negara' value='$Negara' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>KodePos</td>
	    <td><input type=text name='KodePos' value='$KodePos' size=40 maxlength=50></td></tr>
	  <tr><td class=lst>Keterangan</td><td><textarea name='Description' rows=3 cols=35>$Description</textarea></td></tr>
	  <tr><td colspan=2><input type=submit name='prc0' value='Simpan'>
	  <input type=reset name='reset' value='Reset'></td></tr>
	  </form></table>
EOF;
  }
  
  function GetDosenProfile($usr, $usrid) {
    global $strCantQuery, $Student_MinYear, $Student_MaxYear;
	$_sql = "select *, DATE_FORMAT(TglMasuk, '%d') as hhmsk, DATE_FORMAT(TglMasuk, '%m') as bbmsk,
	  DATE_FORMAT(TglMasuk, '%Y') as ttmsk
	  from $usr where ID=$usrid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	
	$hhmsk = mysql_result($_res, 0, 'hhmsk');
	$bbmsk = mysql_result($_res, 0, 'bbmsk');
	$ttmsk = mysql_result($_res, 0, 'ttmsk');
	$JabatanAkademik = mysql_result($_res, 0, 'JabatanAkademik');
	$JabatanOrganisasi = mysql_result($_res, 0, 'JabatanOrganisasi');
	$KodeJurusan = mysql_result($_res, 0, 'KodeJurusan');
	$KodePT = mysql_result($_res, 0, 'InstansiInduk');
	$NamaPT = GetaField('perguruantinggi', 'kode', $KodePT, 'Nama');

	$LulusanPT = mysql_result($_res, 0, 'LulusanPT');
	$Ilmu = mysql_result($_res, 0, 'Ilmu');
	$jen = GetaField('jenjangps', 'Kode', mysql_result($_res, 0, 'JenjangDosen'), 'Nama');
	if (mysql_result($_res, 0, 'Akta')=='Y') $Akta = 'checked';
	else $Akta = '';
	if (mysql_result($_res, 0, 'Ijin')=='Y') $Ijin = 'checked';
	else $Ijin = '';
	$Bank = mysql_result($_res, 0, 'Bank');
	$AccountName = mysql_result($_res, 0, 'AccountName');
	$AccountNumber = mysql_result($_res, 0, 'AccountNumber');
	$KodeDosen = GetaField('kodedosen', 'KodeDosen', mysql_result($_res, 0, 'KodeDosen'), 'Nama');
	$optkodedosen = GetOption('kodedosen', 'Nama', 'Nama', $KodeDosen, '', 'KodeDosen');
	$optjen = GetOption('jenjangps', 'Nama', 'Kode', $jen, '', 'Kode');
	$jur = GetaField('jurusan', 'Kode', $KodeJurusan, 'Nama_Indonesia');
	$optjur = GetOption('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', "$KodeJurusan -- $jur", '', 'Kode');
	//GetOption($_table, $_field, $_order='', $_default='', $_where='', $_value='')
	// opsi utk tgl lahir
	$maxy = date("Y");
	//settype($maxy, 'int');
	$miny = $maxy - 30;
	$opthhmsk = GetNumberOption(1, 31, $hhmsk);
	$optbbmsk = GetMonthOption($bbmsk);
	$optttmsk = GetNumberOption($miny, $maxy, $ttmsk);
	$optjo = GetOption2('jabatanorganisasi', "concat(Kode, ' -- ', Nama)", 'Rank', $JabatanOrganisasi, '', 'Kode');
	//$defja = GetaField('jabatanakademik', 'Kode', $JabatanAkademik, 'Nama');
	$ja = GetOption2('jabatanakademik', 'Nama', 'Kode', $JabatanAkademik, '', 'Kode');

	return <<<EOF
	  <table class=basic width=100% cellspacing=0 cellpadding=2 border=0>
	  <form name='f1' action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='usrid' value='$usrid'>
	  <tr><td class=lst>Mulai Bekerja</td><td>
	    <select name='hhmsk'>$opthhmsk</select> <select name='bbmsk'>$optbbmsk</select> <select name='ttmsk'>$optttmsk</select></td></tr>
	  <tr><td class=lst>Status Dosen</td><td><select name='KodeDosen'>$optkodedosen</select></td></tr>
	  <tr><td class=lst>Mengajar di PS</td><td><select name='KodeJurusan'>$optjur</select></td></tr>

	  <tr><td class=basic colspan=2 height=10></td></tr>

	  <tr><td class=lst>Jabatan Akademik</td><td><select name='JabatanAkademik'>$ja</td></tr>
	  <tr><td class=lst>Jabatan Organisasi</td><td><select name='JabatanOrganisasi'>$optjo</td></tr>
	  <tr><td class=lst>Lulusan Perg. Tinggi</td><td>
	    <input type=text name='LulusanPT' size=40 maxlength=100 value='$LulusanPT'></td></tr>
	  <tr><td class=lst>Keilmuan</td><td><input type=text name='Ilmu' size=40 maxlength=100 value='$Ilmu'></td></tr>
	  <tr><td class=lst>Pendidikan Tertinggi</td><td><select name='JenjangDosen'>$optjen</select></td></tr>
	  <tr><td class=lst>Instansi Induk</td>
	  	<td><input type=text name='KodePT' size=10 maxlength=10 value='$KodePT'>
	    <input type=text name='NamaPT' value='$NamaPT' size=30 maxlength=100>
		<a href="javascript:remote()">Cari PT</a></td></tr>

	  <tr><td class=lst>Akta Mengajar</td><td><input type=checkbox name='Akta' value='Y' $Akta></td></tr>
	  <tr><td class=lst>Ijin Mengajar</td><td><input type=checkbox name='Ijin' value='Y' $Ijin></td></tr>
	    <tr><td class=basic colspan=2 height=10></td></tr>
	  <tr><td class=lst>Nama Bank</td><td><input type=text name='Bank' value='$Bank' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Nama Akun</td><td><input type=text name='AccountName' value='$AccountName' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Nomer Akun</td><td><input type=text name='AccountNumber' value='$AccountNumber' size=40 maxlength=100></td></tr>
	
	  <tr><td colspan=2><input type=submit name='prc1' value='Simpan'> <input type=reset name='reset' value='Reset'> </td></tr>
	  </form></table>
EOF;
  }
  function GetDosenAkademic($usr, $usrid) {
    global $strCantQuery, $strPage;
    $pagefmt = "<a href='sysfo.php?syxec=dosen&usr=$usr&usrid=$usrid&tab=2&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
	if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
  
    $lister = new lister;
    $lister->tables = "jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  where j.IDDosen=$usrid
	  order by j.Tahun desc	";
	//echo $lister->tables;
    $lister->fields = "j.Tahun, mk.Kode, mk.Nama_Indonesia as MK, mk.SKS";
    $lister->startrow = $sr;
    $lister->maxrow = $_COOKIE['maxrow'];
    $lister->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Tahun</th><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>SKS</th>
	  </tr>";
    $lister->detailfmt = "<tr><td class=lst>=Tahun=</td>
	  <td class=lst>=Kode=</td><td class=lst>=MK=</td>
	  <td class=lst align=right>=SKS=</td>
	  </tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = $lister->ListIt () .
	  "$strPage: $halaman</p>";
	return $usrlist;
  }
  function DispRisetForm($aid=0, $usr, $usrid=0) {
    global $strCantQuery;
	if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
	if ($aid == 0) {
	  $Judul = '';
	  $Lokasi = '';
	  $Deskripsi = '';
	  $Publikasi = '';
	  $Tanggal = date('Y-m-d');
	  $NotActive = '';
	  $strjdl = 'Tambah Penelitian Baru';
	}
	else {
	  $s = "select * from aktivitasdosen where ID=$aid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) DisplayHeader($fmtErrorMsg, "Data tidak ditemukan.");
	  else {
	    $Judul = mysql_result($r, 0, 'Judul');
		$Lokasi = mysql_result($r, 0, 'Lokasi');
		$Deskripsi = mysql_result($r, 0, 'Deskripsi');
		if (mysql_result($r, 0, 'Publikasi') == 'Y') $Publikasi = 'checked'; else $Publikasi = '';
		$Tanggal = mysql_result($r, 0, 'Tanggal');
		if (mysql_result($r, 0, 'NotActive') == 'Y') $NotActive = 'checked'; else $NotActive = '';
		$strjdl = "<a href='sysfo.php?syxec=dosen&tab=3&usr=$usr&usrid=$usrid&sr=$sr'>Tambah</a>&nbsp; |
		Edit Penelitian: $aid";
	  }
	}
	$_tgl = explode('-', $Tanggal);
	$opt_d = GetNumberOption(1, 31, $_tgl[2]);
	$opt_m = GetMonthOption($_tgl[1]);
	$opt_y = GetNumberOption(1970, 2010, $_tgl[0]);
	return <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosen'>
	  <input type=hidden name='tab' value=3>
	  <input type=hidden name='aid' value=$aid>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='usrid' value=$usrid>
	  <tr><th class=ttl colspan=2>$strjdl</th></tr>
	  <tr><td class=lst>Judul</td><td class=lst><input type=text name='Judul' value='$Judul' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Deskripsi</td><td class=lst><textarea name='Deskripsi' rows=3 cols=30>$Deskripsi</textarea></td></tr>
	  <tr><td class=lst>Tanggal</td><td class=lst><select name='Tgl_d'>$opt_d</select>
	    <select name='Tgl_m'>$opt_m</select> <select name='Tgl_y'>$opt_y</select></td></tr>
	  <tr><td class=lst>Publikasi</td><td class=lst><input type=checkbox name='Publikasi' value='Y' $Publikasi>
	    di <input type=text name='Lokasi' value='$Lokasi' size=30 maxlength=100></td></tr>
	  <tr><td class=basic colspan=2><input type=submit name='prcrst' value='Simpan'>
	    <input type=reset name='reset' value='Reset'></td></tr>
	  </form></table>
EOF;
  }
  function PrcRstDsn($aid=0) {
    global $strCantQuery;
	$unip = $_SESSION['unip'];
	$usrid = $_REQUEST['usrid'];
	$Judul = FixQuotes($_REQUEST['Judul']);
	$Lokasi = FixQuotes($_REQUEST['Lokasi']);
	$Deskripsi = FixQuotes($_REQUEST['Deskripsi']);
	if (isset($_REQUEST['Publikasi'])) $Publikasi = $_REQUEST['Publikasi']; else $Publikasi = 'N';
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive']; else $NotActive = 'N';
	$Tanggal = $_REQUEST['Tgl_y'].'-'.$_REQUEST['Tgl_m'].'-'.$_REQUEST['Tgl_d'];
	if ($aid == 0) {
	  $s = "insert into aktivitasdosen (IDDosen, Aktivitas, Judul, Lokasi, Deskripsi, Publikasi, Tanggal, 
	    Login, TglLogin, NotActive) values
	    ($usrid, 1, '$Judul', '$Lokasi', '$Deskripsi', '$Publikasi', '$Tanggal',
		'$unip', now(), '$NotActive')";
	  $r = mysql_query($s);
	  return GetLastID();
	}
	else {
	  $s = "update aktivitasdosen set Judul='$Judul', Lokasi='$Lokasi', Deskripsi='$Deskripsi',
	    Publikasi='$Publikasi', Tanggal='$Tanggal', NotActive='$NotActive' where ID=$aid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  return $aid;
	}
  }
  function GetDosenRiset($usr, $usrid) {
    global $strCantQuery, $strPage;
	if (isset($_REQUEST['aid'])) $aid = $_REQUEST['aid']; else $aid =0;
	if (isset($_REQUEST['prcrst'])) $aid = PrcRstDsn($aid);
	$frmriset = DispRisetForm($aid, $usr, $usrid);
	
    $pagefmt = "<a href='sysfo.php?syxec=dosen&usr=$usr&usrid=$usrid&tab=3&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
	if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
  
    $lister = new lister;
    $lister->tables = "aktivitasdosen where Aktivitas=1 and IDDosen=$usrid order by Tanggal Desc";
	//echo $lister->tables;
    $lister->fields = "* ";
    $lister->startrow = $sr;
    $lister->maxrow = $_COOKIE['maxrow'];
    $lister->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=2>
      <tr>
	  <th class=ttl>Judul</th>
	  <th class=ttl>Deskripsi</th>
	  <th class=ttl>Publikasi</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class='lst'>
	  <a href='sysfo.php?syxec=dosen&tab=3&usr=$usr&usrid=$usrid&sr=$sr&aid==ID='>=Judul=</a><br>
	  <font color=gray>=Tanggal=</font></td>
	  <td class='lst'>=Deskripsi=</td>
	  <td class=lst>=Lokasi=</td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = $lister->ListIt () .
	  "$strPage: $halaman</p>";
    return "<table class=basic width=100%><tr><td valign=top>$usrlist</td><td width=1 background='image/vertisilver.gif'></td>
	  <td valign=top>$frmriset</td></tr></table>";
  }
  
  function Process0() {
    global $strCantQuery;
    $usr = $_REQUEST['usr'];
	$usrid = $_REQUEST['usrid'];
	$TempatLahir = FixQuotes($_REQUEST['TempatLahir']);
	$hh = $_REQUEST['hh'];
	$bb = $_REQUEST['bb'];
	$tt = $_REQUEST['tt'];
	$TglLahir = "$tt-$bb-$hh";
	$Alamat1 = FixQuotes($_REQUEST['Alamat1']);
	$Alamat2 = FixQuotes($_REQUEST['Alamat2']);
	$Kota = FixQuotes($_REQUEST['Kota']);
	$Propinsi = FixQuotes($_REQUEST['Propinsi']);
	$Negara = FixQuotes($_REQUEST['Negara']);
	$KodePos = FixQuotes($_REQUEST['KodePos']);
	$Sex = $_REQUEST['Sex'];
	$AgamaID = $_REQUEST['AgamaID'];
	$KTP = FixQuotes($_REQUEST['KTP']);
	$Description = FixQuotes($_REQUEST['Description']);
	
	$_sql = "update $usr set TempatLahir='$TempatLahir', TglLahir='$TglLahir', Sex='$Sex',
	  Alamat1='$Alamat1', Alamat2='$Alamat2', Kota='$Kota', Propinsi='$Propinsi', Negara='$Negara', 
	  KodePos='$KodePos', AgamaID=$AgamaID, KTP='$KTP', Description='$Description'
	  where ID=$usrid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
  }
  function Process1() {
    global $strCantQuery;
	$usr = $_REQUEST['usr'];
	$usrid = $_REQUEST['usrid'];
	$hhmsk = $_REQUEST['hhmsk'];
	$bbmsk = $_REQUEST['bbmsk'];
	$ttmsk = $_REQUEST['ttmsk'];
	$TglMsk = "$ttmsk-$bbmsk-$hhmsk";
	$JabatanAkademik = $_REQUEST['JabatanAkademik'];
	$JabatanOrganisasi = $_REQUEST['JabatanOrganisasi'];
	$KodeJurusan = $_REQUEST['KodeJurusan'];
	$KodeFakultas = GetaField('jurusan', 'Kode', $KodeJurusan, 'KodeFakultas');
	$InstansiInduk = $_REQUEST['KodePT'];
	$LulusanPT = FixQuotes($_REQUEST['LulusanPT']);
	$Ilmu = FixQuotes($_REQUEST['Ilmu']);
	$JenjangDosen = $_REQUEST['JenjangDosen'];
	if (isset($_REQUEST['Akta'])) $Akta = $_REQUEST['Akta'];
	else $Akta = 'N';
	if (isset($_REQUEST['Ijin'])) $Ijin = $_REQUEST['Ijin'];
	else $Ijin = 'N';
	$Bank = FixQuotes($_REQUEST['Bank']);
	$AccountName = FixQuotes($_REQUEST['AccountName']);
	$AccountNumber = FixQuotes($_REQUEST['AccountNumber']);
	$KodeDosen = $_REQUEST['KodeDosen'];
	
	$_sql = "update $usr set TglMasuk='$TglMsk', 
	  JabatanOrganisasi='$JabatanOrganisasi', JabatanAkademik='$JabatanAkademik',
	  KodeJurusan='$KodeJurusan', KodeFakultas='$KodeFakultas', InstansiInduk='$InstansiInduk',
	  LulusanPT='$LulusanPT', Ilmu='$Ilmu', JenjangDosen='$JenjangDosen',
	  Akta='$Akta', Ijin='$Ijin', KodeDosen='$KodeDosen',
	  Bank='$Bank', AccountName='$AccountName', AccountNumber='$AccountNumber'
	  where ID=$usrid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
  }
  
  
  // *** PARAMETER2 ***
  include "class/tab.class.php";
  
$kdf = GetSetVar('kdf');
$dsntab = GetSetVar('tab', 0);
$srcdsnmod = GetSetVar('srcdsnmod');
$srcdsnval = GetSetVar('srcdsnval');
  
  if (isset($_REQUEST['usr'])) $usr = $_REQUEST['usr'];
  else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
  // Ambil ID
  if (isset($_REQUEST['usrid'])) $usrid = $_REQUEST['usrid'];
  else $usrid = -1;
  // Ambil Start Row
  if (isset($_REQUEST['usrsr'])) $usrsr = $_REQUEST['usrsr'];
  else $usrsr = 0;


  // proses2
  if (isset($_REQUEST['prc'])) ProcessUserBrief();
  if (isset($_REQUEST['prc0'])) Process0();
  if (isset($_REQUEST['prc1'])) Process1();
  // tab-tab
  $arrtab = array('Data Pribadi', 
    'Profile', 
	'Pengajaran',
	'Penelitian',
	'Pengabdian');
  
    
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Admin. Berkas $usr");
  DisplaySearchDosen($usr);
  echo "<a href='sysfo.php?syxec=dosen&usr=$usr&usrid=0'><img src='sysfo/image/usr01.gif' border=0> Tambah $usr</a>";
  if ($usrid < 0) DisplayUserList();
  else {
    DisplayUserBrief($usr, $usrid);
	echo "<br>";
	//DisplayUserDetail($usr, $usrid);
	if ($usrid > 0)	{
	  $cont = GetDosenContent($usr, $usrid, $dsntab);
	  DisplayTab($arrtab, $dsntab, $cont, 'sysfo.php', "syxec=dosen&usr=$usr&usrid=$usrid");
	}
  }

?>