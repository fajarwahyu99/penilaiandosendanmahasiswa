<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003


  // *** Fungsi2 ***
  function GetPointJurusan($kdj='') {
    global $strCantQuery;
	$s = "select j.Kode, j.Nama_Indonesia, je.Nama as JEN
	  from jurusan j left outer join jenjangps je on j.Jenjang=je.Kode
	  order by j.Kode";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th></th><th class=ttl>Kode</th><th class=ttl>Jurusan</th><th class=ttl>Jenjang</th><th></th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Kode'] == $kdj) {
	    $cls = 'class=nac';
		$imgi = "<img src='image/kanan.gif' border=0>";
		$imga = "<img src='image/kiri.gif' border=0>";
	  }
	  else {
	    $cls = 'class=lst';
		$imgi = ''; $imga = '';
	  }
	  $a .= "<tr><td class=basic>$imgi</td>
	    <td $cls><a href='sysfo.php?syxec=tandatangan&kdj=$w[Kode]'>$w[Kode]</a></td>
		<td $cls>$w[Nama_Indonesia]</td>
		<td $cls>$w[JEN]</td>
		<td class=basic>$imga</td></tr>";
	}
	return $a . '</table>';
  }
  function GetTandaTangan($kdj='') {
    global $strCantQuery, $fmtMessage;
	if (empty($kdj)) $a = DisplayItem($fmtMessage, 'Pilih Jurusan', 'Pilih salah satu jurusan di kolom sebelah kiri.', 0);
	else {
	  $s = "select Nama_Indonesia, TTPejabat1, TTPejabat2, TTJabatan1, TTJabatan2 
	    from jurusan where Kode='$kdj' limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) > 0) {
	    $NMA = mysql_result($r, 0, 'Nama_Indonesia');
	    $TTJ1 = mysql_result($r, 0, 'TTJabatan1');
		$TTJ2 = mysql_result($r, 0, 'TTJabatan2');
		$TTP1 = mysql_result($r, 0, 'TTPejabat1');
		$TTP2 = mysql_result($r, 0, 'TTPejabat2');
		$a = <<<EOF
		<table class=basic cellspacing=0 cellpadding=4>
		<form action='sysfo.php' method=POST>
		<input type=hidden name='syxec' value='tandatangan'>
		<input type=hidden name='kdj' value='$kdj'>
		<tr><th class=ttl colspan=2>Edit Master Tanda Tangan: $NMA</td></tr>
		<tr><td class=lst>Jabatan 1<br>
		  <input type=text name='TTJ1' value='$TTJ1' size=25 maxlength=100></td>
		<td class=lst>Jabatan 2<br>
		  <input type=text name='TTJ2' value='$TTJ2' size=25 maxlength=100></td></tr>
		<tr><td class=lst>Pejabat 1<br>
		  <input type=text name='TTP1' value='$TTP1' size=25 maxlength=100></td>
		<td class=lst>Pejabat 2<br>
		  <input type=text name='TTP2' value='$TTP2' size=25 maxlength=100></td></tr>
		<tr><td class=lst colspan=2><input type=submit name='prctt' value='Simpan'>&nbsp;
		  <input type=reset name=reset value='Reset'></td></tr>
		</form></table>
EOF;
	  }
	}
	return $a;
  }
  function PrcTandaTangan() {
    $kdj = $_REQUEST['kdj'];
    $TTJ1 = sqling($_REQUEST['TTJ1']);
	$TTJ2 = sqling($_REQUEST['TTJ2']);
	$TTP1 = sqling($_REQUEST['TTP1']);
	$TTP2 = sqling($_REQUEST['TTP2']);
	$s = "update jurusan set TTJabatan1='$TTJ1', TTJabatan2='$TTJ2', TTPejabat1='$TTP1', TTPejabat2='$TTP2'
	  where Kode='$kdj'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj'];
	else $kdj = '';
  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Master Tanda Tangan');
  if (isset($_REQUEST['prctt'])) PrcTandaTangan();
  $ki = GetPointJurusan($kdj);
  $ka = GetTandaTangan($kdj);
  
  echo <<<EOF
  <table class=basic cellspacing=0 cellpadding=4 width=100%>
  <tr><td class=basic style='border-right: 1px solid silver' valign=top>$ki</td>
  <td class=basic valign=top>$ka</td></tr>
  </table>
EOF;

?>