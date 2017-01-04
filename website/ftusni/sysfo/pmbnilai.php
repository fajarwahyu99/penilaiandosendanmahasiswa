<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** Fungsi2 ***
  function DispFormNilai($kdj) {
    global $strCantQuery;
	include "lib/table.common.php";
	$pref = GetPMBPrefix();
	$s = "select * from pmb where Program='$kdj' and PMBID like '$pref%' order by PMBID";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	echo "<br><table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>No. PMB</th><th class=ttl>Nama Peserta</th>
	  <th class=ttl>Nilai Test</th><th class=ttl>Lulus?</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['TestPass'] == 'Y') {
	    $lls = 'checked'; 
		$cls = 'class=lst';
	  }
	  else {
	    $lls = '';
		$cls = 'class=nac';
	  }
	  echo <<<EOF
      <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='pmbnilai'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='pmbid' value='$row[PMBID]'>
	  <tr><td $cls>$row[PMBID]</td><td $cls>$row[Name]</td>
	  <td $cls><input type=text name='TestScore' value='$row[TestScore]' size=5 maxlength=5></td>
	  <td $cls><input type=checkbox name='TestPass' value='Y' $lls></td>
	  <td class=lst><input type=submit name='prcnilai' value='Simpan'></td>
	  </tr></form>
EOF;
	}
	echo "</table>";
  }
  function PrcNilai() {
    global $strCantQuery;
    $pmbid = $_REQUEST['pmbid'];
	$TestScore = $_REQUEST['TestScore'];
	if (isset($_REQUEST['TestPass'])) $TestPass = $_REQUEST['TestPass']; else $TestPass = 'N';
	$s = "update pmb set TestScore='$TestScore', TestPass='$TestPass' where PMBID='$pmbid'";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Nilai Test PMB');
  DispJur($kdj, 0, 'pmbnilai');
  if (isset($_REQUEST['prcnilai'])) PrcNilai();
  if (isset($kdj)) DispFormNilai($kdj);


?>