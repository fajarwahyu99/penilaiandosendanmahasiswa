<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  
  // *** Fungsi2 ***
  function GetPrgBPPP() {
    global $strCantQuery;
	$s = "select pp.*, j.Nama_Indonesia as JUR, p.Nama_Indonesia as PRG
	  from prgbpppokok pp left outer join jurusan j on pp.KodeJurusan=j.Kode
	  left outer join program p on pp.KodeProgram=p.Kode
	  order by j.Kode, p.Kode";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$cnt = 0;
	echo "<a href='sysfo.php?syxec=prgbppp&md=1'>Tambah Program</a><br>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th colspan=2 class=ttl>Jurusan</th><th colspan=2 class=ttl>Program</th>
	  <th class=ttl>BPP Pokok</th><th class=ttl>NA</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  if ($w['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  echo "
	    <tr><td class=nac>$cnt</td>
		<td $cls><a href='sysfo.php?syxec=prgbppp&md=0&prid=$w[ID]'>$w[KodeJurusan]</a></td><td $cls>$w[JUR]</td>
	    <td $cls>$w[KodeProgram]</td><td $cls>$w[PRG]</td>
		<td $cls>$w[Nama]</td><td $cls><img src='image/book$w[NotActive].gif'></td></tr>";
	}
	echo "</table>";
  }
  function GetNamaBPP($nma) {
    $r = mysql_query("select Nama from bpppokok group by Nama") or die('Tidak dapat menjalankan query');
	$a = "<option value=''></option>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Nama'] == $nma) $a .= "<option value='$w[Nama]' selected>$w[Nama]</option>";
	  else $a .= "<option value='$w[Nama]'>$w[Nama]</option>";
	}
	return $a;
  }
  function FormPrgBPPP($md, $prid=0) {
    global $strCantQuery;
    if ($md ==0) {
	  $s = "select * from prgbpppokok where ID=$prid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $kdj = mysql_result($r, 0, 'KodeJurusan');
	  $kdp = mysql_result($r, 0, 'KodeProgram');
	  $nma = mysql_result($r, 0, 'Nama');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = 'Edit Program BPP Pokok';
	}
	else {
	  $kdj = ''; $kdp = ''; $nma = ''; $NA = '';
	  $jdl = 'Tambah Program BPP Pokok';
	}
	$optkdj = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	$optkdp = GetOption2('program', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdp, '', 'Kode');
	$optbppp = GetNamaBPP($nma);
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='prgbppp'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='prid' value='$prid'>
	<tr><th colspan=2 class=ttl>$jdl</th></tr>
	<tr><td class=uline>Jurusan</td><td class=uline><select name='kdj'>$optkdj</select></td></tr>
	<tr><td class=uline>Program</td><td class=uline><select name='kdp'>$optkdp</select></td></tr>
	<tr><td class=uline>BPP Pokok</td><td class=uline><select name='nma'>$optbppp</select></td></tr>
	<tr><td class=uline>Tidak aktif</td><td class=uline><input type=checkbox name='NA' value='Y' $NA></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcprg' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name='Batal' value='Batal' onClick='location="sysfo.php?syxec=prgbppp&PHPSESSID=$sid"'></td></tr>
	</form></table>
EOF;
  }
  function PrcPrgBPPP() {
    global $strCantQuery, $fmtErrorMsg;
	$md = $_REQUEST['md'];
	$prid = $_REQUEST['prid'];
	$kdj = $_REQUEST['kdj'];
	$kdp = $_REQUEST['kdp'];
	$nma = $_REQUEST['nma'];
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	if ($md == 0) {
	  $s = "update prgbpppokok set KodeJurusan='$kdj', KodeProgram='$kdp', Nama='$nma', NotActive='$NA'
	  where ID=$prid";
	  mysql_query($s) or die("$strCantQuery: $s");
	}
	else {
	  $ada = GetaField('prgbpppokok', "KodeJurusan='$kdj' and KodeProgram", $kdp, 'ID');
	  if (empty($ada)) {
	    $s = "insert into prgbpppokok (KodeJurusan, KodeProgram, Nama, NotActive) values
	    ('$kdj', '$kdp', '$nma', '$NA')";
	    mysql_query($s) or die("$strCantQuery: $s");
	  }
	  else DisplayHeader($fmtErrorMsg, "Jurusan: <b>$kdj</b> dan Program: <b>$kdp</b> telah memiliki BPP Pokok.<br>
	    Proses penyimpanan dibatalkan.");
	}
	
	return -1;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['prid'])) $prid = $_REQUEST['prid']; else $prid = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Setup Program BPP Pokok');
  if (isset($_REQUEST['prcprg'])) $md = PrcPrgBPPP();
  if ($md == -1) GetPrgBPPP();
  else FormPrgBPPP($md, $prid);
?>