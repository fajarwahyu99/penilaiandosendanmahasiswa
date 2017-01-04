<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  function setupbppp0() {
    $info = array();
    $info[] = "Script Setup BPP Pokok";
	$info[] = "Untuk mengelola BPP Pokok";
	$info[] = "E. Setio Dewo";
	$info[] = "setio_dewo@telkom.net";
	return $info;
  }
  // *** FUNGSI2 PENDUKUNG ***
  function DispBPPP($kdj, $bea, $act='setupbppp') {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from bpppokok where KodeBiaya='$bea' and KodeJurusan='$kdj' order by MinSKS, MaxSKS desc";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	$b = "<a href='sysfo.php?syxec=setupbppp&md2=1' class=lst>Tambah Biaya BPP Pokok</a>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Dari<br>SKS</th><th class=ttl>Sampai<br>SKS</th><th class=ttl>Biaya</th>
	  <th class=ttl>na</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $biaya = number_format($row['Biaya'], 2, ',', '.');
	  if ($row['NotActive']=='Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  $b = $b . "
	  <tr><td $cls align=right>$row[MinSKS]</td>
	  <td $cls align=right>$row[MaxSKS]</td>
	  <td $cls align=right>$biaya</td>
	  <td $cls align=center>$row[NotActive]</td>
	  <td $cls><a href='sysfo.php?syxec=setupbppp&md2=0&bid=$row[ID]'>ed</td></tr>";
	}
	return $b. "</table>
	  <table class=basic cellspacing=0 cellpadding=2><tr><td class=lst><b>ed</b></td><td class=basic>edit.</td></tr></table>";
  }
  function FormMasterBPPP($md2, $kdj, $bea, $bid) {
    global $strCantQuery;
    if ($md2 == 0) {
	  $s = "select * from bpppokok where ID=$bid limit 1";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  $MinSKS = mysql_result($r, 0, 'MinSKS');
	  $MaxSKS = mysql_result($r, 0, 'MaxSKS');
	  $Biaya = mysql_result($r, 0, 'Biaya');
	  if (mysql_result($r, 0, 'NotActive')=='Y') $na = 'checked'; else $na = '';
	  $jdl = 'Edit BPP Pokok';
	}
	else {
	  $bid = 0;
	  $MinSKS = 0;
	  $MaxSKS = 0;
	  $Biaya = 0;
	  $na = '';
	  $jdl = 'Tambah BPP Pokok';
	}
	$sid = session_id();
	return <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='setupbppp'>
	  <input type=hidden name='md2' value='$md2'>
	  <input type=hidden name='bid' value='$bid'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='bea' value='$bea'>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=lst>Dari SKS</td><td class=lst><input type=text name='MinSKS' value='$MinSKS' size=3 maxlength=2></td></tr>
	  <tr><td class=lst>Sampai SKS</td><td class=lst><input type=text name='MaxSKS' value='$MaxSKS' size=3 maxlength=2></td></tr>
  	  <tr><td class=lst>Biaya</td><td class=lst><input type=text name='Biaya' value='$Biaya' size=15 maxlength=11></td></tr>
	  <tr><td class=lst>Not Active</td><td class=lst><input type=checkbox name='na' value='Y' $na></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcbppp' value='Simpan'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=setupbppp&PHPSESSID=$sid'"></td></tr>
	  </form></table>
EOF;
  }
  function PrcBPPP() {
    global $strCantQuery, $fmtErrorMsg;
    $md2 = $_REQUEST['md2'];
	$bid = $_REQUEST['bid'];
	$kdj = $_REQUEST['kdj'];
	$bea = $_REQUEST['bea'];
	$MinSKS = $_REQUEST['MinSKS'];
	$MaxSKS = $_REQUEST['MaxSKS'];
	$Biaya = $_REQUEST['Biaya'];
	if (isset($_REQUEST['na'])) $na = $_REQUEST['na']; else $na = 'N';
	if ($md2 == 0) {
	  $s = "update bpppokok set MinSKS='$MinSKS', MaxSKS='$MaxSKS', Biaya='$Biaya', NotActive='$na'
	    where ID='$bid' ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else {
	  $s = "insert into bpppokok (KodeBiaya, KodeJurusan, MinSKS, MaxSKS, Biaya, NotActive) values 
	    ('$bea', '$kdj', '$MinSKS', '$MaxSKS', '$Biaya', '$na')";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	return -1;
  }

  // *** PARAMETER2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else { if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';  }
  if (isset($_REQUEST['bea'])) {
    $bea = $_REQUEST['bea'];
	$_SESSION['bea'] = $bea;
  }
  else { if (isset($_SESSION['bea'])) $bea = $_SESSION['bea']; else $bea = ''; }
  if (isset($_REQUEST['bid'])) $bid = $_REQUEST['bid']; else $bid = 0;
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['md2'])) $md2 = $_REQUEST['md2']; else $md2 = -1;


  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Setup BPP Pokok");
  DispJur($kdj, 0, 'setupbppp');
  if (isset($_REQUEST['prcbppp'])) $md2 = PrcBPPP();
  if (!empty($kdj)) {
    $kiri = DispBiaya($kdj, $bea, 'setupbppp', 1);
	$kanan = '';
	
	if (!empty($bea) && ValidMasterBiaya($kdj, $bea)) {
	  if ($md2 == -1) $kanan = DispBPPP($kdj, $bea, 'setupbppp');
	  else $kanan = FormMasterBPPP($md2, $kdj, $bea, $bid);
	} else $kanan = DisplayItem($fmtMessage, 'Master Biaya Belum Dipilih', 
	  'Pilih salah satu set master biaya di sebelah kiri.', 0);
  }
  else {
    $kiri = '';
	$kanan = '';
  }
  echo <<<EOF
  <table class=basic cellspacing=0 cellpadding=2 width=100%>
  <tr><td class=basic valign=top>$kiri</td>
  <td class=basic background='image/vertisilver.gif' width=1></td>
  <td class=basic valign=top>$kanan</td>
  </tr>
  </table>
EOF;
?>
