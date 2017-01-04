<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // *** Fungsi2 ***
  function DispSblmCetakIjazah($nim) {
    $adat = GetFields("mhsw m 
	  left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join jurusan j on m.KodeJurusan=j.Kode", 
	  'NIM', $nim, "m.Name, j.Nama_Indonesia as JUR, f.Nama_Indonesia as FAK,
	  j.IjazahNomer, j.IjazahAkreditasi, j.Gelar, j.IjazahTemplate,
	  m.TA, m.TglLulus as tgl, 
	  m.TotalSKS, m.IPK, m.JudulTA, m.CatatanTA, m.Lulus, m.NomerIjazah");
	if ($adat['Lulus'] == 'Y') {
	  $cetak = "<input type=hidden name='ctk' value=1><input type=submit name='prcijz' value='Cetak Ijazah'>&nbsp;";
	}
	else {
	  $cetak = "";
	}
	if (empty($adat['tgl'])) $adat['tgl'] = date('Y-m-d');
	$tgl = explode('-', $adat['tgl']);
	if (empty($adat['NomerIjazah'])) $adat['NomerIjazah'] = $adat['IjazahNomer'];
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='cetakijazah'>
	  <input type=hidden name='nim' value='$nim'>
	  <tr><th class=ttl colspan=2>Setup Ijazah</th></tr>
	  <tr><td class=lst>Nama Mahasiswa</td><td class=lst>$adat[Name]</td></tr>
	  <tr><td class=lst>Fakultas</td><td class=lst>$adat[FAK]</td></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst>$adat[JUR]</td></tr>
	  <tr><td class=lst>Gelar</td><td class=lst>$adat[Gelar]</td></tr>
	  <tr><td class=lst>Nomer Ijazah</td><td class=lst><input type=text name='NIJ' value='$adat[NomerIjazah]' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Tanggal Lulus</td><td class=lst><input type=text name='tgl_d' value='$tgl[2]' size=2 maxlength=2>&nbsp;
	  <input type=text name='tgl_m' value='$tgl[1]' size=2 maxlength=2>&nbsp;
	  <input type=text name='tgl_y' value='$tgl[0]' size=4 maxlength=4>&nbsp;dd-mm-yyyy</td></tr>
	  <tr><td class=lst>Status Akreditasi</td><td class=lst>$adat[IjazahAkreditasi]</td></tr>
	  <tr><td class=lst colspan=2>$cetak
	  <input type=submit name='prcijz' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'></td></tr>
	  </form></table>
EOF;
  }
  function PrcSetupIjazah() {
    global $fmtErrorMsg;
    $nim = $_REQUEST['nim'];
	$NIJ = $_REQUEST['NIJ'];
	$tgl_d = $_REQUEST['tgl_d'];
	$tgl_m = $_REQUEST['tgl_m'];
	$tgl_y = $_REQUEST['tgl_y'];
	mysql_query("update mhsw set NomerIjazah='$NIJ', TglLulus='$tgl_y-$tgl_m-$tgl_d'
	  where NIM='$nim'");
	if (isset($_REQUEST['ctk'])) {
      $adat = GetFields("mhsw m 
	  left outer join fakultas f on m.KodeFakultas=f.Kode
	  left outer join jurusan j on m.KodeJurusan=j.Kode", 
	  'NIM', $nim, "m.Name, j.Nama_Indonesia as JUR, f.Nama_Indonesia as FAK,
	  j.IjazahNomer, j.IjazahAkreditasi, j.Gelar, j.IjazahTemplate,
	  j.Jabatan1, j.Jabatan2, j.Pejabat1, j.Pejabat2,
	  m.TempatLahir, date_format(TglLahir, '%d %M %Y') as TglLahir,
	  m.TA, m.TglLulus as tgl, date_format(TglLulus, '%d %M %Y') as TglLulus,
	  m.TotalSKS, m.IPK, m.JudulTA, m.CatatanTA, m.Lulus, m.NomerIjazah");
	  $tmpl = "sysfo/$adat[IjazahTemplate]";
	  if (file_exists($tmpl)) {
		$targ = "sysfo/temp/$nim.ijz.rtf";
		if (file_exists($targ)) unlink($targ);
		// baca isi
		$f = fopen($tmpl, "r");
		$isi = fread($f, filesize($tmpl));
		fclose($f);
		$isi = str_replace('=IjazahNomer=', $adat['NomerIjazah'], $isi);
		$isi = str_replace('=IjazahAkreditasi=', $adat['IjazahAkreditasi'], $isi);
		$isi = str_replace('=Name=', $adat['Name'], $isi);
		$isi = str_replace('=NIM=', $nim, $isi);
		$isi = str_replace('=Jurusan=', $adat['JUR'], $isi);
		$isi = str_replace('=Gelar=', $adat['Gelar'], $isi);
		$isi = str_replace('=TglLahir=', $adat['TglLahir'], $isi);
		$isi = str_replace('=TempatLahir=', $adat['TempatLahir'], $isi);
		$isi = str_replace('=TglLulus=', $adat['TglLulus'], $isi);
		$isi = str_replace('=Jabatan1=', $adat['Jabatan1'], $isi);
		$isi = str_replace('=Jabatan2=', $adat['Jabatan2'], $isi);
		$isi = str_replace('=Pejabat1=', $adat['Pejabat1'], $isi);
		$isi = str_replace('=Pejabat2=', $adat['Pejabat2'], $isi);
		// tulis
		$f = fopen($targ, "w");
		fwrite($f, $isi);
		fclose($f);
		echo <<<EOF
		<SCRIPT LANGUAGE=JavaScript>
		<!---
		  window.open("$targ");
		-->
		</SCRIPT>
EOF;
	  }
	  else DisplayHeader($fmtErrorMsg, "File template ijazah <font color=red>$tmpl</font> tidak ditemukan.");
	}
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['nim'])) $nim = $_REQUEST['nim']; else $nim = '';
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Cetak Ijazah");
  if ($prn == 0 && $_SESSION['ulevel'] < 3) {
    DispNIMMhsw($nim, 'cetakijazah');
  }
  if (ValidNIM($nim)) {
    if (isset($_REQUEST['prcijz'])) PrcSetupIjazah();
    DispSblmCetakIjazah($nim);
  }
  else 
    if (!empty($nim)) DisplayHeader($fmtErrorMsg, "Mahasiswa dengan NIM <b>$nim</b> tidak ditemukan.");
?>