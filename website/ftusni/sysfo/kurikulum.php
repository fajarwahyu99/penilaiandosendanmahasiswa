<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function DisplayJurusanHeader($kdj) {
    global $strCantQuery;
    $Jurusan = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	$_sql = "select * from kurikulum where KodeJurusan='$kdj' and NotActive='N'";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	if (mysql_num_rows($_res)==0) {
	  $kurikulum = '';
	  $strkuri = "(kosong)";
	  $strthn = '0000';
	  $strsesi = '&nbsp;';
	  $strjml = '&nbsp;';
	  $strlink = "<a href='sysfo.php?syxec=kurikulum&md=1&kdj=$kdj'>Buat Kurikulum</a>";
	}
	else {
	  $ID = mysql_result($_res, 0, 'ID');
	  $kurikulum = mysql_result($_res, 0, 'Nama');
	  $strkuri = $kurikulum;
	  $strthn = mysql_result($_res, 0, 'Tahun');
	  $strsesi = mysql_result($_res, 0, 'Sesi');
	  $strjml = mysql_result($_res, 0, 'JmlSesi');
	  $strlink = "<a href='sysfo.php?syxec=kurikulum&md=0&kdj=$kdj&ID=$ID'>Edit</a> | 
	    <a href='sysfo.php?syxec=kurikulum&md=1&kdj=$kdj'>Baru</a>";
	}
	echo "<table class=basic width=100% cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=3>Kurikulum</th></tr>
	  <tr><td class=lst>Jurusan:</td><td class=lst colspan=2>$kdj - $Jurusan</td></tr>
	  <tr><td class=lst>Tahun:</td><td class=lst colspan=2>$strthn</td></tr>
	  <tr><td class=lst>Kurikulum:</td><td class=lst>$strkuri</td>
	  <td class=lst>$strlink</td></tr>
	  <tr><td class=lst>Nama Sesi:</td><td class=lst colspan=2>$strsesi</td></tr>
	  <tr><td class=lst>Jml Sesi/tahun:</td><td class=lst colspan=2>$strjml</td></tr>
	</table>";
	
	return $kurikulum;
  }
  function DisplayKurikulumHistory ($kdj, $act='kurikulum') {
	$kuri = new NewsBrowser;
	$kuri->query = "select * from kurikulum where KodeJurusan='$kdj' order by ID desc";
	$kuri->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=4>History Kurikulum</th></tr>
	  <tr><th class=ttl>#</th><td class=ttl>Kurikulum</td>
	  <td class=ttl>Tahun</td><td class=ttl>Tdk Aktif</td></tr>";
	$kuri->detailfmt = "<tr><td class=ttl>=NOMER=</td>
	  <td class=lst><a href='sysfo.php?syxec=$act&md=0&kdj==KodeJurusan=&ID==ID='>=Nama=</a></td>
	  <td class=lst>=Tahun=</td>
	  <td class=lst align=center>=NotActive=</td></tr>";
	$kuri->footerfmt = "</table>";
	echo $kuri->BrowseNews();
  }
  function DisplayKurikulumForm($md=1, $kdj='', $act='kurikulum', $ID=0) {
    global $strCantQuery, $fmtErrorMsg;
    if ($md==0) {
	  $_sql = "select * from kurikulum where ID=$ID";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  if (mysql_num_rows($_res)==0) die(DisplayHeader($fmtErrorMsg, "Tidak ada kurikulum aktif", 0));
	  $ID = mysql_result($_res,0,'ID');
	  $Nama = mysql_result($_res,0,'Nama');
	  $Tahun = mysql_result($_res,0,'Tahun');
	  $Sesi = mysql_result($_res, 0, 'Sesi');
	  $JmlSesi = mysql_result($_res, 0, 'JmlSesi');
	  $NotActive = mysql_result($_res,0,'NotActive');
	  $Jurusan = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  $strjurusan = "<input type=hidden name='kdj' value='$kdj'>$Jurusan";
	  $judul = 'Edit Kurikulum';
	}
	elseif ($md==1) {
	  $ID = 0;
	  $Nama = '';
	  $Tahun = '';
	  $Sesi = 'Semester';
	  $JmlSesi = 1;
	  $NotActive = 'N';
	  $optjurusan = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Nama_Indonesia', $kdj, '', 'Kode');
	  $strjurusan = "<select name='kdj'>$optjurusan</select>";
	  $judul = 'Buat Kurikulum Baru';
	}
	if ($NotActive=='Y') $strna = 'checked';
	else $strna = '';
	$snm = session_name();
	$sid = session_id();
	echo "
	  <table class=basic width=100% cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='md' value=$md>
	  <input type=hidden name='ID' value=$ID>
	  <tr><th class=ttl colspan=2>$judul</th></tr>
	  <tr><td class=lst>Nama Kurikulum</td>
	    <td class=lst><input type=text name='Nama' value='$Nama' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Jurusan</td>
	    <td class=lst>$strjurusan</td></tr>
	  <tr><td class=lst>Tahun</td>
	    <td class=lst><input type=text name='Tahun' value='$Tahun' size=10 maxlength=5></td></tr>
	  <tr><td class=lst>Nama Sesi</td>
	    <td class=lst><input type=text name='Sesi' value='$Sesi' size=20 maxlength=25></td></tr>
	  <tr><td class=lst>Jml Sesi/tahun</td>
	    <td class=lst><input type=text name='JmlSesi' value='$JmlSesi' size=10 maxlength=5></td></tr>

	  <tr><td class=lst>Tidak Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
	  <tr><td class=lst colspan=2 align=center>
	    <input type=submit name='prc' value='Simpan'>
	    <input type=reset name='reset' value='Reset'>
		<input type=button name='batal' value='Batal' onClick=\"location='sysfo.php?syxec=kurikulum&$snm=$sid'\">
		</td></tr>
	  </form></table>";
  }
  function ProcessKurikulumForm() {
    global $strCantQuery, $fmtMessage, $kdj, $prc, $md;
    $md = $_REQUEST['md'];
	if (isset($_REQUEST['ID']))	$ID = $_REQUEST['ID'];
	else $ID = 0;
	$Nama = FixQuotes($_REQUEST['Nama']);
	$kdj = $_REQUEST['kdj'];
	$Tahun = FixQuotes($_REQUEST['Tahun']);
	$Sesi = FixQuotes($_REQUEST['Sesi']);
	$JmlSesi = $_REQUEST['JmlSesi'];

	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	
	if (isset($_REQUEST['conf'])) $conf = $_REQUEST['conf'];
	else $conf = 0;
	
	if ($md==0) {
	  $_sql = "update kurikulum set Nama='$Nama', KodeJurusan='$kdj', Tahun='$Tahun', 
	    Sesi='$Sesi', JmlSesi=$JmlSesi, NotActive='$NotActive'
	    where ID = $ID ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  $md = -1;
	  $prc = '';
	  mysql_query("update jurusan set JmlSesi=$JmlSesi where Kode='$kdj'") or die('Gagal Update Jurusan');
	}
	elseif ($md==1) {
	  $_sc = "select ID,Nama,NotActive from kurikulum where KodeJurusan='$kdj' and NotActive='N' order by ID desc limit 1";
	  $_rc = mysql_query($_sc) or die("$strCantQuery: $_sc");
	  if (mysql_num_rows($_rc)>0 && $conf==0) {
	    $OldID = mysql_result($_rc,0,'ID');
	    DisplayItem($fmtMessage, "Kurikulum Lama Aktif",
		  "Ada kurikulum sebelumnya yang masih aktif. Anda benar akan menon-aktifkan
		  kurikulum lama dan menyimpan kurikulum baru ini?<br>
		  Pilihan: <a href='sysfo.php?syxec=kurikulum&md=$md&prc=1&Nama=$Nama&Jurusan=$Jurusan&Tahun=$Tahun&NotActive=$NotActive&conf=1&OldID=$OldID'>Simpan</a> |
		  <a href='sysfo.php?syxec=kurikulum&kdj=$kdj'>Batal</a>");
	  }
	  else {
	    $unip = $_SESSION['unip'];
		if ($conf==1 && isset($_REQUEST['OldID'])) {
		  $OldID = $_REQUEST['OldID'];
		  $_sna = "update kurikulum set NotActive='Y', TglNA=now() where ID=$OldID";
		  $_rna = mysql_query($_sna) or die("$strCantQuery: $_sna");
		}
	    $_sql = "insert into kurikulum (Nama, KodeJurusan, Tahun, Sesi, JmlSesi, Login, Tgl, NotActive)
		  values ('$Nama', '$kdj', '$Tahun', '$Sesi', $JmlSesi, '$unip', now(), '$NotActive') ";
		$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");

		$md = -1;
		$prc = '';
	    mysql_query("update jurusan set JmlSesi=$JmlSesi where Kode='$kdj'") or die('Gagal Update Jurusan');
	  }
	}
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Kurikulum');
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md'];
  else $md = -1;

  $kdj = GetSetVar('kdj');
  if (isset($_REQUEST['prc'])) {
    $prc = $_REQUEST['prc'];
    $ID = ProcessKurikulumForm();
  } else $prc = '';
?>

<table class='basic' width=100%>
<tr>
<td class=basic valign=top width=50%>
  <?php
    if ($md > -1) {
	  if (isset($_REQUEST['ID'])) $ID = $_REQUEST['ID'];
	  else $ID = 0;
	  if (empty($prc)) DisplayKurikulumForm($md, $kdj, 'kurikulum', $ID);
	}
	else {
	  DisplayJurusanHeader($kdj);
	  echo "<br>";
	  if (!empty($kdj)) DisplayKurikulumHistory($kdj);
	}
  ?>
</td>

<td class=basic width=2 background='image/vertisilver.gif'></td>

<td class=basic valign=top>
  <?php
    DisplayListofJurusan('','kurikulum');
  ?>
</td>
</tr>
</table>