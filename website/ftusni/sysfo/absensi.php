<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNCTION ***
  function GetJadwalMK($thn, $kdj) {
    global $strCantQuery;
	$s = "select jd.*, mk.Kode as KodeMK, mk.Nama_Indonesia as MK, concat(d.Name, ', ', d.Gelar) as Dosen,
	  pr.Nama_Indonesia as PRG, jd.Tunda
	  from jadwal jd left outer join matakuliah mk on jd.IDMK=mk.ID
	  left outer join dosen d on jd.IDDosen=d.ID
	  left outer join program pr on jd.Program=pr.Kode
	  where jd.KodeJurusan='$kdj' and jd.Tahun='$thn'
	  order by KodeMK ";
	$jdwl = new NewsBrowser();
	$jdwl->query = $s;
	$jdwl->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Program</th>
	  <th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>Dosen</th>
	  <th class=ttl>Tunda</td>
	  </tr>";
	$jdwl->detailfmt = "<tr><td class=basic>=NOMER=</td><td class=lst>=PRG=</td>
	  <td class=lst><a href='sysfo.php?syxec=absensi&jid==ID=&mhs=0'>=KodeMK=</a></td>
	  <td class=lst>=MK=</td><td class=lst>=Dosen=</td>
	  <td class=lst align=center>=Tunda=</td>
	  </tr>";
	$jdwl->footerfmt = "</table>";
	echo $jdwl->BrowseNews();
  }
  function GetAbsensi($jid) {
    global $strCantQuery;
	$tmp = '';
	for ($i=1; $i <= 20; $i++) {
	  $ck = GetaField('jadwal', 'ID', $jid, "hd_$i");
	  if ($ck == '1') {
	    $strck = 'checked';
		$strabs = "<a href='sysfo.php?syxec=absensi&jid=$jid&mhs=1&abs=$i'><img src='image/abs.gif' border=0>Absen</a>";
	  }
	  else {
	    $strck = '';
		$strabs = '';
	  }
	  $tmp = "$tmp <tr><td class=lst>Tatap muka ke-$i</td>
	    <form action='sysfo.php' method=GET>
		<input type=hidden name='syxec' value='absensi'>
		<input type=hidden name='abs' value=$i>
		<input type=hidden name='jid' value=$jid>
		<td class=lst><input type=checkbox name='hdr' value='1' $strck></td>
		<td class=lst><input type=text name='dy' value='=hr_d_$i=' size=2 maxlength=2>-<input type=text name='mn' value='=hr_m_$i=' size=2 maxlength=2>-<input type=text name='yr' value='=hr_y_$i=' size=4 maxlength=4></td>
		<td class=lst><input type=submit name='prca' value='Hadir'></td>
	    </form>
		<td class=basic>$strabs</td>
		</tr>";
	}
	$tmptgl = '';
	for ($i=1; $i <= 20; $i++) {
	  $tmptgl = "$tmptgl DATE_FORMAT(hr_$i, '%d') as hr_d_$i, DATE_FORMAT(hr_$i, '%m') as hr_m_$i,
	    DATE_FORMAT(hr_$i, '%Y') as hr_y_$i,";
	}
	$abs = new NewsBrowser();
	$abs->query = "select jd.*, $tmptgl mk.Kode as KodeMK, mk.Nama_Indonesia as MK
	  from jadwal jd left outer join matakuliah mk on jd.IDMK=mk.ID
	  where jd.ID=$jid";
	$abs->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=4>Absensi</th><th class=lst>Mhsw</th></tr>";
	$abs->detailfmt = "$tmp";
	$abs->footerfmt = "</table>";
	echo $abs->BrowseNews();
  }
  function PrcAbsensi($kdj) {
    global $strCantQuery, $fmtErrorMsg, $strTahunNotActive;
    $jid = $_REQUEST['jid'];
	$thn = GetaField('jadwal', 'ID', $jid, 'Tahun');
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	$abs = $_REQUEST['abs'];
	if (isset($_REQUEST['hdr'])) {
	  $hdr = $_REQUEST['hdr'];
	  $dy = $_REQUEST['dy'];
	  $mn = $_REQUEST['mn'];
	  $yr = $_REQUEST['yr'];
	  $strtgl = "'$yr-$mn-$dy'";
	}
	else {
	  $hdr = '0';
	  $strtgl = 'NULL';
	}
	$s = "update jadwal set hd_$abs='$hdr', hr_$abs=$strtgl where ID=$jid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	}
  }
  function PrcAbsensiMhsw($kdj) {
    global $strCantQuery, $fmtErrorMsg, $strTahunNotActive, $thn;
    $jid = $_REQUEST['jid'];
	//$thn = GetaField('jadwal', 'ID', $jid, 'Tahun');
	if (!isTahunAktif($thn, $kdj)) DisplayHeader($fmtErrorMsg, $strTahunNotActive);
	else {
	$nim = $_REQUEST['nim'];
	$abs = $_REQUEST['abs'];
	$hdr = $_REQUEST['hdr'];
	$s = "update krs set hr_$abs='$hdr' where NIM='$nim' and IDJadwal=$jid limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	}
  }
  function PrcAbsensiAll($kdj) {
    global $strCantQuery;
    if (isset($_REQUEST['absall'])) {
	  $absall = $_REQUEST['absall'];
      $jid = $_REQUEST['jid'];
	  $abs = $_REQUEST['abs'];
	  $s = "update krs set hr_$abs = '$absall' where IDJadwal=$jid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
  }
  function GetAbsensiMhsw($jid, $abs) {
    global $strCantQuery;
	$s = "select k.ID, k.NIM, k.hr_$abs as absen, m.Name
	  from krs k inner join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jid
	  order by k.NIM ";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	
	$tgl = GetaField('jadwal', 'ID', $jid, "hr_$abs");
	$optall = GetOption2('absensi', 'Nama', 'Kode', '', '', 'Kode');
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' action=GET>
		<input type=hidden name='syxec' value='absensi'>
		<input type=hidden name='mhs' value=1>
		<input type=hidden name='jid' value=$jid>
		<input type=hidden name='abs' value=$abs>
	  <tr><td class=wrn>&nbsp;</td><td class=lst>Ubah semua absensi menjadi: </td>
	    <td class=lst><select name='absall'>$optall</select>
		<input type=submit name='prcall' value='Ubah Semua'> </td></tr>
	  </form></table><br>";
	
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=4>Pertemuan ke-$abs :: $tgl</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>NIM</th><th class=ttl>Nama Mahasiswa</th><th class=ttl>Absen</th></tr>";
	for ($i=0; $i < mysql_num_rows($r); $i++) {
	  $nmr = $i + 1;
	  $NIM = mysql_result($r, $i, 'NIM');
	  $Name = mysql_result($r, $i, 'Name');
	  $hdr = mysql_result($r, $i, "absen");
	  //function GetOption2($_table, $_field, $_order='', $_default='', $_where='', $_value='') {
	  $opthdr = GetOption2('absensi', 'Nama', 'Kode', $hdr, '', 'Kode');
	  echo "<tr><td class=lst>$nmr</td><td class=lst>$NIM</td><td class=lst>$Name</td>
		<form action='sysfo.php' action=GET>
		<input type=hidden name='syxec' value='absensi'>
		<input type=hidden name='mhs' value=1>
		<input type=hidden name='jid' value=$jid>
		<input type=hidden name='abs' value=$abs>
		<input type=hidden name='nim' value='$NIM'>
		<input type=hidden name='prcm' value=1>
	    <td class=lst>
		<select name='hdr' onChange='this.form.submit()'>$opthdr</select>
		</td></form></tr>";
	}
	echo "</table>";
  }
  function DispMK($jid) {
    global $strCantQuery;
    $s = "select mk.Kode, mk.Nama_Indonesia as MK, pr.Nama_Indonesia as PRG, concat(ds.Name, ', ', ds.Gelar) as DS
	  from jadwal jd left outer join matakuliah mk on jd.IDMK=mk.ID
	  left outer join program pr on jd.Program=pr.Kode
	  left outer join dosen ds on jd.IDDosen=ds.ID
	  where jd.ID=$jid";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$kod = mysql_result($r, 0, 'Kode');
	$MK = mysql_result($r, 0, 'MK');
	$PRG = StripEmpty(mysql_result($r, 0, 'PRG'));
	$DS = mysql_result($r, 0, 'DS');
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>Kode</th><th class=ttl>Mata Kuliah</th><th class=ttl>Program</th><th class=ttl>Dosen</th></tr>
	  <tr><td class=lst>$kod</th><td class=lst>$MK</td><td class=lst>$PRG</td><td class=lst>$DS</td></tr>
	  </table>";
  }
  
  // *** PARAMETER2 ***
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$jid = GetSetVar('jid');
if (empty($jid)) $jid = 0;

if (isset($_REQUEST['mhs'])) $mhs = $_REQUEST['mhs']; else $mhs = 0;
if (isset($_REQUEST['abs'])) $abs = $_REQUEST['abs']; else $abs = 0;

// *** BAGIAN UTAMA ***
DisplayHeader($fmtPageTitle, 'Absensi');
if (isset($_REQUEST['prca'])) PrcAbsensi($kdj);
if (isset($_REQUEST['prcm'])) PrcAbsensiMhsw($kdj);
if (isset($_REQUEST['prcall'])) PrcAbsensiAll($kdj);
DispOptJdwl0('absensi');
if (!empty($thn) && !empty($kdj)) {
  if ($jid == 0) GetJadwalMK($thn, $kdj);
	else {
	  DispMK ($jid);
	  echo "<a href='sysfo.php?syxec=absensi&jid=0' class=lst>Lihat Jadwal Kuliah</a> |
	    <a href='sysfo.php?syxec=absensi&mhs=0' class=lst>Lihat Daftar Pertemuan</a>";
	  if ($mhs == 0) GetAbsensi($jid);
	  elseif ($mhs == 1) {
	    if ($abs > 0) GetAbsensiMhsw($jid, $_REQUEST['abs']);
		else DisplayHeader($fmtErrorMsg, $strNotAuthorized);
	  }
	}
}

?>