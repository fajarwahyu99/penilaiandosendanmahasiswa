<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  // *** FUNGSI2 ***
  function DispPrefixGlobal() {
    global $strCantQuery;
	function GetPrefixNIM() {
	  global $strCantQuery;
      $s = "select * from setupnim limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  return $r;
	}
	$r = GetPrefixNIM();
	if (mysql_num_rows($r) == 0) {
	  $s = "insert into setupnim (NIMPrefix, NIMDescription, NIMDigit, NIMNumber)
	    values(DATE_FORMAT(now(), '%Y'), '', 5, '')";
	  $z = mysql_query($s) or die("$strCantQuery: $s<br>". mysql_error());
	  $r = GetPrefixNIM();
	}
	$prf = mysql_result($r, 0, 'NIMPrefix');
	$dsc = mysql_result($r, 0, 'NIMDescription');
	$dgt = mysql_result($r, 0, 'NIMDigit');
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='prefixnim'>
	  <tr><th class=ttl colspan=2>Prefix Global</th></tr>
	  <tr><td class=lst>Prefix NIM aktif</td><td class=lst><input type=text name='prf' value='$prf' size=10 maxlength=10></td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst><input type=text name='dsc' value='$dsc' size=30 maxlength=100></td></tr>
	  <tr><td class=lst>Jumlah Digit</td><td class=lst><input type=text name='dgt' value='$dgt' size=5 maxlength=5></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcglo' value='Simpan'>&nbsp;<input type=reset name='reset' value='Reset'></td></tr>
	  </form></table><br>
EOF;
  }
  function PrcGlobal() {
    global $strCantQuery;
    $prf = FixQuotes($_REQUEST['prf']);
	$dsc = FixQuotes($_REQUEST['dsc']);
	$dgt = $_REQUEST['dgt'];
	$s = "update setupnim set NIMPrefix='$prf', NIMDescription='$dsc', NIMDigit='$dgt' ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function DispPrefixJurusan() {
    global $strCantQuery;
	$s = "select j.Kode, j.Nama_Indonesia as JUR, j.KodeFakultas,
	  f.Nama_Indonesia as FAK, j.Prefix, jj.Nama as JEN
	  from jurusan j left outer join fakultas f on j.KodeFakultas=f.Kode
	  left outer join jenjangps jj on j.Jenjang=jj.Kode
	  order by j.KodeFakultas, j.Kode, j.Nama_Indonesia ";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=8>Sub Prefix</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl colspan=2>Jurusan</th><th class=ttl colspan=2>Fakultas</th>
	  <th class=ttl>Jenjang</th><th class=ttl>Sub Prefix</th><th class=ttl>Prg</th>
	  </tr>";
	$sid = session_id();
	$snm = session_name();
	$no = 0;
	while ($w = mysql_fetch_array($r)) {
	  $no++;
	  echo <<<EOF
	  <tr><th class=ttl>$no</th>
	  <td class=lst><b>$w[Kode]</b></td>
	  <td class=lst>$w[JUR]</td><td class=lst>$w[JEN]</td>
	  <td class=lst>$w[KodeFakultas]</td><td class=lst>$w[FAK]</td>
	  <form action='sysfo.php' method=GET>
	  <td class=lst>
	  <input type=hidden name='syxec' value='prefixnim'>
	  <input type=hidden name='kdj' value='$w[Kode]'>
	  <input type=text name='prf' value='$w[Prefix]' size=5 maxlength=5>
	  <input type=submit name='prcsub' value='Simpan'></td>
	  <td class=lst><input type=button name='addprg' value='+ Prg' title='Tambah Program' onClick="location='sysfo.php?syxec=prefixprg&kdj=$w[Kode]&md=1&$snm=$sid'"></td>
	  </form>
	  </tr>
EOF;
	  DispPrefixPrg($w['Kode']);
	}
  }
  function DispPrefixPrg($jur) {
    $s = "select jp.*, p.Nama_Indonesia as PRG
	  from jurprg jp left outer join program p on jp.KodeProgram=p.Kode
	  where jp.KodeJurusan='$jur' order by jp.KodeProgram
	  ";
	$r = mysql_query($s) or die(mysql_error());
	echo "<tr><td></td><td colspan=7>
	  <table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  echo <<<EOF
	  <tr><td class=lst width=10><img src='image/brch.gif' border=0></td>
	  <th class=ttl><a href='sysfo.php?syxec=prefixprg&md=0&kdj=$w[KodeJurusan]&kdp=$w[KodeProgram]&jpid=$w[ID]' title='Edit Prefix'>$w[KodeProgram]</a></th>
	  <td class=lst width=300>Program: <a href='sysfo.php?syxec=prefixprg&md=0&kdj=$w[KodeJurusan]&kdp=$w[KodeProgram]&jpid=$w[ID]' title='Edit Prefix'>$w[PRG]</a></td>
	  <td class=lst>Prefix Prg: <b class=ttl>$w[Prefix]<b></td>
	  </tr>
EOF;
	}
	echo "</table></td></tr>";
  }
  function PrcSubPrefix() {
    $kdj = FixQuotes($_REQUEST['kdj']);
	$prf = $_REQUEST['prf'];
	mysql_query("update jurusan set Prefix='$prf' where Kode='$kdj'");
  }

  // *** PARAMETER2 ***
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Prefix NIM Global & Jurusan");
  if (isset($_REQUEST['prcglo'])) PrcGlobal();
  if (isset($_REQUEST['prcsub'])) PrcSubPrefix();
  DispPrefixGlobal();
  DispPrefixJurusan();

?>