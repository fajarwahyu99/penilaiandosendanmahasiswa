<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, September 2003
  
  // *** Fungsi2 ***
  function DispKHSMhsw($nim) {
    global $strCantQuery;
	$s = "select k.*, stm.Nama as STATUS, stm.Nilai NILAISTATUS, date_format(k.TglKartu, '%d') as KD,
	  date_format(k.TglKartu, '%m') as KM, date_format(k.TglKartu, '%Y') as KY
	  from khs k left outer join statusmhsw stm on k.Status=stm.Kode
	  where k.NIM='$nim' order by k.Tahun";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	echo "<br><table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Tahun</th><th class=ttl>Status</th>
	  <th class=ttl>Kartu Berlaku s/d</th></tr>";
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  if ($w['NILAISTATUS'] == 0) {
	    $cls = 'class=nac';
		$ctk = "<td $cls>&nbsp;</td>";
	  }
	  else {
	    $cls = 'class=lst';
		$ctk = "<form action='sysfo.php' method=GET>
		  <input type=hidden name='syxec' value='cetakkartumhsw'>
		  <input type=hidden name='nim' value='$nim'>
		  <input type=hidden name='thn' value='$w[Tahun]'>
		  <td $cls>
		  <input type=text name='KD' value='$w[KD]' size=2 maxlength=2>
		  <input type=text name='KM' value='$w[KM]' size=2 maxlength=2>
		  <input type=text name='KY' value='$w[KY]' size=4 maxlength=4>
		  <input type=submit name='ctk' value='Cetak'>
		  </td></form>
		";
		$xctk = "<a href='sysfo.php?syxec=cetakkartumhsw&ctk=1&nim=$nim&thn=$w[Tahun]'><img src='image/printer.gif' border=0></a>";
	  }
	  echo <<<EOF
	  <tr><td class=ttl>$cnt</td><td $cls>$w[Tahun]</td><td $cls>$w[STATUS]</td>$ctk</tr>
EOF;
	}
	echo "</table>";
  }
  function AddSpaceRight($str, $cnt=0) {
    $len = strlen($str);
	if ($len > $cnt) $str = substr($str, 0, $cnt);
	else {
	  $str = str_pad($str, $cnt, ' ', STR_PAD_RIGHT);
	}
	return $str;
  }
  function CetakKartuMhsw($nim, $thn) {
    global $strCantQuery;
    $tglkartu = "$_REQUEST[KY]-$_REQUEST[KM]-$_REQUEST[KD]";
    $u = mysql_query("update khs set TglKartu='$tglkartu' where NIM='$nim' and Tahun='$thn'") or die("Error");
    
	$mhsw = GetFields('mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode
	  left outer join jenjangps jp on j.Jenjang=jp.Kode
	  left outer join program p on m.KodeProgram=p.Kode
	  left outer join dosen d on m.DosenID=d.ID',
	  'NIM', $nim,
	  "m.Name, Date_Format(m.TglLahir, '%d-%m-%Y') as TGLLHR, m.Alamat1, m.Alamat2, 
	  concat(j.Nama_Indonesia, '(', jp.Nama, ') - ', p.Nama_Indonesia) as JUR,
	  concat(d.Name, ', ', d.Gelar) as DSN,
	  p.Nama_Indonesia as PRG");
	$khs = GetFields('khs', "Tahun='$thn' and NIM", $nim, "Sesi, date_format(TglKartu, '%d-%m-%Y') as TGLKARTU");
	$smt = "$khs[Sesi] / $thn";
    $arr = array();
	$tgl = AddSpaceRight('', 32) . date('d-m-Y');
	// Cetak Kiri dulu
	$arr[0] = chr(15).AddSpaceRight($nim, 59);
	$arr[1] = AddSpaceRight($mhsw['Name'], 59);
	$arr[2] = AddSpaceRight($mhsw['TGLLHR'], 59);
	$arr[3] = AddSpaceRight($mhsw['Alamat1'], 59);
	$arr[4] = AddSpaceRight($mhsw['Alamat2'], 59);
	$arr[5] = AddSpaceRight($mhsw['JUR'], 59);
	$arr[6] = AddSpaceRight($smt, 59);
	$arr[7] = AddSpaceRight($mhsw['DSN'], 59);
	$arr[8] = AddSpaceRight($tgl, 59);
	$arr[9] = AddSpaceRight("     $khs[TGLKARTU]", 59);
	$arr[10] = AddSpaceRight('', 59);
	$arr[11] = AddSpaceRight('', 59);
	$arr[12] = AddSpaceRight('', 59);
	$arr[13] = AddSpaceRight('', 59);
	// KRS Mhsw
	$s = "select k.* from krs k where Tahun='$thn' and NIM='$nim' order by k.KodeMK";
	$r = mysql_query($s) or die("$strCantQuery");
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $arr[$cnt] .= AddSpaceRight($w['KodeMK'], 10);
	  $arr[$cnt] .= AddSpaceRight($w['NamaMK'], 39);
	  $arr[$cnt] .= AddSpaceRight($w['SKS'], 5);
	  $arr[$cnt] .= AddSpaceRight($w['Program'], 4);
	  $cnt++;
	}

	$targ = "sysfo/temp/KartuMhsw.$nim.txt";
	if (file_exists($targ)) unlink($targ);
	  // tulis
	  $f = fopen($targ, "w");
	  for ($i=0; $i <= 13; $i++) fwrite($f, $arr[$i]."\n");
	  fclose($f);
	  echo <<<EOF
	  <SCRIPT LANGUAGE=JavaScript>
	  <!---
	    window.open("$targ");
	  -->
	  </SCRIPT>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['nim'])) $nim = $_REQUEST['nim']; else $nim = '';
  if (isset($_REQUEST['thn'])) $thn = $_REQUEST['thn']; else $thn = '';
  
  
  // *** Bagian Utama ***
  if (isset($_REQUEST['ctk'])) CetakKartuMhsw($nim, $thn);
  DisplayHeader($fmtPageTitle, 'Cetak Kartu Mahasiswa');
  DispNIMMhsw($nim, 'cetakkartumhsw');
  DispHeaderMhsw0($nim);
  if (!empty($nim) && ValidNIM($nim)) DispKHSMhsw($nim);

?>