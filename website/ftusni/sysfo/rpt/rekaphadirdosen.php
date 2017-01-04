<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispHeaderRekapHadirDosen($thn, $kdj, $kdp, $bln) {
    global $arr_Month;
    $nmathn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, "Nama");
	$nmabln = $arr_Month[$bln-1];
	if (empty($kdj)) $strkdj = 'Semua Jurusan'; 
	else $strkdj = GetaField('jurusan j left outer join jenjangps je on j.Jenjang=je.Kode', 'j.Kode', $kdj, "concat(je.Nama, ' - ', j.Nama_Indonesia) as nm");
	if (empty($kdp)) $strkdp = 'Semua Program'; else $strkdp = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	echo <<<EOF
	<center><b>REKAPITULASI KEHADIRAN DOSEN</b></center><br>
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
  function RekapHadirDosen($thn, $kdj, $kdp, $bln) {
    if (empty($kdj)) $filterkdj = ''; else $filterkdj = "and j.KodeJurusan='$kdj'";
    if (empty($kdp)) $filterkdp = ''; else $filterkdp = "and j.Program='$kdp'";
    $s = "select j.*, d.Name, concat(d.Name, ', ', d.Gelar) as DSN
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  where j.NotActive='N' $filterkdj $filterkdp
	  order by d.Name";
	$r = mysql_query($s) or die("Error: $s".mysql_error());
	$did = 0;
	$no = 0;
	$hrhr = '';
	for ($i=1; $i <= 20; $i++) {
	  $hrhr .= "<th class=ttl>".str_pad($i, 2, '0', STR_PAD_LEFT)."</th>";
	}
	echo "<table class=basic cellspacing=0 cellpadding=2>
	<tr><th class=ttl>#</th><th class=ttl>Kode</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
	$hrhr <th class=ttl>Hadir</th><th class=ttl>Rencana</th>
	</tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']) {
	    $did = $w['IDDosen'];
		echo "<tr><td class=uline colspan=26><b>$w[DSN]</td></tr>";
		$no = 0;
	  }
	  $no++; $strhdr = ''; $jmlhdr = 0;
	  for ($i=1; $i <= 20; $i++) {
	    if ($w["hd_$i"] == 1) {
		  $strhdr .= "<td class=lst align=center>H</td>";
		  $jmlhdr++;
		}
		else $strhdr .= "<td class=lst>&nbsp;</td>";
	  }
	  echo <<<EOF
	  <tr><td class=nac>$no</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  $strhdr
	  <td class=lst align=right>$jmlhdr</td>
	  <td class=lst align=right>$w[Rencana]</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
  }
  function DispFooterRekapHadirDosen($thn, $kdj, $kdp, $bln) {
    $tgl = date('d M Y  H:i:s');
    echo <<<EOF
	Dicetak oleh: $_SESSION[uname], $tgl
EOF;
  }
  
  // *** Parameter2 ***
  $bln = $_REQUEST['PerBulan'] +0;
  $thn = $_REQUEST['PerTahun'];
  $kdj = $_REQUEST['PerJur'];
  $kdp = $_REQUEST['PerPrg'];
  
  // *** Bagian Utama ***
  DispHeaderRekapHadirDosen($thn, $kdj, $kdp, $bln);
  RekapHadirDosen($thn, $kdj, $kdp, $bln);
  DispFooterRekapHadirDosen($thn, $kdj, $kdp, $bln);

?>