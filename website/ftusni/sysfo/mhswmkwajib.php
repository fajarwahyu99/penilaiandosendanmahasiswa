<?php
  // Author : E. Setio Dewo, setio_dewo@sisfokampus.net, 24 Desember 2003
  
  // *** Fungsi2 ***
  function DispDaftarMKWajib($nim) {
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$kurid = GetLastKur($kdj);
	$nmr = 0;
	$s = "select mk.*
	  from matakuliah mk
	  where mk.KurikulumID=$kurid and mk.Wajib='Y'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=4>Mata Kuliah Wajib</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>Kode MK</th>
	  <th class=ttl>Mata Kuliah</th><th class=ttl>Sudah?</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  $ada = GetaField('krs', "NIM='$nim' and KodeMK", $w['Kode'], 'KodeMK');
	  if (empty($ada)) {
		$cls = "class=lst";
		$img = "<img src='image/N.gif' border=0>";
	  }
	  else {
		$cls = "class=nac";
		$img = "<img src='image/Y.gif' border=0>";
	  }
	  echo <<<EOF
	  <tr><td class=ttl>$nmr</td>
	  <td $cls>$w[Kode]</td>
	  <td $cls>$w[Nama_Indonesia]</td>
	  <td $cls align=center>$img</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<tr><th class=ttl>Sudah?</th><th class=ttl>Keterangan</th></tr>
	<tr><td class=uline align=center><img src='image/Y.gif'></td><td class=uline>Sudah diambil</td></tr>
	<tr><td class=uline align=center><img src='image/N.gif'></td><td class=uline>Belum diambil</td></tr>
	</table>
EOF;
  }
  
  // *** Parameter2 ***
  $nim = GetSetVar('nim');
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Mata Kuliah Wajib Mahasiswa');
  DispNIMMhsw($nim, 'mhswmkwajib');
  DispDaftarMKWajib($nim);
?>