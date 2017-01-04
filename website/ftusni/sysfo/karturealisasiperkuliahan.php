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
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  echo <<<EOF
	  <tr><td class=lst>$cnt</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[PRG]</td><td class=lst>$w[DSN]</td>
	  <td class=lst>$w[HAR]</td><td class=lst>$w[JM] - $w[JS]</td>
	  <td class=lst align=center><a href='sysfo.php?syxec=karturealisasiperkuliahan&ctk=1&jid=$w[ID]'><img src='image/printer.gif' border=0></a></td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function CetakKartuPerkuliahan($jid) {
    global $fmtErrorMsg;
	$arr = GetFields('jadwal j left outer join dosen d on j.IDDosen=d.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join program p on j.Program=p.Kode
	  left outer join jurusan jr on j.KodeJurusan=jr.Kode
	  left outer join fakultas f on j.KodeFakultas=f.Kode
	  left outer join ruang r on j.KodeRuang=r.Kode
	  left outer join tahun t on j.Tahun=t.Kode and j.KodeJurusan=t.KodeJurusan',
	  "j.ID", $jid, "j.ID, j.KodeMK, j.NamaMK, j.SKS, h.Nama as HARI, t.Nama as NamaTahun,
	  jr.Nama_Indonesia as JUR, f.Nama_Indonesia as FAK, r.Nama as RNG,
	  time_format(j.JamMulai, '%H:%i') as JM, time_format(j.JamSelesai, '%H:%i') as JS,
	  concat(d.Name, ', ', d.Gelar) as DSN, p.Nama_Indonesia as PRG");
	$tmpl = "sysfo/template/KartuRealisasiKuliah.rtf";
	if (file_exists($tmpl)) {
	  $targ = "sysfo/temp/krp.$jid.rtf";
	  if (file_exists($targ)) unlink($targ);
	  // baca isi
	  $f = fopen($tmpl, "r");
	  $isi = fread($f, filesize($tmpl));
	  fclose($f);
	  // Ubah template
	  $isi = str_replace('=NamaTahun=', $arr['NamaTahun'], $isi);
	  $isi = str_replace('=NamaMK=', $arr['NamaMK'], $isi);
	  $isi = str_replace('=DSN=', $arr['DSN'], $isi);
	  $isi = str_replace('=JUR=', $arr['JUR'], $isi);
	  $isi = str_replace('=FAK=', $arr['FAK'], $isi);
	  $isi = str_replace('=HARI=', $arr['HARI'], $isi);
	  $isi = str_replace('=JM=', $arr['JM'], $isi);
	  $isi = str_replace('=JS=', $arr['JS'], $isi);
	  $isi = str_replace('=RNG=', $arr['RNG'], $isi);
	  $isi = str_replace('=PRG=', $arr['PRG'], $isi);
	  // tulis
	  $f = fopen($targ, "w");
	  fwrite($f, $isi);
	  fclose($f);
	  echo <<<EOF
	  <SCRIPT LANGUAGE=JavaScript>
	  <!---
	    window.open("$targ");
	  -->
	  </SCRIPT>
EOF;
	}
	else DisplayHeader($fmtErrorMsg, "File template <b>$tmpl</b> tidak ditemukan. Hubungi MIS/IT/Puskom.");
  }
  
  
  // *** Parameter2 ***
if (isset($_REQUEST['ctk'])) $ctk = $_REQUEST['ctk']; else $ctk = 0;
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
  
  // *** Bagian UTama ***
  if ($ctk == 1) CetakKartuPerkuliahan($jid);
  DisplayHeader($fmtPageTitle, 'KARTU REALISASI PERKULIAHAN');  
  DispOptJdwl0('karturealisasiperkuliahan');
  if (!empty($thn) && !empty($kdj)) DispJadwal($thn, $kdj);


?>