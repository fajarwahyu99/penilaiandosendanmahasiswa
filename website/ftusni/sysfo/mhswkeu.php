<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  include_once "mhswkeu.lib.php";
  
  // *** Fungsi2 ***

  function DispFooterKeuMhsw0($nim, $thn) {
    global $strCantQuery;
	$s = "select Biaya, Bayar, Potong, Tarik from khs where Tahun='$thn' and NIM='$nim' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) die("Data tidak ditemukan.");
	$tbia = mysql_result($r, 0, 'Biaya');
	$tpot = mysql_result($r, 0, 'Potong');
	$tbyr = mysql_result($r, 0, 'Bayar');
	$ttrk = mysql_result($r, 0, 'Tarik');
	$ssa = ($tbia+$tpot)-($tbyr+$ttrk);
	if ($ssa <= 0) $lns = 'class=uline'; else $lns = 'class=wrn';
	$tbia = NUMI($tbia);
	$tpot = NUMI($tpot);
	$tbyr = NUMI($tbyr);
	$ttrk = NUMI($ttrk);
	$ssa = NUMI($ssa);
	echo <<<EOF
	<br><table class=box cellspacing=1 cellpadding=2>
	<tr><th class=ttl colspan=3>Rekapitulasi</th></tr>
	<tr><td width=100>Total Biaya</td><td>:</td><td class=uline align=right width=125>$tbia</td></tr>
	<tr><td>Total Potongan</td><td>:</td><td class=uline align=right>$tpot</td></tr>
	<tr><td>Total Bayar</td><td>:</td><td class=uline align=right>$tbyr</td></tr>
	<tr><td>Total Penarikan/Pengambilan</td><td>:</td><td class=uline align=right>$ttrk</td></tr>
	<tr><td>Kekurangan</td><td>:</td><td $lns align=right>$ssa</td></tr>
	</table>
EOF;
  }
  function DispKeuMhsw($nim='') {
  //<a href='sysfo.php?syxec=mhswkeu&md=-1&thn=$row[Tahun]&nim=$nim'>$row[Tahun]</a>
    $s = "select k.* 
	  from khs k
	  where k.NIM='$nim' order by k.Tahun";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Smt</th><th class=ttl>Tahun</th>
	  <th class=ttl>Master Biaya</th>
	  <th class=ttl>Total Biaya</th><th class=ttl>Total Potong</th>
	  <th class=ttl>Total Bayar</th><th class=ttl>Total Kembali</th>
	  <th class=ttl>Kekurangan</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $kurang = NUMI(($w['Biaya'] + $w['Potong']) - ($w['Bayar'] + $w['Tarik']));
	  $sbia = NUMI($w['Biaya']);
	  $spot = NUMI($w['Potong']);
	  $sbyr = NUMI($w['Bayar']);
	  $strk = NUMI($w['Tarik']);
	  if ($kurang > 0) $lns = 'class=wrn'; else $lns = 'class=lst';
	  echo <<<EOF
	  <tr><td class=lst>$w[Sesi]</td>
	  <td class=lst><a href='sysfo.php?syxec=mhswkeu&md=-1&thn=$w[Tahun]&nim=$nim'>$w[Tahun]</a></td>
	  <td class=lst>$w[KodeBiaya]</td>
	  <td class=lst align=right>$sbia</td>
	  <td class=lst align=right>$spot</td>
	  <td class=lst align=right>$sbyr</td>
	  <td class=lst align=right>$strk</td>
	  <td $lns align=right>$kurang</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function DispBiaya2($nim, $thn) {
    global $strCantQuery;
	$s = "select * from biayamhsw where Tahun='$thn' and NIM='$nim' order by NamaBiaya";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$nmr = 0;
	$hdptg = "<tr><td>&nbsp;</td></tr><tr><th class=ttl colspan=4>Potongan-potongan</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>Jenis</th>
	  <th class=ttl>Jumlah</th><th class=ttl>&nbsp;</th>
	  </tr>";
	$hdbea = "<tr><td>&nbsp;</td></tr><tr><th class=ttl colspan=4>Biaya-biaya</th></tr>
	  <tr><th class=ttl>#</th><th class=ttl>Biaya</th>
	  <th class=ttl>Jumlah</th><th class=ttl>Bayar</th>
	  </tr>";
	$kali = 0;
	$a = "<table class=basic cellspacing=0 cellpadding=2>";
	while ($row = mysql_fetch_array($r)) {
	  if ($kali != $row['Kali']) {
	    $kali = $row['Kali'];
		if ($kali == -1) $a .= $hdptg;
		elseif ($kali == 1) $a .= $hdbea;
		$nmr = 0;
	  }
	  $nmr++;
	  $bia = number_format($row['Kali'] * $row['Jumlah']*$row['Biaya'], 0, ',', '.');
	  $byr = number_format($row['Bayar'], 0, ',', '.');
	  if ($_SESSION['ulevel'] > 2) $strbyr = $row['NamaBiaya'];
	  else $strbyr = "<a href='sysfo.php?syxec=mhswkeu&mdx=bia&md=0&biaid=$row[ID]&thn=$thn&nim=$nim'>$row[NamaBiaya]</a>";
	  if ($row['Kali'] == 1) {
	    if ($row['Jumlah']*$row['Biaya'] > $row['Bayar']) $lns = 'class=wrn'; else $lns = 'class=lst';
	    $a .= <<<EOF
	    <tr><td class=ttl title='$row[Catatan]'>$nmr</td><td class=lst>$strbyr</td>
	    <td class=lst align=right>$bia</td><td $lns align=right>$byr</td>
	    </tr>
EOF;
	  }
	  else {
	    $a .= <<<EOF
	    <tr><td class=ttl title='$row[Catatan]'>$nmr</td><td class=lst>$strbyr</td>
	    <td class=lst align=right>$bia</td><td class=nac>&nbsp;</td></tr>
EOF;
	  }
	}
	return $a . "</table>";
  }
function DispBayar2($nim, $thn) {
  global $strCantQuery;
  $s = "select *, date_format(Tanggal, '%d-%m-%Y') as tgl
	  from bayar where Tahun='$thn' and NIM='$nim' order by Kali,ID";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$kali = 0;
	$hdtrk = "<tr><td>&nbsp;</td></tr><tr><th class=ttl colspan=5>Daftar Penarikan</th></tr>
	  <tr><th class=ttl># Kwi</th><th class=ttl>Tanggal</th>
	  <th class=ttl>Keterangan</th><th class=ttl>Jumlah</th><th class=ttl>&nbsp;</th></tr>";
	$hdbyr = "<tr><td>&nbsp;</td></tr><tr><th class=ttl colspan=5>Daftar Pembayaran</th></tr>
	  <tr><th class=ttl># Kwi</th><th class=ttl>Tanggal</th>
	  <th class=ttl>Keterangan</th><th class=ttl>Jumlah</th><th class=ttl>Denda</th></tr>";
	$a = "<table class=basic cellspacing=0 cellpadding=2>";
	while ($row = mysql_fetch_array($r)) {
	  if ($kali != $row['Kali']) {
	    $kali = $row['Kali'];
		if ($kali == -1) {
		  $a .= $hdtrk;
		}
		elseif ($kali == 1) {
		  $a .= $hdbyr;
		}
	  }
	  $jml = number_format($row['Kali']*$row['Jumlah'], 0, ',', '.');
	  $snm = session_name(); $sid = session_id();
	  if ($kali == -1) {
	    if ($_SESSION['ulevel'] > 2) {
		  $strprn = '';
		}
	    else {
		  $strprn = GetPrinter("print.php?print=sysfo/mhswkeu_tarik.php&biaid=$row[ID]&thn=$thn&nim=$nim&$snm=$sid");
		  //$strprn = '';
		}
	    $a .= "<tr><td class=ttl title='Tanggal: $row[tgl]\nPenarikan: $row[NamaBayar]\nJumlah: $jml\nCatatan: $row[Catatan]'>$row[ID]</td>
		  <td class=lst>$row[tgl]</td>
		  <td class=lst>$row[NamaBayar]</td>
		  <td class=lst align=right>$jml</td><td class=lst align=center>$strprn</td></tr>";
	  }
	  elseif ($kali == 1) {
	    if ($row['Denda'] == 'Y') 
	      $dnd = number_format(($row['HariDenda']-$row['HariBebas']) * $row['HargaDenda'], 0, ',', '.');
	    else $dnd = '0';
	    if ($_SESSION['ulevel'] > 2) {
		  $strprn = '';
		}
	    else {
		  $strprn = GetPrinter("print.php?print=sysfo/mhswkeu_bayar.php&biaid=$row[ID]&thn=$thn&nim=$nim&$snm=$sid");
		  //$strprn = '';
		}
	    $a .= "<tr><td class=ttl title='Tanggal: $row[tgl]\n$row[Catatan]'>$row[ID]</td>
		  <td class=lst>$row[tgl]</td><td class=lst>$row[NamaBayar]</td>
		  <td class=lst align=right>$jml</td><td class=lst align=right>$dnd</td>
		  <td class=basic>$strprn</td></tr>";
	  }
	}
	return $a . "</table>";
  }
function DispKeuMhswRinci($nim, $thn) {
  global $strCantQuery;
	if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
	if ($prn == 0) echo "<table class=box cellspacing=1 cellpadding=2><tr><td>
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim'>Kembali</a> | ";
	if ($_SESSION['ulevel'] <= 2 && $prn == 0)
	  echo "<a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&mdx=bia&md=1'>Tambah Biaya</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&mdx=byr&md=1'>Pembayaran</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&mdx=trk&md=1'>Pengembalian</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&prcoto=1'>Proses Biaya2</a> |
	  <a href='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&prchit=1'>Hitung Ulang</a>";
	echo "</td></tr></table>";
	$kiri = DispBiaya2($nim, $thn);
	$kanan = DispBayar2($nim, $thn);
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td class=basic style='border-right: 1px silver dotted;' valign=top>$kiri</td>
	<td class=basic valign=top>$kanan</td>
	</tr>
	</table>
EOF;
  DispFooterKeuMhsw0($nim, $thn);
}
function EditBiayaMhsw($nim, $thn, $md, $biaid=0) {
  global $strCantQuery;
	$kdj = GetaField('mhsw', "NIM", $nim, "KodeJurusan");
	$KodeBiaya = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'KodeBiaya');
	$IDBiaya2 = 0;
	$NamaBiaya = '';
	$Jumlah = 1;
	$Biaya = 0;
	$na = '';
	$ctt = '';
	$jdl = 'Tambah Biaya/Potongan Mahasiswa';
	if ($md==0) {
	  $r = mysql_query("select * from biayamhsw where ID=$biaid") or die("$strCantQuery: EditBiayaMhsw");
	  $KodeBiaya = mysql_result($r, 0, 'KodeBiaya');
	  $IDBiaya2 = mysql_result($r, 0, 'IDBiaya2');
	  $NamaBiaya = mysql_result($r, 0, 'NamaBiaya');
	  $Jumlah = mysql_result($r, 0, 'Jumlah');
	  $Biaya = mysql_result($r, 0, 'Biaya');
	  $Kali = mysql_result($r, 0, 'Kali');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $na = 'checked'; else $na = '';
	  $ctt = mysql_result($r, 0, 'Catatan');
	  $jdl = 'Edit Biaya Mahasiswa';
	}
	$optman = GetOption2('biaya2', "concat(Nama, '  (', Kali, ')')", 
	  'Kali,Nama', $IDBiaya2, "KodeBiaya='$KodeBiaya' and KodeJurusan='$kdj' and NotActive='N'", 'ID', 1);
	if ($md == 0)
	  $dt = "<tr><td class=lst>Nama Biaya/Potongan</td><td class=lst>
	    <input type=text name='NamaBiaya' value='$NamaBiaya' size=35 maxlength=100></td></tr>
	    <input type=hidden name='Kali' value='$Kali'>";
	else {
	  $dt = <<<EOF
	  <tr><th class=ttl colspan=2 align=left><input type=radio name='dari' value='0' checked>Dari Master Biaya</th></tr>
	  <tr><td class=lst><img src='image/brch.gif'> Jenis Biaya/Potongan</td><td class=lst><select name='IDBiaya2'>$optman</select></td></tr>
	  <tr><th class=ttl colspan=2 align=left><input type=radio name='dari' value='1'>Manual</th></tr>
	  <tr><td class=lst><img src='image/brch.gif'> Nama Akun</td><td class=lst><input type=text name='NamaBiaya' value='$NamaBiaya' size=35 maxlength=100></td></tr>
	  <tr><td class=lst><img src='image/brch.gif'> Jenis Akun</td><td class=lst><input type=radio name='Kali' value='-1'>Potongan &nbsp;
	    <input type=radio name='Kali' value='1'>Biaya</td></tr>
	  <tr><th class=ttl colspan=2>Jumlah</th></tr>
EOF;
	}
	$hd = <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='mhswkeu'>
	  <input type=hidden name='md' value=$md>
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
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&PHPSESSID=$sid'"></td></tr>
	  </form></table>
EOF;
	echo $hd . $dt . $ft;
  }
function PrcBiaya() {
  global $strCantQuery;
  $md = $_REQUEST['md'];
	$KodeBiaya = $_REQUEST['KodeBiaya'];
	$nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$biaid = $_REQUEST['biaid'];
	$Jumlah = $_REQUEST['Jumlah'];
	$Biaya = $_REQUEST['Biaya'];
	$Kali = $_REQUEST['Kali'];
	$NamaBiaya = FixQuotes($_REQUEST['NamaBiaya']);
	$ctt = FixQuotes($_REQUEST['ctt']);
	if ($md == 0) {
	  $s = "Update biayamhsw set NamaBiaya='$NamaBiaya', Jumlah='$Jumlah', Biaya='$Biaya', Catatan='$ctt' where ID='$biaid'";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	} 
	else {
	  $dari = $_REQUEST['dari'];
	  $IDBiaya2 = $_REQUEST['IDBiaya2'];
	  $unip = $_SESSION['unip'];
	  if ($dari == 0) {
	    $arrbea = GetFields('biaya2', 'ID', $IDBiaya2, 'Nama,Kali');
	    $NamaBiaya = $arrbea['Nama'];
		$Kali = $arrbea['Kali'];
	  }
	  else {
	    $IDBiaya2 = 0;
	  }
	  $s = "insert into biayamhsw (Tanggal, Tahun, KodeBiaya, IDBiaya2, NamaBiaya, Kali,
	    NIM,Jumlah,Biaya,Catatan,Login) values (now(), '$thn', '$KodeBiaya', '$IDBiaya2', '$NamaBiaya', '$Kali',
		'$nim', '$Jumlah', '$Biaya','$ctt','$unip') ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	HitungTotalBiaya($thn, $nim);
  }
  function WriteHitungTotalJavaScript() {
    echo <<<EOF
	<SCRIPT LANGUAGE=JavaScript>
	<!--
	  function hitung(form) {
	    var t = 0;
		for (var i =1; i <= form.cnt.value; i++) {
		  eval('t += Number(form.hrg'+i+'.value)');
		}
		form.tot.value = t;
	  }
	-->
	</SCRIPT>
EOF;
  }
  function DispFormBayar1($nim, $thn, $md=1) {
    global $strCantQuery;
	WriteHitungTotalJavaScript();
	$s = "select * from biayamhsw where Tahun='$thn' and NIM='$nim' and Kali=1 order by NamaBiaya";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$cnt = mysql_num_rows($r);
	$tot = 0;
	$i = 0;
	$opt = GetOption2('jenisbayar', 'Nama', 'Nama', 1, '', 'ID');
	$arrtrx = GetFields('jenistrx', 'ID', $md, 'Nama, Kali');
	$tgl = date('d-m-Y');
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
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
	$sid = session_id();
	echo "<form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='mhswkeu'>
	  <input type=hidden name='nim' value='$nim'>
	  <input type=hidden name='thn' value='$thn'>
	  <input type=hidden name='cnt' value=$cnt>
	  <input type=hidden name='md' value=$md>
	  <table class=box cellspacing=0 cellpadding=2>
	  <tr><td valign=top>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>$arrtrx[Nama]</th></tr>
	  <tr><td class=lst>Tanggal</td><td class=lst>$tgl</td></tr>
	  <tr><td class=lst>Pembayaran</td><td class=lst><input type=text name='NamaBayar' size=30 maxlength=50></td></tr>
	  <tr><td class=lst>Jenis Pembayaran</td><td class=lst><select name='JenisBayar'>$opt</select></td></tr>
	  <tr><td class=lst># Slip</td><td class=lst><input type=text name='BuktiBayar' size=30 maxlength=50></td></tr>
	  <tr><th class=ttl colspan=2>Denda</th></tr>
	  <tr><td class=lst>Kena Denda</td><td class=lst><input type=checkbox name='Denda' value='Y' $Denda></td></tr>
	  <tr><td class=lst>Hari Denda</td><td class=lst><input type=text name='HariDenda' value=$HariDenda size=5 maxlength=4> hari</td></tr>
	  <tr><td class=lst>Hari Bebas</td><td class=lst><input type=text name='HariBebas' value=$HariBebas size=5 maxlength=4> hari</td></tr>
	  <tr><td class=lst>Denda</td><td class=lst><input type=text name='HargaDenda' value=$HargaDenda size=15 maxlength=12> rupiah</td></tr>
	  <tr><th class=ttl colspan=2>Catatan</th></tr>
	  <tr><td class=lst colspan=2><textarea name='Catatan' cols=35 rows=3></textarea></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcbayar1' value='Simpan'>&nbsp;
	  <input type=reset name='Reset' value='Reset'>&nbsp;
	  <input type=button name='Batal' value='Batal' onClick=\"location='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&PHPSESSID=$sid'\"></td></tr>
	  </table></td>
	  
	  <td valign=top>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Untuk Membayar :</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $i++;
	  $tmp = ($row['Jumlah'] * $row['Biaya']) - $row['Bayar'];
	  if ($tmp < 0) $tmp = 0;
	  $tot += $tmp;
	  $jml = $tmp;
	  echo "<tr><td class=lst><input type=hidden name='bid$i' value=$row[ID]>$row[NamaBiaya]</td>
	  <td class=lst><input type=text name='hrg$i' value=$jml size=12 maxlength=12 onKeyUp=\"hitung(this.form)\"></td>
	  </tr>";
	}
	echo "<tr><td class=ttl><b>Total</b></td><td class=ttl><input type=text name='tot' value='$tot' size=12 maxlength=12></td></tr>
	</table></td></tr></table></form>";
  }
  function PrcBayar1() {
    $nim = $_REQUEST['nim']; 
	$thn = $_REQUEST['thn'];
	$cnt = $_REQUEST['cnt'];
	$md = $_REQUEST['md'];
	$NamaBayar = $_REQUEST['NamaBayar'];
	$JenisBayar = $_REQUEST['JenisBayar'];
	$BuktiBayar = FixQuotes($_REQUEST['BuktiBayar']);
	$Catatan = FixQuotes($_REQUEST['Catatan']);
	if (isset($_REQUEST['Denda'])) $Denda = $_REQUEST['Denda']; else $Denda = 'N';
	if ($Denda == 'Y') {
	  $HariDenda = $_REQUEST['HariDenda'];
	  $HariBebas = $_REQUEST['HariBebas'];
	  $HargaDenda = $_REQUEST['HargaDenda'];
	}
	else {
	  $HariDenda = 0; $HariBebas = 0; $HargaDenda = 0;
	}
	$Kali = GetaField('jenistrx', 'ID', $md, 'Kali');
	$s0 = "insert into bayar (Tanggal, NIM, Tahun, NamaBayar, JenisTrx, Kali, JenisBayar, BuktiBayar, Catatan, Denda, 
	  HariDenda, HariBebas, HargaDenda, Login) 
	  values (now(), '$nim', '$thn', '$NamaBayar', '$md', '$Kali', '$JenisBayar', 
	  '$BuktiBayar', '$Catatan', '$Denda', '$HariDenda', '$HariBebas', '$HargaDenda', '$_SESSION[unip]' )";
	$r0 = mysql_query($s0) or die("$strCantQuery: $s0<br>".mysql_error());
	$nid = GetLastID();
	$tot = 0;
	for ($i = 1; $i <= $cnt; $i++) {
	  $bid = $_REQUEST["bid$i"];
	  $hrg = $_REQUEST["hrg$i"]; settype($hrg, 'integer');
	  if ($hrg > 0) {
	    $tot += $hrg;
	    $sx = "insert into bayar2 (BayarID, BiayaID, Jumlah) values($nid, $bid, $hrg)";
	    $rx = mysql_query($sx) or die("$strCantQuery: $sx<br>".mysql_query());
	    $s1 = "update biayamhsw set Bayar=Bayar+$hrg where ID=$bid";
	    $r1 = mysql_query($s1) or die("$strCantQuery: $s1<br>".mysql_error());
	  }
	}
	$sy = "update bayar set Jumlah=$tot where ID=$nid";
	$ry = mysql_query($sy) or die("$strCantQuery: $sy<br>".mysql_error());
	HitungTotalBayar($thn, $nim);
	HitungTotalBiaya($thn, $nim);
  }
  function FormPenarikan($nim, $thn, $md, $biaid=0) {
    $def = GetaField('jenisbayar', "NotActive='N' and Def", "Y", 'ID');
	$nmtrx = GetaField('jenistrx', "NotActive='N' and Kali", -1, 'Nama');
	$tgl = date("d-m-Y");
	$snm = session_name();
	$sid = session_id();
	$tot = GetaField('khs', "Tahun='$thn' and NIM", $nim, "(Bayar+Tarik)-(Biaya+Potong)");
	$optjnsbyr = GetOption2('jenisbayar', 'Nama', 'Def,Nama', '', '', 'ID');
	echo <<<EOF
	<table class=box cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='mhswkeu'>
	<input type=hidden name='nim' value='$nim'>
	<input type=hidden name='thn' value='$thn'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='biaid' value='$biaid'>
	<tr><th class=ttl colspan=2>Penarikan Kelebihan Pembayaran</th></tr>
	<tr><td class=lst>Tanggal</td><td class=uline>$tgl</td></tr>
	<tr><td class=lst>Penarikan</td><td class=uline><input type=text name='NamaBayar' value='$nmtrx' size=40 maxlength=100></td></tr>
	<tr><td class=lst>Jenis Pembayaran</td><td class=uline><select name='JenisBayar'>$optjnsbyr</select></td></tr>
	<tr><td class=lst>No. Bukti Penarikan</td><td class=uline><input type=text name='BuktiBayar' size=40 maxlength=50></td></tr>
	<tr><td class=lst>Jumlah Penarikan</td><td class=uline><input type=text name='Jumlah' value='$tot' size=20 maxlength=15></td></tr>
	<tr><th class=ttl colspan=2>Catatan</th></tr>
	<tr><td class=uline colspan=2><textarea name='Catatan' cols=40 rows=3></textarea></td></tr>
	<tr><td class=basic align=center colspan=2><input type=submit name='prctrk' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='reset'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=mhswkeu&nim=$nim&thn=$thn&$snm=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcPenarikan() {
    $jnstrx = GetaField('jenistrx', 'Kali', -1, 'ID');
    $nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$NamaBayar = $_REQUEST['NamaBayar'];
	$JenisBayar = $_REQUEST['JenisBayar'];
	$BuktiBayar = $_REQUEST['BuktiBayar'];
	$biaid = $_REQUEST['biaid'];
	$Jumlah = $_REQUEST['Jumlah'];
	$Catatan = FixQuotes($_REQUEST['Catatan']);
	$s = "insert into bayar (Tanggal, NIM, Tahun, NamaBayar, JenisTrx, Kali, JenisBayar, BuktiBayar,
	  Jumlah, Catatan, Denda, HariDenda, HariBebas, HargaDenda, Login)
	  values (now(), '$nim', '$thn', '$NamaBayar', '$jnstrx', '-1', '$JenisBayar', '$BuktiBayar',
	    '$Jumlah', '$Catatan', 'N', 0, 0, 0, '$_SESSION[unip]')";
	$r = mysql_query($s) or die("Error: $s<br>".mysql_error());
	HitungTotalBayar($thn, $nim);
	HitungTotalBiaya($thn, $nim);
  }

  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['thn'])) $thn = $_REQUEST['thn']; else $thn = '';
  $nim = GetSetVar('nim');
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  if (isset($_REQUEST['mdx'])) $mdx = $_REQUEST['mdx']; else $mdx = '';
  if (isset($_REQUEST['biaid'])) $biaid = $_REQUEST['biaid']; else $biaid = 0;
  if ($_SESSION['ulevel'] == 4) $nim = GetSetVar('nim', $_SESSION['unip']);
  
  // *** Bagian Utama ***
  if ($mdx == 'byr0') DisplayHeader($fmtPageTitle, "BUKTI PEMBAYARAN");
  else DisplayHeader($fmtPageTitle, "Keuangan Mahasiswa");
  if ($prn == 0 && $_SESSION['ulevel'] < 4) {
    DispNIMMhsw($nim, 'mhswkeu');
  }
  if (ValidNIM($nim)) {
    if (isset($_REQUEST['prchit'])) {
	  HitungTotalBayar($thn, $nim);
	  HitungTotalBiaya($thn, $nim);
	}
	if (isset($_REQUEST['prcoto'])) PrcOto($nim, $thn);
	if (isset($_REQUEST['prcbiaya'])) PrcBiaya();
	if (isset($_REQUEST['prcbayar1'])) PrcBayar1();
	if (isset($_REQUEST['prctrk'])) PrcPenarikan();
	DispHeaderMhsw0($nim);
	echo "<br>";
    if ($thn == '') DispKeuMhsw($nim);
	else {
	  if (empty($mdx)) DispKeuMhswRinci($nim, $thn);
	  elseif ($mdx == 'bia') EditBiayaMhsw($nim, $thn, $md, $biaid);
	  elseif ($mdx == 'byr') DispFormBayar1($nim, $thn, $md);
	  elseif ($mdx == 'byr0') DispBayarMhsw($nim, $thn, $md, $biaid);
	  elseif ($mdx == 'trk') FormPenarikan($nim, $thn, $md, $biaid);
	}
  }
  else if (!empty($nim)) DisplayHeader($fmtErrorMsg, "Mahasiswa dengan NIM <b>$nim</b> tidak ditemukan.");
?>