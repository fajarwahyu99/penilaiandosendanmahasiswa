<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  

  // *** Fungsi2 ***
  function GetFldKewajiban() {
    $s = "select * from setupkeuwajib order by Rank";
	$r = mysql_query($s) or die(mysql_error());
	$hsl = array();
	while ($w = mysql_fetch_array($r)) {
	  $hsl[] = $w['Nama'];
	}
	return $hsl;
  }
  function CetakKewajibanMhsw() {
    global $strCantQuery, $PerJur;
	$dw = 70;
	$arrfld = GetFldKewajiban();
	$jmlfld = sizeof($arrfld);
	$jmlfld1 = $jmlfld + 1;
	$hdrfld = '';
	for ($i=0; $i< $jmlfld; $i++) {
	  $hdrfld .= "<td class=ttl width=$dw align=center>$arrfld[$i]</td>";
	}
	$hdrfld .= "<td class=ttl width=$dw align=center>Lain2</td>";
	
	$strfilter = '';
	if (!empty($PerJur)) $strfilter .= " and m.KodeJurusan='$PerJur' ";
	if (!empty($PerTahun)) $strfilter .= " and bm.Tahun='$PerTahun' ";
	$s = "select bm.*, m.KodeJurusan, b2.Nama as NamaBiaya2, m.Name
	  from biayamhsw bm left outer join mhsw m on bm.NIM=m.NIM
	  left outer join biaya2 b2 on bm.IDBiaya2=b2.ID
	  where bm.NIM <> '' $strfilter order by bm.NIM";
	$nim = '';
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	
	$brs = 0;
	$abi = array();
	$prn = false;
	$tot = mysql_num_rows($r)-1;
	$width = $dw * ($jmlfld + 4) + 250;
	$tby = 0;
	$no = 0;

	echo "<table class=basic cellspacing=0 cellpadding=1 width=$width>
	  <tr><th class=ttl rowspan=2>#</th>
	  <th class=ttl rowspan=2>NIM</th> <th class=ttl rowspan=2>Mahasiswa</th> 
	  <th class=ttl colspan=$jmlfld1>Biaya-biaya</th>
	  <th class=ttl rowspan=2>Total<br>Biaya</th><th class=ttl rowspan=2>Total<br>Bayar</th>
	  <th class=ttl rowspan=2>Total<br>Hutang</th></tr>
	  <tr>$hdrfld</tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($brs == 0) {
	    $nim = $w['NIM'];
		$name = $w['Name'];
		$no = 1;
	  }
	  if ($nim != $w['NIM']) {
		$ext = ''; $tbi = 0;
		for ($i=0; $i <= sizeof($arrfld); $i++) {
		  $tbi += $abi[$i];
		  $b = number_format($abi[$i] + 0, 0, ',', '.');
		  $ext .= "<td class=lst align=right>$b</td>";
		}
		$hut = number_format($tbi - $tby, 0, ',', '.');
		$tbi = number_format($tbi, 0, ',', '.');
		$tby = number_format($tby, 0, ',', '.');
	    echo <<<EOF
		<tr><td class=lst>$no</td><td class=lst>$nim</td><td class=lst>$name</td>
		$ext 
		<td class=lst align=right width=$dw>$tbi</td>
		<td class=lst align=right width=$dw>$tby</td>
		<td class=lst align=right width=$dw>$hut</td>
		</tr>
EOF;
		$tby = 0;
		$no++;
		$nim = $w['NIM'];
		$name = $w['Name'];
		$abi = array();
	  }
	  $idx = array_search($w['NamaBiaya2'], $arrfld);
	  if ($idx === false) $idx = sizeof($arrfld);
	  $abi[$idx] += $w['Kali'] * $w['Biaya'] * $w['Jumlah'];
	  //echo "$nim : $w[NamaBiaya2] : $abi[$idx]<br>";
	  //$nim . ' - ' . $abi[$idx]."<br>";
	  $tby += $w['Kali'] * $w['Bayar'];
	  
	  // *** Cetak penghabisan ***
	  if ($brs == $tot) {
		$ext = ''; $tbi = 0;
		for ($i=0; $i <= sizeof($arrfld); $i++) {
		  $tbi += $abi[$i];
		  $b = number_format($abi[$i] + 0, 0, ',', '.');
		  $ext .= "<td class=lst align=right>$b</td>";
		}
		$hut = number_format($tbi - $tby, 0, ',', '.');
		$tbi = number_format($tbi, 0, ',', '.');
		$tby = number_format($tby, 0, ',', '.');
	    echo <<<EOF
		<tr><td class=lst>$no</td><td class=lst>$nim</td><td class=lst>$name</td>
		$ext 
		<td class=lst align=right width=$dw>$tbi</td>
		<td class=lst align=right width=$dw>$tby</td>
		<td class=lst align=right width=$dw>$hut</td>
		</tr>
EOF;
	  }
	  $brs++;
	}
	echo "</table>";
  }
  // *** Parameter ***
  if (isset($_REQUEST['PerJur'])) $PerJur = $_REQUEST['PerJur']; else $PerJur = '';
  if (isset($_REQUEST['PerTahun'])) $PerTahun = $_REQUEST['PerTahun']; else $PerTahun = '';
  if (isset($_REQUEST['PerTglAwal'])) $PerTglAwal = $_REQUEST['PerTglAwal']; else $PerTglAwal = '';
  if (isset($_REQUEST['PerTglAkhir'])) $PerTglAkhir = $_REQUEST['PerTglAkhir']; else $PerTglAkhir = '';
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Laporan Kewajiban Mahasiswa');
  //echo "<center><b>Dari tanggal $PerTglAwal s/d $PerTglAkhir</b></center><br>";
  CetakKewajibanMhsw();

?>