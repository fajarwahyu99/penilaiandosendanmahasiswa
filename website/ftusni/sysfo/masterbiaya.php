<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** FUNGSI2 ***
function FormMasterBiaya($md, $kdj, $bea) {
  global $strCantQuery, $fmtErrorMsg;
	if ($md == 0) {
	  $s = "select * from biaya where KodeJurusan='$kdj' and Kode='$bea' limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $nme = mysql_result($r, 0, 'Nama');
	  if (mysql_result($r, 0, 'NotActive')=='Y') $not = 'checked'; else $not = '';
	  $kode = "<input type=hidden name='bea' value='$bea'>$bea";
	  $jdl = 'Edit Master Biaya';
	}
	elseif ($md == 1) {
	  $bea = '';
	  $nme = '';
	  $not = '';
	  $kode = "<input type=text name='bea' size=5 maxlength=5>";
	  $jdl = 'Tambah Master Biaya';
	}
	$sid = session_id();
    return <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='masterbiaya'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='md' value='$md'>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=lst>Tahun</td><td class=lst>$kode</td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst><input type=text name='nme' value='$nme' size=30 maxlength=50></td></tr>
	  <tr><td class=lst>Not Active</td><td class=lst><input type=checkbox value='Y' name='not' $not></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcbea' value='Simpan'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick='location="sysfo.php?syxec=masterbiaya&PHPSESSID=$sid" '></td></tr>
	  </form></table>
EOF;
}
function PrcBea() {
  global $strCantQuery, $fmtErrorMsg;
	$md = $_REQUEST['md'];
	$kdj = $_REQUEST['kdj'];
	$bea = $_REQUEST['bea'];
	$nme = FixQuotes($_REQUEST['nme']);
	if (isset($_REQUEST['not'])) $not = $_REQUEST['not']; else $not = 'N';
	if ($md == 0) {
	  $s = "update biaya set Nama='$nme', NotActive='$not' where KodeJurusan='$kdj' and Kode='$bea'  ";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	}
	else {
	  $unip = $_SESSION['unip'];
	  $cek = GetaField('biaya', "KodeJurusan='$kdj' and Kode", $bea, 'Kode');
	  if (empty($cek)) {
	    $s = "insert into biaya (Kode, Nama, KodeJurusan, Tgl, unip, NotActive) values ('$bea', 
	      '$nme', '$kdj', now(), '$unip', '$not') ";
		$r = mysql_query($s) or die ("$strCantQuery: $s");
	  }
	  else DisplayHeader($fmtErrorMsg, "Tahun ajaran untuk master biaya sudah ada. Data tidak disimpan.");
	}
	return -1;
}
function StripEmpty001($str='') {
  if (empty($str)) return "<center><font size=1 color=gray>-</font>";
	else return $str;
}
function DispBiaya2($kdj, $bea, $act) {
  global $strCantQuery;
	$s = "select b.*, jb.Nama as JNSBEA, st.Nama as STAT, sta.Nama as STATA, 
	stp.Nama as STATP, pr.Nama_Indonesia as PRG
	from biaya2 b left outer join jenisbiaya jb on b.JenisBiaya=jb.ID
	left outer join statusmhsw st on b.Status=st.Kode
	left outer join statusawalmhsw sta on b.StatusAwal=sta.Kode
	left outer join statuspotongan stp on b.StatusPotongan=stp.Kode
	left outer join program pr on b.KodeProgram=pr.Kode
	where b.KodeJurusan='$kdj' and b.KodeBiaya='$bea' order by b.Kali,b.JenisBiaya,b.Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	$hdptg = "<tr><td>&nbsp;</td></tr><tr><th class=ttl colspan=11>POTONGAN : $kdj - $bea</th></tr>";
	$hdbea = "<tr><td>&nbsp;</td><tr><th class=ttl colspan=11>BIAYA : $kdj - $bea</th></tr>";
	$hdsma = "<tr>
	  <th class=ttl>Nama</th>
	  <th class=ttl>sc</th>
	  <th class=ttl>Penarikan</th>
	  <th class=ttl>Ada<br>dnd</th>
	  <th class=ttl>Oto</th>
	  <th class=ttl>Program</th>
	  <th class=ttl>Status<br>Mhsw</th>
	  <th class=ttl>Status<br>Awal</th>
	  <th class=ttl>Status<br>Potongan</th>
	  <th class=ttl>Jumlah<br>Rp.</th>
	  <th class=ttl>NA</th>
	  </tr> ";
	$kali = 0;
    $b2 = "<a href='sysfo.php?syxec=$act&md2=1' class=lst>Tambah Biaya</a> |
	  <a href='sysfo.php?syxec=masterbiayacopy&kdj=$kdj&bea=$bea' class=lst>Salin dari Master Lain</a>
	  <table class=basic cellspacing=0 cellpadding=1 width=100%>";
	while ($row = mysql_fetch_array($r)) {
	  if ($kali != $row['Kali']) {
	    $kali = $row['Kali'];
		if ($kali == -1) $b2 .= $hdptg;
		elseif ($kali == 1) $b2 .= $hdbea;
		$b2 .= $hdsma;
	  }
	  if ($row['NotActive'] == 'Y') $cls = 'class=nac'; else $cls = 'class=lst';
	  if ($row['PakaiScript'] == 'Y') $psc = "<img src='image/gear.gif' height=15>"; else $psc = '&nbsp;';
	  $stat = StripEmpty001($row['STAT']);
	  $stata = StripEmpty001($row['STATA']);
	  $statp = StripEmpty001($row['STATP']);
	  $row['PRG'] = StripEmpty001($row['PRG']);
	  if ($row['Jumlah'] < 0)  $jml = '<font color=red>'.number_format($row['Jumlah'], 2, ',', '.').'</font>';
	  else $jml = number_format($row['Jumlah'], 2, ',', '.');
	  $jnsbea = StripEmpty001($row['JNSBEA']);
	  $b2 = $b2 . "<tr>
	    <td $cls><a href='sysfo.php?syxec=$act&bid=$row[ID]&md2=0'>$row[Nama]</a></td>
	    <td $cls>$psc</td>
		<td $cls>$jnsbea</td>
		<td $cls align=center><img src='image/$row[Denda].gif' border=0></td>
		<td $cls align=center><img src='image/$row[Otomatis].gif' border=0></td>
		<td $cls>$row[PRG]</td>
		<td $cls>$stat</td>
		<td $cls>$stata</td>
		<td $cls>$statp</td>
		<td $cls align=right>$jml</td>
		<td $cls align=center><img src='image/book$row[NotActive].gif' border=0></td>
		</tr>";
	}
  return $b2 . "</table><br>
	<table class=basic cellspacing=0 cellpadding=1>
	<tr><td class=ttl><b>sc</b></td><td class=basic>script, dijalankan dengan script.</td></tr>
	<tr><td class=ttl><b>dnd</b></td><td class=basic>denda, merujuk pada jadwal pembayaran tiap semester.</td></tr>
	<tr><td class=ttl><b>oto</b></td><td class=basic>Otomatis, ditambahkan otomatis ke rek. mhsw.</td></tr>
	</table>";
}
function GetOptBiaya2($def='') {
	$s = "select Nama from biaya2 group by Nama";
	$r = mysql_query($s) or die("Gagal query: $s<br>".mysql_error());
	$a = '<option></option>';
	while ($w = mysql_fetch_array($r)) {
		if ($w['Nama'] == $def) $a .= "<option selected>$w[Nama]</option>";
		else $a .= "<option>$w[Nama]</option>";
	}
	return $a;
}
function FormMasterBiaya2($md2, $kdj, $bea, $bid) {
  global $strCantQuery;
	if ($md2 == 0) {
	  $s = "select * from biaya2 where ID=$bid";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  $nme = mysql_result($r, 0, 'Nama');
	  $oto = mysql_result($r, 0, 'Otomatis');
	  $prg = mysql_result($r, 0, 'KodeProgram');
	  $stat = mysql_result($r, 0, 'Status');
	  $statawal = mysql_result($r, 0, 'StatusAwal');
	  $statp = mysql_result($r, 0, 'StatusPotongan');
	  $jml = mysql_result($r, 0, 'Jumlah');
	  $jnsbea = mysql_result($r, 0, 'JenisBiaya');
	  $kali = mysql_result($r, 0, 'Kali');
	  $jdl = 'Edit Biaya/Potongan';
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $not = 'checked'; else $not = '';
	  if (mysql_result($r, 0, 'Denda') == 'Y') $dnd = 'checked'; else $dnd = '';
	  if (mysql_result($r, 0, 'PakaiScript') == 'Y') $psc = 'checked'; else $psc  ='';
	  $nsc = mysql_result($r, 0, 'NamaScript');
	  $cknme1 = "<input type=hidden name='isnme' value='Y'>";
	  $cknme2 = "";
	}
	else {
	  $nme = '';
	  $oto = 'N';
	  $prg = '';
	  $stat = '';
	  $statawal = '';
	  $statp = '';
	  $jml = 0;
	  $jnsbea = '';
	  $kali = 1;
	  $jdl = 'Tambah Biaya/Potongan';
	  $not = '';
	  $dnd = '';
	  $psc = '';
	  $nsc = '';
	  $optnme = GetOptBiaya2('');
	  $cknme1 = "<input type=radio name='isnme' value='Y' checked>";
	  $cknme2 = "<br><input type=radio name='isnme' value='N'><select name='oldnme'>$optnme</select>";
	}
	$klptg = ''; $klbea = '';
	if ($kali == -1) $klptg = 'checked'; else $klbea = 'checked';
	$otoy = ''; $oton = '';
	if ($oto == 'Y') $otoy = 'checked'; else $oton = 'checked';
	$optstatawal = GetOption2('statusawalmhsw', "concat(Kode, ' -- ', Nama)", 'Nama', $statawal, '', 'Kode');
	$optstat = GetOption2('statusmhsw', "concat(Kode, ' -- ', Nama)", 'Nama', $stat, 'Keluar=0', 'Kode');
	$optstatp = GetOption2('statuspotongan', "concat(Kode, ' -- ', Nama)", 'Nama', $statp, '', 'Kode');
	$optjnsbea = GetOption2('jenisbiaya', 'Nama', 'ID', $jnsbea, '', 'ID');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Nama_Indonesia', $prg, '', 'Kode');
	$sid = session_id();
	return <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='masterbiaya'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <input type=hidden name='bea' value='$bea'>
	  <input type=hidden name='bid' value='$bid'>
	  <input type=hidden name='md2' value='$md2'>
	  <tr><th colspan=2 class=ttl>$jdl</th></tr>
	  <tr><td class=uline>Nama</td><td class=uline>$cknme1<input type=text name='nme' value='$nme' size=40 maxlength=100>$cknme2</td></tr>
	  <tr><td class=uline>Jenis Account</td><td class=uline><input type=radio name='Kali' value='-1' $klptg>Potongan &nbsp;
	    <input type=radio name='Kali' value='1' $klbea>Biaya</td></tr>
	  <tr><td class=uline>Otomatis</td><td class=uline><input type=radio name='oto' value='Y' $otoy>Otomatis &nbsp;
	  <input type=radio name='oto' value='N' $oton>Manual </td></tr>
	  <tr><td class=uline>Jenis Penarikan</td><td class=uline><select name='jnsbea'>$optjnsbea</select> &nbsp;
	  <font color=red>*)</font></td></tr>

	  <tr><td class=uline>Program</td><td class=uline><select name='prg'>$optprg</select> &nbsp;
	  <font color=red>**)</font></td></tr>

	  <tr><td class=uline>Status Mhsw</td><td class=uline><select name='stat'>$optstat</select>
	  &nbsp;<font color=red>**)</font></td></tr>
	  <tr><td class=uline>Status Awal Mhsw</td><td class=uline><select name='statawal'>$optstatawal</select>
	  &nbsp;<font color=red>**)</font></td></tr>
	  <tr><td class=uline>Status Potongan</td><td class=uline><select name='statp'>$optstatp</select>
	  &nbsp;<font color=red>**)</font></td></tr>

	  <tr><td class=uline>Jumlah</td><td class=uline><input type=text name='jml' value='$jml' size=10 maxlength=11>&nbsp;rupiah</td></tr>
	  <tr><td class=uline>Ada Denda</td><td class=uline><input type=checkbox name='dnd' value='Y' $dnd></td></tr>
	  <tr><td class=uline>Not Active</td><td class=uline><input type=checkbox name='not' value='Y' $not></td></tr>
	  <tr><td class=uline>Script Pengolah<br><img src='image/gear.gif' border=0 height=15></td>
	  <td class=uline><input type=checkbox name='psc' value='Y' $psc>&nbsp;Gunakan Script Pengolah<br>
	  <input type=text name='nsc' value='$nsc' size=30 maxlength=50></td></tr>
	  <tr><td class=uline colspan=2><input type=submit name='prcbea2' value='Simpan'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=masterbiaya&PHPSESSID=$sid'"></td></tr>
	  </form></table>
	  <table class=basic cellspacing=0 cellpadding=1>
	  <tr><td class=lst><font color=red>*)</font></td><td class=basic>Harus diisi.</td></tr>
	  <tr><td class=lst><font color=red>**)</font></td><td class=basic>Kosongkan jika berlaku untuk semua.</td></tr>
	  </table>
EOF;
}
function PrcBea2() {
  global $strCantQuery;
  $kdj = $_REQUEST['kdj'];
	$bea = $_REQUEST['bea'];
	$bid = $_REQUEST['bid'];
	$nme = FixQuotes($_REQUEST['nme']);
	$Kali = $_REQUEST['Kali'];
	$oto = $_REQUEST['oto'];
	$prg = $_REQUEST['prg'];
	$jnsbea = $_REQUEST['jnsbea'];
	$stat = $_REQUEST['stat'];
	$statawal = $_REQUEST['statawal'];
	$statp = $_REQUEST['statp'];
	$jml = $_REQUEST['jml'];
	$md2 = $_REQUEST['md2'];
	if (isset($_REQUEST['not'])) $not = $_REQUEST['not']; else $not = 'N';
	if (isset($_REQUEST['dnd'])) $dnd = $_REQUEST['dnd']; else $dnd = 'N';
	if (isset($_REQUEST['psc'])) $psc = $_REQUEST['psc']; else $psc = 'N';
	$nsc = $_REQUEST['nsc'];
	if ($md2 == 0) {
	  $s = "update biaya2 set Nama='$nme', Kali=$Kali,
	    Otomatis='$oto', KodeProgram='$prg', JenisBiaya='$jnsbea', Status='$stat',
	    StatusAwal='$statawal', StatusPotongan='$statp', Jumlah='$jml', Denda='$dnd', NotActive='$not', 
		PakaiScript='$psc', NamaScript='$nsc'
		where ID=$bid ";
	}
	else {
		if ($_REQUEST['isnme'] == 'N')
		  if (!empty($_REQUEST['oldnme'])) $nme = $_REQUEST['oldnme']; else die ("Anda belum mengisi NAMA");
	  $s = "insert into biaya2 (KodeBiaya, KodeJurusan, KodeProgram, Nama, Kali, JenisBiaya, Denda, Otomatis, 
	    Status, StatusAwal, StatusPotongan,
	    Jumlah, PakaiScript, NamaScript, NotActive) 
		values ('$bea', '$kdj', '$prg', '$nme', '$Kali', '$jnsbea', '$dnd', '$oto', '$stat', '$statawal', '$statp',
		'$jml', '$psc', '$nsc', '$not') ";
	}
	$r = mysql_query($s) or die ("$strCantQuery: $s");
    return -1;
  }
  
  // *** PARAMETER2 ***
$kdj = GetSetVar('kdj');
$bea = GetSetVar('bea');
if (isset($_REQUEST['bid'])) $bid = $_REQUEST['bid']; else $bid = 0;
if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
if (isset($_REQUEST['md2'])) $md2 = $_REQUEST['md2']; else $md2 = -1;
  
// *** BAGIAN UTAMA ***
DisplayHeader($fmtPageTitle, "Master Biaya");
DispJur($kdj, 0, 'masterbiaya');
if (isset($_REQUEST['prcbea'])) $md = PrcBea();
if (isset($_REQUEST['prcbea2'])) $md2 = PrcBea2();
if (!empty($kdj)) {
  if ($md == -1) $kiri = DispBiaya($kdj, $bea, 'masterbiaya');
  else $kiri = FormMasterBiaya($md, $kdj, $bea);	

	if (!empty($bea) && ValidMasterBiaya($kdj, $bea)) {
	  if ($md2 == -1) $kanan = DispBiaya2($kdj, $bea, 'masterbiaya');
	  else $kanan = FormMasterBiaya2($md2, $kdj, $bea, $bid);
	} 
	else $kanan = DisplayItem($fmtMessage, 'Master Biaya Belum Dipilih', 
	  'Pilih salah satu set master biaya di sebelah kiri.', 0);
}
else {
  $kiri = '';
	$kanan = '';
}

?>
<table class=basic cellspacing=0 cellpadding=2 width=100%>
  <tr><td class=basic valign=top><?php echo $kiri; ?></td>
  <td class=basic background='image/vertisilver.gif' width=1></td>
  <td class=basic valign=top><?php echo $kanan; ?></td>
  </tr>
</table>
