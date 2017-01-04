<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  
  // *** Fungsi2 ***
function DispMhswKHS($thn, $nim) {
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$strsesi = GetaField('jurusan', 'Kode', $kdj, 'Sesi');
  $s = "select k.*, date_format(TglRegistrasi, '%d %M %Y') as TGL,
	  sm.Nama as STA
	  from khs k left outer join statusmhsw sm on k.Status=sm.Kode
	  where k.NIM='$nim' order by k.Sesi";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<tr><th class=ttl>$strsesi</th><th class=ttl>Tahun</th><th class=ttl>Status</th>
	<th class=ttl># Registrasi</th><th class=ttl>Tgl Reg.</th><th class=ttl>Registrasi</th></tr>
EOF;
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Registrasi'] == 'Y') {
	    $cls = 'class=nac';
		  $tglreg = $w['TGL'];
		  $nmrreg = $w['ID'];
		  $strreg = "<img src='image/Y.gif' border=0 title='OKE'>";
	  }
	  else {
	    $cls = 'class=lst';
		  $tglreg = '&nbsp;';
		  $nmrreg = '&nbsp;';
		  $strreg = "<a href='sysfo.php?syxec=mhswherreg&prcreg=1&nim=$nim&thn=$w[Tahun]' title='Registrasi Ulang'><img src='image/check.gif' border=0></a>";
	  }
	  echo <<<EOF
	  <tr><td $cls>$w[Sesi]</td><td $cls>$w[Tahun]</td><td $cls>$w[STA]</th>
	  <td  $cls>$nmrreg</td><td $cls>$tglreg</td><td class=lst align=center>$strreg</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
function DispConfirmReg($thn, $nim) {
    global $fmtMessage;
	$snm = session_name(); $sid = session_id();
	$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'NIM,Name,KodeJurusan');
	DisplayDetail($fmtMessage, "Konfirmasi Registrasi Ulang",
	  "Hallo <b>$arrmhsw[Name] - $arrmhsw[NIM]</b>.<br>
	  Anda akan melakukan Registrasi Ulang untuk tahun ajaran <b>$thn</b>.<br>
	  Setelah melakukan Registrasi Ulang, status Anda akan menjadi <b>AKTIF</b>.<br>
	  Dengan status AKTIF, Anda dapat mengisi, mengubah atau menghapus KRS pada tahun ajaran yang AKTIF.<hr>
	  Pilihan: <a href='sysfo.php?syxec=mhswherreg&$snm=$sid&prcrege=1&nim=$nim&thn=$thn'>Registrasi Ulang</a> |
	  <a href='sysfo.php?syxec=mhswherreg&thn=$thn&nim=$nim'>Batalkan</a>");
}
function PrcRegistrasiMhsw($thn, $nim) {
  global $fmtMessage;
	$s = "update khs set Status='A', Registrasi='Y', TglRegistrasi=now() where Tahun='$thn' and NIM='$nim'";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'NIM,Name,KodeJurusan');
	DisplayDetail($fmtMessage, 'Registrasi Ulang Berhasil', 
	  "Hallo <b>$arrmhsw[Name] - $nim</b>, proses Registrasi Ulang telah berhasil.<br>
	  Status Anda telah <b>AKTIF</b>. Anda dapat mulai untuk mengisi KRS.<hr>
	  <b>Selamat Belajar</b>");
}
  
  // *** Parameter2 ***
  $nim = GetSetVar('nim');
  $thn = GetSetVar('thn');
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Registrasi Ulang Mahasiswa');
  if (strpos('14', $_SESSION['ulevel']) === false) die($strNotAuthorized.' #1');
  if ($_SESSION['ulevel'] == 4) $nim = $_SESSION['unip'];
  $valid = GetMhsw($thn, $nim, 'mhswherreg');
  if ($valid) {
    if (isset($_REQUEST['prcrege'])) PrcRegistrasiMhsw($thn, $nim);
    if (isset($_REQUEST['prcreg'])) DispConfirmReg($thn, $nim);
	else DispMhswKHS($thn, $nim);
  }
?>