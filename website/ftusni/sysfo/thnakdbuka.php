<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  
  // *** Function ***
function GetFilterStatusMhsw() {
  $s = "select Kode from statusmhsw where Nilai=1";
	$r = mysql_query($s);
	$res = '';
	while ($w = mysql_fetch_array($r)) {
	  if (empty($res)) $res = "(m.Status='$w[Kode]'";
	  else $res .= " or m.Status='$w[Kode]'";
	}
	return $res . ')';
}

function GetMyMaxSKS($kdj, $myNIM, $mySesi) {
	if ($mySesi <=1) {
		return GetaField("jurusan", "Kode", $kdj, "DefSKS");
  } 
  else {
		$PrefSesi = $mySesi -1;
		$arrPref = GetFields("khs", "NIM='$myNIM' and Sesi", $PrefSesi, 'Bobot, SKS');
		if (sizeof($arrPref) == 0) return GetaField("jurusan", "Kode", $kdj, "DefSKS");
		else {
			if ($arrPref['SKS'] == 0) $PrefIPS = 0;
			else $PrefIPS = $arrPref['Bobot'] / $arrPref['SKS'];
			if ($PrefIPS == 0) return GetaField('jurusan', "Kode", $kdj, 'DefSKS');
			else return GetaField('maxsks', "IPSMIN <= $PrefIPS and $PrefIPS <= IPSMax and KodeJurusan", $kdj, 'SKSMax');
	  }
  }
}
function PrcBuka1($thn, $kdj) {
  global $fmtMessage, $fmtErrorMsg;
	$arrdef = GetFields('statusmhsw', 'Def', 'Y', '*');
	$strkdj = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	$strfilterstatus = GetFilterStatusMhsw();
	$s = "select m.NIM, m.KodeBiaya
	  from mhsw m
	  where m.KodeJurusan='$kdj' and $strfilterstatus";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	echo <<<EOF
	  <p>Proses Pembukaan Tahun Ajaran Baru untuk jurusan: <b>$kdj - $strkdj</b>.</p>
	  <input type=button name='tutup' value='Tutup window ini' onClick="window.close()"><hr><ol>
EOF;
	$nmr = 0;
	while ($w = mysql_fetch_array($r)) {
	  $nmr++;
	  echo "<li>Proses: <b>$w[NIM]</b>. Status: <b>$arrdef[Nama]</b>. ";
	  $ada = GetaField('khs', "NIM='$w[NIM]' and Tahun", $thn, 'NIM');
	  if (!empty($ada)) echo "<font color=red>Sudah pernah diproses.</font></li>";
	  else {
	    $sesi = GetaField('khs', 'NIM', $w['NIM'], 'Sesi+1 as akhir');
	    if ($sesi == 0) $sesi = 1;
	    $MaxSKS = GetMyMaxSKS($kdj, $w['NIM'], $sesi);
		  $sql = "insert into khs (NIM, Tahun, Sesi, KodeBiaya, Status, TglUbah) 
		    values ('$w[NIM]', '$thn', '$sesi', '$w[KodeBiaya]', '$arrdef[Kode]', now())";
	      mysql_query($sql) or die("<font color=red size=4>Gagal Query: $sql</font><br>".mysql_error());
		  echo "<font color=blue>Berhasil diproses.</font></li>";
	  }
	}
	echo <<<EOF
	</ol><hr>
	<p>Jumlah proses: <b>$nmr</b>.</p>
	<input type=button name='tutup' value='Tutup window ini' onClick="window.close()">
EOF;
	$sql = "update tahun set ProsesBuka=ProsesBuka+1 where Kode='$thn' and KodeJurusan='$kdj'";
	mysql_query($sql) or die("<p>Gagal Query: $sql.<br>".mysql_error());
	$sql = "update jurusan set PrcKeu=0 where Kode='$kdj'";
	mysql_query($sql) or die("<p>Gagal Query: $sql.<br>".mysql_error());
	echo "<p>Selesai diproses.</p>";
}

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Proses Pembukaan Tahun Ajaran Baru");
  if (isset($_REQUEST['prcbuka1'])) PrcBuka1($_REQUEST['prcbuka1'], $_REQUEST['kdj']);
?>