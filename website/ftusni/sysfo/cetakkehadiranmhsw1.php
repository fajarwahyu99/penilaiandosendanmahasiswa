<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003
  
  
  // *** Fungsi2 ***
  function JumlahKuliah($jdwl) {
    $ktm = false;
	$cnt = 20;
	$jml = 0;
	while ($cnt >0 and !$ktm) {
	  if ($jdwl["hd_$cnt"] == 1) {
	    $ktm = true;
		$jml = $cnt;
	  }
	  $cnt--;
	}
	if (!$ktm) return 0;
	else return $jml;
  }
  function CetakHeader($jdwl) {
    $jml = JumlahKuliah($jdwl).' ';
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td width=100><b>STIE SUPRA</b></td><td align=center><font size=+1>LAPORAN KEHADIRAN MAHASISWA</font></td></tr>
	</table>
	<table class=basic cellspacing=0 cellpadding=0 width=100%>
	<tr><td valign=top>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td>PROGRAM</td><td>: $jdwl[PRG]</td></tr>
	  <tr><td>Semester</td><td>: $jdwl[Tahun]</td></tr>
	  <tr><td>Jurusan</td><td>: $jdwl[JUR]</td></tr>
	  <tr><td>Mata Kuliah</td><td>: $jdwl[KodeMK] - $jdwl[NamaMK] ($jdwl[SKS] SKS)</td></tr>
	  <tr><td>Dosen</td><td>: $jdwl[DSN]</td></tr>
	  </table>
	</td><td valign=bottom align=right>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td>Hari</td><td>: $jdwl[HAR]</td></tr>
	  <tr><td>Waktu</td><td>: $jdwl[JM] - $jdwl[JS]</td></tr>
	  <tr><td>Kampus</td><td>: $jdwl[KAMP]</td></tr>
	  <tr><td>Ruang</td><td>: $jdwl[KodeRuang]</td></tr>
	  <tr><td>Jml. Kuliah</td><td>: $jml</td></tr>
	  </table>
	</td></tr>
	</table><br>
EOF;
  }
  function CetakAbsenMhsw($jdwl) {
    global $strCantQuery;
	$jml = JumlahKuliah($jdwl);
	$s = "select k.*, m.Name as NamaMhsw
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  where k.IDJadwal=$jdwl[ID] order by k.NIM";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl rowspan=2>#</th><th class=ttl rowspan=2>NIM</th><th class=ttl rowspan=2>Nama Mahasiswa</th>
	  <th class=ttl colspan=16>Pertemuan Ke</th><th class=ttl rowspan=2>Keterangan</th>
	  <th class=ttl rowspan=2>Jml.<br>Hadir</th><th class=ttl rowspan=2>%<br>Hadir</th></tr>
	  <tr><th class=ttl>01</th><th class=ttl>02</th><th class=ttl>03</th><th class=ttl>04</th><th class=ttl>05</th>
	  <th class=ttl>06</th><th class=ttl>07</th><th class=ttl>08</th><th class=ttl>09</th><th class=ttl>10</th>
	  <th class=ttl>11</th><th class=ttl>12</th><th class=ttl>13</th><th class=ttl>14</th><th class=ttl>15</th>
	  <th class=ttl>16</th></tr> ";
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $abs = '';
	  $a = 0;
	  for ($i=1; $i <= 16; $i++) {
	    $hr = "hr_$i";
		if ($w[$hr] == 'H') $a++;
		if (empty($w[$hr])) $w[$hr] = '&nbsp;';
	    $abs .= "<td class=lst align=center>$w[$hr]</td>";
	  }
	  $pct = number_format($a / $jml * 100, 2, ',', '.');
	  echo <<<EOF
	  <tr><td class=lst>$cnt</td><td class=lst>$w[NIM]</td><td class=lst>$w[NamaMhsw]</td>$abs
	  <td class=lst>&nbsp;</td><td class=lst align=right>$a</td><td class=lst align=right>$pct</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function CetakKehadiranMhsw($jid) {
    global $fmtErrorMsg;
	$jdwl = GetFields('jadwal j left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  left outer join jenjangps jp on jr.Jenjang=jp.Kode
	  left outer join program pr on j.Program=pr.Kode
	  left outer join dosen d on j.IDDosen=d.ID
	  left outer join kampus k on j.KodeKampus=k.Kode
	  left outer join hari h on j.Hari=h.ID',
	  'j.ID', $jid, 
	  "j.*, h.Nama as HAR, concat(d.Name, ', ', d.Gelar) as DSN, concat(jr.Nama_Indonesia, '(', jp.Nama, ')') as JUR,
	  pr.Nama_Indonesia as PRG, time_format(j.JamMulai, '%H:%i') as JM, time_format(j.JamSelesai, '%H:%i') as JS,
	  k.Kampus as KAMP");
	CetakHeader($jdwl);
	CetakAbsenMhsw($jdwl);
	CetakFooter();
  }
  function CetakFooter() {
    $tgl = date('d-m-Y');
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td>&nbsp;</td>
	<td align=center width=200>Jakarta, $tgl<br>Yang membuat,<br><br><br><br>
	( ............................ )
	</td></tr>
	</table>
EOF;
  }
  
  // *** Bagian UTama ***
  CetakKehadiranMhsw($_REQUEST['jid']);


?>