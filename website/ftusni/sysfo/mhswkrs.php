<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI-FUNGSI ***
function GoKRS($thn, $nim) {
  global $strCantQuery;
	echo "<a class=lst href='sysfo.php?syxec=mhswkrs&md=1'>Tambah KRS</a>";
	$s = "select k.*, mk.Nama_Indonesia as MK,
	  concat(d.Name, ', ', d.Gelar) as Dosen, h.Nama as HR, 
	  TIME_FORMAT(jd.JamMulai, '%H:%i') as jm, TIME_FORMAT(jd.JamSelesai, '%H:%i') as js,
	  pr.Nama_Indonesia as PRG
	  from krs k left outer join matakuliah mk on k.IDMK=mk.ID
	  left outer join dosen d on k.IDDosen=d.ID
	  left outer join jadwal jd on k.IDJadwal=jd.ID
	  left outer join hari h on jd.Hari=h.ID
	  left outer join program pr on jd.Program=pr.Kode
	  where k.NIM='$nim' and k.Tahun='$thn' order by h.Nama, jd.JamMulai";
	$r = mysql_query($s) or die(mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Program</th>
	  <th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
	  <th class=ttl>Dosen</th><th class=ttl>Hari</th>
	  <th class=ttl>Mulai</th><th class=ttl>Selesai</th>
	  <th class=ttl>Pernah</th>
	  <th class=ttl>Hapus</th>
	  </tr>";
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $pernah = CekPernahAmbil($nim, $thn, $w['KodeMK']);
	  echo "<tr><td class=lst>$cnt</td>
	  <td class=lst>$w[PRG]</td><td class=lst>$w[KodeMK]</td>
	  <td class=lst>$w[MK]</td><td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[Dosen]</td>
	  <td class=ttl>$w[HR]</td>
	  <td class=lst>$w[jm]</td><td class=lst>$w[js]</td>
	  <td class=lst align=center>$pernah</td>
	  <td class=lst align=center><a href='sysfo.php?syxec=mhswkrs&prcdel=$w[ID]'><img src='image/del.gif' border=0 title='Hapus: $w[KodeMK]'></a></td>
	  </tr> ";
	}
	echo "</table><br>";
	$sjk = "select sum(m.SKS) as TT from krs k inner join matakuliah m on k.IDMK=m.ID where k.NIM='$nim' and k.Tahun='$thn'";
	$rjk = mysql_query($sjk) or die ("$strCantQuery: $sjk");
	$maxsks = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'MaxSKS');
	$totsks = mysql_result($rjk, 0, 'TT');
	if ($totsks > $maxsks) $errsks = "<img src='image/silang.jpg' border=0>"; else $errsks = "";
	echo "<table class=basic><tr><td class=lst>Total SKS yang diambil: </td><th class=ttl>$totsks</th>
	  <td class=basic rowspan=2>$errsks</td></tr>
	  <tr><td class=lst>Maximum SKS yg boleh diambil:</td><th class=ttl>$maxsks</th></tr></table>";
}
function CekPernahAmbil($nim, $thn, $k) {
  $s = "select Tahun, GradeNilai
	  from krs where NIM='$nim' and KodeMK='$k' and Tahun <> '$thn' and NotActive='N'
	  order by Tahun desc";
	$r = mysql_query($s) or die(mysql_error());
	$res = '';
	$cnt = 0;
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $res .= "$cnt. Semester: $w[Tahun], Nilai: $w[GradeNilai]\n";
	}
    if (empty($res)) return '&nbsp;';
	else return "<img src='image/check.gif' border=0 alt='Pernah Diambil' title='Mata kuliah ini pernah diambil:\n$res'";
}
function KRSForm($thn, $nim) {
  global $strCantQuery;
	$sid = session_id();
	$snm = session_name();
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$s = "select j.*, mk.Kode as KodeMK, mk.Nama_Indonesia as MataKuliah,
	  TIME_FORMAT(JamMulai, '%H:%i') as jm, TIME_FORMAT(JamSelesai, '%H:%i') as js,
	  h.Nama as HR, concat(d.Name, ', ', d.Gelar) as Dsn, pr.Nama_Indonesia as PRG
	  from jadwal j left outer join matakuliah mk on j.IDMK=mk.ID
	  left outer join hari h on j.Hari=h.ID
	  left outer join dosen d on j.IDDosen=d.ID
	  left join krs k on k.IDJadwal=j.ID and k.NIM='$nim'
	  left outer join program pr on j.Program=pr.Kode
	  where k.ID is null and (j.KodeJurusan='$kdj' or j.Global='Y') and j.Tahun='$thn' 
	  and j.NotActive='N' order by j.Hari, j.JamMulai  ";
	$r = mysql_query($s) or die(mysql_error());
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhswkrs'>
	  <input type=hidden name='nim' value='$nim'>
	  <input type=hidden name='thn' value='$thn'>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=10>Mata Kuliah yg Ditawarkan</th></tr>
	  <tr><th class=ttl>Ambil</th><th class=ttl>Program</th>
	  <th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th>
	  <th class=ttl>SKS</th>
	  <th class=ttl>Dosen</th><th class=ttl>Hari</th>
	  <th class=ttl>Mulai</th><th class=ttl>Selesai</th>
	  <th class=ttl>Pernah</th>
	  </tr>";
	while ($w = mysql_fetch_array($r)) {
	  $pernah = CekPernahAmbil($nim, $thn, $w['KodeMK']);
	  echo "<tr>
	  <td class=lst><input type=checkbox name='ambil[]' value='$w[ID]'></td>
	  <td class=lst>$w[PRG]</td>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[MataKuliah]</td>
	  <td class=lst align=right>$w[SKS]</td>
	  <td class=lst>$w[Dsn]</td>
	  <td class=ttl>$w[HR]</td>
	  <td class=lst>$w[jm]</td><td class=lst>$w[js]</td>
	  <td class=lst align=center>$pernah</td>
	  </tr>";
	}
	echo "<tr><td class=lst colspan=10><input type=submit name='prckrs' value='Ambil Kuliah'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name='batal' value='Batal' onClick=\"location='sysfo.php?syxec=mhswkrs&md=-1&$snm=$sid'\">
	</td></tr></table></form>";
}
function CekMaxSKS($nim, $thn, $arrj) {
  $max = GetaField("khs", "NIM='$nim' and Tahun", $thn, 'MaxSKS');
	$jml = GetaField("krs", "NIM='$nim' and Tahun", $thn, 'sum(SKS)');
	if ($jml+$arrj['SKS'] > $max)
	  return "<li>Error: <b>$arrj[NamaMK]</b><br>
	  Mata kuliah tidak dpt diambil karena SKS akan melebihi batas. <br>
	  Max SKS: <b>$max</b>, yg telah diambil: <b>$jml</b>, yg akan diambil <b>$arrj[SKS]</b>.<br>&nbsp;</li>";
	else return '';
  }
  function CekKecukupanSKS($nim, $thn, $arrj) {
    $tot = GetaField("khs", "NIM", $nim, 'sum(SKS)');
	$min = GetaField("matakuliah", "ID", $arrj['IDMK'], 'SKSMin');
	if ($tot < $min)
	  return "<li>Error: <b>$arrj[NamaMK]</b><br>
	  Mata kuliah tidak dapat diambil karena membutuhkan SKS kumulatif yg telah diambil: <b>$min</b> SKS, dan
	  Anda baru mengambil <b>$tot</b> SKS.";
	else return '';
  }
  function CekPrasyaratMK($nim, $thn, $arrj) {
    $s = "select * from prasyaratmk where IDMK=$arrj[IDMK] order by PraKodeMK";
	$r = mysql_query($s) or die(mysql_error());
	if (mysql_num_rows($r) > 0) {
	  $a = "<li>Error: <b>$arrj[NamaMK]</b><br>
	  Mata kuliah tidak dapat diambil karena Anda belum mengambil mata kuliah prasyarat di bawah ini:
	  <ol>";
	  while ($w = mysql_fetch_array($r)) {
	    $a .= "<li>$arrj[KodeMK] - $arrj[NamaMK]</li>";
	  }
	  return "$a</ol>";
	}
	else return '';
}
function PrcKrs() {
  global $strCantQuery, $fmtErrorMsg;
	$krs = array();
	if (isset($_REQUEST['ambil'])) $krs = $_REQUEST['ambil'];
	if (EmptyArray($krs)) DisplayHeader($fmtErrorMsg, 'Tidak ada mata kuliah yang dipilih');
	else {
	  $nim = $_REQUEST['nim'];
	  $thn = $_REQUEST['thn'];
	  $ssi = GetaField('khs', 'Tahun', $thn, 'Sesi');
	  if (empty($ssi)) $ssi = 0;
	  $unip = $_SESSION['unip'];
	  $msg = ''; 
	  for ($i=0; $i < sizeof($krs); $i++) {
	    $jid = $krs[$i];
		$arrj = GetFields('jadwal', 'ID', $jid, '*');
		$IDMK = $arrj['IDMK'];
		$boleh = CekMaxSKS($nim, $thn, $arrj);
		if (empty($boleh)) $boleh = CekBentrokJdwlMhsw($nim, $thn, $arrj);
		if (empty($boleh)) $boleh = CekKecukupanSKS($nim, $thn, $arrj);
		if (empty($boleh)) $boleh = CekPrasyaratMK($nim, $thn, $arrj);
		$msg = $msg . $boleh;
		if (empty($boleh)) {
		  $NamaMK = GetaField('matakuliah', 'ID', $IDMK, 'Nama_Indonesia');
		  $KodeMK = $arrj['KodeMK'];
		  $IDDosen = $arrj['IDDosen'];
		  $SKS = $arrj['SKS'];
		  $PRG = $arrj['Program'];
		  $sck = "select ID from krs where IDMK=$IDMK and NIM='$nim' and Tahun='$thn'";
		  $rck = mysql_query($sck) or die("$strCantQuery: $sck");
		  if (mysql_num_rows($rck) == 0) {
		    $s = "insert into krs (NIM, Tahun, Sesi, IDJadwal, IDMK, KodeMK, NamaMK, SKS, IDDosen, unip, Tanggal, Program)
		      values ('$nim', '$thn', $ssi, '$jid', $IDMK, '$KodeMK', '$NamaMK', $SKS, $IDDosen, '$unip', now(), '$PRG' )";
		    $r = mysql_query($s) or die("$strCantQuery: $s");
			mysql_query("update khs set TglUbah=now(), CekUbah='N' where Tahun='$thn' and NIM='$nim'");
		  }
		}
	  }
	  UpdateSKSKHS($nim, $thn);
	  if (!empty($msg)) DisplayHeader($fmtErrorMsg, "<ul>$msg</ul>");
	}
}
function BatasKRSNim($thn, $nim) {
  global $fmtErrorMsg;
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
    $ark = GetFields('bataskrs', "Tahun='$thn' and KodeJurusan='$kdj' and NotActive", 'N', 'krsm,krss,Tahun');
	$skrg = date('Ymd');
	if ($ark) {
	  $Tahun = $ark['Tahun'];
	  $t1 = (int)str_replace('-', '', $ark['krsm']);
	  $t2 = (int)str_replace('-', '', $ark['krss']);
	  $res = ($t1 <= $skrg && $skrg <= $t2 && $thn == $Tahun);
	  if (!$res) DisplayHeader($fmtErrorMsg, "KRS sudah tidak dapat diubah.<br>
	    Tahun Akademik: <b>$Tahun</b><br>
	    Batas pengisian/perubahan KRS: <b>".$ark['krsm']. ' </b>s/d<b> '.$ark['krss'] . 
	    '<b><br>Perubahan tidak akan diproses.');
	}
	else {
	  DisplayHeader($fmtErrorMsg, "Data batas input/koreksi KRS tidak ada. 
	    Kesalahan ini mungkin terjadi karena:
	    <ul>
	      <li>Rentang waktu input/koreksi KRS belum ditentukan.</li>
		  <li>Tahun ajaran yang dimasukkan tidak valid.</li>
		</ul>
		Data tidak dapat disimpan.");
	  $res = false;
	}
	return $res;
}
function PrcDel($id, $nim, $thn) {
  global $strCantQuery, $fmtErrorMsg;
  $s = "delete from krs where ID=$id";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	mysql_query("update khs set TglUbah=now(), CekUbah='N' where Tahun='$thn' and NIM='$nim'");
	UpdateSKSKHS($nim, $thn);
}  
function CekHutang($nim) {
  global $fmtErrorMsg;
  $arr = GetFields('khs', "NIM", $nim, 'sum(Bayar) as TBayar, sum(Biaya) as TBiaya, sum(Potong) as TPotong, sum(Tarik) as TTarik');
	$Hutang = $arr['TBiaya'] + $arr['TPotong'] - $arr['TTarik'] - $arr['TBayar'];
	if ($Hutang > 0) {
	  $fmt = number_format($Hutang, 0, ',', '.');
	  DisplayHeader($fmtErrorMsg, "Anda masih memiliki hutang sebesar Rp. <b>$fmt</b>.<br>
	    Silakan menyelesaikan masalah keuangan Anda terlebih dahulu sebelum mengisi KRS.");
	}
  return $Hutang > 0;
}
  
  // *** PARAMETER2 ***
$kdj = GetSetVar('kdj');
$thn = GetSetVar('thn');
if (isset($_REQUEST['nim'])) {
  $nim = $_REQUEST['nim'];
  $_SESSION['nim'] = $nim;
}
else {
	if ($_SESSION['ulevel'] == 4) $nim = $_SESSION['unip'];
	else {
    if (isset($_SESSION['nim'])) $nim = $_SESSION['nim'];
	  else $nim = '';
	}
}

  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;
  
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Kartu Rencana Studi');
  if (isset($_REQUEST['prckrs'])) if (BatasKRSNim($thn, $nim)) PrcKrs();
  if (isset($_REQUEST['prcdel'])) if (BatasKRSNim($thn, $nim)) PrcDel($_REQUEST['prcdel'], $nim, $thn);

  if (strpos('124', $_SESSION['ulevel']) === false) die($strNotAuthorized.' #1');
  $valid = GetMhsw($thn, $nim, 'mhswkrs');
  if ($valid) {
  	$Hutang = CekHutang($nim);
    if (($_SESSION['ulevel'] == 4 && $_SESSION['unip'] == $nim && !$Hutang) || $_SESSION['ulevel'] == 1 || $_SESSION['ulevel'] == 2) {
	  if ($md == -1) {
	    if (IsMhswAktif($thn, $nim)) GoKRS($thn, $nim);
	  }
	  else {
	    if (IsMhswAktif($thn, $nim)) KRSForm($thn, $nim);
	  }
	}
	else die(DisplayHeader($fmtErrorMsg, "$strNotAuthorized", 0));
  }
?>