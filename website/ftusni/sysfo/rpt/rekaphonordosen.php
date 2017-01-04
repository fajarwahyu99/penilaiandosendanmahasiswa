<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispHeaderHonorDosen($thn, $kdj, $kdp, $bln) {
    global $arr_Month;
    $nmathn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, "Nama");
	$nmabln = $arr_Month[$bln-1];
	if (empty($kdj)) $strkdj = 'Semua Jurusan'; 
	else $strkdj = GetaField('jurusan j left outer join jenjangps je on j.Jenjang=je.Kode', 'j.Kode', $kdj, "concat(je.Nama, ' - ', j.Nama_Indonesia) as nm");
	if (empty($kdp)) $strkdp = 'Semua Program'; else $strkdp = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	echo <<<EOF
	<center><b>REKAPITULASI HONOR DOSEN</b></center><br>
	<table class=basic cellspacing=1 cellpadding=2 width=100%>
	<tr><td class=basic width=50%>
	  <table class=basic cellspacing=1 cellpadding=2>
		<tr><td class=basic>Jurusan:</td><td class=uline>$strkdj</td></tr>
		<tr><td class=basic>Program:</td><td class=uline>$strkdp</td></tr>
	  </table>
	</td><td>
	  <table class=basic cellspacing=1 cellpadding=2>
	    <tr><td class=basic>Tahun Akademik:</td><td class=uline>$thn $nmathn</td></tr>
		<tr><td class=basic>Bulan:</td><td class=uline>$nmabln</td></tr>
	  </table>
	</td></tr>
	</table><br>
EOF;
  }
  function DispHitungDosenHonor($thn, $kdj, $kdp, $bln) {
    if (empty($kdj)) $filterkdj = ''; else $filterkdj = "and j.KodeJurusan='$kdj'";
    if (empty($kdp)) $filterkdp = ''; else $filterkdp = "and j.Program='$kdp'";
    $s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN,
	  h.Nama as HR, jo.Nama as JBTN
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join jabatanorganisasi jo on j.JabatanOrganisasi=jo.Kode
	  where j.Tahun='$thn' $filterkdj $filterkdp
	  order by d.Name, j.Hari";
	$r = mysql_query($s) or die("Error: $s");
	$cnt = 0;
	$did = 0;
	$gatot = 0;
	$hrabsen = '';
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=ttl>#</td><td class=ttl>Kode</td><td class=ttl>Mata Kuliah</td>
	  <td class=ttl>SKS</td><td class=ttl>Hari</td>
	  <td class=ttl>Hdr</td><td class=ttl>Trans</td><td class=ttl>Tot Trans</td>
	  <td class=ttl>Honor</td><td class=ttl>Tot Honor</td>
	  <td class=ttl>Total</td>
	  </tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']) {
	    $strgatot = number_format($gatot, 0, ',', '.');
	    if ($did != 0) echo "<tr><td colspan=10 align=right>Total:</td><td class=ttl align=right><b>$strgatot</td></tr>";
	    $did = $w['IDDosen'];
		$cnt = 0;
		echo "<tr><td class=uline colspan=4><b>$w[DSN]</td>
		  <td class=uline colspan=7><img src='image/kanan.gif'> $w[JBTN]</td></tr>";
		$gatot = 0;
	  }
	  $cnt++;
	  $hdr = 0;
	  for ($i=1; $i <= 20; $i++) {
	    //echo GetMonth($w["hr_$i"])."-";
		if (GetMonth($w["hr_$i"]) == $bln) $hdr++;
	  }
	  $trans = $hdr * $w["Transport"];
	  $honor = $hdr * $w["Honor"];
	  $deftransport = number_format($w['Transport'], 0, ',', '.');
	  $defhonor = number_format($w['Honor'], 0, ',', '.');
	  $strtrans = number_format($trans, 0, ',', '.');
	  $strhonor = number_format($honor, 0, ',', '.');
	  $total = $trans + $honor;
	  $gatot += $total;
	  $strtotal = number_format($total, 0, ',', '.');
	  echo <<<EOF
	  <tr><td class=nac>$cnt</td><td class=lst>$w[KodeMK]</td>
	  <td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[HR]</td>
	  <td class=lst align=right>$hdr</td>
	  <td class=lst align=right>$deftransport</td>
	  <td class=lst align=right>$strtrans</td>
	  <td class=lst align=right>$defhonor</td>
	  <td class=lst align=right>$strhonor</td>
	  <td class=lst align=right>$strtotal</td>
	  </tr>
EOF;
	}
	$strgatot = number_format($gatot, 0, ',', '.');
	echo "<tr><td colspan=10 align=right>Total:</td><td class=ttl align=right><b>$strgatot</td></tr>";
	echo "</table><br>";
  }
  function GetMonth($str='') {
    if (empty($str)) return 0;
	else {
	  $tgl = explode('-', $str);
	  return $tgl[1]+0;
	}
  }
  
  // *** Parameter2 ***
  $bln = $_REQUEST['PerBulan'] +0;
  $thn = $_REQUEST['PerTahun'];
  $kdj = $_REQUEST['PerJur'];
  $kdp = $_REQUEST['PerPrg'];
  
  // *** Bagian Utama ***
  DispHeaderHonorDosen($thn, $kdj, $kdp, $bln);
  DispHitungDosenHonor($thn, $kdj, $kdp, $bln);
?>