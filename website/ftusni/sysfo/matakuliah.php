<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function GetKurID($kdj) {
    global $kurid, $Sesi, $JmlSesi;
	global $fmtErrorMsg, $fmtMessage, $Language;
	if (empty($kdj)) {
	  DisplayItem($fmtMessage, 'Belum Ada Jurusan yg Dipilih',
	    "Anda belum memilih jurusan. Pilihlah salah satu jurusan yang terdapat pada
	    daftar pilihan pada menu <code>Jurusan</code> di atas.");
	}
	else {
	$_skur = "select * from kurikulum where KodeJurusan='$kdj' and NotActive='N' order by ID desc limit 1";
	$_rkur = mysql_query($_skur) or die("$strCantQuery: $_skur");
	if (mysql_num_rows($_rkur)==0) {
	  DisplayHeader($fmtErrorMsg, "Tidak ada kurikulum Aktif.<br>
	    Anda belum mendefinisikan kurikulum untuk jurusan <b>$kdj</b>. Anda dapat membuat kurikulum dari
		menu: <br><code>Akademik > Kurikulum</code>.");
	  $kurid = 0;
	  $Sesi = '';
	  $JmlSesi = 0;
	  return false;
	}
	else {
	  $jrsn = GetaField('jurusan', 'Kode', $kdj, "Nama_$Language");
	  $kurid = mysql_result($_rkur, 0, 'ID');
	  $Nama = mysql_result($_rkur, 0, 'Nama');
	  $Tahun = mysql_result($_rkur, 0, 'Tahun');
	  $Sesi = mysql_result($_rkur, 0, 'Sesi');
	  $JmlSesi = mysql_result($_rkur, 0, 'JmlSesi');
	  echo "<table class=basic cellspacing=0 cellpadding=2>
	    <tr><th class=ttl colspan=2>Kurikulum</td></tr>
		<tr><td class=lst width=100>Jurusan</td><td class=lst width=200>$jrsn</td></tr>
		<tr><td class=lst>Kurikulum</td><td class=lst>$Nama</td></tr>
		<tr><td class=lst>Tahun</td><td class=lst>$Tahun</td></tr>
		<tr><td class=lst>Nama Semester</td><td class=lst>$Sesi</td></tr>
		<tr><td class=lst>Jml Semester/tahun</td><td class=lst>$JmlSesi</td></tr>
	    </table><br>";
	  return true;
	}
	}
  }
  function WriteMataKuliah0($kdj, $kur, $ses, $i) {
    $s = "select * from matakuliah where KurikulumID=$kur and Sesi=$i and NotActive='N' order by Kode";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	$stot = 0;
	echo "<td valign=top style='border-bottom: gray 1px dotted; '>";
	echo "<table class=basic cellspacing=0 cellpadding=2 width=100%>
	      <tr><th class=ttl colspan=4>$ses $i</th></tr>
		  <tr><td class=ttl>Kode</td><td class=ttl>Nama</td>
		  <td class=ttl colspan=2>SKS</td></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $stot += $w['SKS'];
	  if ($w['Wajib'] == 'Y') $strwjb = "<font color=red>*</font>"; else $strwjb = "&nbsp;";
	  echo <<<EOF
 		<tr><td class=lst><a href='sysfo.php?syxec=matakuliah&kdj=$kdj&md=0&mkid=$w[ID]' title='$w[Kode] - $w[Nama_Indonesia]\nSKS Minimal: $w[SKSMin]\nIP Min: $w[IPMin]'>$w[Kode]</td>
	    <td class=lst>$w[Nama_Indonesia]</td>
		<td class=uline align=center>$strwjb</td>
		<td class=lst align=right>$w[SKS]</td></tr>
EOF;
	}
	echo "<tr><td class=basic colspan=2 align=right>Jumlah SKS:</td>
		  <td class=lst align=right colspan=2><b>$stot</td></tr></table>";
	echo "</td>";
  }
  function WriteMataKuliah1($kdj, $kur, $ses, $nilai, $strnilai) {
	$s = "select mk.* from matakuliah mk where mk.KurikulumID=$kur and mk.KodeJenisMK='$nilai' and mk.NotActive='N' order by mk.Sesi, mk.Kode";
	$r = mysql_query($s) or die ("Gagal Query: $s<br>".mysql_error());
	$nmr = 0; $stot = 0;
	echo <<<EOF
	      <tr><td class=ttl colspan=7>$nilai -- $strnilai</td></tr>
          <tr><td class=basic width=20></td>
		  <th class=basic>#</th><th class=ttl>Kode</th>
          <th class=ttl>Mata Kuliah</th>
		  <th class=ttl>$ses</th>
		  <th class=ttl colspan=2>SKS</th></tr>
EOF;
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  $stot += $w['SKS'];
	  if ($w['Wajib'] == 'Y') $strwjb = "<font color=red>*</font>"; else $strwjb = "&nbsp;";
	  echo <<<EOF
		<tr><td class=basic></td>
		<td class=ttl align=right>$nmr</td>
		<td class=lst><a href='sysfo.php?syxec=matakuliah&md=0&kurid=$kur&kdj=$kdj&mkid=$w[ID]&st=1' title='$w[Kode] - $w[Nama_Indonesia]\nSKS Minimal: $w[SKSMin]\nIP Min: $w[IPMin]'>$w[Kode]</a></td>
        <td class=lst>$w[Nama_Indonesia]</td>
		<td class=lst align=right>$w[Sesi]</td>
		<td class=uline align=center>$strwjb</td>
		<td class=lst align=right>$w[SKS]</td></tr>
EOF;
	}
	echo <<<EOF
	  <tr><td class=basic colspan=5 align=right>Jumlah SKS</td>
	  <td class=lst align=right colspan=2><b>$stot</td></tr>
	  <tr><td class=basic height=4 colspan=6></td></tr>
EOF;
  }
function DisplayMKList($_kdj, $_kurid, $_Sesi, $_JmlSesi, $_st=0) {
  global $Language, $fmtErrorMsg;
	if ($_st == 0) {
      $_rawmax = GetaField('matakuliah', 'KurikulumID', $_kurid, 'max(Sesi)');
	  echo "<table class=basic cellspacing=0 cellpadding=2 border=0>";
	  $_n = 1;
	  for ($i=1; $i <= $_rawmax; $i++) {
	    if ($_n == 1) echo "<tr>";
	    if ($_n < $_JmlSesi) $_n++;
	    else $_n = 1;
		WriteMataKuliah0($_kdj, $_kurid, $_Sesi, $i);
	    if ($_n == 1) echo "</tr>";
	  }
	  echo "</table><br>";
	}
	elseif ($_st == 1) {
	  $_ssmt = "select distinct mk.KodeJenisMK from matakuliah mk left outer join jenismatakuliah jmk on mk.KodeJenisMK=jmk.Kode where mk.KurikulumID=$_kurid order by jmk.Rank";
	  $_rsmt = mysql_query($_ssmt) or die ("$strCantQuery: $_ssmt");
	  if (mysql_num_rows($_rsmt)==0) die(DisplayHeader($fmtErrorMsg, "<p>Tidak ada data</p>", 0));
	  $_smt = array();
	  for ($i=0; $i < mysql_num_rows($_rsmt); $i++) $_smt[$i] = mysql_result($_rsmt, $i, 'KodeJenisMK');
	  
	  echo "<table class=basic cellspacing=0 cellpadding=2>";
	  for ($i=0; $i < sizeof($_smt); $i++) {
	    $nilai = $_smt[$i];
		$strnilai = GetaField('jenismatakuliah', 'Kode', $nilai, 'Nama');
		WriteMataKuliah1($_kdj, $_kurid, $_Sesi, $nilai, $strnilai);
	  }
	  echo "</table><br>";
	}
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=uline><font color=red>*</td><td class=basic>Mata kuliah wajib</td></tr>
	  </table>
EOF;
}
function DisplayMKForm($md, $kdj, $kurid, $mkid, $act='matakuliah', $style=0) {
  global $Language, $strCantQuery, $strNotAuthorized, $fmtErrorMsg;
	if ($md==0) {
	  $_sql = "select * from matakuliah where ID=$mkid";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  $Kode = mysql_result($_res, 0, 'Kode');
	  $Nama_Indonesia = mysql_result($_res, 0, 'Nama_Indonesia');
	  $Nama_English = mysql_result($_res, 0, 'Nama_English');
	  $SKS = mysql_result($_res, 0, 'SKS');
	  $SKSTatapMuka = mysql_result($_res, 0, 'SKSTatapMuka');
	  $SKSPraktikum = mysql_result($_res, 0, 'SKSPraktikum');
	  $SKSPraktekLap = mysql_result($_res, 0, 'SKSPraktekLap');
	  $SKSMin = mysql_result($_res, 0, 'SKSMin');
	  $IPMin = mysql_result($_res, 0, 'IPMin');
	  $KodeJenisMK = mysql_result($_res, 0, 'KodeJenisMK');
	  $Wajib = mysql_result($_res, 0, 'Wajib');
	  $Sesi = mysql_result($_res, 0, 'Sesi');
	  $NotActive = mysql_result($_res, 0, 'NotActive');
	  $doublemajor = mysql_result($_res, 0, 'DoubleMajor');
	  $judul = 'Edit Mata Kuliah';
	}
	elseif ($md==1) {
	  $mkid = 0;
	  $Kode = '';
	  $Nama_Indonesia = '';
	  $Nama_English = '';
	  $SKS = 0;
	  $SKSTatapMuka = 0;
	  $SKSPraktikum = 0;
	  $SKSPraktekLap = 0;
	  $SKSMin = 0;
	  $IPMin = 0;
	  $KodeJenisMK = '';
	  $Wajib = 'N';
	  $Sesi = 1;
	  $NotActive = 'N';
	  $doublemajor = ''; //mysql_result($_res, 0, 'DoubleMajor');
	  $judul = 'Tambah Mata Kuliah';
	}
	$ulevel = $_SESSION['ulevel'];

	$kdf = GetaField('jurusan', 'Kode', $kdj, 'KodeFakultas');
	$kuri = GetaField('kurikulum', 'ID', $kurid, 'Nama');
	$optJenisMK = GetOption('jenismatakuliah', 'Kode', 'Kode', $KodeJenisMK, "KodeFakultas='$kdf'");
	$optDM = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $doublemajor, '', 'Kode');
	// hanya utk Administrator
	if ($ulevel==1) {
	  $optkuri = GetOption('kurikulum', "concat(ID,' -- ',Nama)", 'Nama', "$kurid -- $kuri");
	  $strkuri = "<tr><td class=lst><font color=red><b>Ubah Kurikulum</b></font></td>
	    <td class=lst><select name='kuri'>$optkuri</select><br>
		<font color=red>*) hanya utk administrator</font></td></tr>";
	}
	else $strkuri = '';
	
    if ($Wajib == 'Y') $strwa = 'checked';
	else $strwa = '';
	if ($NotActive == 'Y') $strna = 'checked';
	else $strna = '';
	$snm = session_name();
	$sid = session_id();

	// Tampilkan form
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='kurid' value=$kurid>
	  <input type=hidden name='md' value=$md>
	  <input type=hidden name='mkid' value=$mkid>
	  <input type=hidden name='kdj' value=$kdj>
	  <input type=hidden name='st' value=$style>
	  <table cellspacing=0 cellpadding=2 class=basic>
	  <tr><th class=ttl colspan=2>$judul</th></tr>
	  <tr><td class=lst>Kurikulum</td><td class=lst>$kuri</td></tr>
	  <tr><td class=lst>Kode</td>
	    <td class=lst><input type=text name='Kode' value='$Kode' size=15 maxlength=10></td></tr>
	  <tr><td class=lst>Nama Indonesia</td>
	    <td class=lst><input type=text name='Nama_Indonesia' value='$Nama_Indonesia' size=35 maxlength=100></td></tr>
	  <tr><td class=lst>Nama English</td>
	    <td class=lst><input type=text name='Nama_English' value='$Nama_English' size=35 maxlength=100></td></tr>
	  <tr><td class=lst>SKS Mata Kuliah</td>
	    <td class=lst><input type=text name='SKS' value='$SKS' size=5 maxlength=2></td></tr>

	  <tr><td class=lst colspan=2>
	  <table class=basic align=center><th class=ttl>SKS Tatap Muka</th><th class=ttl>SKS Praktikum</th><th class=ttl>SKS Prak. Lapangan</th></tr>
	  <tr><td class=lst><input type=text name='SKSTatapMuka' value='$SKSTatapMuka' size=5 maxlength=2></td>
	    <td class=lst><input type=text name='SKSPraktikum' value='$SKSPraktikum' size=5 maxlength=2></td>
		<td class=lst><input type=text name='SKSPraktekLap' value='$SKSPraktekLap' size=5 maxlength=2></td></tr>
	  </table>
	  </td></tr>
	  <tr><td class=lst>SKS minimal yg tlh diambil</td>
	    <td class=lst><input type=text name='SKSMin' value='$SKSMin' size=5 maxlength=5></td></tr>
	  <tr><td class=lst>IP minimal</td>
	    <td class=lst><input type=text name='IPMin' value='$IPMin' size=5 maxlength=5></td></tr>

	  <tr><td class=lst>Semester</td>
	    <td class=lst><input type=text name='Sesi' value='$Sesi' size=5 maxlength=2></td></tr>
	  <tr><td class=lst>Wajib</td>
	    <td class=lst><input type=checkbox name='Wajib' value='Y' $strwa></td></tr>
	  <tr><td class=lst>Tdk Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
	  <tr><td class=lst>Jenis MK</td>
	    <td class=lst><select name='JenisMK'>$optJenisMK</select></td></tr>
	  $strkuri
	
	  <tr><td class=lst>Double Major</td><td class=lst><select name='doublemajor'>$optDM</select></td></tr>
	  <tr><td class=lst align=center colspan=2><input type=submit name='prc' value='Simpan'>&nbsp;
	    <input type=reset name=reset value='Reset'>&nbsp;
		<input type=button name=batal value='Batal' onClick=\"location='sysfo.php?syxec=matakuliah&$snm=$sid&st=$style'\">&nbsp;
		<input type=button name='prasyarat' value='Prasyarat' onClick=\"location='sysfo.php?syxec=prasyaratmk&idmk=$mkid&$snm=$sid'\"></td></tr>

	  </table></form>";
  }
  function ProcessMKForm() {
    global $strCantQuery, $fmtErrorMsg, $fmtMessage;
	global $md, $kdj, $mkid, $kurid, $st;
    $md = $_REQUEST['md'];
	$mkid = $_REQUEST['mkid'];
	$kdj = $_REQUEST['kdj'];
	$kurid = $_REQUEST['kurid'];
	$Kode = FixQuotes($_REQUEST['Kode']);
	$Nama_Indonesia = FixQuotes($_REQUEST['Nama_Indonesia']);
	$Nama_English = FixQuotes($_REQUEST['Nama_English']);
	$SKS = $_REQUEST['SKS'];
	$SKSTatapMuka = $_REQUEST['SKSTatapMuka'];
	$SKSPraktikum = $_REQUEST['SKSPraktikum'];
	$SKSPraktekLap = $_REQUEST['SKSPraktekLap'];
	$SKSMin = $_REQUEST['SKSMin'];
	$IPMin = $_REQUEST['IPMin'];
	$Sesi = $_REQUEST['Sesi'];
	$st = $_REQUEST['st'];
	if (isset($_REQUEST['Wajib'])) $Wajib = $_REQUEST['Wajib'];
	else $Wajib = 'N';
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	$JenisMK = $_REQUEST['JenisMK'];
	if (isset($_REQUEST['kuri'])) {
	  $kuri = $_REQUEST['kuri'];
	  $arrkuri = explode(' -- ', $kuri);
	  if ($kurid != $arrkuri[0]) {
	    DisplayItem($fmtMessage, 'Pemberitahuan', "Terjadi perubahan kurikulum pada mata kuliah ini.<br>
		  Perubahan dari ID kurikulum <b>$kurid</b> ke <b>".$arrkuri[0]."</b>.");
		$kurid = $arrkuri[0];
	  }
	}
	$DM = $_REQUEST['doublemajor'];
	if ($md==0) {
	  $_sql = "update matakuliah set Kode='$Kode', Nama_Indonesia='$Nama_Indonesia', Nama_English='$Nama_English',
	    KurikulumID=$kurid, SKS=$SKS, SKSTatapMuka='$SKSTatapMuka',
		SKSPraktikum='$SKSPraktikum', SKSPraktekLap='$SKSPraktekLap',
		SKSMin='$SKSMin', IPMin='$IPMin',
		KodeJenisMK='$JenisMK', DoubleMajor='$DM',
		Wajib='$Wajib', Sesi=$Sesi,
		NotActive='$NotActive' where ID=$mkid ";
	}
	elseif ($md==1) {
	  $unip = $_SESSION['unip'];
	  $_sql = "insert into matakuliah (Kode, Nama_Indonesia, Nama_English, KurikulumID, SKS,
	    SKSTatapMuka, SKSPraktikum, SKSPraktekLap, SKSMin, IPMin,
	    KodeJenisMK, DoubleMajor, Wajib, Sesi, Login, Tgl, NotActive) 
	    values ('$Kode', '$Nama_Indonesia',
		'$Nama_English', $kurid, $SKS, $SKSTatapMuka, $SKSPraktikum, $SKSPraktekLap, $SKSMin, '$IPMin',
		'$JenisMK', '$DM', '$Wajib', $Sesi, '$unip', now(), '$NotActive')";
	}
	else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$md = -1;
  }

// *** Bagian Utama ***
DisplayHeader($fmtPageTitle, 'Mata Kuliah');
$kdj = GetSetVar('kdj');
  
if (isset($_REQUEST['md'])) $md = $_REQUEST['md'];
else $md = -1;
  
if (isset($_REQUEST['st'])) $st = $_REQUEST['st'];
else $st = 0;
  
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
else $prn = 0;
  
if (isset($_REQUEST['prc'])) ProcessMKForm();
  
if ($prn==0) DispJur($kdj, $st);
//DisplayJurusanChoice(GetaField('jurusan', 'Kode', $kdj, "Nama_$Language"), $st);
if (GetKurID($kdj)) {
  if ($md==-1) {
	  if ($prn==0) {
	    DisplayPrinter("print.php?print=sysfo/matakuliah.php&kdj=$kdj&st=$st&prn=1&PHPSESSID=".session_id());
	    echo "<br><a href='sysfo.php?syxec=matakuliah&kdj=$kdj&md=1&st=$st'>Tambah Mata Kuliah</a>";
	  }
	  DisplayMKList($kdj, $kurid, $Sesi, $JmlSesi, $st);
	}
	else {
	  if (isset($_REQUEST['mkid'])) $mkid = $_REQUEST['mkid'];
	  else $mkid = 0;
	  DisplayMKForm($md, $kdj, $kurid, $mkid, 'matakuliah', $st);
	}
}

?>