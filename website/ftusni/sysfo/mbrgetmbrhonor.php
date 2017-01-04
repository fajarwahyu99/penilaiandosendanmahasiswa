<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  
  // *** Fungsi2 ***
  function DispHonorMGM() {
    global $strCantQuery;
	$s = "select h.*, p.Nama_Indonesia as PRG, s.Nama as STA
	  from honormgm h left outer join program p on h.KodeProgram=p.Kode
	  left outer join statusawalmhsw s on h.StatusAwal=s.Kode
	  order by p.Nama_Indonesia";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	echo <<<EOF
	<a href='sysfo.php?syxec=mbrgetmbrhonor&md=1'>Tambahkan Honor</a><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><th class=ttl colspan=2>Program</th><th class=ttl>Mhsw</th>
	<th class=ttl>Honor</th><th class=ttl>NA</th></tr>
EOF;
	while ($w = mysql_fetch_array($r)) {
	  if ($w['NotActive'] == 'Y') { $cls = 'class=nac'; }
	  else { $cls = 'class=lst'; }
	  $hnr = number_format($w['PMBHonor'], 0, ',', '.');
	  if (empty($w['STA'])) $w['STA'] = '&nbsp;';
	  echo <<<EOF
	  <tr><td $cls>$w[KodeProgram]</td>
	  <td $cls><a href='sysfo.php?syxec=mbrgetmbrhonor&hnrid=$w[ID]&md=0'>$w[PRG]</a></td>
	  <td $cls>$w[STA]</td>
	  <td $cls align=right>$hnr</td>
	  <td $cls align=center><img src='image/book$w[NotActive].gif'></td>
	  <tr>
EOF;
	}
	echo "</table><br>";
  }
  function EditHonorMGM($md, $hnrid) {
    if ($md == 0) {
	  $arrhnr = GetFields('honormgm', 'ID', $hnrid, '*');
	  if ($arrhnr['NotActive'] == 'Y') $na = 'checked'; else $na = '';
	  $jdl = 'Edit Honor MGM';
	}
	else {
	  $arrhnr = array();
	  $arrhnr['ID'] = 0;
	  $arrhnr['KodeProgram'] = '';
	  $arrhnr['StatusAwal'] = 'B';
	  $arrhnr['PMBHonor'] = 0;
	  $na = '';
	  $jdl = "Tambah Honor MGM";
	}
	$optprg = GetOption2('program', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $arrhnr['KodeProgram'], '', 'Kode');
	$optsta = GetOption2('statusawalmhsw', 'Nama', 'Nama', $arrhnr['StatusAwal'], '', 'Kode');
	$snm = session_name(); $sid = session_id();
    echo <<<EOF
	<table class=basic cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='mbrgetmbrhonor'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='hnrid' value='$hnrid'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Program</td><td class=lst><select name='KodeProgram'>$optprg</select></td></tr>
	<tr><td class=lst>Status Awal Mahasiswa</td><td class=lst><select name='StatusAwal'>$optsta</select></td></tr>
	<tr><td class=lst>Honor MBM</td><td class=lst><input type=text name='PMBHonor' value='$arrhnr[PMBHonor]'size=10 maxlength=10></td></tr>
	<tr><td class=lst>Not Active</td><td class=lst><input type=checkbox name='NA' value='Y' $na></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prchnr' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name='Batal' value='Batal' onClick="location='sysfo.php?syxec=mbrgetmbrhonor&$snm=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcHonorMGM($md, $hnrid) {
    global $fmtErrorMsg, $fmtMessage;
    $KodeProgram = $_REQUEST['KodeProgram'];
	$StatusAwal = $_REQUEST['StatusAwal'];
	$PMBHonor = $_REQUEST['PMBHonor'];
	if (isset($_REQUEST['NA'])) $na = $_REQUEST['NA']; else $na = 'N';
	if ($md == 0) {
	  $s = "update honormgm set PMBHonor='$PMBHonor', NotActive='$na' where ID=$hnrid";
	  $r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	  DisplayDetail($fmtMessage, "Berhasil", "Penyuntingan honor berhasil.");
	}
	else {
	  $ada = GetaField('honormgm', "KodeProgram='$KodeProgram' and StatusAwal", $StatusAwal, 'ID');
	  if (!empty($ada)) {
	    $strprg = GetaField('program', 'Kode', $KodeProgram, 'Nama_Indonesia');
	    $strsta = GetaField('statusawalmhsw', 'Kode', $StatusAwal, 'Nama');
	    DisplayHeader($fmtErrorMsg, "Honor untuk program <b>$strprg</b> dan untuk status awal mahasiswa <b>$strsta</b>
	      sudah ada. Anda tidak dapat dua kali mendaftarkannya.<hr>
		  Pilihan: <a href='sysfo.php?syxec=mbrgetmbrhonor'>Kembali</a>");
	  }
	  else {
	    $s = "insert into honormgm (KodeProgram, StatusAwal, PMBHonor, NotActive)
		  values('$KodeProgram', '$StatusAwal', '$PMBHonor', '$na')";
		$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
		DisplayDetail($fmtMessage, "Berhasil", "Penambahan honor berhasil.");
	  }
	}
	return -1;
  }
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['hnrid'])) $hnrid = $_REQUEST['hnrid']; else $hnrid = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Honor Program Member Get Member");
  if (isset($_REQUEST['prchnr'])) $md = PrcHonorMGM($md, $hnrid);
  if ($md == -1) DispHonorMGM();
  else EditHonorMGM($md, $hnrid);
?>