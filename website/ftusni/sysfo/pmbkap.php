<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  function GetJur($def='') {
    $str = GetaField('jurusan', 'Kode', $def, 'Nama_Indonesia');
    $opt = GetOption('jurusan', 'concat(Kode, " -- ", Nama_Indonesia)', 
	  'Kode', "$def -- $str", '', 'Kode');
	echo <<<EOF
	  <form name='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='pmbkap'>
	  Jurusan: <select name='kdj' onChange='this.form.submit()'>$opt</select>
	  </form>
EOF;
  }
  function DispKapForm($kdj) {
    global $strCantQuery;
    $s = "select * from jurusan where Kode='$kdj'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$TargetMhs = mysql_result($r, 0, 'TargetMhs');
	$Pendaftar = mysql_result($r, 0, 'Pendaftar');
	$LulusSeleksi = mysql_result($r, 0, 'LulusSeleksi');
	$PendaftarMhs = mysql_result($r, 0, 'PendaftarMhs');
	$PendaftarMundur = mysql_result($r, 0, 'PendaftarMundur');
	$MhsPindahan = mysql_result($r, 0, 'MhsPindahan');
	echo <<<EOF
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='pmbkap'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>Kapasitas Penerimaan Mahasiswa</th></tr>
	  <tr><td class=lst>Kode Jurusan</td><td class=lst>$kdj</td></tr>
	  <tr><td class=lst>Target Mhs Baru</td><td class=lst><input type=text name='TargetMhs' value='$TargetMhs' size=4 maxlength=5></td></tr>
	  <tr><td class=lst>Jumlah Pendaftar</td><td class=lst><input type=text name='Pendaftar' value='$Pendaftar' size=4 maxlength=5></td></tr>
	  <tr><td class=lst>Jumlah Lulus Seleksi</td><td class=lst><input type=text name='LulusSeleksi' value='$LulusSeleksi' size=4 maxlength=5></td></tr>
	  <tr><td class=lst>Jumlah Pendaftar yg Menjadi Mhs</td><td class=lst><input type=text name='PendaftarMhs' value='$PendaftarMhs' size=4 maxlength=5></td></tr>
	  <tr><td class=lst>Jml Pendaftar yg Mengundurkan Diri</td><td class=lst><input type=text name='PendaftarMundur' value='$PendaftarMundur' size=4 maxlength=5></td></tr>
	  <tr><td class=lst>Jumlah Mahasiswa Pindahan</td><td class=lst><input type=text name='MhsPindahan' value='$MhsPindahan' size=4 maxlength=5></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prc' value='Simpan'>
	    <input type=reset name='reset' value='Reset'></td></tr>
	  </table></form>
EOF;
  }
  function PrcKap() {
    global $strCantQuery;
    $kdj = $_REQUEST['kdj'];
	$TargetMhs = $_REQUEST['TargetMhs'];
	$Pendaftar = $_REQUEST['Pendaftar'];
	$LulusSeleksi = $_REQUEST['LulusSeleksi'];
	$PendaftarMhs = $_REQUEST['PendaftarMhs'];
	$PendaftarMundur = $_REQUEST['PendaftarMundur'];
	$MhsPindahan = $_REQUEST['MhsPindahan'];
	$s = "update jurusan set TargetMhs=$TargetMhs, Pendaftar=$Pendaftar, LulusSeleksi=$LulusSeleksi,
	  PendaftarMhs=$PendaftarMhs, PendaftarMundur=$PendaftarMundur, MhsPindahan=$MhsPindahan
	  where Kode='$kdj'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Kapasistas Penerimaan Mahasiswa');
  
  if (isset($_REQUEST['kdj'])) $kdj = $_REQUEST['kdj']; else $kdj = '';
  if (isset($_REQUEST['prc'])) PrcKap();
  GetJur($kdj);
  if (!empty($kdj)) DispKapForm($kdj);

?>