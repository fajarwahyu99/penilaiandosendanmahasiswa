<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  
  include "class/tab.class.php";
  
  // ** Fungsi2 ***
  function DispDetilAlumni($nim, $tab) {
    $dat = GetFields('alumni', 'NIM', $nim, 
	  "*, date_format(TglLahir, '%d %M %Y') as tgl, date_format(TglLulus, '%d %M %Y') as strTglLulus");
	if ($dat['SudahBekerja'] == 'Y') $strkerja = 'Sudah'; else $strkerja = '<b><font color=red>Belum';
	echo <<<EOF
	<table class=box cellspacing=0 cellpadding=2 align=center>
	<tr><th class=ttl colspan=3>Detil Alumni</th></tr>
	<tr><td class=uline>NIM</td><td class=uline width=200>: $dat[NIM]</td>
	<td class=uline rowspan=4><a href='sysfo.php?syxec=alumni&rfr=1'><img src='image/tux001.jpg' border=0><br>Kembali</a></td></tr>
	<tr><td class=uline>Nama Alumni</td><td class=uline>: $dat[Name]</td></tr>
	<tr><td class=uline>Angkatan</td><td class=uline>: $dat[TahunAkademik]</td></tr>
	<tr><td class=uline>Sudah Bekerja?</td><td class=uline>: $strkerja</td></tr>
	</table><br>
EOF;
	$isi = '';
	$arr = array('Data Pribadi', 'Data Orang Tua', 'Data Akademik', 'Pekerjaan');
    switch($tab):
	  case 0 :
	    $isi = GetAlumniPribadi($dat);
	    break;
	  case 1 :
	    $isi = GetAlumniOrtu($dat);
	    break;
	  case 2 :
	    $isi = GetAlumniAkademik($dat);
		break;
	  case 3 :
	    $isi = GetAlumniKerja($dat);
		break;
	endswitch;
	DisplayTab($arr, $tab, $isi, 'sysfo.php', "syxec=alumnidetil&nim=$nim");
  }
  function GetAlumniPribadi($dat) {
    $optagm = GetOption2('agama', 'Agama', 'AgamaID', $dat['AgamaID'], '', 'AgamaID');
    return <<<EOF
	<br><table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='alumnidetil'>
	  <input type=hidden name='nim' value='$dat[NIM]'>
	<tr><th class=ttl colspan=2>Data Pribadi Alumni</th></tr>
	<tr><td class=uline>Tempat Lahir</td><td class=uline>: $dat[TempatLahir]</td></tr>
	<tr><td class=uline>Tanggal Lahir</td><td class=uline>: $dat[tgl]</td></tr>
	<tr><td class=uline>Jenis Kelamin</td><td class=uline>: $dat[Sex]</td></tr>
	<tr><td class=uline>Agama</td><td class=uline>: <select name='AgamaID'>$optagm</select></td></tr>
	<tr><td class=uline rowspan=2>Alamat</td><td class=uline>: <input type=text name='Alamat1' value='$dat[Alamat1]' size=40 maxlength=100></td></tr>
	<tr><td class=uline>: <input type=text name='Alamat2' value='$dat[Alamat2]' size=40 maxlength=100></td></tr>
	<tr><td class=uline>RT - RW</td><td class=uline>: <input type=text name='RT' value='$dat[RT]' size=8 maxlength=4>&nbsp;<input type=text name='RW' value='$dat[RW]' size=8 maxlength=4></td></tr>
	<tr><td class=uline>Kota - Kode Pos</td><td class=uline>: <input type=text name='Kota' value='$dat[Kota]' size=20 maxlength=50>&nbsp;<input type=text name='KodePos' value='$dat[KodePos]' size=10 maxlength=10></td></tr>
	<tr><td class=uline>Telepon</td><td class=uline>: <input type=text name='Phone' value='$dat[Phone]' size=30 maxlength=30></td></tr>
	<tr><td class=uline>E-mail</td><td class=uline>: <input type=text name='Email' value='$dat[Email]' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Kewarganegaraan</td><td class=uline>: <input type=text name='WargaNegara' value='$dat[WargaNegara]' size=30 maxlength=30></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcpri' value='Simpan'>&nbsp;<input type=reset name=reset value='reset'></td></tr>
	</form></table><br>
EOF;
  }
  function PrcPribadiAlumni() {
    $nim = $_REQUEST['nim'];
	$AgamaID = $_REQUEST['AgamaID'];
	$Alamat1 = FixQuotes($_REQUEST['Alamat1']);
	$Alamat2 = FixQuotes($_REQUEST['Alamat2']);
	$RT = FixQuotes($_REQUEST['RT']); $RW = FixQuotes($_REQUEST['RW']);
	$Kota = FixQuotes($_REQUEST['Kota']); $KodePos = FixQuotes($_REQUEST['KodePos']);
	$Phone = FixQuotes($_REQUEST['Phone']); $Email = FixQuotes($_REQUEST['Email']);
	$WargaNegara = FixQuotes($_REQUEST['WargaNegara']);
	$s = "update alumni set AgamaID='$AgamaID', Alamat1='$Alamat1', Alamat2='$Alamat2',
	  RT='$RT', RW='$RW', Kota='$Kota', KodePos='$KodePos', Phone='$Phone', Email='$Email',
	  WargaNegara='$WargaNegara'
	  where NIM='$nim' ";
	$r = mysql_query($s) or die("Error SQL: $s.<br>".mysql_error());
  }
  function GetAlumniOrtu($dat) {
    return <<<EOF
	<br><table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='alumnidetil'>
	<input type=hidden name='nim' value='$dat[NIM]'>
	<tr><th class=ttl colspan=2>Data Orang Tua Alumni</td></tr>
	<tr><td class=uline>Nama Orang Tua</td><td class=uline>: <input type=text name='NamaOT' value='$dat[NamaOT]' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Pekerjaan</td><td class=uline>: <input type=text name='PekerjaanOT' value='$dat[PekerjaanOT]' size=40 maxlength=50></td></tr>
	<tr><td class=uline rowspan=2>Alamat</td><td class=uline>: <input type=text name='AlamatOT1' value='$dat[AlamatOT1]' size=40 maxlength=100</td></tr>
	<tr><td class=uline>: <input type=text name='AlamatOT2' value='$dat[AlamatOT2]' size=40 maxlength=50></td></tr>
	<tr><td class=uline>RT - RW</td><td class=uline>: <input type=text name='RTOT' value='$dat[RTOT]' size=8 maxlength=4>&nbsp;<input type=text name='RWOT' value='$dat[RWOT]' size=8 maxlength=4></td></tr>
	<tr><td class=uline>Kota - Kode Pos</td><td class=uline>: <input type=text name='KotaOT' value='$dat[KotaOT]' size=20 maxlength=50>&nbsp;<input type=text name='KodePosOT' value='$dat[KodePosOT]' size=10 maxlength=10></td></tr>
	<tr><td class=uline>Telepon</td><td class=uline>: <input type=text name='TelpOT' value='$dat[TelpOT]' size=30 maxlength=30></td></tr>
	<tr><td class=uline>E-mail</td><td class=uline>: <input type=text name='EmailOT' value='$dat[EmailOT]' size=40 maxlength=50></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcot' value='Simpan'>&nbsp;<input type=reset name=reset value='reset'></td></tr>
	</form></table><br>
EOF;
  }
  function PrcOTAlumni() {
    $nim = $_REQUEST['nim'];
	$NamaOT = FixQuotes($_REQUEST['NamaOT']);
	$PekerjaanOT = FixQuotes($_REQUEST['PekerjaanOT']);
	$AlamatOT1 = FixQuotes($_REQUEST['AlamatOT1']);
	$AlamatOT2 = FixQuotes($_REQUEST['AlamatOT2']);
	$RTOT = FixQuotes($_REQUEST['RTOT']); $RWOT = FixQuotes($_REQUEST['RWOT']);
	$KotaOT = FixQuotes($_REQUEST['KotaOT']); $KodePosOT = FixQuotes($_REQUEST['KodePosOT']);
	$TelpOT = FixQuotes($_REQUEST['TelpOT']); $EmailOT = FixQuotes($_REQUEST['EmailOT']);
	$s = "update alumni set NamaOT='$NamaOT', PekerjaanOT='$PekerjaanOT',
	  AlamatOT1='$AlamatOT1', AlamatOT2='$AlamatOT2', RTOT='$RTOT', RWOT='$RWOT',
	  KotaOT='$KotaOT', KodePosOT='$KodePosOT', TelpOT='$TelpOT', EmailOT='$EmailOT'
	  where NIM='$nim' ";
	$r = mysql_query($s) or die("Error Query: $s.<br>".mysql_error());
  }
  function GetAlumniAkademik($dat) {
    $strfak = GetaField('fakultas', 'Kode', $dat['KodeFakultas'], 'Nama_Indonesia');
	$arrjur = GetFields('jurusan', 'Kode', $dat['KodeJurusan'], 'Nama_Indonesia, Jenjang');
	$strprg = GetaField('program', 'Kode', $dat['KodeProgram'], 'Nama_Indonesia');
	$strjen = GetaField('jenjangps', 'Kode', $arrjur['Jenjang'], 'Nama');
	$strsam = GetaField('statusawalmhsw', 'Kode', $dat['StatusAwal'], 'Nama');
	$strpot = GetaField('statuspotongan', 'Kode', $dat['StatusPotongan'], 'Nama');
	$strdsn = GetaField('dosen', 'ID', $dat['DosenID'], "concat(Name, ', ', Gelar)");
    return <<<EOF
	<br><table class=basic cellspacing=0 cellpadding=2>
	<tr><th class=ttl colspan=2>Data Akademik Alumni</th></tr>
	<tr><td class=uline>Tahun Akademik</td><td class=uline>: $dat[TahunAkademik]</td></tr>
	<tr><td class=uline>Fakultas</td><td class=uline>: $dat[KodeFakultas] - $strfak</td></tr>
	<tr><td class=uline>Jurusan</td><td class=uline>: $dat[KodeJurusan] - $arrjur[Nama_Indonesia]</td></tr>
	<tr><td class=uline>Program</td><td class=uline>: $dat[KodeProgram] - $strprg</td></tr>
	<tr><td class=uline>Jenjang Pendidikan</td><td class=uline>: $strjen</td></tr>
	<tr><td class=uline>Status Awal Mahasiswa</td><td class=uline>: $strsam</td></tr>
	<tr><td class=uline>Status Potongan</td><td class=uline>: $strpot</td></tr>
	<tr><td class=uline>Kode Biaya</td><td class=uline>: $dat[KodeBiaya]</td></tr>
	<tr><td class=uline>Dosen Pembimbing Akademik</td><td class=uline>: $strdsn</td></tr>
	<tr><td class=uline>Tanggal Lulus</td><td class=uline>: $dat[strTglLulus]</td></tr>
	<tr><td class=uline>Judul TA</td><td class=uline>: $dat[JudulTA]</td></tr>
	<tr><td class=uline>IPK</td><td class=uline>: <b>$dat[IPK]</td></tr>
	</table><br>
EOF;
  }
  function GetAlumniKerja($dat) {
    $selky = ''; $selkn = '';
	if ($dat['SudahBekerja'] == 'Y') $selky = 'checked'; else $selkn = 'checked';
    return <<<EOF
	<br><table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='alumnidetil'>
	<input type=hidden name='nim' value='$dat[NIM]'>
	<tr><th class=ttl colspan=2>Pekerjaan Alumni</th></tr>
	<tr><td class=uline>Sudah Bekerja?</td><td class=uline><input type=radio name='SudahBekerja' value='Y' $selky>Sudah &nbsp;
	  <input type=radio name='SudahBekerja' value='N' $selkn>Belum</td></tr>
	<tr><td class=uline>Nama Perusahaan</td><td class=uline><input type=text name='NamaPrsh' value='$dat[NamaPrsh]' size=40 maxlength=50></td></tr>
	<tr><td class=uline rowspan=2>Alamat</td><td class=uline><input type=text name='Alamat1Prsh' value='$dat[Alamat1Prsh]' size=40 maxlength=100></td></tr>
	  <tr><td class=uline><input type=text name='Alamat2Prsh' value='$dat[Alamat2Prsh]' size=40 maxlength=100></td></tr>
	<tr><td class=uline>Kota</td><td class=uline><input type=text name='KotaPrsh' value='$dat[KotaPrsh]' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Telepon</td><td class=uline><input type=text name='TelpPrsh' value='$dat[TelpPrsh]' size=30 maxlength=20></td></tr>
	<tr><td class=uline>Facsimile</td><td class=uline><input type=text name='FaxPrsh' value='$dat[FaxPrsh]' size=30 maxlength=20></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prckrj' value='Simpan'>&nbsp;
	  <input type=reset name='Reset' value='Reset'></td></tr>
	</form></table><br>
EOF;
  }
  function PrcKerjaAlumni() {
    $nim = $_REQUEST['nim'];
	if (isset($_REQUEST['SudahBekerja'])) $SudahBekerja = $_REQUEST['SudahBekerja']; else $SudahBekerja = 'N';
	$NamaPrsh = FixQuotes($_REQUEST['NamaPrsh']);
	$Alamat1Prsh = FixQuotes($_REQUEST['Alamat1Prsh']);
	$Alamat2Prsh = FixQuotes($_REQUEST['Alamat2Prsh']);
	$KotaPrsh = FixQuotes($_REQUEST['KotaPrsh']);
	$TelpPrsh = FixQuotes($_REQUEST['TelpPrsh']);
	$FaxPrsh = FixQuotes($_REQUEST['FaxPrsh']);
	$s = "update alumni set SudahBekerja='$SudahBekerja', NamaPrsh='$NamaPrsh',
	  Alamat1Prsh='$Alamat1Prsh', Alamat2Prsh='$Alamat2Prsh', KotaPrsh='$KotaPrsh',
	  TelpPrsh='$TelpPrsh', FaxPrsh='$FaxPrsh' where NIM='$nim'	";
	$r = mysql_query($s) or die("Error Query: $s.<br>".mysql_error());
  }
  
  // *** Parameter2 ***
  $tab = GetSetVar('tab'); if (empty($tab)) $tab = 0; if ($tab > 3) $tab = 3;
  $nim = GetSetVar('nim');
  if (isset($_REQUEST['prcpri'])) PrcPribadiAlumni();
  if (isset($_REQUEST['prcot'])) PrcOTAlumni();
  if (isset($_REQUEST['prckrj'])) PrcKerjaAlumni();
  
  // *** Bagian Utama ***
  //DisplayHeader($fmtPageTitle, 'Detil Alumni');
  if (isset($nim)) DispDetilAlumni($nim, $tab);
  else DisplayHeader($fmtErrorMsg, 'Terjadi kesalahan dalam mengakses data detail alumni.');

?>