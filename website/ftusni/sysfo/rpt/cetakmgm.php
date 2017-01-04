<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  include_once "lib/table.common.php";

  // *** FUngsi2 ***
  function DispMhswMGM($kdj='') {
    global $strCantQuery;
	$pref = GetPMBPrefix();
	if (empty($kdj)) $strkdj = ''; else $strkdj = "and KodeJurusan='$kdj'";
	$s = "select m.NIM, m.PMBID, m.Name, mgm.Nama, concat(je.Nama, '-', j.Nama_Indonesia) as JUR,
	  sta.Nama as STATA
	  from mhsw m left outer join mbrgetmbr mgm on m.MGMOleh=mgm.ID
	  left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps je on j.Jenjang=je.Kode
	  left outer join statusawalmhsw sta on m.StatusAwal=sta.Kode
	  where m.MGM='Y' and m.PMBID like '$pref%' $strkdj order by mgm.Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Yang<br>merekomendasikan</th>
	  <th class=ttl>Mhsw baru yg<br>direkomendasikan</th><th class=ttl>NIM</th><th class=ttl>No. PMB</th>
	  <th class=ttl>Jurusan</th><th class=ttl>Status</th></tr>";
	$cnt=0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  echo <<<EOF
	  <tr><td class=nac>$cnt</td><td class=lst>$w[Nama]</td><td class=lst>$w[Name]</td>
	  <td class=lst>$w[NIM]</td><td class=lst>$w[PMBID]</td>
	  <td class=lst>$w[JUR]</td><td class=lst>$w[STATA]</td></tr>
EOF;
	}
	echo "</table>";
  }
  // *** Parameter ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
  }
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;

  // *** Bagian Utama ***
  $sid = session_id();
  DisplayHeader($fmtPageTitle, 'MEMBER GET MEMBER');
  echo "<center><b>Selamat dan terima kasih kepada anggota program Member Get Member yang 
    telah merekomendasikan mahasiswa/i baru berikut ini:</b></center><br>";
  DispJur($kdj, 0, 'rpt/cetakmgm');
  if ($prn == 0) DisplayPrinter("print.php?print=sysfo/rpt/cetakmgm.php&kdj=$kdj&prn=1&PHPSESSID=$sid");
  DispMhswMGM($kdj);
?>