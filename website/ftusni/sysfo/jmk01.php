<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003
  
  //include "jdwlkuliah.res.php";


  function DaftarJadwal($thn, $kdj) {
    global $strCantQuery;
	$s = "select jd.*, TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,
	  h.Nama as HR, mk.Kode as KodeMK, mk.Nama_Indonesia as MK, mk.SKS, 
	  concat(d.Name, ', ', d.Gelar) as Dosen, pr.Nama_Indonesia as PRG
	  from jadwal jd left outer join hari h on jd.Hari=h.ID
	  left outer join matakuliah mk on jd.IDMK=mk.ID
	  left outer join dosen d on jd.IDDosen=d.ID
	  left outer join program pr on jd.Program=pr.Kode
	  where jd.Tahun='$thn' and jd.KodeJurusan='$kdj' 
	  order by jd.Hari, jd.JamMulai";

	$jdwl = new NewsBrowser;
	$jdwl->query = $s;
	$jdwl->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <th class=ttl>Hari</th>
	  <th class=ttl>Ruang</th><th class=ttl>Kampus</th>
	  <th class=ttl>Jam</th>
	  <th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>Program</th>
	  <th class=ttl>SKS</th>
	  <th class=ttl>Dosen</th>
	  </tr>";
	$jdwl->detailfmt = "<tr><td class=ttl>=HR=</td>
	  <td class=lst>=KodeRuang=</td><td class=lst>=KodeKampus=</td>
	  <td class=lst>=jm=-=js=</td>
	  <td class=lst>=KodeMK=</td>
	  <td class=lst>=MK=</td>
	  <td class=lst>=PRG=</td>
	  <td class=lst align=right>=SKS=</td> 
	  <td class=lst>=Dosen=</td>
	</tr>";
	$jdwl->footerfmt = "</table>";
	echo $jdwl->BrowseNews();
  }
  
  // *** PARAMETER ***
$thn = GetSetVar('thn');
if (isset($_REQUEST['kdj'])) {
  $kdj = $_REQUEST['kdj']; 
	$_SESSION['kdj'] = $kdj;
} 
else {
	if ($_SESSION['ulevel'] == 4) $kdj = GetaField('mhsw', 'NIM', $_SESSION['unip'], 'KodeJurusan');
	else {
    if (!empty($_SESSION['kdj'])) $kdj = $_SESSION['kdj'];
	  else $kdj = '';
	}
}
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Jadwal Kuliah");
  DispOptJdwl0('jmk01');
  if (!empty($thn) && !empty($kdj)) DaftarJadwal($thn, $kdj);
?>