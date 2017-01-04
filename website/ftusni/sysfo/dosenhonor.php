<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // Fungsi2
  function WriteHeaderDosenHonor() {
    echo "<tr><td class=nac><img src='image/bawah.gif' border=0></td><td class=nac>Kode MK</td>
	  <td class=nac>Mata Kuliah</td><td class=nac>SKS</td>
	  <td class=nac>Program</td>
	  <td class=nac>Honor</td><td class=nac>Transport</td>
	  <td class=nac>Pembulatan</td><td class=nac>Tetap</td><td class=nac>KUM</td>
	  <td class=nac>Deft</td><td class=nac>Man</td><td class=nac>Rst</td></tr>";
  }
  function WriteFooterDosenHonor() {
    echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><td class=ttl>Def</td><td class=uline>Set honor ke nilai Default</td></tr>
	  <tr><td class=ttl>Man</td><td class=uline>Edit honor secara manual</td></tr>
	  <tr><td class=ttl>Rst</td><td class=uline>Reset honor menjadi Rp. 0</td></tr>
	  </table><br>
EOF;
  }
  function DispDosenHonor($thn, $kdj) {
    $s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN, prg.Nama_Indonesia as PRG
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join program prg on j.Program=prg.Kode
	  left outer join jabatanorganisasi jo on d.JabatanOrganisasi=jo.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by d.Name, prg.Nama_Indonesia";
	$r = mysql_query($s) or die ("Error: $s.<br>".mysql_error());
	$did = 0;
	$sks = 0;
	echo "<br><table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']){
	    if ($did != 0) echo "<tr><td colspan=3 align=right>Total SKS:</td><td class=ttl align=right><b>$sks</td></tr>";
		$sks = 0;
	    $did = $w['IDDosen'];
	    $optjo = GetOption2('jabatanorganisasi', 'Nama', 'Rank', $w['JabatanOrganisasi'], '', 'Kode');
		echo "<tr><td>&nbsp;</td></tr>
	      <form action='sysfo.php' method=POST>
		  <input type=hidden name='syxec' value='dosenhonor'>
		  <input type=hidden name='did' value='$w[IDDosen]'>
		  <input type=hidden name='thn' value='$thn'>
		  <input type=hidden name='kdj' value='$kdj'>
		  <input type=hidden name='prcjo' value=1>
		  <tr><td class=ttl colspan=4><b>$w[DSN]</td>
		  <td class=ttl colspan=9><select name='jo' onChange='this.form.submit()'>$optjo</select></td>
		  </tr></form>";
		WriteHeaderDosenHonor();
	  }
	  $sks += $w['SKS'];
	  $w['Honor'] = number_format($w['Honor'], 0, ',', '.');
	  $w['Transport'] = number_format($w['Transport'], 0, ',', '.');
	  $w['Pembulatan'] = number_format($w['Pembulatan'], 0, ',', '.');
	  $w['Tetap'] = number_format($w['Tetap'], 0, ',', '.');
	  $w['KUM'] = number_format($w['KUM'], 0, ',', '.');

	  echo <<<EOF
	  <tr><td class=uline><img src='image/brch.gif'></td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[PRG]</td>
	  <td class=lst align=right>$w[Honor]</td>
	  <td class=lst align=right>$w[Transport]</td>
	  <td class=lst align=right>$w[Pembulatan]</td>
	  <td class=lst align=right>$w[Tetap]</td>
	  <td class=lst align=right>$w[KUM]</td>
	  <td class=lst align=center><a href='sysfo.php?syxec=dosenhonor&jid=$w[ID]&prcdef=1'><img src='image/check.gif' border=0 Title='Set honor ke nilai default'></a></td>
	  <td class=lst align=center><a href='sysfo.php?syxec=dosenhonor&jid=$w[ID]&md=0'><img src='image/abs.gif' border=0 Title='Edit nilai honor secara manual'></a></td>
	  <td class=lst align=center><a href='sysfo.php?syxec=dosenhonor&jid=$w[ID]&prcrst=1'><img src='image/N.gif' border=0 Title='Reset honor menjadi 0'></a></td>
	  </tr>
EOF;
	}
	echo "<tr><td colspan=3 align=right>Total SKS:</td><td class=ttl align=right><b>$sks</td></tr>";
	echo "</table><br>";
	WriteFooterDosenHonor();
  }
  function PrcJabatanOrganisasi() {
	$jo = $_REQUEST['jo'];
	$thn = $_REQUEST['thn'];
	$kdj = $_REQUEST['kdj'];
	$did = $_REQUEST['did'];
	$s = "update jadwal set JabatanOrganisasi='$jo'
	  where IDDosen=$did and Tahun='$thn' and KodeJurusan='$kdj'";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
  }
  function PrcHonorDefault() {
    $jid = $_REQUEST['jid'];
	$arrj = GetFields('jadwal', 'ID', $jid, 'KodeJurusan,Program');
	$arrjp = GetFields('jurprg', "KodeJurusan='$arrj[KodeJurusan]' and KodeProgram", $arrj['Program'], '*');
	if (!empty($arrjp)) {
	  $s = "Update jadwal set Honor=$arrjp[Honor], Transport=$arrjp[Transport],
	    Pembulatan=$arrjp[Pembulatan], Tetap=$arrjp[Tetap], KUM=$arrjp[KUM]
		where ID=$jid ";
	  $r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	}
  }
  function EditDosenHonor() {
    $jid = $_REQUEST['jid'];
	$arrj = GetFields('jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join program prg on j.Program=prg.Kode', 'j.ID', $jid, 'j.*, d.Name as DSN, prg.Nama_Indonesia as PRG');
	if (!empty($arrj)) {
	  $snm = session_name();
	  $sid = session_id();
	  echo <<<EOF
	  <br><table class=box cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='dosenhonor'>
	  <input type=hidden name='jid' value=$jid>

	  <tr><th class=ttl colspan=2>Edit Nilai Honor Manual</th></tr>
	  <tr><td class=lst>Mata Kuliah</td><td class=lst>$arrj[KodeMK] - $arrj[NamaMK] ($arrj[SKS] SKS)</td></tr>
	  <tr><td class=lst>Program</td><td class=lst>$arrj[Program] - $arrj[PRG]</td></tr>
	  <tr><td class=lst>Nama Dosen</td><td class=lst>$arrj[DSN]</td></tr>
	  <tr><td class=lst>Jabatan &nbsp;</td><td class=lst>$arrj[JabatanOrganisasi]</td></tr>
	  <tr><th class=ttl colspan=2><b>Honor</th></tr>
	  <tr><td class=lst>Honor per Hadir</td><td class=lst><input type=text name='Honor' value='$arrj[Honor]' size=12 maxlength=12></td></tr>
	  <tr><td class=lst>Transport per Hadir</td><td class=lst><input type=text name='Transport' value='$arrj[Transport]' size=12 maxlength=12></td></tr>
	  <tr><td class=lst>Pembulatan 1x</td><td class=lst><input type=text name='Pembulatan' value='$arrj[Pembulatan]' size=12 maxlength=12></td></tr>
	  <tr><td class=lst>Tetap</td><td class=lst><input type=text name='Tetap' value='$arrj[Tetap]' size=12 maxlength=12></td></tr>
	  <tr><td class=lst>KUM</td><td class=lst><input type=text name='KUM' value='$arrj[KUM]' size=12 maxlength=12></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcedit' value='Simpan'>&nbsp;
	    <input type=reset name=reset value='Reset'>&nbsp;
		<input type=button name=batal value='Batal' onClick="location='sysfo.php?syxec=dosenhonor&$snm=$sid'"></td></tr>
	  </form></table><br>
EOF;
	}
  }
  function PrcEditDosenHonor() {
    $jid = $_REQUEST['jid'];
	$Honor = $_REQUEST['Honor']+0;
	$Transport = $_REQUEST['Transport']+0;
	$Pembulatan = $_REQUEST['Pembulatan']+0;
	$Tetap = $_REQUEST['Tetap']+0;
	$KUM = $_REQUEST['KUM']+0;
	$s = "update jadwal set Honor=$Honor, Transport=$Transport,
	  Pembulatan=$Pembulatan, Tetap=$Tetap, KUM=$KUM where ID=$jid";
	$r = mysql_query($s) or die("Error: $s");
	return -1;
  }
  function PrcResetHonor() {
    $jid = $_REQUEST['jid'];
	$s = "update jadwal set Honor=0, Transport=0, Pembulatan=0, Tetap=0, sKUM=0 where ID=$jid";
	$r = mysql_query($s) or die("Error: $s");
  }
  
  // Parameter2
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');

  if (isset($_REQUEST['prcjo'])) PrcJabatanOrganisasi();
  if (isset($_REQUEST['prcdef'])) PrcHonorDefault();
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['prcedit'])) $md = PrcEditDosenHonor();
  if (isset($_REQUEST['prcrst'])) PrcResetHonor();
  
  // Bagian Utama
  DisplayHeader($fmtPageTitle, 'Honor Dosen');
  DispOptJdwl0('dosenhonor');
  if (!empty($thn) && !empty($kdj)) {
    if ($md == -1) DispDosenHonor($thn, $kdj);
	else EditDosenHonor();
  }
?>