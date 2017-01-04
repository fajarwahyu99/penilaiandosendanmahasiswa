<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
function GetDosen ($kdf, $thn, $act='jdwldosen') {
    global $thn, $did;
    if (empty($thn)) $thn = GetLastThn($kdf);
	//$jur = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	$optjur = GetOption2('dosen', "concat(Name, ', ', Gelar)", 'Name', $did, "KodeFakultas='$kdf'", 'ID');
	$nmthn = GetaField('tahun', 'Kode', $thn, 'Nama');
	if (empty($nmthn)) $nmthn = '<font color=red><b>Tahun Akademik TIDAK ADA</b></font>';
	$th_n = substr($thn, 0, 4);
	$th_s = substr($thn, 4, 1);
	echo <<<EOF
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='$act'>
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>Tahun Akademik</th></tr>
	  <tr><td class=lst rowspan=2>Tahun Akademik</td><td class=lst><input type=text name='thn' value='$thn' size=5 maxlength=5></td></tr>
	  <tr><td class=lst>$nmthn</td></tr>
	  <tr><td class=lst>Dosen</td><td class=lst><select name='did'>$optjur</select></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='go' value='Refresh'></td></tr>
	  </table></form>
EOF;
}
function GetJadwalDosen($thn, $did) {
  global $strCantQuery;
	$s = "select j.*, mk.Kode as KodeMK, mk.Nama_Indonesia as MK, h.Nama as HR, mk.SKS,
	  pr.Nama_Indonesia as PRG
	  from jadwal j left join matakuliah mk on j.IDMK=mk.ID
	  left join hari h on j.Hari=h.ID
	  left outer join program pr on j.Program=pr.Kode
	  where Tahun='$thn' and IDDosen=$did";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
	  <th class=ttl>Hari</th><th class=ttl>Program</th><th class=ttl>Mulai</th><th class=ttl>Selesai</th>
	  <th class=ttl>Kampus</th><th class=ttl>Ruang</th><th class=ttl>Mhsw</th>
	  </tr>	";
	$i = 0;
	while ($row = mysql_fetch_array($r)) {
	  $i++;
	  $sj = "select count(*) as Jumlah from krs where IDJadwal=".$row['ID'];
	  $rj = mysql_query($sj) or die ("$strCantQuery: $s");
	  $jml = mysql_result($rj, 0, 'Jumlah');
	  echo "<tr><td class=lst>".$i."</td>
	    <td class=lst>".$row['KodeMK']."</td><td class=lst>".$row['MK']."</td>
		  <td class=lst align=right>".$row['SKS']."<td class=ttl>".$row['HR']."</td>
		  <td class=lst>".$row['PRG']."
	    <td class=lst>".$row['JamMulai']."</td><td class=lst>".$row['JamSelesai']."</td>
	    <td class=lst>".$row['KodeKampus']."</td><td class=lst>".$row['KodeRuang']."</td>
		  <td class=lst align=right>".$jml."</tr>";
	}
	echo "</table>";
}
function ValidDosenFak($kdf, $did) {
  return (mysql_num_rows(mysql_query("select ID from dosen where KodeFakultas='$kdf' and ID=$did")) > 0);
}
  

// *** PARAMETER ***
$thn = GetSetVar('thn');
$kdf = GetSetVar('kdf');
if ($_SESSION['ulevel'] == 3) {
  $kdf = GetaField('dosen', 'ID', $_SESSION['uid'], 'KodeFakultas');
  $_SESSION['kdf'] = $kdf;
}
$did = GetSetVar('did');
if ($_SESSION['ulevel'] == 3) $did = $_SESSION['uid'];
  
// *** BAGIAN UTAMA ***
DisplayHeader($fmtPageTitle, "Jadwal Mengajar Dosen");
GetFak($kdf, 'jdwldosen');
GetDosen($kdf, $thn, 'jdwldosen');
if (!empty($kdf) && $did > 0 && ValidDosenFak($kdf, $did)) {
  if (($_SESSION['ulevel'] == 3 && $_SESSION['uid'] == $did) || $_SESSION['ulevel'] == 1) {
    GetJadwalDosen($thn, $did);
  }
  else die(DisplayHeader($fmtErrorMsg, "Anda tidak berhak atas informasi dosen ini.", 0));
}
?>