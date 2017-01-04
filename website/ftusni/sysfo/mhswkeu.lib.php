<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  // Port some portion from mhswkeu to mhswkeu.lib for used from another script file.
  
  // *** Fungsi2 ***
  function HitungTotalBiaya($thn, $nim) {
	$tbia = GetaField('biayamhsw', "Tahun='$thn' and Kali=1 and NIM", $nim, "sum(Kali*Jumlah*Biaya) as tbia") +0;
	$tpot = GetaField('biayamhsw', "Tahun='$thn' and Kali=-1 and NIM", $nim, "sum(Kali*Jumlah*Biaya) as tpot") +0;
	mysql_query("update khs set Biaya=$tbia, Potong=$tpot where Tahun='$thn' and NIM='$nim'") or die("Error: $s<br>".mysql_error());
  }
  function HitungTotalBayar($thn, $nim) {
    $tbyr = GetaField('bayar', "Tahun='$thn' and Kali=1 and NIM", $nim, "sum(Kali*Jumlah) as tbyr") +0;
	$ttrk = GetaField('bayar', "Tahun='$thn' and Kali=-1 and NIM", $nim, "sum(Kali*Jumlah) as ttrk") +0;
	mysql_query("update khs set Bayar=$tbyr, Tarik=$ttrk where Tahun='$thn' and NIM='$nim'") or die("Error: $s<br>".mysql_error());
  }
  function InsertBiaya($nim, $thn, $row) {
    global $strCantQuery, $fmtErrorMsg;
    if ($row['PakaiScript'] == 'Y') {
      if (file_exists("sysfo/script/$row[NamaScript].php")) {
        include_once "sysfo/script/$row[NamaScript].php";
        $func = $row['NamaScript'];
		//echo "$func<br>";
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
  function PrcOto($nim, $thn) {
    global $strCantQuery, $fmtErrorMsg;
	$arr = GetFields('khs', "Tahun='$thn' and NIM", $nim, 'Sesi,KodeBiaya,Status');
	$bea = $arr['KodeBiaya'];
	$ssi = $arr['Sesi'];
	$arrmhsw = GetFields('mhsw', 'NIM', $nim, 'StatusAwal,StatusPotongan,KodeJurusan,KodeProgram');
	//$arrmhsw = array('StatusAwal'->'B', 'KodeJurusan'->'D3M', 'KodeProgram'->'E');
	$sta = $arrmhsw['StatusAwal'];
	$kdj = $arrmhsw['KodeJurusan'];
	$kdp = $arrmhsw['KodeProgram'];
	
	if (empty($bea)) DisplayHeader($fmtErrorMsg, "Kode Biaya belum diset untuk mhsw ini di Tahun Ajaran $thn.");
	else {
	  $s = "select * from biaya2 where KodeBiaya='$bea' and KodeJurusan='$kdj' and Otomatis='Y' ";
	  $r = mysql_query($s) or die ("$strCantQuery:: $s.<br>".mysql_error());
	  //die ($s . '<br>'. mysql_num_rows($r) . '<br>');
	  while ($row = mysql_fetch_array($r)) {
	    $jb = $row['JenisBiaya'];
		if (empty($row['Status'])) $st = true; else $st = $row['Status'] == $arr['Status'];
		if (empty($row['StatusAwal'])) $sa = true; else $sa = $row['StatusAwal'] == $sta;
		if (empty($row['KodeProgram'])) $prg = true; else $prg = $row['KodeProgram'] == $kdp;
		if (empty($row['StatusPotongan'])) $statp = true; else $statp = $row['StatusPotongan'] == $arrmhsw['StatusPotongan'];
		$bypass = true;
		if ($st && $sa && $prg && $statp && $bypass) {
		switch($jb):
		  case 5: 
		    // Sebelum masuk
			if ($ssi == 0) InsertBiaya($nim, $thn, $row);
			break;
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
			if ($arr['Status'] == 'L') InsertBiaya($nim, $thn, $row);
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
?>