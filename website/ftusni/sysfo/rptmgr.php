<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  

  // *** Fungsi2 ***
  function DispDaftRpt() {
    global $strCantQuery;
	$s = "select * from rptmgr order by Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	$cnt = 0;
	echo "<br><a href='sysfo.php?syxec=rptmgr&md=1' class=lst>Tambah Report</a>";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Nama Rpt</th>
	  <th class=ttl>Keterangan</th><th class=ttl>No. Dokumen</th>
	  <th class=ttl>Script</th><th class=ttl>Nama Script</th><th class=ttl>NA</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $w['NoDok'] = StripEmpty($w['NoDok']);
	  $w['Nama'] = StripEmpty($w['Nama']);
	  echo <<<EOF
	  <tr><td class=nac align=center>$cnt</td>
	  <td class=lst><a href='sysfo.php?syxec=rptmgr&md=0&rid=$w[ID]'>$w[Rpt]</a></td>
	  <td class=lst>$w[Nama]</td>
	  <td class=lst>$w[NoDok]</td>
	  <td class=lst align=center><img src='image/$w[PakaiScript].gif' border=0></td>
	  <td class=lst>$w[Script]</td>
	  <td class=lst align=center><img src='image/$w[PakaiScript].gif' border=0></td>
	  </tr>
EOF;
	}
	echo "</table><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=ttl><img src='image/copy.gif' border=0>&nbsp;Copy</td>
	<td class=lst>Copy digunakan untuk menyalin laporan yg sama untuk tiap jurusan.</td></tr>
	</table>";
  }
  function DispRptForm($md, $rid=0) {
    global $strCantQuery;
	if ($md == 0) {
	  $s = "select * from rptmgr where ID=$rid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s. <br>".mysql_error());
	  $w = mysql_fetch_array($r);
	  $Rpt = $w['Rpt'];
	  $NoDok = $w['NoDok'];
	  $Nama = $w['Nama'];
	  if ($w['PerTahun'] == 'Y') $PerTahun = 'checked'; else $PerTahun = '';
	  if ($w['PerMhsw'] == 'Y') $PerMhsw = 'checked'; else $PerMhsw = '';
	  if ($w['PerJur'] == 'Y') $PerJur = 'checked'; else $PerJur = '';
	  if ($w['PerPrg'] == 'Y') $PerPrg = 'checked'; else $PerPrg = '';
	  if ($w['PerJnsByr'] == 'Y') $PerJnsByr = 'checked'; else $PerJnsByr = '';
	  if ($w['PerTglAwal'] == 'Y') $PerTglAwal = 'checked'; else $PerTglAwal = '';
	  if ($w['PerTglAkhir'] == 'Y') $PerTglAkhir = 'checked'; else $PerTglAkhir = '';
	  if ($w['PerBulan'] == 'Y') $PerBulan = 'checked'; else $PerBulan = '';
	  if ($w['PerStatusMhsw'] == 'Y') $PerStatusMhsw = 'checked'; else $PerStatusMhsw = '';
	  if ($w['PerAngkDari'] == 'Y') $PerAngkDari = 'checked'; else $PerAngkDari = '';
	  if ($w['PerAngkSampai'] == 'Y') $PerAngkSampai = 'checked'; else $PerAngkSampai = '';
	  if ($w['PakaiScript'] == 'Y') $PakaiScript = 'checked'; else $PakaiScript = '';
	  if ($w['NotActive'] == 'Y') $NA = 'checked'; else $NA = '';
	  $Script = $w['Script'];
	  $Author = $w['Author'];
	  $jdl = "Edit Report";
	}
	else {
	  $Rpt = '';
	  $NoDok = '';
	  $Nama = '';
	  $PerTahun = '';
	  $PerMhsw = '';
	  $PerJur = '';
	  $PerPrg = '';
	  $PerJnsByr = '';
	  $PerTglAwal = '';
	  $PerTglAkhir = '';
	  $PerBulan = '';
	  $PerStatusMhsw = '';
	  $PerAngkDari = '';
	  $PerAngkSampai = '';
	  $PakaiScript = '';
	  $NA = '';
	  $Script = '';
	  $Author = $_SESSION['uname'];
	  $jdl = "Tambah Report";
	}
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='rptmgr'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='rid' value='$rid'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Nama Report</td><td class=lst><input type=text name='Rpt' value='$Rpt' size=40 maxlength=100></td></tr>
	<tr><td class=lst>Judul</td><td class=lst><input type=text name='Nama' value='$Nama' size=40 maxlength=100></td></tr>
	<tr><td class=lst>No. Dokumen</td><td class=lst><input type=text name='NoDok' value='$NoDok' size=40 maxlength=100></td></tr>
	<tr><td class=lst>Input Tahun Ajaran</td><td class=lst><input type=checkbox name='PerTahun' value='Y' $PerTahun></td></tr>
	<tr><td class=lst>Input NIM</td><td class=lst><input type=checkbox name='PerMhsw' value='Y' $PerMhsw></td></tr>
	<tr><td class=lst>Input Jurusan</td><td class=lst><input type=checkbox name='PerJur' value='Y' $PerJur></td></tr>
	<tr><td class=lst>Input Program</td><td class=lst><input type=checkbox name='PerPrg' value='Y' $PerPrg></td></tr>
	<tr><td class=lst>Input Jenis Bayar</td><td class=lst><input type=checkbox name='PerJnsByr' value='Y' $PerJnsByr></td></tr>
	<tr><td class=lst>Input Tanggal Awal</td><td class=lst><input type=checkbox name='PerTglAwal' value='Y' $PerTglAwal></td></tr>
	<tr><td class=lst>Input Tanggal Akhir</td><td class=lst><input type=checkbox name='PerTglAkhir' value='Y' $PerTglAkhir></td></tr>
	<tr><td class=lst>Input Bulan Laporan</td><td class=lst><input type=checkbox name='PerBulan' value='Y' $PerBulan></td></tr>
	<tr><td class=lst>Input Status Mhsw</td><td class=lst><input type=checkbox name='PerStatusMhsw' value='Y' $PerStatusMhsw></td></tr>
	<tr><td class=lst>Input Dari Angkatan Mhsw</td><td class=lst><input type=checkbox name='PerAngkDari' value='Y' $PerAngkDari></td></tr>
	<tr><td class=lst>Input Sampai Angkatan</td><td class=lst><input type=checkbox name='PerAngkSampai' value='Y' $PerAngkSampai></td></tr>
	<tr><td class=lst>Gunakan Script</td><td class=lst><input type=checkbox name='PakaiScript' value='Y' $PakaiScript><input type=text name='Script' value='$Script' size=30 maxlength=100></td></tr>
	<tr><td class=lst>Pembuat</td><td class=lst><input type=text name='Author' value='$Author' size=40 maxlength=100></td></tr>
	
	<tr><td class=lst colspan=2>
	  <input type=submit name='prcmgr' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=rptmgr&PHPSESSID=$sid'">
	</td></tr>
	</form></table>
EOF;
  }
  function PrcRptMgr() {
    global $strCantQuery;
    $md = $_REQUEST['md'];
	$rid = $_REQUEST['rid'];
	$Rpt = FixQuotes($_REQUEST['Rpt']);
	$Nama = FixQuotes($_REQUEST['Nama']);
	$NoDok = FixQuotes($_REQUEST['NoDok']);
	$Author = FixQuotes($_REQUEST['Author']);
	$Script = $_REQUEST['Script'];
	if (isset($_REQUEST['PerTahun'])) $PerTahun = $_REQUEST['PerTahun']; else $PerTahun = 'N';
	if (isset($_REQUEST['PerMhsw'])) $PerMhsw = $_REQUEST['PerMhsw']; else $PerMhsw = 'N';
	if (isset($_REQUEST['PerJur'])) $PerJur = $_REQUEST['PerJur']; else $PerJur = 'N';
	if (isset($_REQUEST['PerPrg'])) $PerPrg = $_REQUEST['PerPrg']; else $PerPrg = 'N';
	if (isset($_REQUEST['PerJnsByr'])) $PerJnsByr = $_REQUEST['PerJnsByr']; else $PerJnsByr = 'N';
	if (isset($_REQUEST['PerTglAwal'])) $PerTglAwal = $_REQUEST['PerTglAwal']; else $PerTglAwal = 'N';
	if (isset($_REQUEST['PerTglAkhir'])) $PerTglAkhir = $_REQUEST['PerTglAkhir']; else $PerTglAkhir = 'N';
	if (isset($_REQUEST['PerBulan'])) $PerBulan = $_REQUEST['PerBulan']; else $PerBulan = 'N';
	if (isset($_REQUEST['PerStatusMhsw'])) $PerStatusMhsw = $_REQUEST['PerStatusMhsw']; else $PerStatusMhsw = 'N';
	if (isset($_REQUEST['PerAngkDari'])) $PerAngkDari = $_REQUEST['PerAngkDari']; else $PerAngkDari = 'N';
	if (isset($_REQUEST['PerAngkSampai'])) $PerAngkSampai = $_REQUEST['PerAngkSampai']; else $PerAngkSampai = 'N';
	if (isset($_REQUEST['PakaiScript'])) $PakaiScript = $_REQUEST['PakaiScript']; else $PakaiScript = 'N';
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	if ($md == 0) {
	  $s = "update rptmgr set Rpt='$Rpt', NoDok='$NoDok', Nama='$Nama',
	    PerTahun='$PerTahun', PerMhsw='$PerMhsw', PerJur='$PerJur', 
		PerPrg='$PerPrg', PerJnsByr='$PerJnsByr',
		PerTglAwal='$PerTglAwal', PerTglAkhir='$PerTglAkhir', PerBulan='$PerBulan',
		PerStatusMhsw='$PerStatusMhsw', PerAngkDari='$PerAngkDari', PerAngkSampai='$PerAngkSampai',
		PakaiScript='$PakaiScript', Script='$Script', NotActive='$NA', Author='$Author'
		where ID='$rid'  ";
	}
	else {
	  $s = "insert into rptmgr(Rpt, NoDok, Nama, PerTahun, PerMhsw, PerJur, PerPrg, PerJnsByr,
	    PerTglAwal, PerTglAkhir, PerBulan,
	    PerStatusMhsw, PakaiScript, Script, NotActive, Author) values ('$Rpt', '$NoDok', '$Nama',
		'$PerTahun', '$PerMhsw', '$PerJur', '$PerPrg', '$PerJnsByr',
		'$PerTglAwal', '$PerTglAkhir', '$PerBulan', '$PerStatusMhsw',
		'$PakaiScript', '$Script', '$NA', '$Author')";
	}
    $r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	return -1;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['rid'])) $rid = $_REQUEST['rid']; else $rid = 0;
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Pengelolaan Laporan");
  if (isset($_REQUEST['cp'])) PrcCopyRptMgr($_REQUEST['cp']);
  if (isset($_REQUEST['prcmgr'])) $md = PrcRptMgr();
  if ($md == -1) {
    DispDaftRpt();
  }
  else {
    DispRptForm($md, $rid);
  }
?>