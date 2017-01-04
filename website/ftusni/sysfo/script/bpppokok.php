<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, 7 Juli 2003
  // Modul tambahan untuk memproses BPP Pokok
  // rentang harga SKS ada di tabel bpppokok

  function bpppokok0() {
    $info = array();
    $info[] = "AutoScript BPP Pokok";
	$info[] = "Digunakan untuk perhitungan BPP Pokok mhsw";
	$info[] = "E. Setio Dewo";
	$info[] = "setio_dewo@telkom.net";
	return $info;
  }
  function bpppokok($nim, $thn, $row) {
    global $strCantQuery, $fmtErrorMsg;
	$ada = GetaField('biayamhsw', "Tahun='$thn' and NIM='$nim' and IDBiaya2", $row['ID'], 'ID');
	$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'KodeJurusan,KodeProgram');
	$prgbppp = GetaField('prgbpppokok', "KodeJurusan='$arrmhsw[KodeJurusan]' and KodeProgram", 
	  $arrmhsw['KodeProgram'], 'Nama');
	$unip = $_SESSION['unip'];
	$sks = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'SKS');
	if (empty($sks)) $sks = 0;
	$s = "select * from bpppokok 
	  where MinSKS <= $sks and $sks <= MaxSKS and Nama='$prgbppp' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) $hrg = 0;
	else $hrg = mysql_result($r, 0, 'Biaya');
	$ctt = "SKS yg diambil: $sks SKS \nBPP Pokok: $prgbppp";

	if (empty($ada)) {	  
	  $s = "insert into biayamhsw (Tanggal, Tahun, KodeBiaya, IDBiaya2, NamaBiaya, NIM,
		Jumlah, Biaya, Denda, Catatan, Login) 
		values (now(), '$thn', '$row[KodeBiaya]', $row[ID], '$row[Nama]',
		'$nim', 1, $hrg, '$row[Denda]', '$ctt', '$unip') ";
	}
	else {
	  $s = "update biayamhsw set Biaya=$hrg, Denda='$row[Denda]', Catatan='$ctt', Login='$unip'
	    where ID=$ada";
	}
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
?>