<?php
  // Author: E Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003

  // *** Fungsi2 ***
  function DispAlumniStat() {
    $s = "select j.*, je.Nama as JEN from jurusan j left outer join jenjangps je on j.Jenjang=je.Kode order by j.Kode";
	$r = mysql_query($s) or die("Error Query: $s<br>".mysql_error());
	$nmr = 0; $_tot = 0; $_sdh = 0; $_blm = 0;
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><th class=ttl rowspan=2>#</th>
	<th class=ttl rowspan=2 colspan=2>Jurusan</th>
	<th class=ttl rowspan=2>Jenjang</th><th class=ttl rowspan=2>Total<br>Lulusan</th>
	<th class=ttl colspan=2>Bekerja</th><th class=ttl rowspan=2>Rata2<br>IPK</td></tr>
	<tr><th class=ttl>Sudah</th><th class=ttl>Belum</th></tr>
EOF;
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  $tot = GetaField("alumni", "KodeJurusan", $w['Kode'], "count(NIM)");
	  $sdh = GetaField("alumni", "SudahBekerja='Y' and KodeJurusan", $w['Kode'], "count(NIM)");
	  $blm = GetaField("alumni", "SudahBekerja='N' and KodeJurusan", $w['Kode'], "count(NIM)");
	  $ipk = GetaField("alumni", "KodeJurusan", $w['Kode'], "sum(IPK)/$tot");
	  $ipk = number_format($ipk, 2, ',', '.');
	  $_tot += $tot;
	  $_sdh += $sdh;
	  $_blm += $blm;
	  echo <<<EOF
	  <tr><td class=nac>$nmr</td>
	  <td class=lst>$w[Kode]</td><td class=lst>$w[Nama_Indonesia]</td><td class=lst>$w[JEN]</td>
	  <td class=lst align=right>$tot</td><td class=lst align=right>$sdh</td><td class=lst align=right>$blm</td>
	  <td class=lst align=right>$ipk</td>
	  </tr>
EOF;
	}
	if ($_tot == 0) {
		$_psdh = 0; 
		$_pblm = 0;
	}
	else {
		$_psdh = $_sdh / $_tot * 100;
		$_pblm = $_blm / $_tot * 100;
	}
	echo <<<EOF
	  <tr><td colspan=4 align=right>Total:&nbsp;</td><td class=ttl align=right>$_tot</td>
	  <td class=ttl align=right>$_sdh</td><td class=ttl align=right>$_blm</td></tr>
	  <tr><td colspan=5 align=right>Persentase:</td><td class=ttl align=right>$_psdh%</td>
	  <td class=ttl align=right>$_pblm%</td></tr>
	  </table>
EOF;
  }
  
  // *** Parameter2 ***
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Statistik Alumni yg Sudah Bekerja');
  DispAlumniStat();

?>