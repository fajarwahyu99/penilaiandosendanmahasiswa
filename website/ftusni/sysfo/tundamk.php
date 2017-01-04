<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function FormTunda($jid) {
    global $strCantQuery;
	$s = "select mk.Kode, mk.Nama_Indonesia as MK, concat(ds.Name, ', ', ds.Gelar) as DS,
	  pr.Nama_Indonesia as PRG, j.Tunda, j.AlasanTunda
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  left outer join program pr on j.Program=pr.Kode
	  where j.ID=$jid	limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$kod = mysql_result($r, 0, 'Kode');
	$MK = mysql_result($r, 0, 'MK');
	$DS = mysql_result($r, 0, 'DS');
	$PRG = mysql_result($r, 0, 'PRG');
	if (mysql_result($r, 0, 'Tunda') == 'Y') {
	  $strtnd = 'checked'; 
	  $cls = 'class=nac';
	}
	else {
	  $strtnd = '';
	  $cls = 'class=lst';
	}
	$als = mysql_result($r, 0, 'AlasanTunda');
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='tundamk'>
	  <input type=hidden name='jid' value=$jid>
	  <tr><th class=ttl colspan=2>Tunda Mata Kuliah</th></tr>
	  <tr><td class=lst>Kode MK</td><td class=lst>$kod</td></tr>
	  <tr><td class=lst>Mata Kuliah</td><td class=lst>$MK</td></tr>
	  <tr><td class=lst>Dosen</td><td class=lst>$DS</td></tr>
	  <tr><td class=lst>Program</td><td class=lst>$PRG</td></tr>
	  <tr><td $cls>Tunda Nilai MK</td><td $cls><input type=checkbox name='tnd' value='Y' $strtnd></td></tr>
	  <tr><td class=lst>Alasan Penundaan</td><td class=lst><textarea name='als' cols=30 rows=3>$als</textarea></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prctunda' value='Simpan'>&nbsp;<input type=reset name='reset' value='Reset'></td></tr>
	  </form></table>
EOF;
  }
function PrcTunda($kdj) {
  global $strCantQuery, $thn, $fmtErrorMsg, $strTahunNotActive;
  $jid = $_REQUEST['jid'];
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	if (isset($_REQUEST['tnd'])) $tnd = $_REQUEST['tnd']; else $tnd = 'N';
	$als = FixQuotes($_REQUEST['als']);
	$s = "update jadwal set Tunda='$tnd', AlasanTunda='$als' where ID=$jid";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	return 0;
	}
}
function DispTundaMK($thn, $kdj) {
  global $strCantQuery;
	$s = "select j.ID, j.Tunda,
	  mk.Kode, mk.Nama_Indonesia as MK,
	  concat(ds.Name, ', ', ds.Gelar) as DSN
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join dosen ds on j.IDDosen=ds.ID
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by mk.Kode ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Dosen</th><th class=ttl>Status</th>
	  </tr>	";
	while ($row = mysql_fetch_array($r)) {
	  $mkd = $row['Kode'];
	  $jid = $row['ID'];
	  $MK = $row['MK'];
	  $dsn = $row['DSN'];
	  if ($row['Tunda'] == 'Y') {
	    $tnd = 'Ditunda';
		$cls = 'class=nac';
	  }
	  else {
	    $tnd = '&nbsp;';
		$cls = 'class=lst';
	  }
	  echo <<<EOF
	    <tr><td $cls><a href='sysfo.php?syxec=tundamk&jid=$jid'>$mkd</a></td>
		<td $cls>$MK</td>
		<td $cls>$dsn</td>
		<td $cls>$tnd</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  
  // *** PARAMETER ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
if (isset($_REQUEST['prctunda'])) $jid = PrcTunda($kdj);

  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Penundaan Penilaian Mata Kuliah');
  DispOptJdwl0('tundamk');
  echo "<br>";
  //DispJadwalMK($thn, $kdj, $jid, 'tundamk');
  if ($jid > 0) FormTunda($jid);
  else DispTundaMK($thn, $kdj);
?>