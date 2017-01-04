<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003

  // *** Fungsi2 ***
function DispPanelAlumniClosed() {
	global $prn;
	if ($prn == 0)
  echo <<<EOF
	<a href='sysfo.php?syxec=alumni&ClosePanelAlumni=N'><img src='image/menu.gif' border=0> Tampilkan Panel</a>
EOF;
}
function DispPanelAlumni($kdj, $kdp, $thn, $lls, $krj) {
	global $prn;
	if ($prn == 0) {
    $optkdj = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	  $optkdp = GetOption2('program', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdp, '', 'Kode');
	  $selky = ''; $selkn = ''; $selks = '';
	  if (empty($krj)) $selks = 'checked';
	  elseif ($krj == 'Y') $selky = 'checked';
	  elseif ($krj == 'N') $selkn = 'checked';
	  $snm = session_name(); $sid = session_id();
    echo <<<EOF
	  <table class=box cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='alumni'>
	  <input type=hidden name='nil' value=''>
	  <input type=hidden name='key' value=''>
	  <tr><th class=ttl colspan=2>Panel Filter</th></tr>
	  <tr><td class=uline>Jurusan :</td><td class=uline><select name='kdj'>$optkdj</select></td></tr>
	  <tr><td class=uline>Program :</td><td class=uline><select name='kdp'>$optkdp</select></td></tr>
	  <tr><td class=uline>Tahun Angkatan : </td><td class=uline><input type=text name='thn' value='$thn' size=5 maxlength=5> Tahun Akademik</td></tr>
	  <tr><td class=uline>Tahun Lulus : </td><td class=uline><input type=text name='lls' value='$lls' size=5 maxlength=5> Tahun Akademik</td></tr>
	  <tr><td class=uline>Sudah Bekerja:</td><td class=uline><input type=radio name='krj' value='Y' $selky>Sudah &nbsp;
	    <input type=radio name='krj' value='N' $selkn>Belum &nbsp;
	    <input type=radio name='krj' value='' $selks>Semua</td></tr>
	  <tr><td class=uline colspan=2><input type=submit name='rfr' value='Refresh Daftar Alumni'>&nbsp;
	    <input type=button name='sma' value='Lihat Semua' onClick="location='sysfo.php?syxec=alumni&rfr=1&kdj=&kdp=&thn=&lls=&nil=&key=&krj=&$snm=$sid'">
	   <input type=button name='sma' value='Tutup Panel' onClick="location='sysfo.php?syxec=alumni&rfr=1&ClosePanelAlumni=Y&kdj=&kdp=&thn=&lls=&nil=&key=&krj=&$snm=$sid'"></td></tr>
	  </form></table><br>
EOF;
  }
  else {
	  if (!empty($kdj)) $strkdj = $kdj; else $strkdj = 'semua jurusan';
	  if (!empty($kdp)) $strkdp = $kdp; else $strkdp = 'semua program';
	  if (!empty($thn)) $strthn = $thn; else $strthn = 'semua tahun';
	  if (!empty($lls)) $strlls = $lls; else $strlls = 'semua tahun lulus';
	  if (empty($krj)) $strkrj = 'semua';
	  elseif ($krj == 'Y') $strkrj = 'sudah'; elseif ($krj == 'N') $strkrj = 'belum';
	  
	  echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><td>Jurusan :</td><td class=uline>$strkdj</td></tr>
	  <tr><td>Program :</td><td class=uline>$strkdp</td></tr>
	  <tr><td>Angkatan :</td><td class=uline>$strthn</td></tr>
	  <tr><td>Tahun lulus :</td><td class=uline>$strlls</td></tr>
	  </table>
EOF;
  }
}
function DispSearchAlumni($nil, $key) {
	global $prn;
	if ($prn == 0)
  echo <<<EOF
	<table class=box cellspacing=2 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='alumni'>
	<input type=hidden name='kdj' value=''>
	<input type=hidden name='kdp' value=''>
	<input type=hidden name='thn' value=''>
	<input type=hidden name='lls' value=''>
	<tr><td class=uline>Cari Alumni : </td><td class=uline><input type=text name='nil' value='$nil' size=20 maxlength=10>
	&nbsp;<input type=submit name='key' value='NIM'>&nbsp;<input type=submit name='key' value='Name'></td></tr>
	</form></table><br>
EOF;
}
function DispMenuAlumni() {
	global $prn;
	$snm = session_name(); $sid = session_id();
	if ($prn == 0) {
		$strprn = GetPrinter("print.php?print=sysfo/alumni.php&prn=1&$snm=$sid&rfr=1");
    echo <<<EOF
	  <a href='sysfo.php?syxec=alumni&datamhsw=1'>Ambil Dari Data Mahasiswa</a> | $strprn
	  <br>
EOF;
  }
  else echo "<br>";
}
function DispAlumni($kdj, $kdp, $thn, $lls, $key, $nil, $krj) {
  global $maxrow;
  $strkdj = ''; $strkdp = ''; $strthn = ''; $strlls = ''; $strsrc = ''; $strkrj = '';
	if (!empty($kdj)) $strkdj = "and a.KodeJurusan='$kdj'";
	if (!empty($kdp)) $strkdp = "and a.KodeProgram='$kdp'";
	if (!empty($thn)) $strthn = "and a.TahunAkademik='$thn'";
	if (!empty($lls)) $strlls = "and a.TahunLulus='$lls'";
	if (!empty($key) && !empty($nil)) $strsrc = "and a.$key like '%$nil%'";
	if (!empty($krj)) $strkrj = "and a.SudahBekerja='$krj'";
	
	$sra = GetSetVar('sr'); if (empty($sra)) $sra = 0;
    $pagefmt = "<a href='sysfo.php?syxec=alumni&rfr=1&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
	
	$lister = new lister;
	$lister->tables = "alumni a left outer join jurusan j on a.KodeJurusan=j.Kode
	  left outer join program p on a.KodeProgram=p.Kode
	  where a.NotActive='N' $strkdj $strkdp $strthn $strlls $strsrc $strkrj order by a.NIM";
	$lister->fields = "a.*, j.Nama_Indonesia as JUR, p.Nama_Indonesia as PRG";
	$lister->startrow = $sra;
	$lister->maxrow = $maxrow;
	$lister->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Nama Alumni</th>
	  <th class=ttl colspan=2>Jurusan</th><th class=ttl colspan=2>Program</th>
	  <th class=ttl>Email</th><th class=ttl>Kerja</th>
	  </tr>";
	$lister->detailfmt = "<tr><td class=lst><a href='sysfo.php?syxec=alumnidetil&nim==NIM='>=NIM=</td>
	  <td class=lst>=Name=</td>
	  <td class=lst>=KodeJurusan=</td><td class=lst>=JUR=</td><td class=lst>=KodeProgram=</td><td class=lst>=PRG=</td>
	  <td class=lst><a href='mailto:=Email='>=Email=</a></td><td class=lst align=center><img src='image/=SudahBekerja=.gif'></td>
	  </tr>";
	$lister->footerfmt = "</table>";
	$halaman = $lister->WritePages ($pagefmt, $pageoff);
    $Total = $lister->MaxRowCount;
	echo $lister->ListIt();
	echo "<br>Hal.: $halaman<br>Total Alumni: $Total<br>";
}
function DispAmbilDataMhsw() {
	$snm = session_name(); $sid = session_id();
  echo <<<EOF
	<table class=box cellspacing=2 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='alumni'>
	<input type=hidden name='datamhsw' value=2>
	<tr><th class=ttl colspan=2>Ambil Data Mahasiswa yg Lulus</th></tr>
	<tr><td class=uline>NIM Mahasiswa : </td><td class=uline><input type=text name='nim' size=20 maxlength=20></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcdatamhsw' value='Ambil Data Mahasiswa'>&nbsp;
	<input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=alumni&$snm=$sid&rfr=1'"></td></tr>
	</form></table>
EOF;
}
function PrcAmbilDataMhsw() {
  global $fmtErrorMsg, $fmtMessage;
  if (isset($_REQUEST['nim'])) $nim = $_REQUEST['nim']; else $nim = '';
	if (!empty($nim)) {
	  $ada = GetaField('alumni', 'NIM', $nim, 'Name');
	  if (!empty($ada))
	    DisplayHeader($fmtErrorMsg, "Alumni <b>$nim - $ada</b> telah terdaftar. Tidak dapat mengambil data dari data mahasiswa.");
	  else {
	    $dat = GetFields('mhsw', 'NIM', $nim, '*');
	    if ($dat['Lulus'] == 'N')
	      DisplayHeader($fmtErrorMsg, "Mahasiswa <b>$dat[NIM] - $dat[Name]</b> belum lulus. Anda tidak dapat mengambil datanya untuk menjadi alumni.");
	    else {
		  TambahkanAlumni($dat);
	      DisplayDetail($fmtMessage, "Berhasil", "Mahasiswa <b>$dat[NIM] - $dat[Name]</b> telah diproses menjadi alumni.<br>
		    Pilihan: <a href='sysfo.php?syxec=alumni&prcnim=1&nil=$dat[NIM]&key=NIM'>Lihat Data $dat[NIM]</a> |
		    <a href='sysfo.php?syxec=alumni&rfr=1'>Kembali ke Daftar Alumni</a>");
	    }
	  }
	}
	else DisplayHeader($fmtErrorMsg, 'Anda belum mengisi NIM. Proses dibatalkan');
}
function TambahkanAlumni($dat) {
  $s = "insert into alumni(
	  Login, Password, Description, NIM, PMBID, NIRM, Tanggal, Name,
	  Email, Sex, TempatLahir, TglLahir, Alamat1, Alamat2, RT, RW, Kota,
	  KodePos, KodeTelp, Phone, Agama, AgamaID, WargaNegara, NamaPrsh,
	  Alamat1Prsh, Alamat2Prsh, KotaPrsh, FaxPrsh,
	  NamaOT, PekerjaanOT, AlamatOT1, AlamatOT2, RTOT, RWOT, KotaOT,
	  KodeTelpOT, TelpOT, EmailOT, KodePosOT,
	  AsalSekolah, PropSekolah, JenisSekolah, LulusSekolah, IjazahSekolah,
	  NilaiSekolah, Pilihan1, Pilihan2, KodeFakultas, KodeJurusan, Status,
	  KodeProgram, StatusAwal, StatusPotongan, SPP_D, Semester, TahunAkademik,
	  KodeBiaya, Posting, Lulus, TglLulus, TahunLulus, WaktuKuliah, Keterangan,
	  Pinjaman, KTahun, K_Dosen, DosenID, Ranking, mGroup, Target, Prop, Masuk,
	  TestScore, TA, TglTA, TotalSKS, IPK, JudulTA, PembimbingTA, CatatanTA,
	  PMBSyarat, NomerIjazah, MGM, MGMOleh, MGMHonor) values (
	  '$dat[Login]', '$dat[Password]', '$dat[Description]', '$dat[NIM]', '$dat[PMBID]', '$dat[NIRM]', '$dat[Tanggal]', '$dat[Name]',
	  '$dat[Email]', '$dat[Sex]', '$dat[TempatLahir]', '$dat[TglLahir]', '$dat[Alamat1]', '$dat[Alamat2]', '$dat[RT]', '$dat[RW]', '$dat[Kota]',
	  '$dat[KodePos]', '$dat[KodeTelp]', '$dat[Phone]', '$dat[Agama]', '$dat[AgamaID]', '$dat[WargaNegara]', '$dat[NamaPrsh]',
	  '$dat[Alamat1Prsh]', '$dat[Alamat2Prsh]', '$dat[KotaPrsh]', '$dat[FaxPrsh]',
	  '$dat[NamaOT]', '$dat[PekerjaanOT]', '$dat[AlamatOT1]', '$dat[AlamatOT2]', '$dat[RTOT]', '$dat[RWOT]', '$dat[KotaOT]',
	  '$dat[KodeTelpOT]', '$dat[TelpOT]', '$dat[EmailOT]', '$dat[KodePosOT]',
	  '$dat[AsalSekolah]', '$dat[PropSekolah]', '$dat[JenisSekolah]', '$dat[LulusSekolah]', '$dat[IjazahSekolah]',
	  '$dat[NilaiSekolah]', '$dat[Pilihan1]', '$dat[Pilihan2]', '$dat[KodeFakultas]', '$dat[KodeJurusan]', '$dat[Status]',
	  '$dat[KodeProgram]', '$dat[StatusAwal]', '$dat[StatusPotongan]', '$dat[SPP_D]', '$dat[Semester]', '$dat[TahunAkademik]',
	  '$dat[KodeBiaya]', '$dat[Posting]', '$dat[Lulus]', '$dat[TglLulus]', '$dat[TahunLulus]', '$dat[WaktuKuliah]', '$dat[Keterangan]',
	  '$dat[Pinjaman]', '$dat[KTahun]', '$dat[K_Dosen]', '$dat[DosenID]', '$dat[Ranking]', '$dat[mGroup]', '$dat[Target]', '$dat[Prop]', '$dat[Masuk]',
	  '$dat[TestScore]', '$dat[TA]', '$dat[TglTA]', '$dat[TotalSKS]', '$dat[IPK]', '$dat[JudulTA]', '$dat[PembimbingTA]', '$dat[CatatanTA]',
	  '$dat[PMBSyarat]', '$dat[NomerIjazah]', '$dat[MGM]', '$dat[MGMOleh]', '$dat[MGMHonor]')";
	$r = mysql_query($s) or die("Tidak dapat memproses alumni. Proses Gagal.");
  }
  
  // *** Parameter2 ***
  $kdj = GetSetVar('kdj');
  $kdp = GetSetVar('kdp');
  $thn = GetSetVar('thn');
  $lls = GetSetVar('lls');
  $nil = GetSetVar('nil');
  $key = GetSetVar('key');
  $krj = GetSetVar('krj');
  $ClosePanelAlumni = GetSetVar('ClosePanelAlumni'); if (empty($ClosePanelAlumni)) $ClosePanelAlumni = 'N';
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Pengelolaan Alumni');
  if ($ClosePanelAlumni == 'N') DispPanelAlumni($kdj, $kdp, $thn, $lls, $krj);
  else DispPanelAlumniClosed();
  DispSearchAlumni($nil, $key);
  DispMenuAlumni();
  if (isset($_REQUEST['rfr']) || isset($_REQUEST['prcnim']) || isset($_REQUEST['prcname'])) 
    DispAlumni($kdj, $kdp, $thn, $lls, $key, $nil, $krj);
  if (isset($_REQUEST['datamhsw'])) $datamhsw = $_REQUEST['datamhsw']; else $datamhsw = 0;
  switch ($datamhsw):
    case 1:
	  DispAmbilDataMhsw();
	  break;
	case 2:
	  PrcAmbilDataMhsw();
	  break;
  endswitch;
  
  echo "<br>";
?>