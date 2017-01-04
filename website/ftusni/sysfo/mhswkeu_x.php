<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** FUNGSI2 ***
  function DispKeuMhsw($nim) {
    global $strCantQuery,  $fmtErrorMsg;
	$s = "select k.*, st.Nama as STAT, st.Nilai
	  from khs k left outer join statusmhsw st on k.Status=st.Kode
	  where k.NIM='$nim' order by k.Tahun ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Sesi</th><th class=ttl>Tahun</th><th class=ttl>Status</th>
	  <th class=ttl>SKS</th><th class=ttl>IPS</th>
	  <th class=ttl>Kode Biaya</th>
	  <th class=ttl>Biaya</th><th class=ttl>Bayar</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['Nilai'] == 0) $cls = 'class=nac'; else $cls = 'class=lst';
	  if ($row['SKS'] == 0) $ips = 0; else $ips = $row['Bobot'] / $row['SKS'];
	  $bia = number_format($row['Biaya'], 2, ',', '.');
	  $byr = number_format($row['Bayar'], 2, ',', '.');
	  if ($row['Biaya'] > $row['Bayar']) $lns = 'class=wrn'; else $lns = $cls;
	  echo "<tr><td $cls>$row[Sesi]</td>
	    <td $cls>$row[Tahun]</td>
		<td $cls>$row[STAT]</td>
	    <td $cls align=right>$row[SKS]</td>
		<td $cls align=right>$ips</td>
		<td $cls align=right>$row[KodeBiaya]</td>
		<td $cls align=right>$bia</td>
		<td $lns align=right>$byr</td>
		<td class=lst><a href='sysfo.php?syxec=mhswkeu&md=1&md1=0&thn=$row[Tahun]&nim=$nim'>edit</td>
		</tr> ";
	}
	echo "</table><br>";
  }
  function DaftarBiayaMhsw($nim, $thn) {
    global $strCantQuery, $fmtErrorMsg;
	$s = "select * from biayamhsw where Tahun='$thn' and NIM='$nim' order by NamaBiaya";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	if (strpos('12', $_SESSION['ulevel'])===false) $t = '';
	else $t = "<a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0&md1=0&prcoto=1' class=lst>Proses Biaya</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0&md1=0&md2=1' class=lst>Tambah Biaya</a>";
	$t = $t . "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Biaya</th><th class=ttl>Jumlah</th><th class=ttl>Bayar</th>
	  <th class=basic></th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if (($row['Jumlah'] * $row['Biaya']) > $row['Bayar']) $lns = 'class=wrn'; else $lns = 'class=lst';
	  $jml = number_format($row['Jumlah']*$row['Biaya'], 2, ',', '.');
	  $byr = number_format($row['Bayar'], 2, ',', '.');
	  if (strpos('12', $_SESSION['ulevel'])===false) $edt = '';
	  else $edt = "<a href='sysfo.php?syxec=mhswkeu&md=0&md1=0&md2=0&biaid=$row[ID]&nim=$nim&thn=$thn'>edt</a>";
	  $t = $t. <<<EOF
	  <tr><td class=lst>$row[NamaBiaya]</td>
	  <td class=lst align=right>$jml</td><td $lns align=right>$byr</td>
	  <td class=lst>$edt</td>
	  </tr>
EOF;
	}
	return $t . "</table>";
  }
  function DaftarBayarMhsw($nim, $thn) {
    global $strCantQuery;
	if (strpos('12', $_SESSION['ulevel'])===false) $mn = '';
	else $mn = "<a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0&md1=0&md3=1' class=lst>Tambah Pembayaran</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0&md1=0&prcjml=1' class=lst>Hitung Ulang</a>";
	$s = "select b.*, date_format(Tanggal,'%d-%m-%Y') as tgl, jb.Nama as JENBI
	  from bayar b left outer join jenistrx jb on b.JenisTrx=jb.ID
	  where b.Tahun='$thn' and b.NIM='$nim' order by b.Tanggal";
	$r = mysql_query($s) or die("$strCantQuery: $s<br>".mysql_error());
	$dt = "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>Trx #</th>
	  <th class=ttl>Tanggal</th><th class=ttl>Jenis Trx.</th>
	  <th class=ttl>Pembayaran</th>
	  </tr>";
	$cls = 'class=lst';
	while ($row = mysql_fetch_array($r)) {
	  $jml = number_format($row['Kali'] * $row['Jumlah'], 2, ',', '.');
	  $ctt = StripEmpty($row['Catatan']);
	  if (strpos('123', $_SESSION['ulevel']) === false) $strid = $row['ID'];
	  else $strid = "<a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&byrid=$row[ID]&md=0&md1=0&md3=0'>$row[ID]</a>";
	  $dt = $dt . <<<EOF
	  <tr><td $cls rowspan=2>$strid</td>
	  <td $cls>$row[tgl]</td>
	  <td $cls>$row[JENBI]</td>
	  <td $cls>$row[NamaBayar]</td></tr>
	  <tr><td class=ttl>$jml</td>
	  <td class=lst colspan=3>$ctt</td></tr>
	  <tr><td colspan=4 class=basic>&nbsp;</td></tr>
EOF;
	}
	$dt = $dt . "</table>";
    return $mn . $dt;
  }
  function EditBiayaMhsw($nim, $thn, $md2, $biaid) {
    global $strCantQuery;
	$KodeBiaya = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'KodeBiaya');
	$IDBiaya2 = 0;
	$NamaBiaya = '';
	$Jumlah = 1;
	$Biaya = 0;
	$na = '';
	$ctt = '';
	$jdl = 'Tambah Biaya Mahasiswa';
	if ($md2==0) {
	  $r = mysql_query("select * from biayamhsw where ID=$biaid") or die("$strCantQuery: EditBiayaMhsw");
	  $KodeBiaya = mysql_result($r, 0, 'KodeBiaya');
	  $IDBiaya2 = mysql_result($r, 0, 'IDBiaya2');
	  $NamaBiaya = mysql_result($r, 0, 'NamaBiaya');
	  $Jumlah = mysql_result($r, 0, 'Jumlah');
	  $Biaya = mysql_result($r, 0, 'Biaya');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $na = 'checked'; else $na = '';
	  $ctt = mysql_result($r, 0, 'Catatan');
	  $jdl = 'Edit Biaya Mahasiswa';
	}
	$optman = GetOption2('biaya2', 'Nama', 'Nama', $IDBiaya2, '', 'ID');
	if ($md2 == 0) {
	  $dt = <<<EOF
	    <tr><td class=lst>Nama Biaya</td><td class=lst><input type=text name='NamaBiaya' value='$NamaBiaya' size=35 maxlength=100></td></tr>
EOF;
	}
	else {
	  $dt = <<<EOF
	  <tr><th class=ttl colspan=2 align=left><input type=radio name='dari' value='0' checked>Dari Master Biaya</th></tr>
	  <tr><td class=lst>Jenis Biaya</td><td class=lst><select name='IDBiaya2'>$optman</select></td></tr>
	  
	  <tr><th class=ttl colspan=2 align=left><input type=radio name='dari' value='1'>Manual</th></tr>
	  <tr><td class=lst>Nama Biaya</td><td class=lst><input type=text name='NamaBiaya' value='$NamaBiaya' size=35 maxlength=100></td></tr>
	  <tr><th class=ttl colspan=2>Jumlah</th></tr>
EOF;
	}
	$hd = <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhswkeu'>
	  <input type=hidden name='md' value=0>
	  <input type=hidden name='md1' value=0>
	  <input type=hidden name='md2' value=$md2>
	  <input type=hidden name='nim' value='$nim'>
	  <input type=hidden name='thn' value='$thn'>
	  <input type=hidden name='biaid' value=$biaid>
	  <input type=hidden name='KodeBiaya' value='$KodeBiaya'>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
EOF;
    $sid = session_id();
    $ft = <<<EOF
	  <tr><td class=lst>Jumlah</td><td class=lst><input type=text name='Jumlah' value='$Jumlah' size=3 maxlength=3></td></tr>
	  <tr><td class=lst>Biaya</td><td class=lst><input type=text name='Biaya' value='$Biaya' size=15 maxlength=11></td></tr>
	  <tr><td class=lst colspan=2>Catatan:<br>
	  <textarea name='ctt' cols=35 rows=3>$ctt</textarea></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcbiaya' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0&md1=0&PHPSESSID=$sid'"></td></tr>
	  </form></table>
EOF;
	return $hd . $dt . $ft;
  }
  function HitungTotalBiaya($thn, $nim) {
    global $strCantQuery;
	$st = "select sum(Jumlah*Biaya) as BIA from biayamhsw where Tahun='$thn' and NIM='$nim'";
	$rt = mysql_query($st) or die("$strCantQuery: $st<br>".mysql_error());
	if (mysql_num_rows($rt) > 0) {
	  $_bia = mysql_result($rt, 0, 'BIA');
	  mysql_query("update khs set Biaya=$_bia where Tahun='$thn' and NIM='$nim'");
	}
  }
  function HitungTotalBayar($thn, $nim) {
    global $strCantQuery;
    $st = "select sum(Kali*Jumlah) as BYR from bayar where Tahun='$thn' and NIM='$nim'";
	$rt = mysql_query($st) or die("$strCantQuery: $st<br>".mysql_error());
	if (mysql_num_rows($rt) > 0) {
	  $_byr = mysql_result($rt, 0, 'BYR');
	  mysql_query("update khs set Bayar=$_byr where Tahun='$thn' and NIM='$nim'");
	}
  }
  function PrcBiaya() {
    global $strCantQuery;
    $md2 = $_REQUEST['md2'];
	$KodeBiaya = $_REQUEST['KodeBiaya'];
	$nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$biaid = $_REQUEST['biaid'];
	$Jumlah = $_REQUEST['Jumlah'];
	$Biaya = $_REQUEST['Biaya'];
	$NamaBiaya = FixQuotes($_REQUEST['NamaBiaya']);
	$ctt = FixQuotes($_REQUEST['ctt']);
	if ($md2 == 0) {
	  $s = "Update biayamhsw set NamaBiaya='$NamaBiaya', Jumlah='$Jumlah', Biaya='$Biaya', Catatan='$ctt' where ID='$biaid'";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	} 
	else {
	  $dari = $_REQUEST['dari'];
	  $IDBiaya2 = $_REQUEST['IDBiaya2'];
	  $unip = $_SESSION['unip'];
	  if ($dari == 0) $NamaBiaya = GetaField('biaya2', 'ID', $IDBiaya2, 'Nama');
	  else $IDBiaya2 = 0;
	  $s = "insert into biayamhsw (Tanggal, Tahun, KodeBiaya, IDBiaya2, NamaBiaya,
	    NIM,Jumlah,Biaya,Catatan,Login) values (now(), '$thn', '$KodeBiaya', '$IDBiaya2', '$NamaBiaya',
		'$nim', '$Jumlah', '$Biaya','$ctt','$unip') ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	HitungTotalBiaya($thn, $nim);
	return -1;
  }
  function EditBayarMhsw($nim, $thn, $md3, $byrid) {
    global $strCantQuery, $fmtErrorMsg, $kdj;
	if ($md3 == 0) {
	  $s = "select * from bayar where ID=$byrid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $KodeBiaya = mysql_result($r, 0, 'KodeBiaya');
	  $NamaBayar = mysql_result($r, 0, 'NamaBayar');
	  $JenisTrx = mysql_result($r, 0, 'JenisTrx');
	  $Jumlah = mysql_result($r, 0, 'Jumlah');
	  if (mysql_result($r, 0, 'Denda') == 'Y') $Denda = 'checked'; else $Denda = '';
	  $HariDenda = mysql_result($r, 0, 'HariDenda');
	  $HariBebas = mysql_result($r, 0, 'HariBebas');
	  $HargaDenda = mysql_result($r, 0, 'HargaDenda');
	  $Catatan = mysql_result($r, 0, 'Catatan');
	  $jdl = 'Edit Pembayaran';
	  $strnote = '<font color=red>*) </font>';
	  $strfoot = "<font color=red class=ttl>*) </font>: Tidak dapat diubah.";
	}
	else {
	  $byrid = 0;
	  $arrkhs = GetFields('khs', "Tahun='$thn' and NIM", $nim, 'KodeBiaya,Biaya,Bayar');
	  $KodeBiaya = $arrkhs['KodeBiaya'];
	  $NamaBayar = '';
	  $JenisTrx = '';
	  $Jumlah = $arrkhs['Biaya'] - $arrkhs['Bayar'];
	  $tlt = KenaDenda($thn, $kdj);
	  if ($tlt > 0) {
	    $Denda = 'checked';
		$HariDenda = $tlt;
		$HargaDenda = GetaField('bataskrs', "Tahun='$thn' and KodeJurusan", $kdj, 'HargaDenda');
	  }
	  else {
	    $Denda = '';
		$HariDenda = 0;
		$HargaDenda = 0;
	  }
	  $HariBebas = 0;
	  $Catatan = '';
	  $jdl = 'Tambah Pembayaran';
	  $strnote = '';
	  $strfoot = '';
	}
	$optjnstrx = GetOption2('jenistrx', "concat(Nama, ' (x ', Kali, ')')", 'Nama', $JenisTrx, '', 'ID');
	$sid = session_id();
	return <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='mhswkeu'>
	<input type=hidden name='md' value=0>
	<input type=hidden name='md1' value=0>
	<input type=hidden name='md2' value=-1>
	<input type=hidden name='md3' value=$md3>
	<input type=hidden name='nim' value='$nim'>
	<input type=hidden name='thn' value='$thn'>
	<input type=hidden name='byrid' value=$byrid>
	<input type=hidden name='KodeBiaya' value='$KodeBiaya'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=lst>Jenis Transaksi</td><td class=lst><select name='JenisTrx'>$optjnstrx</select></td></tr>
	<tr><td class=lst>Nama Pembayaran</td><td class=lst><input type=text name='NamaBayar' value='$NamaBayar' size=30 maxlength=50> $strnote</td></tr>
	<tr><td class=lst>Jumlah</td><td class=lst><input type=text name='Jumlah' value='$Jumlah' size=12 maxlength=11> $strnote</td></tr>
	<tr><th class=ttl colspan=2>Denda</th></tr>
	<tr><td class=lst>Kena Denda</td><td class=lst><input type=checkbox name='Denda' value='Y' $Denda> $strnote</td></tr>
	<tr><td class=lst>Keterlambatan</td><td class=lst><input type=text name='HariDenda' value='$HariDenda' size=5 maxlength=3> hari. $strnote</td></tr>
	<tr><td class=lst>Hari bebas/libur</td><td class=lst><input type=text name='HariBebas' value='$HariBebas' size=5 maxlength=3> hari. $strnote</td></tr>
	<tr><td class=lst>Denda</td><td class=lst><input type=text name='HargaDenda' value='$HargaDenda' size=12 maxlength=11> rupiah/hari. $strnote</td></tr>
	<tr><td class=lst colspan=2>Catatan:<br><textarea name='Catatan' cols=30 rows=3>$Catatan</textarea></td></tr>
	<tr><td class=lst colspan=2><input type=submit name='prcbayar' value='Simpan'>&nbsp;
	<input type=reset name='reset' value='Reset'>&nbsp;
	<input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=mhswkeu&md=0&md1=0&nim=$nim&thn=$thn&PHPSESSID=$sid'"></td></tr>
	</form></table>$strfoot
EOF;
  }
  function PrcBayar() {
    global $strCantQuery;
    $md3 = $_REQUEST['md3'];
	$nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$byrid = $_REQUEST['byrid'];
	$KodeBiaya = $_REQUEST['KodeBiaya'];
	$JenisTrx = $_REQUEST['JenisTrx'];
	$NamaBayar = FixQuotes($_REQUEST['NamaBayar']);
	$Jumlah = $_REQUEST['Jumlah'];
	if (isset($_REQUEST['Denda'])) {
	  $Denda = $_REQUEST['Denda']; 
	  $HariDenda = $_REQUEST['HariDenda'];
	  $HariBebas = $_REQUEST['HariBebas'];
	  $HargaDenda = $_REQUEST['HargaDenda'];
	}
	else {
	  $Denda = 'N';
	  $HariDenda = 0;
	  $HariBebas = 0;
	  $HargaDenda = 0;
	}
	$Catatan = FixQuotes($_REQUEST['Catatan']);
	$kali = GetaField('jenistrx', 'ID', $JenisTrx, 'Kali');
	if ($md3 == 0) {
	  $s = "update bayar set JenisTrx=$JenisTrx, Kali=$kali, Catatan='$Catatan'
	    where ID=$byrid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else {
	  $unip = $_SESSION['unip'];
	  $s = "insert into bayar(Tanggal, Tahun, KodeBiaya, NIM, NamaBayar, JenisTrx, Kali,
	    Jumlah, Denda, HariDenda, HariBebas, HargaDenda, Catatan, Login) values
		(now(), '$thn', '$KodeBiaya', '$nim', '$NamaBayar', '$JenisTrx', '$kali',
		$Jumlah, '$Denda', $HariDenda, $HariBebas, $HargaDenda, '$Catatan', '$unip') ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	HitungTotalBayar($thn, $nim);
    return -1;
  }
  function EditKeuMhsw($nim, $thn, $md2, $md3) {
    global $strCantQuery;
	if (isset($_REQUEST['biaid'])) $biaid = $_REQUEST['biaid']; else $biaid = 0;
	if (isset($_REQUEST['byrid'])) $byrid = $_REQUEST['byrid']; else $byrid = 0;
	if ($md2 == -1)	$_biaya = DaftarBiayaMhsw($nim, $thn); else $_biaya = EditBiayaMhsw($nim, $thn, $md2, $biaid);
	if ($md3 == -1)	$_bayar = DaftarBayarMhsw($nim, $thn); else $_bayar = EditBayarMhsw($nim, $thn, $md3, $byrid);
	echo <<<EOF
	<a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&md=0' class=lst>Kembali</a>
	<table class=box cellspacing=1 cellpadding=1 width=100%>
	<tr><th class=ttl>Biaya-biaya</th><th class=ttl>Pembayaran</th></tr>
	<tr><td class=basic valign=top>$_biaya</td>
	<td class=basic valign=top>$_bayar</td></tr>
	</table>
EOF;
  }
  function DispHeaderKeu($nim, $thn, $kdj) {
	global $strCantQuery, $fmtErrorMsg;
	$s = "select k.*, st.Nama as STA, st.Nilai as STN
	  from khs k left outer join statusmhsw st on k.Status=st.Kode
	  where k.Tahun='$thn' and NIM='$nim'";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	$jml = mysql_num_rows($r);
	if ($jml == 0) DisplayHeader($fmtErrorMsg, 'Data Tidak ditemukan.');
	elseif ($jml > 1) DisplayHeader($fmtErrorMsg, "Terjadi duplikasi data tahun - $thn utk mhsw ini.");
	elseif ($jml == 1) {
	  $ssi = mysql_result($r, 0, 'Sesi');
	  $sta = mysql_result($r, 0, 'STA');
	  $nil = mysql_result($r, 0, 'STN');
	  $sks = mysql_result($r, 0, 'SKS');
	  $bbt = mysql_result($r, 0, 'Bobot');
	  if ($sks == 0) $ips = 0; else $ips = $bbt / $sks;
	  $bea = mysql_result($r, 0, 'KodeBiaya');
	  $bia = number_format(mysql_result($r, 0, 'Biaya'), 2, ',', '.');
	  $byr = number_format(mysql_result($r, 0, 'Bayar'), 2, ',', '.');
	  if ($nil == 0) $cls = 'class=nac'; else $cls = 'class=lst';
	  if ($bia > $byr) {
	    $strbyr = 'Belum Lunas';
		$clsbyr = 'class=wrn';
	  }
	  else {
	    $strbyr = 'Sudah Lunas';
		$clsbyr = 'class=nac';
	  }
	  $tlt = KenaDenda($thn, $kdj);
	  if ($bia > $byr && $tlt > 0) {
	    $strdnd = "$tlt hari";
		$clsdnd = 'class=wrn';
	  }
	  else {
	    $strdnd = '<center>0</center>';
		$clsdnd = 'class=lst';
	  }
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Sesi</th><th class=ttl>Tahun</th><th class=ttl>Status</th><th class=ttl>SKS</th>
	  <th class=ttl>IPS</th><th class=ttl>Kode Biaya</th><th class=ttl>Biaya</th><th class=ttl>Bayar</th>
	  <th class=ttl>Stat. Byr</th><th class=ttl>Denda</a></tr>
	  <tr><td $cls>$ssi</td><td $cls>$thn</td><td $cls>$sta</td><td $cls>$sks</td>
	  <td $cls>$ips</td><td $cls>$bea</td><td $cls align=right>$bia</td><td $cls align=right>$byr</td>
	  <td $clsbyr>$strbyr</td><td $clsdnd>$strdnd</td>
	  </tr></table><br>
EOF;
	}
  }
  function PrcOto($nim, $thn) {
    global $strCantQuery, $fmtErrorMsg;
	function InsertBiaya($nim, $thn, $row) {
	  global $strCantQuery, $fmtErrorMsg;
	  if ($row['PakaiScript'] == 'Y') {
	    if (file_exists("sysfo/script/$row[NamaScript].php")) {
	      include_once "sysfo/script/$row[NamaScript].php";
		  $func = $row['NamaScript'];
		  $func($nim, $thn, $row);
		}
		else echo "<script language='javascript'>alert('Script: sysfo/script/$row[NamaScript].php tidak ditemukan.')</script>";
	  }
	  else {
	    $sdh = GetaField('biayamhsw', "NIM='$nim' and Tahun='$thn' and IDBiaya2", $row['ID'], 'IDBiaya2');
		if (empty($sdh)) {
		  $unip = $_SESSION['unip'];
	      $s = "insert into biayamhsw (Tanggal, Tahun, KodeBiaya, IDBiaya2, NamaBiaya, NIM,
		    Jumlah, Biaya, Denda, Login) values (now(), '$thn', '$row[KodeBiaya]', $row[ID], '$row[Nama]',
		    '$nim', 1, $row[Jumlah], '$row[Denda]', '$unip') ";
		  $r = mysql_query($s) or die("$strCantQuery: $s");
		}
	  }
	}
	$arr = GetFields('khs', "Tahun='$thn' and NIM", $nim, 'Sesi,KodeBiaya,Status');
	$bea = $arr['KodeBiaya'];
	$ssi = $arr['Sesi'];
	$sta = GetaField('mhsw', 'NIM', $nim, 'StatusAwal');
	if (empty($bea)) DisplayHeader($fmtErrorMsg, "Kode Biaya belum diset untuk mhsw ini di Tahun Ajaran $thn.");
	else {
	  $s = "select * from biaya2 where KodeBiaya='$bea' and Otomatis='Y' ";
	  $r = mysql_query($s) or die ("$strCantQuery:: $s.<br>".mysql_error());
	  while ($row = mysql_fetch_array($r)) {
	    $jb = $row['JenisBiaya'];
		if (empty($row['Status'])) $st = true; else $st = $row['Status'] == $arr['Status'];
		if (empty($row['StatusAwal'])) $sa = true; else $sa = $row['StatusAwal'] == $sta;
		if ($st && $sa) {
		switch($jb):
		  case 5: 
		    // Sebelum masuk
			if ($ssi == 0) InsertBiaya($nim, $thn, $row);
		  case 10:
		    // Awal masuk kuliah
			if ($ssi == 1) InsertBiaya($nim, $thn, $row);
			break;
		  case 20:
		    // Tiap semester
			if ($ssi > 0) InsertBiaya($nim, $thn, $row);
			break;
		  case 30:
		    // Lulus kuliah
			$sx = "select max(Sesi) as mx from khs where NIM='$nim'";
			$rx = mysql_query($sx) or die ("$strCantQuery: $s");
			$mx = mysql_result($r, 0, 'mx');
			if ($ssi == $mx) InsertBiaya($nim, $thn, $row);
			break;
		  case 40:
		    // Penyetaraan
			InsertBiaya($nim, $thn, $row);
			break;
		endswitch;
		}
	  }
	}
	HitungTotalBiaya($thn, $nim);
  }
  function DispFooterKeu($nim) {
    global $strCantQuery;
	$s = "select sum(Biaya) as BIA, sum(Bayar) as BYR from khs where NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $ss");
	if (mysql_num_rows($r) > 0) {
	  $bia = number_format(mysql_result($r, 0, 'BIA'), 2, ',', '.');
	  $byr = number_format(mysql_result($r, 0, 'BYR'), 2, ',', '.');
	  echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=lst>Total Biaya</td><td class=ttl align=right>$bia</td></tr>
	  <tr><td class=lst>Total Pembayaran</td><td class=ttl align=right>$byr</td></tr>
	  </table>
EOF;
	}
  }

  // *** PARAMETER2 ***
  if ($_SESSION['ulevel'] == 4) {
    $nim = $_SESSION['unip'];
	$_SESSION['nim'] = $nim;
	$_SESSION['srcmhsw'] = $nim;
	$_SESSION['prcsrc'] = 'NIM';
  }
  else {
    if (isset($_REQUEST['nim'])) {
      $nim = $_REQUEST['nim'];
	  $_SESSION['nim'] = $nim;
    } else { if (isset($_SESSION['nim'])) $nim = $_SESSION['nim']; else $nim = ''; }
  }
  if ($_SESSION['ulevel'] == 4) {
   $kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
   $_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_REQUEST['kdj'])) {
     $kdj = $_REQUEST['kdj'];
	  $_SESSION['kdj'] = $kdj;
    } else { if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = ''; }
  }

  if (isset($_REQUEST['srcmhsw'])) {
    $srcmhsw = $_REQUEST['srcmhsw'];
	$_SESSION['srcmhsw'] = $srcmhsw;
  } else { if (isset($_SESSION['srcmhsw'])) $srcmhsw = $_SESSION['srcmhsw']; else $srcmhsw=''; }
  if (isset($_REQUEST['prcsrc'])) {
    $prcsrc = $_REQUEST['prcsrc'];
	$_SESSION['prcsrc'] = $prcsrc;
  } else { if (isset($_SESSION['prcsrc'])) $prcsrc = $_SESSION['prcsrc']; else $prcsrc=''; }
  if (isset($_REQUEST['thn'])) $thn = $_REQUEST['thn']; else $thn = '';
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['md1'])) $md1 = $_REQUEST['md1']; else $md1 = -1;
  if (isset($_REQUEST['md2'])) $md2 = $_REQUEST['md2']; else $md2 = -1;
  if (isset($_REQUEST['md3'])) $md3 = $_REQUEST['md3']; else $md3 = -1;

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Keuangan Mahasiswa');
  //if (isset($_REQUEST['prcbea'])) $md = PrcBea();
  if (strpos('123', $_SESSION['ulevel']) === false) {}
  else {
    DispJur($kdj, 0, 'mhswkeu');
    DispSearchMhsw($srcmhsw, 'mhswkeu');
  }
  if (isset($_REQUEST['prcoto'])) PrcOto($nim, $thn);
  if (isset($_REQUEST['prcbiaya'])) $md2 = PrcBiaya();
  if (isset($_REQUEST['prcbayar'])) $md3 = PrcBayar();
  if (isset($_REQUEST['prcjml'])) {
    HitungTotalBiaya($thn, $nim);
	HitungTotalBayar($thn, $nim);
  }
  if ($md == -1) DispDaftarMhsw($kdj, $prcsrc, $srcmhsw, 'mhswkeu');
  else {
    DispHeaderMhsw($nim, 'mhswkeu');
	if ($md1 == -1)	{
	  DispKeuMhsw($nim);
	  DispFooterKeu($nim);
	}
	else {
	  DispHeaderKeu($nim, $thn, $kdj);
	  EditKeuMhsw($nim, $thn, $md2, $md3);
	}
  }
?>
