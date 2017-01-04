<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  include_once "lib/table.common.php";
  
  // *** Fungsi2 ***
  function DispPanelIntake($kdj, $kdp, $prn) {
    if ($prn == 0) {
      $optkdj = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	  $optkdp = GetOption2('program', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdp, '', 'Kode');
	  echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='pmbintake'>
	  <tr><th class=ttl>Jurusan</th><th class=ttl>Program</th><th class=ttl></th></tr>
	  <tr><td class=lst><select name='kdj'>$optkdj</select></td>
	  <td class=lst><select name='kdp'>$optkdp</select></td>
	  <td class=lst><input type=submit name='prcintake' value='Refresh'></td></tr>
	  </form></table><br>
EOF;
	  DisplayPrinter("print.php?print=sysfo/pmbintake.php&prn=1&prcintake=1");
	}
	else {
	  if (empty($kdj)) $strkdj = 'Semua'; else $strkdj = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  if (empty($kdp)) $strkdp = 'Semua'; else $strkdp = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	  echo "<p>Jurusan: $kdj $strkdj, Program: $kdp $strkdp</p>";
	}
  }
  function GetArraySyarat(&$str, &$nil) {
    $s = "select ID,Kode,Nama from pmbsyarat order by Rank";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	while ($w = mysql_fetch_array($r)) {
	  $str[] = $w['Kode'];
	  $nil[] = $w['ID'];
	}
  }
  function DispDataIntake($pref, $kdj, $kdp) {
    $strsya = array(); $nilsya = array();
    GetArraySyarat($strsya, $nilsya);
	DispHeaderIntake($strsya);
	$strkdj = ''; $strkdp = ''; $nmr = 0;
	if (!empty($kdj)) $strkdj = "and Program='$kdj'";
	if (!empty($kdp)) $strkdp = "and ProgramType='$kdp'";
	$s = "select PMBID, Name, StatusAwal, PMBSyarat, Setara, PMBKurang
	  from pmb where PMBID like '$pref%' $strkdj $strkdp order by PMBID";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  if ($w['StatusAwal'] == 'B') {
	    $strbr = "<img src='image/Y.gif' border=0>";
		$strpi = '&nbsp;';
	  }
	  else {
	    $strbr = '&nbsp;';
		$strpi = $w['Setara'];
	  }
	  $sya = '';
	  for ($i=0; $i < sizeof($nilsya); $i++) {
	    if (strpos($w['PMBSyarat'], "|$nilsya[$i]|") === false) $sya .= "<td class=lst align=center>-</td>";
		else $sya .= "<td class=lst align=center><img src='image/Y.gif'></td>";
	  }
	  $ket = StripEmpty($w['PMBKurang']);
	  echo <<<EOF
	  <tr><td class=lst>$nmr</td>
	  <td class=lst>$w[PMBID]</td><td class=lst>$w[Name]</td>
	  <td class=lst align=center>$strbr</td><td class=lst align=center>$strpi</td>
	  $sya <td class=lst>$ket</td></tr>
EOF;
	}
	echo "</table>";
  }
  function DispHeaderIntake($strsya) {
    echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl rowspan=2>#</th><th class=ttl rowspan=2>PMBID</th>
	  <th class=ttl rowspan=2>Nama</th><th class=ttl colspan=2>Status</th>";
	for ($i=0; $i < sizeof($strsya); $i++) 
	  echo "<th rowspan=2 class=ttl>$strsya[$i]</th>";
	echo "<th class=ttl rowspan=2>Ket.</th></tr>
	  <tr><th class=ttl>Baru</th><th class=ttl>Pind</th></tr>";
  }
  
  // *** Parameter2 ***
  $kdj = GetSetVar('kdj');
  $kdp = GetSetVar('kdp');
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** Bagian Utama ***
  $pref = GetPMBPrefix();
  $prefdesc = GetPMBDescription();

  DisplayHeader($fmtPageTitle, "Data Mahasiswa Intake $prefdesc");
  DispPanelIntake($kdj, $kdp, $prn);
  if (isset($_REQUEST['prcintake'])) DispDataIntake($pref, $kdj, $kdp);
?>