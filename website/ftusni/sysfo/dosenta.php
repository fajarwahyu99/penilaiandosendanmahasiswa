<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** FUNGSI2 ***
function GetDaftarMhswTA($dsn) {
    global $strCantQuery, $walisr, $maxrow, $strPage;
	$did = GetaField('dosen', 'Login', $dsn, 'ID');
	if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
    $pagefmt = "<a href='sysfo.php?syxec=dosenta&walisr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
    $lister = new lister;
    $lister->tables = "mhsw m 
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join statusmhsw sm on m.Status=sm.Kode
	  where m.PembimbingTA=$did order by m.NIM desc";
    $lister->fields = "m.NIM, m.Name, concat(j.Kode, ' - ', j.Nama_Indonesia) as JUR, sm.Nama as STT, m.TA, m.Lulus ";
    $lister->startrow = $sr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Status</th><th class=ttl>TA</th><th class=ttl>Lulus</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=dosenta&nim==NIM=&md=-1'>=NIM=</a></td>
	  <td class=lst>=Name=</td><td class=lst>=JUR=</td><td class=lst>=STT=</td>
	  <td class=lst><img src='image/=TA=.gif' border=0></td>
	  <td class=lst><img src='image/=Lulus=.gif' border=0></td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<p>$strPage: $halaman<br>".
    $lister->ListIt () .
	  "$strPage: $halaman</p>";
    echo $usrlist;
}
function validDosenPembimbingTA($dsn, $nim) {
  $did = GetaField('dosen', 'Login', $dsn, 'ID');
  $pta = GetaField('mhsw', 'NIM', $nim, 'PembimbingTA');
	return $did == $pta;
}
function DaftarBimbinganTA($dsn, $nim, $lls) {
  $r = mysql_query("select *,date_format(Tanggal,'%d-%m-%Y') as Tanggal from bimbinganta where NIM='$nim'");
	$ret = '<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=3>Daftar Riwayat Bimbingan</th></tr>';
	$num = 0;
	while ($w = mysql_fetch_array($r)) {
	  if ($lls == 'N') {
	    $lnk = "<a href='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&bid=$w[ID]&md=0'>$w[Tanggal]</a>";
	  }
	  else {
	    $lnk = "$w[Tanggal]";
	  }
	  $num++;
	  $cata = str_replace('\n', '<br>', $w['Catatan']);
	  $ret .= "<tr><td class=lst>$num</td>
	  <td class=lst>$lnk</td>
	  <td class=lst>$cata</td></tr>";
	}
    return $ret . "</table>";
}
function GetFormMhswTA($dsn, $nim, $md, $mdx){
	$ata = GetFields('mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps jp on j.Jenjang=jp.Kode
	  left outer join program p on m.KodeProgram=p.Kode', 
	  'NIM', $nim, "m.Name,m.KodeJurusan,j.Nama_Indonesia as JUR,m.TotalSKS,m.IPK,m.JudulTA,m.Lulus,
	  date_format(TglTA,'%d-%m-%Y') as TglTA,jp.Nama as JEN,p.Nama_Indonesia as PRG,CatatanTA");
	if ($ata['Lulus'] == 'Y') {
	  $lls = '';
	  $bim = '';
	  $but = '';
	  $cat = '';
	  $nil = "| <a href='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&mdx=2' class=lst>Nilai TA</a>";
	}
	else {
	  $lls = "| <a href='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&mdx=1' class=lst>Luluskan Mahasiswa</a>";
	  $bim = "| <a href='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&md=1' class=lst>Tambah Bimbingan TA</a>";
	  $but = "<tr><td class=lst colspan=2><input type=submit name='prccata' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'></td></tr>";
	  $cat = "<tr><td class=lst colspan=2>Catatan:<br><textarea name='cata' cols=30 rows=3>$ata[CatatanTA]</textarea></td></tr>";
	  $nil = '';
	}
  echo "<a href='sysfo.php?syxec=dosenta' class=lst>Kembali</a> $bim $lls $nil";

	$kiri = <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Mahasiswa</th></tr>
	  <tr><td class=lst>NIM</td><td class=lst>$nim</td></tr>
	  <tr><td class=lst>Mahasiswa</td><td class=lst>$ata[Name]</td></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst>$ata[KodeJurusan] - $ata[JUR]</td></tr>
	  <tr><td class=lst>Jenjang Pendidikan</td><td class=lst>$ata[JEN]</td></tr>
	  <tr><td class=lst>Program/Kelas</td><td class=lst>$ata[PRG]</td></tr>
	  <tr><td class=lst>Total SKS</td><td class=lst>$ata[TotalSKS]</td></tr>
	  <tr><td class=lst>IPK</td><td class=lst>$ata[IPK]</td></tr>
	  <tr><th class=ttl colspan=2>Tugas Akhir</th><tr>
	  <tr><td class=lst>Tanggal Mulai</td><td class=lst>$ata[TglTA]</td></tr>
	  <tr><td class=lst>Judul</td><td class=lst>$ata[JudulTA]</td></tr>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosenta'>
	  <input type=hidden name='dsn' value='$dsn'>
	  <input type=hidden name='nim' value='$nim'>
	  $cat
	  $but
	  </form></table>
EOF;

	if ($ata['Lulus'] == 'N') {
	  if ($mdx > 0) $kanan = FormLuluskan($dsn, $nim);
	  else {
	    if ($md == -1) $kanan = DaftarBimbinganTA($dsn, $nim, $ata['Lulus']);
	    else $kanan = FormBimbinganTA($dsn, $nim, $md);
	  }
	}
	else $kanan = FormLuluskan($dsn, $nim);
	echo <<<EOF
	<table class=basic cellspacing=2 cellpadding=2>
	<tr><td class=basic style='border-right: 1px solid silver;' valign=top>$kiri</td>
	<td class=basic valign=top>$kanan</td></tr>
	</table>
EOF;
}
function FormLuluskan($dsn, $nim) {
	$arr = GetFields('mhsw', 'NIM', $nim, "TglLulus, Lulus");
	if (empty($arr['TglLulus'])) $arr['TglLulus'] = date('Y-m-d');
	$atgl = explode('-', $arr['TglLulus']);
	$llsy = ''; $llsn = '';
	$snm = session_name(); $sid = session_id();
	if ($arr['Lulus'] == 'Y') {
	  $llsy = 'checked';
	  $but = '';
	  $tgl = $atgl[2].'-'.$atgl[1].'-'.$atgl[0];
	}
	else {
	  $llsn = 'checked';
	  $but = "<tr><td class=lst colspan=2><input type=submit name='prclulus' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'>&nbsp;
	  <input type=button name='balik' value='Kembali' onClick=\"location='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&P$snm=$sid'\"></td></tr>";
	  $tgl = "<input type=text name='lls_d' value='$atgl[2]' size=2 maxlength=2>-<input type=text name='lls_m' value='$atgl[1]' size=2 maxlength=2>-<input type=text name='lls_y' value='$atgl[0]' size=4 maxlength=4>";
	}
  $a = <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='dosenta'>
	<input type=hidden name='nim' value='$nim'>
	<input type=hidden name='dsn' value='$dsn'>
	<tr><th class=ttl colspan=2>Status Kelulusan</th></tr>
	<tr><td class=lst>Lulus</td><td class=lst><input type=radio name='lls' value='Y' $llsy>Lulus &nbsp;
	<input type=radio name='lls' value='N' $llsn>Belum Lulus</td></tr>
	<tr><td class=lst>Tanggal Lulus</td><td class=lst>$tgl</td></tr>
	$but
	</form></table><br>
EOF;
	if ($arr['Lulus'] == 'Y') $b = DispNilaiTA($dsn, $nim); else $b = '';
	return $a . $b;
}
function DispNilaiTA($dsn, $nim) {
    $kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
    $kurid = GetLastKur($kdj);
	$opt = GetOption2('matakuliah mk left outer join jenismatakuliah jmk on mk.KodeJenisMK=jmk.Kode',
	  "concat(Nama_Indonesia)", "mk.Kode", '', "mk.KurikulumID=$kurid and jmk.TA='Y' and mk.NotActive='N'", "ID", 1);
    $a = <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<form>
	<tr><td class=lst>Tambahkan MK</td><td class=lst><select name='MKTA'>$opt</select></td></tr>
	</form></table>
EOF;
	$s = "select r.*, mk.Nama_Indonesia as mat
	  from krs r left outer join matakuliah mk on r.IDMK=mk.ID
	  left outer join jenismatakuliah jmk on mk.KodeJenisMK=jmk.Kode
	  where jmk.TA='Y' and NIM='$nim' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$b = "<table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  $b .= <<<EOF
	  <tr><td class=lst>$w[KodeMK]</td></tr>
EOF;
	}
	$b .= "</table>";
	return $a . $b;
  }
  function PrcMhswLulus() {
    $nim = $_REQUEST['nim'];
	$dsn = $_REQUEST['dsn'];
	$tglLulus = $_REQUEST['lls_y'] .'-'. $_REQUEST['lls_m'] .'-'. $_REQUEST['lls_d'];
	$lls = $_REQUEST['lls'];
	$s = "update mhsw set TglLulus='$tglLulus', Lulus='$lls' where NIM='$nim'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function FormBimbinganTA($dsn, $nim, $md) {
    global $strCantQuery;
    if ($md == 0) {
	  $bid = $_REQUEST['bid'];
	  $s = "select * from bimbinganta where ID=$bid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) == 0) die ("Data tidak ditemukan.");
	  $tgl = mysql_result($r, 0, 'Tanggal');
	  $cata = mysql_result($r, 0, 'Catatan');
	  $jdl = 'Edit Bimbingan';
	}
	else {
	  $bid = 0;
	  $tgl = date('Y-m-d');
	  $cata = '';
	  $jdl = 'Tambah Bimbingan';
	}
	$tgl = explode('-', $tgl);
	$tgl_y = $tgl[0]; $tgl_m = $tgl[1]; $tgl_d = $tgl[2];
	$sid = session_id();
    return <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='dosenta'>
	<input type=hidden name='bid' value='$bid'><input type=hidden name='md' value='$md'>
	<input type=hidden name='dsn' value='$dsn'><input type=hidden name='nim' value='$nim'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Tanggal</td><td class=lst><input type=text name='tgl_d' value='$tgl_d' size=2 maxlength=2>&nbsp;
	<input type=text name='tgl_m' value='$tgl_m' size=2 maxlength=2>&nbsp;
	<input type=text name='tgl_y' value='$tgl_y' size=4 maxlength=4></td></td>
	<tr><td class=lst colspan=2>Catatan:<br><textarea name='cata' cols=30 rows=3>$cata</textarea></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcbim' value='Simpan'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name=btn value='Batal' onClick="location='sysfo.php?syxec=dosenta&nim=$nim&dsn=$dsn&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcBimbinganTA() {
    global $strCantQuery;
    $nim = $_REQUEST['nim'];
	$dsn = $_REQUEST['dsn'];
	$bid = $_REQUEST['bid'];
	$tgl_d = $_REQUEST['tgl_d']; $tgl_m = $_REQUEST['tgl_m']; $tgl_y = $_REQUEST['tgl_y'];
	$tgl = "$tgl_y-$tgl_m-$tgl_d";
	$cata = FixQuotes($_REQUEST['cata']);
	$md = $_REQUEST['md'];
	if ($md == 0) $s = "update bimbinganta set Tanggal='$tgl', Catatan='$cata' where ID=$bid";
	else $s = "insert into bimbinganta(Tanggal,NIM,PembimbingTA,Catatan,NotActive) 
	  values('$tgl','$nim','$dsn','$cata','N')";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	return -1;
  }
  function PrcCatatanTA() {
    $nim = $_REQUEST['nim'];
	$cata = FixQuotes($_REQUEST['cata']);
	mysql_query("update mhsw set CatatanTA='$cata' where NIM='$nim'");
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
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['mdx'])) $mdx = $_REQUEST['mdx']; else $mdx = 0;
  if (isset($_REQUEST['nim'])) $nim = $_REQUEST['nim']; else $nim = '';

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Bimbingan Tugas Akhir');
  $vld = GetLoginDosen($dsn, 'dosenta');
  if ($vld) {
    if ($prn == 0 && $_SESSION['ulevel'] < 4) {
      DispNIMMhsw($nim, 'dosenta');
    }
	if (isset($_REQUEST['prccata'])) PrcCatatanTA();
	if (isset($_REQUEST['prcbim'])) $md = PrcBimbinganTA();
	if (isset($_REQUEST['prclulus'])) PrcMhswLulus();
    if (empty($nim)) GetDaftarMhswTA($dsn);
	if (isset($nim)) {
	  if (validDosenPembimbingTA($dsn, $nim)) GetFormMhswTA($dsn, $nim, $md, $mdx);
	  else if (!empty($dsn) && !empty($nim)) 
	    DisplayHeader($fmtErrorMsg, "Dosen <b>$dsn</b> bukan dosen Pembimbing Tugas Akhir <b>$nim</b>.");
	}
  }
  else if (!empty($dsn))
    DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas data dosen dengan login <b>$dsn</b>.<br>");
?>