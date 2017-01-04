<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003
  
  // *** Fungsi2 ***
  function CetakSuratMengajar($thn, $did) {
    global $strCantQuery;
	$s = "select j.*, h.Nama as HAR, concat(d.Name, ', ', d.Gelar) as DSN,
	  TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js
	  from jadwal j left outer join hari h on j.Hari=h.ID
	  left outer join dosen d on j.IDDosen=d.ID
	  where j.IDDosen=$did and j.Tahun='$thn' order by j.NamaMK";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	// Cetak header
	$no = mysql_result($r, 0, 'NoSurat');
	$dsn = mysql_result($r, 0, 'DSN');
	$kdj = mysql_result($r, 0, 'KodeJurusan');
	$nmthn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, 'Nama');
	echo "<p align=center><b>SURAT KEPUTUSAN<br>
	  KETUA SEKOLAH TINGGI ILMU EKONOMI SUPRA<br>
	  No.: $no<br></b></p>
	  
	  <p>Ketua Universitas Satya Negara Indonesia menugaskan Bapak/Ibu:</p>
	  <p align=center><b><u>$dsn</u></b></p>
	  <p>Untuk memberikan perkuliahan pada $nmthn sesuai dengan mata kuliah dan jadwal sebagai berikut:</p> ";
	$cnt = 0;
	echo "<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><th class=ttl>No.</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
	<th class=ttl>Kampus</th><th class=ttl>Hari</th><th class=ttl>Jam</th></tr>";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  echo <<<EOF
	  <tr><td class=lst>$cnt</td><td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[KodeKampus]</td><td class=lst>$w[HAR]</td><td class=lst>$w[jm] - $w[js]</td></tr>
EOF;
	}
	echo "</table>";
	$tgl = date('d M Y');
	echo "<p>Kepada yang bersangkutan diberikan kewenangan mengajak serta hak dan kewajiban lain yang
	sesuai dengan ketentuan yang berlaku.</p>
	
	<p>Ditetapkan di Jakarta<br>
	Pada tanggal $tgl<br>
	Universitas Satya Negara Indonesia<p><br>
	
	<p><u>Dr. Yos E. Susanto, Ph.D</u><br>
	Ketua</p>
	";
  }
  
  // *** Parameter2 ***
  $thn = $_REQUEST['thn'];
  $did = $_REQUEST['did'];
  
  // *** Bagian Utama ***
  CetakSuratMengajar($thn, $did);


?>