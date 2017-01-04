<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net
  include_once "lib/table.common.php";
  
  // *** Fungsi2 ***
  function DaftarPMB($kdj, $lls) {
    global $strCantQuery;
	$pref = GetPMBPrefix();
	if (!empty($kdj)) $strkdj = "and Program='$kdj'"; else $strkdj = '';
	$s = "select * from pmb where PMBID like '$pref%' and TestPass='$lls' $strkdj order by TestScore desc";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$h = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=basic></th><th class=ttl># PMB</th><th class=ttl>Nama</th>
	  <th class=ttl>Nilai</th><th class=ttl>Bayar</th><th class=ttl>MGM</th>
	  <th class=ttl>Trm</th><th class=basic></th></tr>";
	while ($row = mysql_fetch_array($r)) {
      if ($lls == 'Y') {
	    if ($row['Terima'] == 'Y') {
		  $str1 = '';
		  $str2 = '';
		  $strtrm = '<img src="image/Y.gif" border=0>';
		}
		else {
		  $str1 = "<a href='sysfo.php?syxec=pmbterima&pmbid=$row[PMBID]&prcn=1'><img src='image/kiri.gif' border=0></a>";
		  $str2 = '';
		  $strtrm = "<a href='sysfo.php?syxec=pmbterima&pmbid=$row[PMBID]&prcsatu=1'><img src='image/gear.gif' width=14 border=0></a>";
		}
	  }
	  else {
	    $str1 = '';
		$str2 = "<a href='sysfo.php?syxec=pmbterima&pmbid=$row[PMBID]&prcy=1'><img src='image/kanan.gif' border=0></a>";
		$strtrm = '&nbsp;';
	  }
	  if ($row['PMBPaid'] == 'Y') $paid = 'class=lst align=center';
	  else $paid = 'class=nac align=center';
	  if (isset($row['KodeBiaya'])) $bia = $row['KodeBiaya']; else $bia = '&nbsp;';
	  $h = $h . <<<EOF
	    <tr><td class=lst>$str1</td><td class=lst>$row[PMBID]</td><td class=lst>$row[Name]</td>
		<td class=lst align=right>$row[TestScore]</td><td $paid><img src='image/$row[PMBPaid].gif' border=0></td>
		<td class=lst align=center><img src='image/MGM$row[MGM].gif' border=0></td>
		<td class=lst align=center>$strtrm</td>
		<td class=lst>$str2</td></tr>
EOF;
	}
	$jml = mysql_num_rows($r);
	return $h . "</table>
	  <font class=lst>Jumlah:</font><font class=ttl>$jml</font><br><br>";
  }
  function UbahLulus($id, $st) {
    global $strCantQuery;
	$s = "update pmb set TestPass='$st' where PMBID='$id'";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
  }
  function FormLulus($kdj) {
    return <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='pmbterima'>
	<input type=hidden name='kdj' value='$kdj'>
	<tr><td class=lst>Luluskan peserta dengan nilai di atas:</td>
	<td class=lst><input type=text name='nil' size=3 maxlength=3>
	<input type=submit name='prclls' value='Luluskan'></td></tr>
	</form></table><br>
EOF;
  }
  function ProsesLulus() {
    global $strCantQuery, $fmtErrorMsg;
	$pref = GetPMBPrefix();
	if (isset($_REQUEST['kdj'])) $kdj = $_REQUEST['kdj']; else $kdj = '';
	if (isset($_REQUEST['nil'])) $nil = $_REQUEST['nil']; else $nil = '';
	if (!empty($nil)) {
	  if (!empty($kdj)) $strkdj = "and Program='$kdj'"; else $strkdj = '';
	  $s = "update pmb set TestPass='Y' where TestScore >= '$nil' and TestPass='N' and PMBID like '$pref%' $strkdj";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	}
	else DisplayHeader($fmtErrorMsg, "Field Nilai tidak diisi. Tidak diproses.");
  }
  function TerimaPMB($row) {
	$ada = GetaField('mhsw', 'NIRM', $row['PMBID'], 'NIM');
	if (empty($ada)) {
	  $kdj = $row['Program'];
	  $kdp = $row['ProgramType'];
	  // 3 baris kode di bawah ini tidak efisien karena diletakkan di loop while sehingga akan selalu dieksekusi.
	  // tetapi ini demi menjamin keakuratan data yg diambil dari tabel PMB.
	  $kdf = GetaField("jurusan", 'Kode', $kdj, 'KodeFakultas');
	  $thn = GetLastThn($kdj);
	  $bia = GetLastBiaya($kdj);
	  $NIM = GetNextNIM($kdj, $kdp);
	  $s = "insert into mhsw (Login, Password, NIM, PMBID, Tanggal,
	    Name, Email, Sex, TempatLahir, TglLahir, Alamat1, Alamat2, RT, RW, Kota,
		KodePos, Phone, AgamaID, WargaNegara, NamaPrsh, Alamat1Prsh, Alamat2Prsh,
		KotaPrsh, TelpPrsh, FaxPrsh, NamaOT, PekerjaanOT, AlamatOT1, AlamatOT2,
		RTOT, RWOT, KotaOT, TelpOT, EmailOT, KodePosOT,
		AsalSekolah, PropSekolah, JenisSekolah, LulusSekolah, IjazahSekolah,
		NilaiSekolah, Pilihan1, Pilihan2, KodeFakultas, KodeJurusan, Status,
		KodeProgram, StatusAwal, StatusPotongan, Semester, TahunAkademik, KodeBiaya, TestScore, DosenID, 
		PMBSyarat, PMBKurang,
		MGM, MGMOleh, MGMHonor)
		values ('$NIM', '$row[tgllhr]', '$NIM', '$row[PMBID]', now(),
		ucase('$row[Name]'), '$row[Email]', '$row[Sex]', '$row[BirthPlace]',
		'$row[BirthDate]', '$row[Address1]', '$row[Address2]',
		'$row[RT]', '$row[RW]', '$row[City]', '$row[PostalCode]', '$row[Phone]',
		'$row[AgamaID]', '$row[Nationality]', '$row[CompanyName]',
		'$row[CompanyAddress1]', '$row[CompanyAddress2]', '$row[CompanyCity]',
		'$row[CompanyPhone]', '$row[CompanyFacsimile]',
		'$row[ParentName]', '$row[ParentWork]',
		'$row[ParentAddress1]', '$row[ParentAddress2]',
		'$row[ParentRT]', '$row[ParentRW]',
		'$row[ParentCity]', '$row[ParentPhone]', '$row[ParentMobilePhone]',
		'$row[ParentPostalCode]',
		'$row[FromSchool]', '$row[SchoolCity]', '$row[SchoolType]',
		'$row[NotGraduated]', '$row[CertificateNumber]', '$row[SchoolScore]',
		'$row[Program]', '', '$kdf', '$kdj', 'A', '$row[ProgramType]', '$row[StatusAwal]', '$row[StatusPotongan]', 
		'0', '$thn', '$bia', '$row[TestScore]', '$row[DosenID]', '$row[PMBSyarat]', '$row[PMBKurang]',
		'$row[MGM]', '$row[MGMOleh]', $row[MGMHonor]) ";
	  $r = mysql_query($s) or die("$strCantQuery: $s <br><b>" . mysql_error());
	  mysql_query("update pmb set Terima='Y' where PMBID='$row[PMBID]'");
	}
  }
  function ProsesTerimaSatu() {
    global $strCantQuery, $fmtMessage;
	$PMBID = $_REQUEST['pmbid'];
	$s0 = "select *, date_format(BirthDate, '%d%m%Y') as tgllhr
	  from pmb where PMBID='$PMBID' limit 1";
	$r0 = mysql_query($s0) or die("$strCantQuery: $s");
	while ($row = mysql_fetch_array($r0)) TerimaPMB($row);
	DisplayItem($fmtMessage, 'Proses', 'Penerimaan Mahasiswa Baru telah diproses.');
  }
  function ProsesTerima() {
    global $strCantQuery, $fmtErrorMsg, $fmtMessage;
	$pref = GetPMBPrefix();
	if (isset($_REQUEST['kdj'])) {
	  $kdj = $_REQUEST['kdj'];
	  $strkdj = "and Program='$kdj'";
	}
	else{
	  $kdj = ''; $strkdj = '';
	}
	$s0 = "select *, date_format(BirthDate, '%d%m%Y') as tgllhr
	  from pmb where PMBID like '$pref%' and TestPass='Y' and Terima='N' $strkdj order by Name";
	$r0 = mysql_query($s0) or die("$strCantQuery: $s");

	while ($row = mysql_fetch_array($r0)) TerimaPMB($row);
	DisplayItem($fmtMessage, 'Proses', 'Penerimaan Mahasiswa Baru telah diproses.');
  }
  function FormTerima($kdj) {
    $bea = GetLastBiaya($kdj);
    return <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=GET>
	<input type=hidden name='syxec' value='pmbterima'>
	<input type=hidden name='kdj' value='$kdj'>
	<tr><td class=ttl>1</td><td class=lst>Kode Biaya</td><td class=lst>$bea <font color=red>*)</font></td></tr>
	<tr><td class=ttl width=5>2</td><td class=lst width=150>Terima peserta yg Lulus</td>
	<td class=lst><input type=submit name='prctrm' value='Proses'></td></tr>
	</form></table><br>
EOF;
  }
  function Keterangan() {
    return <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=ttl><font color=red>*)</td>
	<td class=lst>Ini adalah Master Biaya yang aktif. Konfirmasikan dengan bag. Keuangan apakah default ini benar.
	Ini dapat berbeda untuk tiap jurusan.</td></tr>
	<tr><td class=ttl>MGM</td><td class=lst>Member Get Member</td></tr>
	<tr><td class=ttl>Trm</td><td class=lst>Telah diterima & diproses</td></tr>
	</table>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Proses Penerimaan');
  DispJur($kdj, 0, 'pmbterima');
  if (isset($_REQUEST['prcn'])) UbahLulus($_REQUEST['pmbid'], 'N');
  if (isset($_REQUEST['prcy'])) UbahLulus($_REQUEST['pmbid'], 'Y');
  if (isset($_REQUEST['prcsatu'])) ProsesTerimaSatu();
  if (isset($_REQUEST['prclls'])) ProsesLulus();
  if (isset($_REQUEST['prctrm'])) ProsesTerima();
  if (isset($_REQUEST['prcbea'])) ProsesBiaya();
  if (!empty($kdj)) {
    $kiri = FormLulus($kdj) . DaftarPMB($kdj, 'N');
	$kanan = FormTerima($kdj) . DaftarPMB($kdj, 'Y') . Keterangan();
  }
  else { 
    $kiri = DisplayItem($fmtMessage, 'Pilih Jurusan', 'Anda harus memilih salah satu jurusan terlebih dahulu.', 0) ;
    $kanan = ''; 
  }
?>

<br>
<table class=box cellspacing=0 cellpadding=2 width=100%>
<tr>
  <th class=ttl>Tidak Lulus</th>
  <th class=ttl>Lulus</th>
</tr>
<tr>
  <td class=basic valign=top width=50% style='border-right:1px silver solid'><?php echo $kiri; ?></td>
  <td class=basic valign=top><?php echo $kanan; ?></td>
</tr>
</table>