<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function DisplayListofRuang($kmps='', $act='sysfo.php') {
    global $strCantQuery, $fmtPageTitle, $maxrow, $halaman, $strPage, $strTotalData, $sr;
	if (empty($kmps)) $strKmps = '';
	else $strKmps = "where KodeKampus='$kmps'";

    $pagefmt = "<a href='sysfo.php?exec=listofruang&sr==STARTROW=&kampus=$kmps'>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
	
	$table = "ruang $strKmps order by KodeKampus,Kode";
	
    $lister = new lister;
    $lister->tables = $table;
    $lister->fields = "*";
    $lister->startrow = $sr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic cellpadding=2 cellspacing=0 width=100%>
	  <tr><th class=ttl>Kode</th><th class=ttl>Nama Ruang</th>
	  <th class=ttl>Kampus</th>
	  <th class=ttl>Lantai</th>
	  <th class=ttl>Kapasitas</th>
	  <th class=ttl>Kapasitas<br>Ujian</th>
	  <th class=ttl>NA</td>
	  <th class=ttl>Keterangan</td></tr>";
    $lister->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=listofruang&md=0&Kode==Kode='>=Kode=</a></td>
	  <td class=lst>=Nama=</td>
	  <td class=lst>=KodeKampus=</td>
	  <td class=lst align=right>=Lantai=</td>
	  <td class=lst align=right>=Kapasitas=</td>
	  <td class=lst align=right>=KapasitasUjian=</td>
	  <td class=lst align=center><img src='image/book=NotActive=.gif' border=0></td>
	  <td class=lst>=Keterangan=</td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    
    echo "$strPage: $halaman<br>";
    echo $lister->ListIt ();
    echo "<p>$strPage: $halaman</p>";  
    echo "$strTotalData: $TotalNews";
  }
  function DisplayRuangForm($md,$kdrg,$kdkmps='') {
    global $strCantQuery, $fmtPageTitle;
	if ($md==0) {
	  $_sql = "select * from ruang where Kode='$kdrg'";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  if (mysql_num_rows($_res)==0) die("$strNotAuthorized");
	  $Kode = mysql_result($_res,0,'Kode');
	  $Nama = mysql_result($_res,0,'Nama');
	  $kdkmps = mysql_result($_res,0,'KodeKampus');
	  $Lantai = mysql_result($_res,0,'Lantai');
	  $Kapasitas = mysql_result($_res, 0, 'Kapasitas');
	  $KapasitasUjian = mysql_result($_res, 0, 'KapasitasUjian');
	  $Keterangan = mysql_result($_res,0,'Keterangan');
	  $NotActive = mysql_result($_res,0,'NotActive');
	  $strKode = "<input type=hidden name='Kode' value='$kdrg'>$kdrg";
	  $judul = 'Edit Ruang';
	}
	elseif ($md==1) {
	  $Kode = '';
	  $Nama = '';
	  $Lantai = '';
	  $Kapasitas = 0;
	  $KapasitasUjian = 0;
	  $Keterangan = '';
	  $NotActive = 'N';
	  $strKode = "<input type=text name='Kode' size=15 maxlength=10>";
	  $judul = 'Tambah Ruang';
	}
	$optkampus = GetOption('kampus', 'Kode', 'Kode', $kdkmps);
	if ($NotActive=='Y') $strna = 'checked';
	else $strna = '';
	$snm = session_name();
	$sid = session_id();
	// tampilkan form
	DisplayHeader($fmtPageTitle, $judul);
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='listofruang'>
	  <input type=hidden name='md' value='$md'>
	  <table class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>$judul</th></tr>
	  <tr><td class=lst>Kode Ruang</td><td class=lst>$strKode</td></tr>
	  <tr><td class=lst>Nama Ruang</td>
	    <td class=lst><input type=text name='Nama' size=40 maxlength=100 value='$Nama'></td></tr>
	  <tr><td class=lst>Kode Kampus</td>
	    <td class=lst><select name='kampus'>$optkampus</select></td></tr>
	  <tr><td class=lst>Lantai</td>
	    <td class=lst><input type=text name='Lantai' size=15 maxlength=10 value='$Lantai'></td></tr>
	  <tr><td class=lst>Kapasitas</td>
	    <td class=lst><input type=text name='Kapasitas' size=15 maxlength=5 value=$Kapasitas></td></tr>
	  <tr><td class=lst>Kapasitas Ujian</td>
	    <td class=lst><input type=text name='KapasitasUjian' size=15 maxlength=5 value=$KapasitasUjian></td></tr>

	  <tr><td class=lst>Keterangan</td>
	    <td class=lst><textarea name='Keterangan' cols=35 rows=3>$Keterangan</textarea></td></tr>
	  <tr><td class=lst>Tidak Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
	  <tr><td class=lst colspan=2 align=center>
	    <input type=submit name='prc' value='Simpan'>
		<input type=reset name='reset' value='Reset'>
		<input type=button name='batal' value='Batal' onClick=\"location='sysfo.php?syxec=listofruang&$snm=$sid'\"
		</td></tr>
	  </table></form>";
  }
  function ProcessRuangForm() {
    global $strCantQuery, $fmtErrorMsg;
    $Kode = FixQuotes($_REQUEST['Kode']);
	$Nama = FixQuotes($_REQUEST['Nama']);
	$KodeKampus = $_REQUEST['kampus'];
	$Lantai = FixQuotes($_REQUEST['Lantai']);
	$Kapasitas = $_REQUEST['Kapasitas'];
	$KapasitasUjian = $_REQUEST['KapasitasUjian'];
	$Keterangan = FixQuotes($_REQUEST['Keterangan']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	$unip = $_SESSION['unip'];
	$md = $_REQUEST['md'];
	if ($md==0) {
	  $_sql = "update ruang set Kode='$Kode', Nama='$Nama', KodeKampus='$KodeKampus',
	    Lantai='$Lantai', Kapasitas=$Kapasitas, KapasitasUjian=$KapasitasUjian,
		Keterangan='$Keterangan', NotActive='$NotActive'
		where Kode='$Kode'  ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	elseif ($md==1) {
	  $_chk = GetaField('ruang','Kode',$Kode,'Kode');
	  if (!empty($_chk)) die(DisplayHeader($fmtErrorMsg, "Kode ruang <b>$Kode</b> sudah ada. Tidak dapat disimpan.", 0));
	  $_sql = "insert into ruang (Kode, Nama, KodeKampus, Lantai, Kapasitas, KapasitasUjian,
	    Keterangan, Login, Tgl, NotActive)
	    values ('$Kode', '$Nama', '$KodeKampus', '$Lantai', $Kapasitas, $KapasitasUjian,
		'$Keterangan', '$unip', now(), '$NotActive')";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
  }
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md'];
  else $md = -1;
  $kampus = GetSetVar('kampus');
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
  else $prn = 0;
  if (isset($_REQUEST['prc'])) {
    ProcessRuangForm();
	$md = -1;
  }
  if (!isset($_REQUEST['sr'])) $sr = 0;
  else $sr = $_REQUEST['sr'];

  // *** Bagian Utama ***
  if ($md==0) DisplayRuangForm(0,$_REQUEST['Kode']);
  elseif ($md==-1) {
    DisplayHeader($fmtPageTitle, 'Daftar Ruang');
    if ($prn==0) {
	// tampilkan pilihan kampus
	  $optkmps = GetOption2('kampus', "concat(Kode, ' - ', Kampus)", '', $kampus, '', 'Kode');
	  echo "<form action='sysfo.php' method=GET>
	    <input type=hidden name='syxec' value='listofruang'>
	    Kode Kampus: <select name='kampus' onChange='this.form.submit()'>$optkmps</select>
	    </form>";
	  DisplayPrinter("print.php?print=sysfo/listofruang.php&kampus=$kampus&sr=$sr&prn=1");
	  echo "<a href='sysfo.php?syxec=listofruang&md=1&kampus=$kampus'>Tambah Ruang</a><br>";
	}
	else echo "Kode Kampus: $kampus<br>";
    DisplayListofRuang($kampus);
  }
  elseif ($md==1) DisplayRuangForm(1,'',$kampus);
?>