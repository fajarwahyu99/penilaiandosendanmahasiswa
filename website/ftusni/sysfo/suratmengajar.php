<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Sept 2003
  

  // *** Fungsi2 ***
  function DispSuratKeputusan($kdj, $thn) {
    global $strCantQuery;
	$s = "select j.*, d.Name as DSN, h.Nama as HAR,
	  TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join hari h on j.Hari=h.ID
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by d.Name";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<br><table class=basic cellspacing=1 cellpadding=2>";
	$did = 0;
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']) {
	    $did = $w['IDDosen'];
		$cnt = 0;
		echo "<tr><td class=uline colspan=3><br><b>$w[DSN]</b></td>
		<form action='sysfo.php' method=POST>
		<input type=hidden name='syxec' value='suratmengajar'>
		<input type=hidden name='kdj' value='$kdj'>
		<input type=hidden name='thn' value='$thn'>
		<input type=hidden name='did' value='$did'>
		<td class=uline colspan=3><br><input type=text name='NoSurat' value='$w[NoSurat]' size=25 maxlength=100>
		<input type=submit name='prnsurat' value='Cetak'></td>
		</form></tr>";
	  }
	  $cnt++;
	  echo "<tr><td class=nac>$cnt</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td>
	  <td class=lst>$w[KodeKampus]</td><td class=lst>$w[HAR]</td><td class=lst>$w[jm] - $w[js]</td></tr>";
	}
	echo "</table>";
  }
  function PrnSuratMengajar() {
    global $strCantQuery;
    $sid = session_id();
    $kdj = $_REQUEST['kdj']; $thn = $_REQUEST['thn'];
	$did = $_REQUEST['did']; $srt = $_REQUEST['NoSurat'];
	$s = "update jadwal set NoSurat='$srt' where IDDosen=$did and Tahun='$thn'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo <<<EOF
      <SCRIPT>
      var popOldOL = window.onload;
      window.onload = function(){ if (popOldOL) popOldOL(); 
	  newwin = window.open('print.php?print=sysfo/cetaksuratmengajar.php&did=$did&thn=$thn&PHPSESSID=$sid'); }
      </SCRIPT>
EOF;
  }

  // *** Parameter 2 ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Cetak Surat Keputusan Mengajar');
  if (isset($_REQUEST['prnsurat'])) PrnSuratMengajar();
  DispOptJdwl0('suratmengajar');
  if (!empty($kdj) && !empty($thn)) DispSuratKeputusan($kdj, $thn);


?>