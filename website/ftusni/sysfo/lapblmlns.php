<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** Fungsi2 ***
function LapBlmLns($kdj='') {
  global $strCantQuery;
  if (empty($kdj)) $strkdj = '';
	else $strkdj = "and m.KodeJurusan='$kdj'";
	
	$s = "select k.*, (k.Biaya+k.Potong-k.Bayar+k.Tarik) as KRG, m.KodeJurusan, m.Name, st.Nama as STA
	  from khs k left outer join mhsw m on k.NIM=m.NIM
	  left outer join statusmhsw st on k.Status=st.Kode
	  where (k.Biaya+k.Potong-k.Bayar+k.Tarik) > 0 $strkdj order by m.KodeJurusan, k.Tahun, k.NIM	";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <th class=ttl>Thn Akd</th><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Jur</th>
	  <th class=ttl>Biaya</th><th class=ttl>Potong</th><th class=ttl>Bayar</th><th class=ttl>Tarik</th>
	  <th class=ttl>Kurang</th><th class=ttl>Status</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $krg = number_format($row['KRG'], 2, ',', '.');
	  $bia = number_format($row['Biaya'], 2, ',', '.');
	  $pot = number_format($row['Potong'], 2, ',', '.');
	  $byr = number_format($row['Bayar'], 2, ',', '.');
	  $trk = number_format($row['Tarik'], 2, ',', '.');
	  //sysfo.php?syxec=mhswkeu&md=1&md1=0&thn=20031&nim=199281001
	  echo <<<EOF
	  <tr><td class=lst>$row[Tahun]</td>
	  <td class=lst><a href='sysfo.php?syxec=mhswkeu&md=1&md1=0&thn=$row[Tahun]&nim=$row[NIM]'>
	  $row[NIM]</a></td>
	  <td class=lst>$row[Name]</td>
	  <td class=lst>$row[KodeJurusan]</td>
	  <td class=lst align=right>$bia</td><td class=lst align=right>$trk</td>
	  <td class=lst align=right>$byr</td><td class=lst align=right>$pot</td>
	  <td class=wrn align=right>$krg</td>
	  <td class=lst>$row[STA]</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
}
function RekapBlmLns($kdj) {
  global $strCantQuery;
  if (empty($kdj)) $strkdj = '';
	else $strkdj = "and m.KodeJurusan='$kdj'";
	$s = "select sum(k.Biaya) as BIA, sum(k.Bayar) as BYR, sum(k.Potong) as POT, sum(k.Tarik) as TRK,
	  sum(k.Biaya+k.Potong-k.Bayar+k.Tarik) as KRG
	  from khs k left outer join mhsw m on k.NIM=m.NIM
	  where (k.Biaya+k.Potong-k.Bayar+k.Tarik) > 0 $strkdj limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	if (mysql_num_rows($r) > 0) {
	  $bia = number_format(mysql_result($r, 0, 'BIA'), 2, ',', '.');
	  $pot = number_format(mysql_result($r, 0, 'POT'), 2, ',', '.');
	  $byr = number_format(mysql_result($r, 0, 'BYR'), 2, ',', '.');
	  $trk = number_format(mysql_result($r, 0, 'TRK'), 2, ',', '.');
	  $krg = number_format(mysql_result($r, 0, 'KRG'), 2, ',', '.');
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=ttl>Total Biaya</td><td class=lst align=right>$bia</td></tr>
	  <tr><td class=ttl>Total Potongan</td><td class=lst align=right>$pot</td></tr>
	  <tr><td class=ttl>Total Bayar</td><td class=lst align=right>$byr</td></tr>
	  <tr><td class=ttl>Total Ambil</td><td class=lst align=right>$trk</td></tr>
	  <tr><td class=ttl>Total Kekurangan</td><td class=wrn align=right>$krg</td></tr>
	  </table>
EOF;
}
  }
  
  // *** Parameter2 ***
$kdj = GetSetVar('kdj');
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Laporan Mahasiswa Belum Lunas');
  DispJur($kdj, 0, 'lapblmlns');
  if ($prn == 0) {
    $sid = session_id();
    SimplePrinter("print.php?print=sysfo/lapblmlns.php&kdj=$kdj&prn=1&PHPSESSID=$sid",
	  'Cetak Laporan');
  }
  LapBlmLns($kdj);
  RekapBlmLns($kdj);
?>