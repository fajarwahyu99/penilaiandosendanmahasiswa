<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Oktober 2003
  
  // *** Fungsi2 ***
  function DispKRSMhsw($nim, $thn) {
    $s = "select k.*, h.Nama as HR, p.Nama_Indonesia as PRG,
	  time_format(j.JamMulai, '%h:%i') as JM, time_format(j.JamSelesai, '%h:%i') as JS
	  from krs k left outer join jadwal j on k.IDJadwal=j.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join program p on j.Program=p.Kode
	  where k.NIM='$nim' and k.Tahun='$thn' order by k.KodeMK";
	$r = mysql_query($s) or die(mysql_error());
	echo "<a href='sysfo.php?syxec=dispensasikrs&md=1'>Tambah Dispensasi</a><br>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>SKS</th><th class=ttl>Program</th><th class=ttl>Hari</th>
	  <th class=ttl>Jam Kuliah</th><th class=ttl>Disp</th><th class=ttl>Hps</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Dispensasi'] == 'Y') $ttl = "Title='Alasan Dispensasi:\n$w[KetDispensasi]'";
	  else $ttl = '';
	  echo <<<EOF
	  <tr><td class=lst>$w[KodeMK]</td>
	  <td class=lst>$w[NamaMK]</td>
	  <td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[PRG]</td>
	  <td class=lst>$w[HR]</td>
	  <td class=lst>$w[JM]-$w[JS]</td>
	  <td class=lst><img src='image/$w[Dispensasi].gif' $ttl></td>
	  <td class=lst><a href='sysfo.php?syxec=dispensasikrs&prcdel=$w[ID]'><img src='image/del.gif' title='Hapus' border=0></a></td>
	  </tr>
EOF;
	}
	echo "</table><br>
	<b>Disp</b>: Dispensasi<br>
	<b>Hps</b>: Hapus<br>";
  }
  function TambahKRS($nim, $thn) {
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
    $s = "select j.*, mk.Kode as KodeMK, mk.Nama_Indonesia as MataKuliah,
	  TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,
	  h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join dosen d on j.IDDosen=d.ID
	  left join krs k on k.IDJadwal=j.ID and k.NIM='$nim'
	  left outer join program pr on j.Program=pr.Kode
	  where k.ID is null and (j.KodeJurusan='$kdj' or j.Global='Y') and j.Tahun='$thn' 
	  and j.NotActive='N' order by j.Hari, j.JamMulai  ";
	$r = mysql_query($s) or die(mysql_error());
	$no = 0;
	echo "<a href='sysfo.php?syxec=dispensasikrs'>Kembali</a>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
	  <th class=ttl>Program</th><th class=ttl>Hari, Jam</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $no++;
	  echo <<<EOF
	  <tr>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='dispensasikrs'>
	  <input type=hidden name='jid' value='$w[ID]'>
	  <input type=hidden name='nim' value='$nim'>
	  <input type=hidden name='thn' value='$thn'>
	  <td class=ttl rowspan=2>$no</td><td class=lst>$w[KodeMK]</td>
	  <td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td><td class=lst>$w[PRG]</td>
	  <td class=lst>$w[HR], $w[jm]-$w[js]</td></tr>
	  <tr>
	  <td class=lst colspan=5>Alasan: <input type=text name='KetDisp' value='' size=50 maxlength=50>
	  <input type=submit name='prckrs' value='Ambil'></td>
	  </form></tr>
EOF;
	}
	echo "</table>";
  }
  function PrcKRS() {
    global $strCantQuery, $fmtErrorMsg;
	$jid = $_REQUEST['jid'];
	$nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$ssi = GetaField('khs', 'Tahun', $thn, 'Sesi');
	$KetDisp = sqling($_REQUEST['KetDisp']);
	if (empty($ssi)) $ssi = 0;
	$unip = $_SESSION['unip'];
	$msg = ''; 
	$arrj = GetFields('jadwal', 'ID', $jid, '*');
	$IDMK = $arrj['IDMK'];
	$boleh = CekBentrokJdwlMhsw($nim, $thn, $arrj);
	$msg = $msg . $boleh;
	if (empty($boleh)) {
	  $NamaMK = GetaField('matakuliah', 'ID', $IDMK, 'Nama_Indonesia');
	  $KodeMK = $arrj['KodeMK'];
	  $IDDosen = $arrj['IDDosen'];
	  $SKS = $arrj['SKS'];
	  $PRG = $arrj['Program'];
	  $sck = "select ID from krs where IDMK=$IDMK and NIM='$nim' and Tahun='$thn'";
	  $rck = mysql_query($sck) or die("$strCantQuery: $sck");
	  if (mysql_num_rows($rck) == 0) {
	    $s = "insert into krs (NIM, Tahun, Sesi, IDJadwal, IDMK, KodeMK, NamaMK, SKS, IDDosen, unip, Tanggal, Program,
		  Dispensasi, TglDispensasi, KetDispensasi)
	      values ('$nim', '$thn', $ssi, '$jid', $IDMK, '$KodeMK', '$NamaMK', $SKS, $IDDosen, '$unip', now(), '$PRG',
		  'Y', now(), '$KetDisp' )";
	    $r = mysql_query($s) or die("$strCantQuery: $s");
	  }
	}
	UpdateSKSKHS($nim, $thn);
	if (!empty($msg)) DisplayHeader($fmtErrorMsg, "<ul>$msg</ul>");
  }
  function PrcDel($id, $nim, $thn) {
    global $strCantQuery, $fmtErrorMsg;
    $s = "delete from krs where ID=$id";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	UpdateSKSKHS($nim, $thn);
  }
  
  // *** Parameter2 ***
$thn = GetSetVar('thn');
$nim = GetSetVar('nim');
if ($_SESSION['ulevel'] == 4) {
	$nim = $_SESSION['unip'];
	$_SESSION['nim'] = $nim;
}
if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Dispensasi KRS');
  if (isset($_REQUEST['prckrs'])) PrcKRS();
  if (isset($_REQUEST['prcdel'])) PrcDel($_REQUEST['prcdel'], $nim, $thn);
  $valid = GetMhsw($thn, $nim, 'dispensasikrs');
  if ($valid) {
    if ($md == -1) DispKRSMhsw($nim, $thn);
	else TambahKRS($nim, $thn);
  }

?>