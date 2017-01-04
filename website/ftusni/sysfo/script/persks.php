<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, 7 Juli 2003
  // Modul tambahan untuk memproses biaya per SKS

  function persks0() {
    $info = array();
    $info[] = "AutoScript Biaya per SKS";
	$info[] = "Digunakan untuk perhitungan biaya per SKS";
	$info[] = "E. Setio Dewo";
	$info[] = "setio_dewo@telkom.net";
	return $info;
  }
  function persks($nim, $thn, $row) {
    global $strCantQuery, $fmtErrorMsg;
	$ada = GetaField('biayamhsw', "Tahun='$thn' and NIM='$nim' and IDBiaya2", $row['ID'], 'ID');
	$sks = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'SKS');
	if (empty($sks)) $sks = 0;
	$ctt = "SKS yg diambil: $sks\nHarga/SKS: $row[Jumlah]";
	$unip = $_SESSION['unip'];

	if (empty($ada)) {
	  $s = "insert into biayamhsw (Tanggal, Tahun, KodeBiaya, IDBiaya2, NamaBiaya, NIM,
		Jumlah, Biaya, Denda, Catatan, Login) 
		values (now(), '$thn', '$row[KodeBiaya]', $row[ID], '$row[Nama]',
		'$nim', $sks, $row[Jumlah], '$row[Denda]', '$ctt', '$unip') ";
	}
	else {
	  $s = "update biayamhsw set Jumlah=$sks, Biaya=$row[Jumlah], Denda='$row[Denda]', Catatan='$ctt',
	    Login='$unip' where ID=$ada ";
	}
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
?>