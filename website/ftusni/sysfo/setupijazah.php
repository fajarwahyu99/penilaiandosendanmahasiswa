<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // *** Fungsi2 ***
  function FormSetupIjazah($kdj, $act='setupijazah') {
    global $strCantQuery;
	$s = "select * from jurusan where Kode='$kdj' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	while ($w = mysql_fetch_array($r)) {
	  echo <<<EOF
	  <br><table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <tr><th class=ttl colspan=2>Setup Ijazah</th></tr>
	  <tr><td class=lst>Nomer Seri Ijazah</td><td class=lst><input type=text name='seri' value='$w[IjazahNomer]' size=50 maxlength=100></td></tr>
	  <tr><td class=lst>Akreditasi</td><td class=lst><input type=text name='akre' value='$w[IjazahAkreditasi]' size=50 maxlength=100></td></tr>
	  <tr><td class=lst>Gelar</td><td class=lst><input type=text name='gelar' value='$w[Gelar]' size=50 maxlength=100></td></tr>
	  <tr><td class=lst>Template Ijazah</td><td class=lst><input type=text name='temp' value='$w[IjazahTemplate]' size=50 maxlength=100></td></tr>
	  <tr><td class=basic colspan=2>
	    <table class=basic cellspacing=0 cellpadding=2 width=100%>
		<tr><td class=lst width=50% align=center>Jabatan 1<br><input type=text name='jbt1' value='$w[Jabatan1]' size=30 maxlength=100></td>
		<td class=lst align=center>Jabatan 2<br><input type=text name='jbt2' value='$w[Jabatan2]' size=30 maxlength=100></td></tr>
		<tr><td class=lst width=50% align=center>Pejabat 1<br><input type=text name='pjbt1' value='$w[Pejabat1]' size=30 maxlength=100></td>
		<td class=lst align=center>Pejabat 2<br><input type=text name='pjbt2' value='$w[Pejabat2]' size=30 maxlength=100></td></tr>
		</table>
	  </td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcijz' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'></td></tr>
	  </form></table>
EOF;
	}
  }
  function PrcSetupIjazah() {
    global $strCantQuery;
    $kdj = $_REQUEST['kdj'];
	$seri = $_REQUEST['seri'];
	$akre = $_REQUEST['akre'];
	$gelar = $_REQUEST['gelar'];
	$temp = $_REQUEST['temp'];
	$jbt1 = $_REQUEST['jbt1'];
	$jbt2 = $_REQUEST['jbt2'];
	$pjbt1 = $_REQUEST['pjbt1'];
	$pjbt2 = $_REQUEST['pjbt2'];
	$s = "update jurusan set IjazahNomer='$seri', IjazahAkreditasi='$akre', Gelar='$gelar', IjazahTemplate='$temp',
	  Jabatan1='$jbt1', Jabatan2='$jbt2', Pejabat1='$pjbt1', Pejabat2='$pjbt2' where Kode='$kdj' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else { if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Setup Ijazah');
  DispJur($kdj, 0, 'setupijazah');
  if (!empty($kdj)) {
    if (isset($_REQUEST['prcijz'])) PrcSetupIjazah();
    FormSetupIjazah($kdj, 'setupijazah');
  }
?>