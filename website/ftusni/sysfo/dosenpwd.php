<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Oktober 2003
  
  // *** Fungsi2 ***
function DispDaftarJurusanDosenPwd() {
  $s = "select j.*, jp.Nama as JEN
    from jurusan j left outer join jenjangps jp on j.Jenjang=jp.Kode
	  order by j.Kode";
	$r = mysql_query($s) or die(mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Kode</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Jenjang</th><th class=ttl>Tahun</th><th class=ttl colspan=2>Proses</th>
	  </tr>";
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  if ($w['NotActive'] == 'Y') {
	    $cls = 'class=nac'; 
		$thn = '&nbsp;';
		$prc = '&nbsp;';
	  }
	  else {
	    $cls = 'class=lst';
		$thn = "$w[Tahun]";
		if ($w['PasswordNilai'] == 'Y') {
		  $prc = '&nbsp;';
		  $prn = "<a href='sysfo.php?syxec=dosenpwd&kdj=$w[Kode]&thn=$w[Tahun]&prn=1'><img src='image/printer.gif' border=0 height=16 title='Cetak Password'></a>";
		}
		else {
		  $prc = "<a href='sysfo.php?syxec=dosenpwd&kdj=$w[Kode]&thn=$w[Tahun]&prc=1'><img src='image/gear.gif' border=0 height=16 title='Proses Password'></a>";
		  $prn = '&nbsp;';
		}
	  }
	  echo <<<EOF
	  <tr><td class=ttl>$cnt</td>
	  <td $cls>$w[Kode]</td><td $cls>$w[JEN]</td>
	  <td $cls>$w[Nama_Indonesia]</td><td $cls>$thn</td>
	  <td $cls align=center>$prc</td><td $cls align=center>$prn</td>
	  </tr>
EOF;
	}
	echo "</table>";
}
function PrcDosenPwd($kdj, $thn) {
  $s = "select IDDosen, KodeMK from jadwal where KodeJurusan='$kdj' and Tahun='$thn' and PasswordNilai=NULL group by IDDosen";
	$r = mysql_query($s) or die(mysql_error());
	while ($w = mysql_fetch_array($r)) {
	  $crypt = crypt($w['KodeMK'], $w['IDDosen']);
	  mysql_query("update jadwal set PasswordNilai='$crypt' where KodeJurusan='$kdj' and Tahun='$thn' and IDDosen='$w[IDDosen]'") or die(mysql_error());
	}
	mysql_query("update jurusan set PasswordNilai='Y' where Kode='$kdj'");
}
function PrnDosenPwd($kdj, $thn) {
  $nr = "\n";
  $s = "select j.ID, d.Login, d. Name, j.PasswordNilai, j.IDDosen,
	  concat(d.Name, ', ', d.Gelar) as DSN,
	  concat(ju.Nama_Indonesia, ' (' , jp.Nama, ')') as JUR
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join jurusan ju on j.KodeJurusan=ju.Kode
	  left outer join jenjangps jp on ju.Jenjang=jp.Kode
	  where j.KodeJurusan='$kdj' and j.Tahun='$thn'
	  group by j.IDDosen";
	$r = mysql_query($s) or die(mysql_error());
	
	$targ = "sysfo/temp/PWD.$kdj.$thn.nil";
	if (file_exists($targ)) unlink($targ);
	$f = fopen($targ, "w");
	fwrite($f, chr(15));
	$cnt = 0; $urt = 0; $hal = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++; $urt++;
	  if ($cnt == 9) $cnt = 1;
	  if ($cnt == 1) {
	    $hal++;
		//if ($hal > 1) fwrite($f, chr(EJECT));
	    $str = str_pad('RAHASIA', 40, ' ') . "Hal: " . str_pad($hal, 2, '0', STR_PAD_LEFT) . str_pad('', 13, ' ');
	    fwrite($f, $str . $str . $nr);
		$str = str_pad('DAFTAR PASSWORD DOSEN', 40, ' ', STR_PAD_BOTH) . 'Tgl: ' . str_pad(date('d-m-Y'), 15, ' ');
		fwrite($f, $str . $str . $nr);
		$str = 'Program : ' . str_pad($w['JUR'], 50, ' ');
		fwrite($f, $str . $str . $nr);
		fwrite($f, str_pad('Lembar untuk Dosen Pengajar', 60, ' ') . str_pad('Lembar Arsip untuk Sekretaris Program', 60, ' ') . $nr . $nr);
		
		//fwrite($f, str_pad('', 120, '0123456789'). $nr);
		fwrite($f, str_pad('-', 120, '-'). $nr);
	  }
	  $str = '   Urt: ' . str_pad($urt, 2, '0', STR_PAD_LEFT) . str_pad('', 50, ' ');
	  fwrite($f, $str . $str . $nr);
	  $str = '   Kode Dosen : ' . str_pad($w['Login'], 44, ' ');
	  fwrite($f, $str . $str . $nr);
	  $str = '   Nama Dosen : ' . str_pad($w['DSN'], 44, ' ');
	  fwrite($f, $str . $str . $nr);
	  $str = '   Password   : ' . str_pad($w['PasswordNilai'], 44, ' ');
	  fwrite($f, $str . $str . $nr . $nr);
	  fwrite($f, str_pad('', 120, '-') . $nr);
	}
	
	fclose($f);
	echo <<<EOF
	<script language=JavaScript>
	<!--
	  wnd = window.open("dl.php?fl=$targ");
	-->
	</script>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) $kdj = $_REQUEST['kdj']; else $kdj = '';
  if (isset($_REQUEST['thn'])) $thn = $_REQUEST['thn']; else $thn = '';
  if (isset($_REQUEST['prc'])) PrcDosenPwd($kdj, $thn);
  if (isset($_REQUEST['prn'])) PrnDosenPwd($kdj, $thn);
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Set Password Dosen untuk File Nilai");
  DispDaftarJurusanDosenPwd();


?>