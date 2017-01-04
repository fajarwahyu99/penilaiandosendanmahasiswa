<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispBulanHonor($bln=0) {
    $optbln = GetMonthOption($bln);
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='dosenhitunghonor'>
	<tr><td class=lst width=165>Honor Bulan:</td>
	<td class=lst><select name='bln' onChange='this.form.submit()'>$optbln</select></td></tr>
	</form></table><br>
EOF;
  }
  function DispHitungDosenHonor($thn, $kdj, $bln) {
    $s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN,
	  h.Nama as HR, jo.Nama as JBTN
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join jabatanorganisasi jo on j.JabatanOrganisasi=jo.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj'
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
	  <td class=ttl>Honor</td><td class=ttl>Tot Hnr</td>
	  <td class=ttl>Total</td>
	  </tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']) {
	    $strgatot = number_format($gatot, 0, ',', '.');
	    if ($did != 0) echo "<tr><td colspan=10 align=right>Total:</td><td class=ttl align=right><b>$strgatot</td></tr>";
	    $did = $w['IDDosen'];
		$cnt = 0;
		echo "<tr><td class=uline colspan=11><b>$w[DSN] : $w[JBTN]</td></tr>";
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
	  <td class=lst alibn=right>$deftransport</td>
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
  function WriteHeaderRekapHonor($thn, $kdj, $bln) {
    global $arr_Month;
    $smt = GetaField("tahun", "Kode=$thn and KodeJurusan", $kdj, 'Nama');
	$bulan = $arr_Month[$bln];
	echo <<<EOF
	<center>$smt<br>
	Laporan Bulan: $bulan<br>
	</center>
EOF;
  }
  
  // *** Parameter2 ***
  $thn = GetSetVar('thn');
  $kdj = GetSetVar('kdj');
  $bln = GetSetVar('bln');
  if (isset($_REQUEST['go'])) {
    $thn = $_REQUEST['th_n'].$_REQUEST['th_s'];
	$_SESSION['thn'] = $thn;
  }
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Rekapitulasi Honor Dosen');
  if ($prn == 0) DispOptJdwl0('dosenhitunghonor');
  else WriteHeaderRekapHonor($thn, $kdj, $bln);
  if (!empty($thn) && !empty($kdj)) {
    $snm = session_name();
	$sid = session_id();
	if ($prn == 0) {
	  DispBulanHonor($bln);
	  DisplayPrinter("print.php?print=sysfo/dosenhitunghonor.php&prn=1&$snm=$sid");
	}
    if ($md == -1) DispHitungDosenHonor($thn, $kdj, $bln);
	//else EditDosenHonor();
	$tgl = date('d M Y');
	echo <<<EOF
	Dicetak oleh $_SESSION[uname], $tgl
EOF;
  }
?>