<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** Fungsi2 ***
  function DispTAForm($kdj) {
	$r = mysql_query("select TA from jurusan where Kode='$kdj' limit 1");
	if (mysql_num_rows($r) > 0) {
	  $TA = mysql_result($r, 0, 'TA');
	  if (empty($TA)) $TA = 0;
	  echo <<<EOF
	  <table class=basic cellspacing=1 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='tgsakhir'>
	  <input type=hidden name='kdj' value='$kdj'>
	  <tr><td class=lst>Syarat SKS mengambil Tugas Akhir</td>
	  <td class=lst><input type=text name='TA' size=5 maxlength=3 value='$TA'></td>
	  <td class=lst><input type=submit name='prcsks' value='Ubah'></td></tr>
	  </form></table>
EOF;
	}
  }
  function PrcMinSKS($kdj) {
    $TA = $_REQUEST['TA'];
	$r = mysql_query("update jurusan set TA='$TA' where Kode='$kdj'") or die("Gagal: Function PrcMinSKS.");
  }
  function DispHarusTA($kdj) {
    $minsks = GetaField('jurusan', 'Kode', $kdj, 'TA');
	$hrs = new NewsBrowser;
	$hrs->query = "select m.NIM, m.Name, m.TotalSKS, m.TA, m.TglTA, sm.Nama as STA,
	  concat(d.Name, ', ', d.Gelar) as DSN
	  from mhsw m left outer join statusmhsw sm on m.Status=sm.Kode
	  left outer join dosen d on m.DosenID=d.ID
	  where m.KodeJurusan='$kdj' and m.TA='N' and m.TotalSKS >= $minsks and sm.Keluar=0
	  order by m.NIM";
	$hrs->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=6>Yg Harus Ambil TA</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Tot SKS</th><th class=ttl>Status</th><th class=ttl>Dosen Wali</th></tr>";
	$hrs->detailfmt = "<tr><td class=ttl>=NOMER=</td><td class=lst>=NIM=</td><td class=lst>=Name=</td>
	  <td class=lst align=right>=TotalSKS=</td><td class=lst>=STA=</td>
	  <td class=lst>=DSN=</td></tr>";
	$hrs->footerfmt = "</table>";
	echo $hrs->BrowseNews();
  }
  function DispSedangTA($kdj) {
    $hrs = new NewsBrowser();
	$hrs->query = "select m.NIM, m.Name, m.TotalSKS, m.TA, m.TglTA, sm.Nama as STA, m.Lulus,
	  concat(d.Name, ', ', d.Gelar) as DSN
	  from mhsw m left outer join statusmhsw sm on m.Status=sm.Kode
	  left outer join dosen d on m.PembimbingTA=d.ID
	  where m.KodeJurusan='$kdj' and m.TA='Y' and m.Lulus='N' and sm.Keluar=0
	  order by m.NIM";
	$hrs->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=6>Yg Harus Ambil TA</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Tot SKS</th><th class=ttl>Status</th>
	  <th class=ttl>Dosen Pembimbing</th></tr>";
	$hrs->detailfmt = "<tr><td class=ttl>=NOMER=</td><td class=lst>=NIM=</td><td class=lst>=Name=</td>
	  <td class=lst align=right>=TotalSKS=</td><td class=lst>=STA=</td><td class=lst>=DSN=</td></tr>";
	$hrs->footerfmt = "</table>";
	echo $hrs->BrowseNews();
  }

  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) { $kdj = $_REQUEST['kdj']; $_SESSION['kdj'] = $kdj; }
  else { if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = ''; }
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -3;
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Tugas Akhir");
  DispJur($kdj, 0, 'tgsakhir');
  if (isset($_REQUEST['prcsks'])) PrcMinSKS($kdj);
  if (!empty($kdj)) {
    if ($prn == 0) {
      DispTAForm($kdj);
      echo "<a href='sysfo.php?syxec=tgsakhir&kdj=$kdj&md=-2' class=lst>Daftar Mhsw yg Sedang TA</a> |
	  <a href='sysfo.php?syxec=tgsakhir&kdj=$kdj&md=-1' class=lst>Daftar Mhsw yg Harus TA</a>";
	}
	if ($md == -1) DispHarusTA($kdj);
	if ($md == -2) DispSedangTA($kdj);
  }
?>