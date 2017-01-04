<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function GetMyMhsw($dsn) {
    global $strCantQuery, $walisr, $maxrow, $strPage;
	$did = GetaField('dosen', 'Login', $dsn, 'ID');

    $pagefmt = "<a href='sysfo.php?syxec=dosenwali&walisr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
  
    $lister = new lister;
    $lister->tables = "mhsw m 
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join statusmhsw sm on m.Status=sm.Kode
	  where m.DosenID=$did order by m.NIM";
    $lister->fields = "m.NIM, m.Name, concat(j.Kode, ' - ', j.Nama_Indonesia) as JUR, sm.Nama as STT, m.TA ";
    $lister->startrow = $walisr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Status</th><th class=ttl>TA</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=mhswipk&nim==NIM='>=NIM=</a></td>
	  <td class=lst>=Name=</td><td class=lst>=JUR=</td><td class=lst>=STT=</td>
	  <td class=lst><a href='sysfo.php?syxec=dosenwali&md=0&nim==NIM='><img src='image/=TA=.gif' border=0></a></td>
	  </tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<p>$strPage: $halaman<br>".
    $lister->ListIt () .
	  "$strPage: $halaman</p>";
    echo $usrlist;
  }
  function DispFormTA($md, $nim) {
    $arr = GetFields('mhsw', 'NIM', $nim, 'TA,TglTA,TglLulus,JudulTA,PembimbingTA');
	if (!isset($arr['TglLulus'])) $arr['TglLulus'] = '0000-00-00';
	if (!isset($arr['TglTA'])) $arr['TglTA'] = date('Y-m-d');
	$tls = explode('-',$arr['TglLulus']);
	$tta = explode('-',$arr['TglTA']);
	$tls_y = $tls[0]; $tls_m = $tls[1]; $tls_d = $tls[2];
	$tta_y = $tta[0]; $tta_m = $tta[1]; $tta_d = $tta[2];
	$optpta = GetOption2('dosen', "concat(Name, ', ', Gelar)", "Name", $arr['PembimbingTA'], '', 'ID');
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='dosenwali'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='nim' value='$nim'>
	<tr><th class=ttl colspan=2>Formulir Tugas Akhir</th></tr>
	<tr><td class=lst>Tanggal Mulai</td><td class=lst><input type=text name='tta_d' value='$tta_d' size=2 maxlength=2>-
	  <input type=text name='tta_m' value='$tta_m' size=2 maxlength=2>-
	  <input type=text name='tta_y' value='$tta_y' size=4 maxlength=4></td></tr>
	<tr><td class=lst>Pembimbing TA</td><td class=lst><select name='pta'>$optpta</select></td></tr>
	<tr><td class=lst colspan=2>Judul TA:<br><textarea name='jdl' cols=40 rows=3>$arr[JudulTA]</textarea></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcta' value='Simpan'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name='Batal' value='Batal/Kembali' onClick="location='sysfo.php?syxec=dosenwali&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcMhswTA() {
    global $strCantQuery;
    $nim = $_REQUEST['nim'];
	$tta_d = $_REQUEST['tta_d']; $tta_m =$_REQUEST['tta_m']; $tta_y = $_REQUEST['tta_y'];
	$pta = $_REQUEST['pta'];
	$jdl = FixQuotes($_REQUEST['jdl']);
	$s = "update mhsw set TA='Y', TglTA='$tta_y-$tta_m-$tta_d', PembimbingTA='$pta', JudulTA='$jdl' where NIM='$nim'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function SetupMhswTA($md, $nim) {
    global $strCantQuery, $fmtErrorMsg, $fmtMessage;
    DispHeaderMhsw($nim, 'dosenwali', 1);
	$arr = GetFields('mhsw', 'NIM', $nim, 'Name,TA');
	if ($arr['TA'] == 'Y') DispFormTA($md, $nim);
	else {
	  if ($md == 0) DisplayItem($fmtMessage, 'Tugas Akhir', 
	    "Mahasiswa <b>". $nim . " </b>--<b> " . $arr['Name'] . "</b> belum mengambil Tugas Akhir.<br>
		Pilihan: <a href='sysfo.php?syxec=dosenwali&md=1&nim=$nim' class=lst>Ambil Tugas Akhir</a> |
		<a href='sysfo.php?syxec=dosenwali&md=-1' class=lst>Kembali</a>");
	  elseif ($md == 1) DispFormTA($md, $nim);
	}
  }
  
  // *** PARAMETER ***
  if (isset($_REQUEST['dsn'])) {
    $dsn = $_REQUEST['dsn'];
	$_SESSION['dsn'] = $dsn;
  }
  else {
    if ($_SESSION['ulevel'] == 3) {
	  $dsn = $_SESSION['unip'];
	  $_SESSION['dsn'] = $dsn;
	}
	else {
      if (isset($_SESSION['dsn'])) $dsn = $_SESSION['dsn'];
	  else $dsn = '';
	}
  }
  if (isset($_REQUEST['walisr'])) {
    $walisr = $_REQUEST['walisr'];
	$_SESSION['walisr'] = $walisr;
  }
  else {
    if (isset($_SESSION['walisr'])) $walisr = $_SESSION['walisr']; else $walisr = 0;
  }
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  
  // *** BAGIAN UTAMA ***
  if ($md == -1) DisplayHeader($fmtPageTitle, 'Penasehat Akademik');
  elseif ($md == 0) DisplayHeader($fmtPageTitle, 'Penasehat Akademik: Setup Tugas Akhir');
  $vld = GetLoginDosen($dsn, 'dosenwali');
  if ($vld) {
    if (isset($_REQUEST['prcta'])) PrcMhswTA();
    if ($md == -1) GetMyMhsw($dsn);
	else SetupMhswTA($md, $_REQUEST['nim']);
  }
  else DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas data dosen dengan login <b>$dsn</b>.<br>");

?>