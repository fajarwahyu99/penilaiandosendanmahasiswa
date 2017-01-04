<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003
  
  // *** FUNGSI2 ***
function DisplayFacultyForm($kdf, $_md=0, $act='fakjur') {
  global $strCantQuery, $strNotAuthorized;
  if ($_md==0) {
    $judul = 'Edit Fakultas';
    $_sql = "select * from fakultas where Kode='$kdf'";
    $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
    if (mysql_num_rows($_res)==0) die("$strNotAuthorized: $kdf");
    else {
	    $Nama_Indonesia = mysql_result($_res, 0, 'Nama_Indonesia');
	    $Nama_English = mysql_result($_res,0,'Nama_English');
	    $NotActive = mysql_result($_res,0,'NotActive');
	    $strkd = "<input type=hidden name='kdf' value='$kdf'>".$kdf;
    }
	}
	elseif ($_md==1) {
	  $judul = 'Tambah Fakultas';
	  $Nama_Indonesia = '';
	  $Nama_English = '';
	  $NotActive = 'N';
	  $strkd = "<input type=text name='kdf' size=14 maxlength=10>";
	}
	if ($NotActive=='Y') $strchk = 'checked';
	else $strchk = '';
	// tampilkan form
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='md' value='$_md'>
	  <input type=hidden name='OldKode' value='$kdf'>
	  <table class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>$judul</th></tr>
	  <tr><td class=lst>Kode Fakultas</td>
	    <td class=lst>$strkd</td></tr>
	  <tr><td class=lst>Nama Indonesia</td>
	    <td class=lst><input type=text name='Nama_Indonesia' value='$Nama_Indonesia' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Nama English</td>
	    <td class=lst><input type=text name='Nama_English' value='$Nama_English' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Tidak Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strchk></td></tr>
	  <tr><td class=lst colspan=2 align=center>
	    <input type=submit name='prc' value='simpan'>
		<input type=reset name=reset value='reset'></td></tr>
	  </table></form>";
  }
function ProcessFacultyForm() {
  global $strCantQuery;
	$unip = $_SESSION['unip'];
  $md = $_REQUEST['md'];
	$Nama_Indonesia = FixQuotes($_REQUEST['Nama_Indonesia']);
	$Nama_English = FixQuotes($_REQUEST['Nama_English']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	if ($md==0) {
	  $Kode = $_REQUEST['OldKode'];
	  $_sql = "update fakultas set Nama_Indonesia='$Nama_Indonesia',
	    Nama_English='$Nama_English', NotActive='$NotActive'
		where Kode='$Kode' ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	elseif ($md==1) {
	  $Kode = $_REQUEST['kdf'];
	  // cek dulu dong!
	  $_sck = "select Kode from fakultas where Kode='$Kode'";
	  $_rck = mysql_query($_sck) or die("$strCantQuery: $_sck");
	  if (mysql_num_rows($_rck) > 0) die("Kode fakultas <b>$Kode</b> sudah ada.");
	  
	  $_sql = "insert into fakultas(Kode,Nama_Indonesia,Nama_English,Login,Tgl,NotActive)
	    values ('$Kode','$Nama_Indonesia','$Nama_English','$unip',now(),'$NotActive')";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	return $Kode;
}
  //function GetOption($_table, $_field, $_order='', $_default='') {
function DisplayJurusanForm($_kdj, $_kdf, $_md=0, $act='fakjur') {
  global $strCantQuery;
  if ($_md==0) {
	  $judul = 'Edit Jurusan';
	  $_sql = "select * from jurusan where Kode='$_kdj'";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  if (mysql_num_rows($_res)==0) die("$strNotAuthorized");
	  else {
	  $KodePS = mysql_result($_res, 0, 'KodePS');
	  $Rank = mysql_result($_res, 0, 'Rank');
	  $PMBPrice = mysql_result($_res, 0, 'PMBPrice');
	  $Akreditasi = mysql_result($_res, 0, 'Akreditasi');
	  $Nama_Indonesia = mysql_result($_res, 0, 'Nama_Indonesia');
	  $Nama_English = mysql_result($_res,0,'Nama_English');
	  $Jenjang = GetaField('jenjangps', 'Kode', mysql_result($_res, 0, 'Jenjang'), 'Nama');
	  $Sesi = mysql_result($_res, 0, 'Sesi');
	  $NoSKDikti = mysql_result($_res, 0, 'NoSKDikti');
	  $TglSKDikti = mysql_result($_res, 0, 'TglSKDikti');
	  $NoSKBAN = mysql_result($_res, 0, 'NoSKBAN');
	  $TglSKBAN = mysql_result($_res, 0, 'TglSKBAN');
	  $MinSKS = mysql_result($_res, 0, 'MinSKS');
	  $MaxWaktu = mysql_result($_res, 0, 'MaxWaktu');
	  $NotActive = mysql_result($_res,0,'NotActive');
	  $strkd = "<input type=hidden name='Kode' value=$_kdj>$_kdj";
	  $strkdf = "<input type=hidden name='kd' value='$_kdf'>$_kdf";
	  $KodeNilai = mysql_result($_res, 0, 'KodeNilai');
	  }
	}
	elseif ($_md==1) {
	  $judul = 'Tambah Jurusan';
	  $KodePS = '';
	  $Rank = 0;
	  $PMBPrice = 0;
	  $Akreditasi = '';
	  $Nama_Indonesia = '';
	  $Nama_English = '';
	  $Jenjang = 'S1';
	  $Sesi = 'Semester';
	  $NoSKDikti = '';
	  $TglSKDikti = date('Y-m-d');
	  $NoSKBAN = '';
	  $TglSKBAN = date('Y-m-d');
	  $MinSKS = 0;
	  $MaxWaktu = 0;
	  $NotActive = 'N';
	  $strkd = "<input type=text name='Kode' size=14 maxlength=10>";
	  $optkdf = GetOption('fakultas','Kode','Kode',$_kdf);
	  $strkdf = "<select name='kd'>$optkdf</select>";
	  $KodeNilai = "";
	}
	if ($NotActive=='Y') $strchk = 'checked';
	else $strchk = '';
	$optjenjang = GetOption('jenjangps', 'Nama', 'Kode', $Jenjang, '', 'Kode');
	
	$optni = "";
	$rni = mysql_query("select distinct Kode from nilai order by Kode");
	while ($ani = mysql_fetch_array($rni)) 
	  if ($ani['Kode'] == $KodeNilai) $optni .= "<option selected>$ani[Kode]</option>";
	  else $optni .= "<option>$ani[Kode]</option>";
	$td = explode('-', $TglSKDikti);
	$optdi_d = GetNumberOption(1, 31, $td[2]);
	$optdi_m = GetMonthOption($td[1]);
	$optdi_y = GetNumberOption(1940, 2010, $td[0]);

	$tb = explode('-', $TglSKBAN);
	$optbn_d = GetNumberOption(1, 31, $tb[2]);
	$optbn_m = GetMonthOption($tb[1]);
	$optbn_y = GetNumberOption(1940, 2010, $tb[0]);
	$snm = session_name(); $sid = session_id();
	// tampilkan form
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='md' value='$_md'>
	  <table class=basic cellspacing=1 cellpadding=1>
	  <tr><th colspan=2 class=ttl>$judul</th></tr>
	  <tr><td class=lst>Kode Jurusan</td>
	    <td class=lst>$strkd</td></tr>
	  <tr><td class=lst>Kode Fakultas</td>
	    <td class=lst>$strkdf</td></tr>

	  <tr><td class=lst>Nama Indonesia</td>
	    <td class=lst><input type=text name='Nama_Indonesia' value='$Nama_Indonesia' size=30 maxlength=100></td></tr>
	  <tr><td class=lst>Nama English</td>
	    <td class=lst><input type=text name='Nama_English' value='$Nama_English' size=30 maxlength=100></td></tr>
	  <tr><td class=lst>Kode Nilai</td><td class=lst><select name='kni'>$optni</select></td></tr>
	  <tr><td class=lst>Jenjang Pendidikan</td><td class=lst><select name='Jenjang'>$optjenjang</select></td></tr>
	  <tr><td class=lst>Jml. min. SKS Lulus</td><td class=lst><input type=text name='MinSKS' value='$MinSKS' size=3 maxlength=3></td></tr>
	  <tr><td class=lst>Nama Sesi</td><td class=lst><input type=text name='Sesi' value='$Sesi' size=20 maxlength=25></td></tr>
	  <tr><td class=lst>Lama Waktu Studi</td><td class=lst><input type=text name='MaxWaktu' value='$MaxWaktu' size=3 maxlength=3> Sesi/Semester/Cawu</td></tr>

	  <tr><td class=ttl colspan=2 height=2><td></tr>
	  <tr><td class=lst>Kode PS (Kopertis/Dikti)</td><td class=lst><input type=text name='KodePS' value='$KodePS' size=10 maxlength=10></td></tr>
	  <tr><td class=lst>No SK DIKTI</td><td class=lst><input type=text name='NoSKDikti' value='$NoSKDikti' size=30 maxlength=50></td></tr>
	  <tr><td class=lst>Tgl SK DIKTI</td><td class=lst><select name='TglSKDikti_d'>$optdi_d</select>
	    <select name='TglSKDikti_m'>$optdi_m</select> <select name='TglSKDikti_y'>$optdi_y</td></tr>

	  <tr><td class=lst>No SK BAN</td><td class=lst><input type=text name='NoSKBAN' value='$NoSKBAN' size=30 maxlength=50></td></tr>
	  <tr><td class=lst>Tgl SK BAN</td><td class=lst><select name='TglSKBAN_d'>$optbn_d</select>
	    <select name='TglSKBAN_m'>$optbn_m</select> <select name='TglSKBAN_y'>$optbn_y</td></tr>
	  <tr><td class=lst>Status Akreditasi</td><td class=lst><input type=text name='Akreditasi' value='$Akreditasi' size=2 maxlength=1></td></tr>

	  <tr><td class=ttl colspan=2 height=2><td></tr>
	  <tr><td class=lst>Urutan Tampilan</td>
	    <td class=lst><input type=text name='Rank' value='$Rank' size=4></td></tr>
	  <tr><td class=lst>Harga Form Pendaftaran</td>
	    <td class=lst><input type=text name='PMBPrice' value='$PMBPrice' size=10></td></tr>

	  <tr><td class=lst>Tidak Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strchk></td></tr>
	  <tr><td colspan=2 align=center class=lst>
	    <input type=submit name='prcj' value='Simpan'>
		  <input type=reset name=reset value='Reset'>
		  <input type=button name='Batal' value='Batal' onClick=\"location='sysfo.php?syxec=fakjur&$snm=$sid'\"></td></tr>
	  </table></form>";
  }
function ProcessJurusanForm() {
  global $strCantQuery;
	$unip = $_SESSION['unip'];
    $md = $_REQUEST['md'];
	$Kode = FixQuotes($_REQUEST['Kode']);
	$kni = $_REQUEST['kni'];
	$KodePS = FixQuotes($_REQUEST['KodePS']);
	$Rank = $_REQUEST['Rank'];
	$Akreditasi = $_REQUEST['Akreditasi'];
	$PMBPrice = $_REQUEST['PMBPrice'];
	$Nama_Indonesia = FixQuotes($_REQUEST['Nama_Indonesia']);
	$Nama_English = FixQuotes($_REQUEST['Nama_English']);
	$Jenjang = $_REQUEST['Jenjang'];
	$MinSKS = $_REQUEST['MinSKS'];
	$Sesi = $_REQUEST['Sesi'];
	$MaxWaktu = $_REQUEST['MaxWaktu'];
	$NoSKDikti = FixQuotes($_REQUEST['NoSKDikti']);
	$TglSKDikti = $_REQUEST['TglSKDikti_y'].'-'.$_REQUEST['TglSKDikti_m'].'-'.$_REQUEST['TglSKDikti_d'];
	$NoSKBAN = FixQuotes($_REQUEST['NoSKBAN']);
	$TglSKBAN = $_REQUEST['TglSKBAN_y'].'-'.$_REQUEST['TglSKBAN_m'].'-'.$_REQUEST['TglSKBAN_d'];
	$KodeFakultas = FixQuotes($_REQUEST['kd']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	if ($md==0) {
	  $_sql = "update jurusan set KodePS='$KodePS',
	    KodeNilai='$kni',
	    Rank=$Rank, PMBPrice=$PMBPrice,
	    Akreditasi='$Akreditasi',
	    Nama_Indonesia='$Nama_Indonesia',
	    Nama_English='$Nama_English', Jenjang='$Jenjang',
		  MinSKS='$MinSKS', Sesi='$Sesi', MaxWaktu='$MaxWaktu',
		  NoSKDikti='$NoSKDikti', TglSKDikti='$TglSKDikti',
		  NoSKBAN='$NoSKBAN', TglSKBAN='$TglSKBAN',
		  NotActive='$NotActive'
		  where Kode='$Kode' ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	elseif ($md==1) {
	  // cek dulu dong!
	  $_sck = "select Kode from jurusan where Kode='$Kode'";
	  $_rck = mysql_query($_sck) or die("$strCantQuery: $_sck");
	  if (mysql_num_rows($_rck) > 0) die("Kode jurusan <b>$Kode</b> sudah ada.");
	  
	  $_sql = "insert into jurusan(Kode,KodeNilai,KodePS,Rank,PMBPrice,Akreditasi,
	    Nama_Indonesia, Nama_English, Jenjang, MinSKS, MaxWaktu, Sesi,
		  KodeFakultas,Login,Tgl,TglSKDikti, TglSKBAN, NotActive)
		  
	    values ('$Kode','$kni', '$KodePS',$Rank,$PMBPrice,'$Akreditasi',
		  '$Nama_Indonesia','$Nama_English','$Jenjang', '$MinSKS', '$MaxWaktu', '$Sesi',
		  '$KodeFakultas','$unip',now(), '$TglSKDikti', '$TglSKBAN', '$NotActive')";
	    $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");	
	}
	return $KodeFakultas;
}

// *** BAGIAN UTAMA ***
DisplayHeader($fmtPageTitle, 'Master: Fakultas-Jurusan');

$kdf = GetSetVar('kdf');
  
if (isset($_REQUEST['prc'])) $kd = ProcessFacultyForm();
if (isset($_REQUEST['prcj'])) $kd = ProcessJurusanForm();
?>

<table class=basic width=100% border=0>
<tr>
  <td valign=top>
  <?php
    if (isset($_REQUEST['seq'])) {
	  // tambahkan fakultas
	  if ($_REQUEST['seq']==1) DisplayFacultyForm('0',1);
	  // tambah jurusan
	  elseif ($_REQUEST['seq']==2) {
	    DisplayJurusanForm('0',$kd,1);
	  }
	  // edit jurusan
	  elseif ($_REQUEST['seq']==3) {
	    DisplayJurusanForm($_REQUEST['kdj'], $kdf);
	  }
    }
	else {
	  if (!empty($kdf)) {
	    DisplayFacultyForm($kdf);
		  echo "<a href='sysfo.php?syxec=fakjur&seq=2&md=1&kdf=$kdf'>Tambah Jurusan</a>";
	    DisplayListofJurusan($kdf);
	  }
	  else DisplayFacultyForm('0',1);
	}
  ?>
  </td>
  <td width=1 class='basic' background='image/vertisilver.gif'><td>
  <td valign=top width=250>
    <?php
	  DisplayPrinter("print.php?print=sysfo/printfaculty.php&prn=1");
	  echo "<br>";
	  echo "<a href='sysfo.php?syxec=fakjur&seq=1'>Tambah Fakultas</a>";
	  DisplayListofFaculty();
	?>
  </td>
</tr>
</table>