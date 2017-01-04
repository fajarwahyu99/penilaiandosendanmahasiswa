<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juni 2003

  // *** FUNGSI2 ***
  function GoMhswMK($nim, $act) {
    global $strCantQuery;
	$kdj = GetaField('mhsw', 'NIM', $nim, 'KodeJurusan');
	$kurid = GetLastKur($kdj);
	$strss = GetaField('kurikulum', 'ID', $kurid, 'Sesi');
	$s = "select k.*, mk.Nama_Indonesia as MK, mk.Sesi,
	  ds.Name as DS, k.ID as KID, k.Nilai, k.GradeNilai, k.NotActive
	  from krs k left outer join matakuliah mk on k.IDMK=mk.ID
	  left outer join dosen ds on k.IDDosen=ds.ID
	  where k.NIM='$nim' order by mk.Sesi, mk.Kode	";
	$r = mysql_query($s) or die("$strCantQuery: $s" . mysql_error());
	echo "<table cellspacing=0 cellpadding=2>";
	$ss0 = -1;
	$jmlsks = 0;
	$totsks = 0;
	$chg = false;
	while ($row = mysql_fetch_array($r)) {
	  $ss = $row['Sesi'];
	  if ($ss != $ss0) {
	    if ($ss0 != -1) {
		  echo "<tr><td class=basic colspan=1></td>
		    <td class=basic align=right>Jumlah SKS:</td><th class=ttl align=right>$jmlsks</th>
		    <td class=basic colspan=4></td></tr>";
		  $jmlsks = 0;
		}
	    echo "<tr><th class=ttl colspan=8>$strss $ss</th></tr>";
		echo "<tr><th class=ttl>KodeMK</th><th class=ttl>Mata Kuliah</th><th class=ttl>SKS</th>
		  <th class=ttl>Dosen</th><th class=ttl>Nilai</th><th class=ttl>Grade</th>
		  <th class=ttl>Setr</th>
		  <th class=ttl>Abaikan</th></tr>	";
		$ss0 = $ss;
	  }
	  if ($row['NotActive'] == 'Y') {
	    $na = 'checked'; 
		$cls = 'class=nac';
	  }
	  else {
	    $na = '';
		$cls = 'class=lst';
		$jmlsks = $jmlsks + $row['SKS'];
		$totsks = $totsks + $row['SKS'];
	  }
	  $DS = StripEmpty($row['DS']);
	  echo <<<EOF
	    <tr><td $cls>$row[KodeMK]</td><td $cls>$row[MK]</td><td $cls align=right>$row[SKS]</td><td $cls>$DS</td>
		<td $cls>$row[Nilai]</td><td $cls>$row[GradeNilai]</td>
		<td $cls align=center><img src='image/$row[Setara].gif' border=0></td>
		<form action='sysfo.php' method=GET>
		<input type=hidden name='syxec' value='$act'>
		<input type=hidden name='nim' value='$nim'>
		<input type=hidden name='kid' value='$row[KID]'>
		<input type=hidden name='prcna' value=1>
		<td $cls align=center><input type=checkbox name='na' $na value='Y' onClick='this.form.submit()'></td>
		</form>
		</tr>
EOF;
	}
    echo "<tr><td class=basic colspan=1></td><td class=basic align=right>Jumlah SKS:</td>
	  <th class=ttl align=right>$jmlsks</th>
	  <td class=basic colspan=4></td></tr>";
	echo "</table>";
	echo "Total SKS yg telah diambil : <font class=ttl><b>$totsks</b></font>";
  }
  function PrcNAMK() {
    global $strCantQuery;
	$kid = $_REQUEST['kid'];
	if (isset($_REQUEST['na'])) $na = $_REQUEST['na']; else $na = 'N';
	mysql_query("update krs set NotActive='$na' where ID=$kid");
  }
  
  // *** PARAMETER2 ***
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

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Daftar Mata Kuliah yg Telah Diambil');

  if (isset($_REQUEST['prcna'])) PrcNAMK();
  if (strpos('14', $_SESSION['ulevel']) === false) die($strNotAuthorized.' #1');
  $valid = GetMhsw0($nim, 'mhswmk');
  if ($valid) {
    if (($_SESSION['ulevel'] == 4 && $_SESSION['unip'] == $nim) || $_SESSION['ulevel'] == 1) {
	  GoMhswMK($nim, 'mhswmk');
	}
	else die(DisplayHeader($fmtErrorMsg, "$strNotAuthorized", 0));
  }
?>