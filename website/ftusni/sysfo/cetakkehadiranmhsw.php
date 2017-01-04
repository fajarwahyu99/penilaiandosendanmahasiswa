<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003
  
  // *** Fungsi 2 ***  
  function DispJadwal ($thn, $kdj) {
    global $strCantQuery;
	$s = "select j.ID, j.KodeMK, j.NamaMK, j.SKS, h.Nama as HAR,
	  time_format(j.JamMulai, '%H:%i') as JM, time_format(j.JamSelesai, '%H:%i') as JS,
	  concat(d.Name, ', ', d.Gelar) as DSN, p.Nama_Indonesia as PRG
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join program p on j.Program=p.Kode
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj' order by j.KodeMK";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<br><table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Kode MK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>SKS</th><th class=ttl>Program</th>
	  <th class=ttl>Dosen</th><th class=ttl>Hari</th>
	  <th class=ttl>Jam</th><th class=ttl>Cetak</th></tr>";
	$sid = session_id();
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $prn = GetPrinter("print.php?print=sysfo/cetakkehadiranmhsw1.php&prn=1&jid=$w[ID]&PHPSESSID=$sid");
	  echo <<<EOF
	  <tr><td class=lst>$cnt</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[PRG]</td><td class=lst>$w[DSN]</td>
	  <td class=lst>$w[HAR]</td><td class=lst>$w[JM] - $w[JS]</td>
	  <td class=lst align=center>$prn</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  
  
  // *** Parameter2 ***
if (isset($_REQUEST['ctk'])) $ctk = $_REQUEST['ctk']; else $ctk = 0;
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
  
  // *** Bagian UTama ***
  DisplayHeader($fmtPageTitle, 'Laporan Kehadiran Mhsw');
  DispOptJdwl0('cetakkehadiranmhsw');
  if (!empty($thn) && !empty($kdj)) DispJadwal($thn, $kdj);

?>