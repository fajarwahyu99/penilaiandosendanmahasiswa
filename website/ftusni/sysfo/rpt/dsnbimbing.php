<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi ***
  function WriteHeaderDosenPembimbing($thn, $jur, $prg) {
    if (empty($jur)) $strjur = 'Semua Jurusan';
	else $strjur = GetaField('jurusan', 'Kode', $jur, 'Nama_Indonesia');
	if (empty($prg)) $strprg = 'Semua Program';
	else $strprg = GetaField('program', 'Kode', $prg, 'Nama_Indonesia');
	$strthn = GetaField('tahun', 'Kode', $thn, 'Nama');
	echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<tr><td class=basic>Tahun Ajaran:</td><td class=uline>$thn - $strthn</td></tr>
	<tr><td class=basic>Jurusan:</td><td class=uline>$strjur</td></tr>
	<tr><td class=basic>Program:</td><td class=uline>$strprg</td></tr>
	</table><br>
EOF;
  }
  function DosenPembimbingAkd($thn, $jur, $prg) {
    WriteHeaderDosenPembimbing($thn, $jur, $prg);
	if (empty($jur)) $whrjur = ''; else $whrjur = "and m.KodeJurusan='$jur'";
	if (empty($prg)) $whrprg = ''; else $whrprg = "and m.KodeProgram='$prg'";
    $s = "select k.NIM, m.DosenID, m.Name,
	  d.Name as DSN, k.GradeNilai, k.SKS, k.Bobot
	  from khs k left outer join mhsw m on k.NIM=m.NIM
	  left outer join dosen d on m.DosenID=d.ID
	  left outer join statusmhsw sm on k.Status=sm.Kode
	  where k.Tahun='$thn' $whrjur $whrprg
	  and sm.Nilai=1
	  order by d.Name, k.NIM";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	$dsn = ''; $no = 0;
	echo "<table class=basic cellspacing=1 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  if ($dsn != $w['DosenID']) {
	    if (!empty($dsn)) {
		  echo "<tr><td colspan=2 align=right>Jumlah:</td><td><b>$no</td></tr>";
		}
	    $dsn = $w['DosenID'];
		$no = 0;
		echo "<tr><td></td></tr>
		  <tr><td class=ttl colspan=3>$w[DSN]</td><td class=nac>SKS</td><td class=nac>IPS</td></tr>";
	  }
	  $no++;
	  if ($w['SKS'] == 0) $ips = 0;
	  else $ips = $w['Bobot'] / $w['SKS'];
	  echo "<tr><td class=nac>$no</td><td class=lst>$w[NIM]</td><td class=lst>$w[Name]</td>
	    <td class=lst align=right>$w[SKS]</td><td class=lst align=right>$ips</td></tr>";
	}
	echo "<tr><td colspan=2 align=right>Jumlah:</td><td><b>$no</td></tr>";
	echo "</table>";
  }
  
  // *** Parameter ***
  $PerTahun = $_REQUEST['PerTahun'];
  $PerJur = $_REQUEST['PerJur'];
  $PerPrg = $_REQUEST['PerPrg'];
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Dosen Pembimbing Akademik');
  DosenPembimbingAkd($PerTahun, $PerJur, $PerPrg);

?>