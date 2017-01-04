<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003


  // *** FUNGSI2 ***
  function GetMhswTundaList($jid) {
    global $strCantQuery, $strPending;
	$s = "select k.ID, mh.Name, mh.NIM, k.Tunda, k.AlasanTunda
	  from krs k left join mhsw mh on k.NIM=mh.NIM
	  where k.IDJadwal=$jid order by mh.NIM	";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Status</th><th class=ttl>Keterangan</th>
	  <th class=ttl>Edit</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  $kid = $row['ID'];
	  $nim = $row['NIM'];
	  $nme = $row['Name'];
	  $tnd = $row['Tunda'];
	  $als = $row['AlasanTunda'];
	  if (empty($als)) $als = '&nbsp;';
	  if ($tnd == 'Y') {
	    $strtnd = $strPending;
	    $cls = "class=nac"; 
		$strlnk = "<a href='sysfo.php?syxec=tundamhsw&kid=$kid&prctnd=1'>Buka Penundaan</a>";
	  }
	  else {
	    $strtnd = "&nbsp;";
	    $cls = "class=lst";
		$strlnk = "<a href='sysfo.php?syxec=tundamhsw&kid=$kid&tunda=1'>Tunda Nilai</a>";
	  }
	  echo "<tr><td $cls>$nim</td><td $cls>$nme</td>
		<td $cls>$strtnd</td><td $cls>$als</td><td $cls>$strlnk</td>
	    </tr>";
	}
	echo "</table>";
  }
  function FormTundaMhsw($kid) {
    $arrk = GetFields('krs', 'ID', $kid, 'NIM,Tunda,AlasanTunda');
	$nim = $arrk['NIM'];
	$tnd = $arrk['Tunda'];
	$als = $arrk['AlasanTunda'];
	if ($tnd == 'Y') $strtnd = 'checked'; else $strtnd = '';
	$nme = GetaField('mhsw', 'NIM', $nim, 'Name');
	echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>Tunda Nilai Mahasiswa</th></tr>
	  <tr><td class=lst>NIM</td><td class=lst>$nim</td></tr>
	  <tr><td class=lst>Mahasiswa</td><td class=lst>$nme</td></tr>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='tundamhsw'>
	  <input type=hidden name='kid' value=$kid>
	  <tr><td class=lst>Status Penundaan</td><td class=lst><input type=checkbox name='tnd' value='Y' $strtnd></td></tr>
	  <tr><td class=lst>Alasan Penundaan</td><td class=lst><textarea name='als' rows=3 cols=30>$als</textarea></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prctnd' value='Simpan'>&nbsp;<input type=reset name='reset' value='Reset'></td></tr>
	  
	  </table>
EOF;
  }
  function PrcTunda($kdj) {
    Global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
    $kid = $_REQUEST['kid'];
	if (isset($_REQUEST['tnd'])) {
	  $tnd = $_REQUEST['tnd']; 
	  $als = FixQuotes($_REQUEST['als']);
	}
	else {
	  $tnd = 'N';
	  $als = '';
	}
	$s = "update krs set Tunda='$tnd', AlasanTunda='$als' where ID=$kid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	}
  }
  
  // *** PARAMETER ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$jid = GetSetVar('jid');

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Tunda Nilai Mahasiswa');

  DispOptJdwl0('tundamhsw');
  DispJadwalMK($thn, $kdj, $jid, 'tundamhsw');
  
  if ($jid > 0) {
    if (isset($_REQUEST['prctnd'])) PrcTunda($kdj);
    $did = GetaField('jadwal', 'ID', $jid, 'IDDosen');
    if (($_SESSION['ulevel'] == 3 && $_SESSION['uid'] == $did) || $_SESSION['ulevel'] == 1) {
	}
	else die(DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas mata kuliah ini.", 0));
  }
  if ($jid > 0) {
    if (isset($_REQUEST['tunda'])) FormTundaMhsw($_REQUEST['kid']);
	else GetMhswTundaList($jid);
  }

?>