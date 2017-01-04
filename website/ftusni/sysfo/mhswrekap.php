<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Oktober 2003
  
  // Fungsi2
  function DispRekapMhswHeader($prg, $prn=0) {
    $jam = date('H:i:s');
	$tgl = date('d-m-Y');
    echo <<<EOF
	<table class=basic cellspacing=2 cellpadding=1 width=100%>
	<tr><td width=50%>
	  <table class=basic><tr><td colspan=2>STIE SUPRA</td></tr>
	  <tr><td>Program:</td><td>Seluruh Program</td></tr></table>
	</td>
	<td align=right>
	  <table class=basic><tr><td>Jam:</td><td>$jam</td></tr>
	  <tr><td>Tanggal</td><td>$tgl</td></tr></table>
	</td>
	</table>
EOF;
  }
  function CetakRekapMhsw($prg='') {
    $s = "select m.TahunAkademik, m.Status, count(m.Name) as Jml,
	  m.KodeProgram, concat(jur.Nama_Indonesia, '(', jp.Nama, ')') as JUR
	  from mhsw m left outer join jurusan jur on m.KodeJurusan=jur.Kode
	  left outer join jenjangps jp on jur.Jenjang=jp.Kode
	  group by m.KodeJurusan, m.TahunAkademik
	";
	$r = mysql_query($s) or die(mysql_error());
	$jur = '';
	echo "<table class=box cellspacing=2 cellpadding=1>";
	while ($w = mysql_fetch_array($r)) {
	  if ($jur != $w['JUR']) {
	    $jur = $w['JUR'];
		$strjur = $w['JUR'];
	  } else $strjur = '';
	  echo "<tr>
	    <td class=lst>$strjur</td>
	    <td class=lst>$w[TahunAkademik]</td>
	    <td class=lst>$w[Jml]</td>
	    </tr> ";
	}
	echo "</table>";
  }
  
  // Parameter2
  if (isset($_REQUEST['prg'])) {
    $prg = $_REQUEST['prg']; $_SESSION['prg'] = $prg;
  }
  else { if (isset($_SESSION['prg'])) $prg = $_SESSION['prg']; else $prg = ''; }
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 1;
  
  // Bagian Utama
  DisplayHeader($fmtPageTitle, "REKAP DATA MAHASISWA");
  DispRekapMhswHeader($prg, $prn);
  if ($prn == 1) CetakRekapMhsw($prg);

?>