<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  include_once "lib/table.common.php";

  // *** Fungsi2 ***
  function DispBayarPMB($md=0, $jdl='') {
    global $strCantQuery, $fmtPageTitle, $prn;
	$sid = session_id();
	if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
	$desc = GetPMBDescription();
	DisplayHeader($fmtPageTitle, $jdl);
	echo "<center><b>$desc</b></center>";
	if ($prn == 0)
	  SimplePrinter("print.php?print=sysfo/cetakbyrpmb.php&md=$md&prn=1&PHPSESSID=$sid", "Cetak Laporan");
	if ($md == -1) $strbyr = "and p.PMBPaid='N'";
	elseif ($md == 0) $strbyr = '';
	elseif ($md == 1) $strbyr = "and p.PMBPaid='Y'";
	$pref = GetPMBPrefix();
	$s = "select p.PMBID, p.PMBPrice, p.Name, p.PMBPaid, j.Nama_Indonesia as PRG, jp.Nama as JEN
	  from pmb p left outer join jurusan j on p.Program=j.Kode
	  left outer join jenjangps jp on j.Jenjang=jp.Kode
	  where p.PMBID like '$pref%' $strbyr order by p.PMBID";
    $r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>PMBID</th><th class=ttl>Nama</th><th class=ttl>Program</th>
	  <th class=ttl>Bayar</th><th class=ttl>Harga</th>
	  </tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['PMBPaid'] == 'Y') $cls = 'class=lst'; else $cls = 'class=wrn';
	  $hrg = number_format($row['PMBPrice'], 2, ',', '.');
	  echo <<<EOF
	  <tr><td class=lst>$row[PMBID]</td><td class=lst>$row[Name]</td><td class=lst>$row[JEN] - $row[PRG]</td>
	  <td $cls align=center>$row[PMBPaid]</td><td class=lst align=right>$hrg</td>
	  </tr>
EOF;
	}
	$jml = mysql_num_rows($r);
	echo "</table><br><font class=lst>Jumlah:</font><font class=ttl><b>$jml</b></font>";
  }

  // *** Bagian Utama ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = 1;
  if ($md == 1) DispBayarPMB(1, 'Daftar yang Sudah Bayar');
  elseif ($md == -1) DispBayarPMB(-1, 'Daftar yang Belum Bayar');
?>