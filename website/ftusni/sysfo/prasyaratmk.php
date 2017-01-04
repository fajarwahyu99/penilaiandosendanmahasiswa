<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** FUNCTION ***
  function DisplayMKList1($kurid, $kurss) {
    global $strCantQuery;
	$s = "Select * from matakuliah where KurikulumID=$kurid order by Sesi,Kode";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$ss0 = -1;
	
	echo "<table class=basic cellspacing=0 cellpadding=2>";
	while ($row = mysql_fetch_array($r)) {
	  $idmk = $row['ID'];
	  $kod = $row['Kode'];
	  $nme = $row['Nama_Indonesia'];
	  $sks = $row['SKS'];
	  $kdmk = StripEmpty($row['KodeJenisMK']);
	  $wjb = $row['Wajib'];
	  $ss = $row['Sesi'];
	  $row['SKSMin'] += 0;
	  $row['IPMin'] += 0;
	  if ($ss != $ss0) {
	    echo "<tr><td>&nbsp;</td></tr>
		 <tr><th colspan=7 class=ttl>$kurss $ss</th></tr>";
		echo "<tr><td class=ttl>Kode</td><td class=ttl>Mata Kuliah</td>
		  <td class=ttl>SKS</td><td class=ttl>Jenis</td><td class=ttl>Wajib</td>
		  <td class=ttl>Min SKS</td><td class=ttl>Min IPS</td>
		  </tr>";
		$ss0 = $ss;
	  }	  
	  echo <<<EOF
	    <tr><td class=lst><a href='sysfo.php?syxec=prasyaratmk&idmk=$idmk'>$kod</a></td>
		<td class=lst>$nme</td><td class=lst>$sks</td>
		<td class=lst>$kdmk</td><td class=lst align=center>$wjb</td>
		<td class=lst align=right>$row[SKSMin]</td>
		<td class=lst align=right>$row[IPMin]</td>
		</t>
EOF;
	}
	echo "</table>";
  }
  function DisplayMKList($kdj) {
    global $strCantQuery;
	$kurid = GetLastKur($kdj);
	$arrkur = GetFields('kurikulum', 'ID', $kurid, "Nama,Tahun,Sesi,JmlSesi");
	$kurnme = $arrkur['Nama'];
	$kurthn = $arrkur['Tahun'];
	$kurss = $arrkur['Sesi'];
	$kurjml = $arrkur['JmlSesi'];
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Kurikulum Aktif</th></tr>
	  <tr><td class=lst>Tahun</td><td class=lst>$kurthn</td></tr>
	  <tr><td class=lst>Nama Kurikulum</td><td class=lst>$kurnme</td></tr>
	  <tr><td class=lst>Nama Sesi</td><td class=lst>$kurss</td></tr>
	  <tr><td class=lst>Jumlah $kurss</td><td class=lst>$kurjml</td></tr>
	  </table><br>
EOF;
    DisplayMKList1($kurid, $kurss);
  }
  function DisplayPrasyarat($idmk) {
    global $strCantQuery;
	$s = "select mk.Kode, mk.Nama_Indonesia as MK, mk.Sesi, mk.Wajib, mk.SKS, mk.KodeJenisMK as kdmk,
	  p.ID
	  from prasyaratmk p left outer join matakuliah mk on p.PraID=mk.ID
	  where IDMK=$idmk
	  order by mk.Sesi,mk.Kode	";
	$r = mysql_query($s);
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=4>Prasyarat Mata Kuliah</th></tr>
	  <tr><th class=ttl>Kode</th><th class=ttl>Nama Mata Kuliah</th>
	  <th class=ttl>Sesi</th><th class=ttl>Wajib</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $prid = $row['ID'];
	  $kod = $row['Kode'];
	  $nme = $row['MK'];
	  $ss = $row['Sesi'];
	  $wjb = $row['Wajib'];
	  $kdmk = $row['kdmk'];
	  echo <<<EOF
	    <tr><td class=lst>$kod</td><td class=lst>$nme</td>
		<td class=lst align=right>$ss</td><td class=lst align=center>$wjb</td>
		<td class=lst><a href='sysfo.php?syxec=prasyaratmk&idmk=$idmk&del=$prid' title='Hapus'><img src='image/del.gif' border=0></a></td></tr>
EOF;
	}
	echo "</table><br>";
  }
  function DisplayAddPrasyaratForm($idmk, $kurid) {
    //GetOption('jenismatakuliah', 'Kode', 'Kode', $KodeJenisMK, "KodeFakultas='$kdf'");
    $opt = GetOption('matakuliah', "concat(Kode, ' -- ', Nama_Indonesia)", 'Sesi,Kode', $idmk, "KurikulumID=$kurid and ID<>$idmk", 'ID');
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Tambahkan Mata Kuliah ini sebagai Prasyarat</th></tr>
	  <tr><td class=lst>Mata Kuliah</td>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='prasyaratmk'>
	  <input type=hidden name='idmk' value=$idmk>
	  <td class=lst><select name='prid'>$opt</select>
	  </td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcpra' value='Tambah'></td></form></tr>
	  </table><br>
EOF;
  }
  function EditPraMK($idmk) {
    global $strCantQuery;
	echo "<a href='sysfo.php?syxec=prasyaratmk' class=lst>Daftar Mata Kuliah</a>";
	
	$s = "select * from matakuliah where ID=$idmk limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$kod = mysql_result($r, 0, 'Kode');
	$nme = mysql_result($r, 0, 'Nama_Indonesia');
	$sks = mysql_result($r, 0, 'SKS');
	$kdmk = StripEmpty(mysql_result($r, 0, 'KodeJenisMK'));
	$wjb = mysql_result($r, 0, 'Wajib');
	$ss = mysql_result($r, 0, 'Sesi');
	$kurid = mysql_result($r, 0, 'KurikulumID');
	$IPMin = mysql_result($r, 0, 'IPMin') + 0;
	$SKSMin = mysql_result($r, 0, 'SKSMin') + 0;
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Mata Kuliah #$idmk</th></tr>
	  <tr><td class=lst>Kode Mata Kuliah</td><td class=lst>$kod</td></tr>
	  <tr><td class=lst>Nama Mata Kuliah</td><td class=lst>$nme</td></tr>
	  <tr><td class=lst>SKS</td><td class=lst>$sks</td></tr>
	  <tr><td class=lst>Jenis Mata Kuliah</td><td class=lst>$kdmk</td></tr>
	  <tr><td class=lst>Mata Kuliah Wajib</td><td class=lst>$wjb</td></tr>
	  <tr><td class=lst>Minimal IP</td><td class=lst>$IPMin</td></tr>
	  <tr><td class=lst>Minimal SKS</td><td class=lst>$SKSMin</td></tr>
	  </table><br>
EOF;
    DisplayAddPrasyaratForm($idmk, $kurid);
 	DisplayPrasyarat($idmk);
  }
  function PrcPra() {
    global $strCantQuery, $fmtErrorMsg;
	function CekPrid($idmk, $prid) {
	  global $strCantQuery;
	  $s = "select count(*) as jml from prasyaratmk where IDMK=$idmk and PraID=$prid";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  return mysql_result($r, 0, 'jml') > 0;
	}
	$idmk = $_REQUEST['idmk'];
	$kdmk = GetaField('matakuliah', 'ID', $idmk, 'Kode');
	$prid = $_REQUEST['prid'];
	$prkd = GetaField('matakuliah', 'ID', $prid, 'Kode');
	$cek = CekPrid($idmk, $prid);
	if ($cek) DisplayHeader($fmtErrorMsg, "Prasyarat telah ditambahkan.");
	else {
	  $s = "insert into prasyaratmk (ID, IDMK, KodeMK, PraID, PraKodeMK, NotActive) values 
	    (0, $idmk, '$kdmk', $prid, '$prkd', 'N')";
	  $r = mysql_query($s) or die("$strCantQuery: $s" . mysql_error());
	}
  }
  function DelPra($prid) {
    $r = mysql_query("delete from prasyaratmk where ID=$prid");
  }
  
  
  // *** PARAMETER ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = '';
  }
  if (isset($_REQUEST['idmk'])) $idmk = $_REQUEST['idmk']; else $idmk = 0;
  
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Prasyarat Mata Kuliah');
  DisplayJurusanChoice($kdj, 0, 'prasyaratmk');
  if (isset($_REQUEST['prcpra']) && !empty($_REQUEST['prid'])) PrcPra();
  if (isset($_REQUEST['del'])) DelPra($_REQUEST['del']);
  if (!empty($kdj)) {
    if (empty($idmk)) DisplayMKList($kdj);
	else EditPraMK($idmk);
  }

?>