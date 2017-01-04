<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispHonorperProgram() {
    $s = "select jp.*, jur.Nama_Indonesia as JUR, prg.Nama_Indonesia as PRG
	  from jurprg jp left outer join jurusan jur on jp.KodeJurusan=jur.Kode
	  left outer join program prg on jp.KodeProgram=prg.Kode
	  order by jp.KodeJurusan, jp.KodeProgram";
	$r = mysql_query($s) or die(mysql_error());
	$kdp = '';
	$kdj = '';
	echo "<table class=basic cellspacing=1 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  if ($kdj != $w['KodeJurusan']) {
	    $kdj = $w['KodeJurusan'];
		echo "<tr><td>&nbsp;</td></tr>
		  <tr><td class=ttl colspan=7><b>$kdj - $w[JUR]</b></td></tr>
		  <tr><td class=nac><img src='image/bawah.gif'></td><td class=nac>Program</td><td class=nac>Honor</td>
		  <td class=nac>Transport</td><td class=nac>Pembulatan</td>
		  <td class=nac>Tetap</td>
		  <td class=nac>KUM</td></tr>";
	  }
	  $w['Honor'] = number_format($w['Honor'], 0, ',', '.');
	  $w['Transport'] = number_format($w['Transport'], 0, ',', '.');
	  $w['Pembulatan'] = number_format($w['Pembulatan'], 0, ',', '.');
	  $w['KUM'] = number_format($w['KUM'], 0, ',', '.');
	  $w['Tetap'] = number_format($w['Tetap'], 0, ',', '.');
	  echo <<<EOF
	  <tr><td width=5><img src='image/brch.gif'></td>
	  <td class=lst><a href='sysfo.php?syxec=jurhonor&md=0&jpid=$w[ID]&kdj=$w[KodeJurusan]&kdp=$w[KodeProgram]'>$w[PRG]</td></td>
	  <td class=lst align=right>$w[Honor]</td><td class=lst align=right>$w[Transport]</td>
	  <td class=lst align=right>$w[Pembulatan]</td><td class=lst align=right>$w[KUM]</td>
	  <td class=lst align=right>$w[Tetap]</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
  }
  function EditHonorperProgram() {
    global $fmtErrorMsg;
	$jpid = $_REQUEST['jpid'];
	$arr = GetFields('jurprg', "ID", $jpid, '*');
	if (!empty($arr)) {
      $kdj = $arr['KodeJurusan'];
	  $kdp = $arr['KodeProgram'];
	  $strkdj = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	  $strkdp = GetaField('program', 'Kode', $kdp, 'Nama_Indonesia');
	  $snm = session_name();
	  $sid = session_id();
	  echo <<<EOF
	  <table class=box cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='jurhonor'>
	  <input type=hidden name='jpid' value='$jpid'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='kdp' value='$kdp'>
	  <tr><th class=ttl colspan=2>Edit Honor Standar per Program</th></tr>
	  <tr><td class=uline>Jurusan: </td><td class=uline><b>$kdj - $strkdj</td></tr>
	  <tr><td class=uline>Program: </td><td class=uline><img src='image/brch.gif'>&nbsp;<b>$kdp - $strkdp</td></tr>
	  <tr><td class=uline>Honor 2SKS:&nbsp;</td><td class=uline><input type=text name='Honor' value='$arr[Honor]' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>Transport:&nbsp;</td><td class=uline><input type=text name='Transport' value='$arr[Transport]' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>Pembulatan:&nbsp;</td><td class=uline><input type=text name='Pembulatan' value='$arr[Pembulatan]' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>Honor Tetap:&nbsp;</td><td class=uline><input type=text name='Tetap' value='$arr[Tetap]' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>KUM:&nbsp;</td><td class=uline><input type=text name='KUM' value='$arr[KUM]' size=10 maxlength=10></td></tr>
	  <tr><td class=uline colspan=2><input type=submit name='prchnr' value='Simpan'>&nbsp;
	  <input type=reset name=reset value=Reset>&nbsp;
	  <input type=button name=Batal value='Batal' onClick="location='sysfo.php?syxec=jurhonor&$snm=$sid'"></td></tr>
	  </form></table>
EOF;
	}
	else DisplayHeader($fmtErrorMsg, "Data tidak ditemukan. $kdj - $kdp");
  }
  function PrcHonorperProgram() {
    $jpid = $_REQUEST['jpid'];
	$Honor = $_REQUEST['Honor'] + 0;
	$Transport = $_REQUEST['Transport'] +0;
	$Pembulatan = $_REQUEST['Pembulatan'] +0;
	$Tetap = $_REQUEST['Tetap'] +0;
	$KUM = $_REQUEST['KUM'] +0;
	$s = "update jurprg set Honor=$Honor, Transport=$Transport, Pembulatan=$Pembulatan, KUM=$KUM, Tetap=$Tetap
	  where ID=$jpid";
	$r = mysql_query($s) or die("$s. <br>".mysql_error());
	return -1;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['prchnr'])) $md = PrcHonorperProgram();
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Honor Dosen per Program');
  if ($md == -1) DispHonorperProgram();
  else EditHonorperProgram();
?>