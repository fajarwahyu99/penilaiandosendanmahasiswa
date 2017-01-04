<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function GetOptionDosenMhsw($did) {
    $s = "select m.DosenID as DID, concat(d.Name, ', ', d.Gelar) as DSN
	  from mhsw m left outer join dosen d on m.DosenID=d.ID
	  where m.NotActive='N'
	  group by m.DosenID";
	$r = mysql_query($s) or die(mysql_error());
	$ret = '';
	while ($w = mysql_fetch_array($r)) {
	  if ($w['DID'] == $did) $ret .= "<option value='$w[DID]' selected>$w[DSN]</option>";
	  else $ret .= "<option value='$w[DID]'>$w[DSN]</option>";
	}
	return $ret;
  }
  function DispFilterIPKIPS($thn, $kdj, $kdp, $did, $ipks, $ip1, $ip2, $urt) {
    $optkdj = GetOption2("jurusan", "concat(Kode, ' -- ', Nama_Indonesia)", "Kode, Nama_Indonesia", $kdj, "", 'Kode');
    $optkdp = GetOption2("program", "concat(Kode, ' -- ', Nama_Indonesia)", "Kode, Nama_Indonesia", $kdp, "", 'Kode');
	$optdid = GetOptionDosenMhsw($did);
	
	$ipk = ''; $ips = '';
	if ($ipks == 'IPK') $ipk = 'checked';
	elseif ($ipks == 'IPS') $ips = 'checked';
	
	$kd = ''; $ksd = ''; $sd = ''; $ld = ''; $lsd = '';
	$urtip = ''; $urtnim = '';
	if ($urt == 'IP') $urtip = 'checked'; else $urtnim = 'checked';
	
	echo <<<EOF
	<table class=box cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='mhswipkips'>
	<tr><td class=uline>Jurusan: </td><td class=uline><select name='kdj'>$optkdj</select></td></tr>
	<tr><td class=uline>Program: </td><td class=uline><select name='kdp'>$optkdp</select></td></tr>
	<tr><td class=uline>Dosen Pembimbing:</td><td class=uline><select name='did'>$optdid</select></td></tr>
	<tr><td class=uline rowspan=2>Monitor IPK/IPS: </td>
	  <td class=uline><input type=radio name='ipks' value='IPK' $ipk>IPK</td></tr>
	  <tr><td class=uline><input type=radio name='ipks' value='IPS' $ips>IPS.&nbsp;
	  Tahun Ajaran:<input type=text name='thn' value='$thn' size=5 maxlength=5></td></tr>
	<tr><td class=uline>Range IP: </td><td class=uline>Dari <input type=text name='ip1' value='$ip1' size=5 maxlength=5>&nbsp;
	  Sampai <input type=text name='ip2' value='$ip2' size=5 maxlength=5></td></tr>
	<tr><td class=uline>Urut berdasarkan:</td><td class=uline><input type=radio name='urt' value='IP' $urtip>IP&nbsp;
	  <input type=radio name='urt' value='NIM' $urtnim>NIM</td></tr>
	
	<tr><td class=uline colspan=2><input type=submit name='prcipkips' value='Refresh'></td></tr>
	</form></table>
EOF;
  }
  function PrcIPKIPS($thn, $kdj, $kdp, $did, $ipks, $ip1, $ip2, $urt) {
    //echo "<H3>$mip</H3>";
	if (!empty($thn)) $strthn = "and khs.Tahun='$thn'"; else $strthn = '';
    if (!empty($kdj)) $strkdj = "and m.KodeJurusan='$kdj'"; else $strkdj = '';
	if (!empty($kdp)) $strkdp = "and m.KodeProgram='$kdp'"; else $strkdp = '';
	if (!empty($did)) $strdid = "and m.DosenID='$did'"; else $strdid = '';
	
    if ($ipks == 'IPK') {
	  if ($urt == 'IP') $strurt = ", m.IP DESC";
	  elseif ($urt = 'NIM') $strurt = ", m.NIM";
	  else $urt = '';
	  $s = "select m.NIM, m.Name, m.IPK as IP,
	    m.KodeProgram, prg.Nama_Indonesia as PRG,
		m.KodeJurusan, jur.Nama_Indonesia as JUR,
		concat(d.Name, ', ', d.Gelar) as DSN
	    from mhsw m
		left outer join program prg on m.KodeProgram=prg.Kode
		left outer join jurusan jur on m.KodeJurusan=jur.Kode
		left outer join dosen d on m.DosenID=d.ID
		where m.NotActive='N' $strkdj $strkdp $strdid
		and $ip1 <= m.IPK and m.IPK <= $ip2
		order by m.KodeProgram, m.KodeJurusan $strurt";
	}
	else {
	  if ($urt == 'IP') $strurt = ", (khs.Bobot / khs.SKS) DESC";
	  elseif ($urt = 'NIM') $strurt = ", m.NIM";
	  else $urt = '';
	  $s = "select khs.*, (khs.Bobot / khs.SKS) as IP,
	    m.Name,
	    m.KodeProgram, prg.Nama_Indonesia as PRG,
		m.KodeJurusan, jur.Nama_Indonesia as JUR,
		concat(d.Name, ', ', d.Gelar) as DSN
	    from khs khs left outer join mhsw m on khs.NIM=m.NIM
		left outer join program prg on m.KodeProgram=prg.Kode
		left outer join jurusan jur on m.KodeJurusan=jur.Kode
		left outer join dosen d on m.DosenID=d.ID
		where m.NotActive='N' $strkdj $strkdp $strdid $strthn
		and khs.Tahun='$thn'
		and $ip1 <= (khs.Bobot / khs.SKS) and (khs.Bobot / khs.SKS) <= $ip2
		order by m.KodeProgram, m.KodeJurusan $strurt";
	}
	$r = mysql_query($s) or die(mysql_error());
	$no = 0;
	$_kdp = '';
	echo "<table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['KodeProgram'] != $_kdp) {
	    $_kdp = $w['KodeProgram'];
		$_kdj = '';
		echo "<tr><td>&nbsp;</td></tr>
		  <tr><td class=ttl colspan=5><b>$_kdp - $w[PRG]</td></tr>";
	  }
	  if ($w['KodeJurusan'] != $_kdj) {
	    $_kdj = $w['KodeJurusan'];
		echo "<tr><td class=uline><img src='image/brch.gif' border=0></td>
		  <td class=uline colspan=5><b>$_kdj - $w[JUR]</td></tr>";
		WriteHeaderIPKIPS($ipks);
		$no = 0;
	  }
	  $no++;
	  $w['IP'] = number_format($w['IP'], 2, '.', ',');
	  echo <<<EOF
	  <tr><td>&nbsp;</td><td class=ttl>$no</td>
	  <td class=lst><a href='sysfo.php?syxec=mhswipk&nim=$w[NIM]'>$w[NIM]</a>&nbsp;</td>
	  <td class=lst>$w[Name]</td>
	  <td class=lst align=right>$w[IP]</td>
	  <td class=lst>$w[DSN]</td>
	  </tr>
EOF;
	}
	echo "</table><br>";
  }
  function WriteHeaderIPKIPS($ipks) {
    echo "<tr><td>&nbsp;</td><td class=nac>#</td><td class=nac>NIM</td><td class=nac>Mahasiswa</td>
	<td class=nac>$ipks</td><td class=nac>Pembimbing</td></tr>";
  }
  
  // *** Parameter2 ***
  $thn = GetSetVar('thn', '');
  $kdj = GetSetVar('kdj', '');
  $kdp = GetSetVar('kdp', '');
  $did = GetSetVar('did', '');
  $ipks = GetSetVar('ipks', 'IPK');
  $ip1 = GetSetVar('ip1', 0);
  $ip2 = GetSetVar('ip2', 4);
  $urt = GetSetVar('urt', 'IP');
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Monitor $ipks Mahasiswa");
  DispFilterIPKIPS($thn, $kdj, $kdp, $did, $ipks, $ip1, $ip2, $urt);
  if (isset($_REQUEST['prcipkips'])) PrcIPKIPS($thn, $kdj, $kdp, $did, $ipks, $ip1, $ip2, $urt);

?>