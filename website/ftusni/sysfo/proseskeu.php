<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function GetLastThn2Prc($kdj='') {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from tahun where NotActive='N' and KodeJurusan='$kdj' order by Kode desc limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) {
	  //DisplayHeader($fmtErrorMsg, "Tidak ada tahun akademik yang aktif.");
	  return array('','');
	}
	else {
	  $arr = array(mysql_result($r, 0, 'Kode'), mysql_result($r, 0, 'Nama'));
	  return $arr;
	}
  }
  function DispPrcKeu() {
    $s = "select j.*
	  from jurusan j
	  order by Kode";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	$cnt=0;
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th>
	  <th class=ttl>Kode</th><th class=ttl>Nama Jurusan</th>
	  <th class=ttl colspan=2>Tahun Akd. Aktif</th>
	  <th class=ttl colspan=2>Prc</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $arrthn = GetLastThn2Prc($w['Kode']);
	  $thn = $arrthn[0]; $nmathn = $arrthn[1];
	  if (!empty($thn)) {
	    $prc = GetaField('tahun', "KodeJurusan='$w[Kode]' and Kode", $thn, 'ProsesBuka') +0;
	    if ($prc > 0) {
	      $strprc = "<a href='sysfo.php?syxec=proseskeu&prckeu=1&thn=$thn&kdj=$w[Kode]' title='Proses thn akademik $thn'>
		  <img src='image/gear.gif' border=0 height=20></a>";
	    } else $strprc = '-';
	  } else $strprc = '-';
	  if ($w['PrcKeuTahun'] == $thn) $cntprckeu = "$w[PrcKeu]x"; else $cntprckeu = '-';
	  $cnt++;
	  $thn = StripEmpty($arrthn[0]); $nmathn = StripEmpty($arrthn[1]);
	  echo <<<EOF
	  <tr><td class=nac>$cnt</td>
	  <td class=lst>$w[Kode]</td><td class=lst>$w[Nama_Indonesia]</td>
	  <td class=lst>$thn</td><td class=lst>$nmathn</td>
	  <td class=lst align=center>$strprc</td>
	  <td class=lst align=right>$cntprckeu</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function PrcKeuangan() {
    $thn = $_REQUEST['thn'];
	$kdj = $_REQUEST['kdj'];
	$s = "update jurusan set PrcKeu=PrcKeu+1, PrcKeuTahun='$thn' where Kode='$kdj'";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	// Kemudian proses keuangan !!!!
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['prckeu'])) PrcKeuangan();
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Proses Keuangan');
  DispPrcKeu();


?>