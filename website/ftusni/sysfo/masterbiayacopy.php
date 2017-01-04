<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  
  // *** Fungsi2 ***
  function DispHeaderCopyMaster($kdj, $bea) {
    $nmkdj = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	$optjur = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	$sid = session_id();
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='masterbiayacopy'>
	<input type=hidden name='kdj' value='$kdj'>
	<input type=hidden name='bea' value='$bea'>
	<tr><th class=ttl colspan=2>Copy Ke</th></tr>
	<tr><td class=uline>Untuk Jurusan</td><td class=uline>: $kdj - $nmkdj</td></tr>
	<tr><td class=uline>Untuk Master Biaya</td><td class=uline>: $bea</td></tr>
	
	<tr><th class=ttl colspan=2>Copy Dari</th></tr>
	<tr><td class=uline>Dari Jurusan</td><td class=uline><select name='frmkdj'>$optjur</select></td></tr>
	<tr><td class=uline>Dari Master Biaya</td><td class=uline><input type=text name='frmbea' value='$bea' size=10 maxlength=10></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prccopy' value='Proses Copy'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name=batal value='Batal' onClick="location='sysfo.php?syxec=masterbiaya&kdj=$kdj&bea=$bea&PHPSESSID=$sid'"></td></tr>
	</table>
EOF;
  }
  function EmptyMasterBiaya($kdj, $bea) {
    global $strCantQuery;
	$s = "select count(ID) as JML from biaya2 where KodeJurusan='$kdj' and KodeBiaya='$bea'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$j = mysql_result($r, 0, 'JML');
	return $j == 0;
  }
  function PrcHpsMasterBiaya($kdj, $bea) {
    global $strCantQuery;
	$s = "delete from biaya2 where KodeJurusan='$kdj' and KodeBiaya='$bea'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }
  function PrcCopyMasterBiaya($kdj, $bea) {
    global $strCantQuery;
    $frmkdj = $_REQUEST['frmkdj'];
	$frmbea = $_REQUEST['frmbea'];
	$s = "select * from biaya2 where KodeJurusan='$frmkdj' and KodeBiaya='$frmbea'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	while ($w = mysql_fetch_array($r)) {
	  $s0 = "insert into biaya2 (KodeBiaya, KodeJurusan, KodeProgram, Nama, Kali, JenisBiaya, Denda, Otomatis,
	  Status, StatusAwal, StatusPotongan, Jumlah, PakaiScript, NamaScript, NotActive)
	  values('$bea', '$kdj', '$w[KodeProgram]', '$w[Nama]', '$w[Kali]', '$w[JenisBiaya]', '$w[Denda]', '$w[Otomatis]',
	  '$w[Status]', '$w[StatusAwal]', '$w[StatusPotongan]', '$w[Jumlah]', '$w[PakaiScript]', '$w[NamaScript]',
	  '$w[NotActive]'  )";
	  $r0 = mysql_query($s0) or die("$strCantQuery: $s");
	}
	$snm = session_name(); $sid = session_id();
	echo <<<EOF
      <SCRIPT>
      var popOldOL = window.onload;
      window.onload = function(){ if (popOldOL) popOldOL(); 
	  newwin = window.location('sysfo.php?syxec=masterbiaya&kdj=$kdj&bea=$bea&$snm=$sid'); }
      </SCRIPT>
EOF;
  }
  
  
  // *** Parameter2 ***
  $msg = 'Plug-in ini membutuhkan parameter.<br>Hubungi SeFak untuk informasi lebih lanjut.';
  if (isset($_REQUEST['kdj'])) $kdj = $_REQUEST['kdj']; 
  else die(DisplayHeader($fmtErrorMsg, $msg, 0));
  
  if (isset($_REQUEST['bea'])) $bea = $_REQUEST['bea'];
  else die(DisplayHeader($fmtErrorMsg, $msg, 0));
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Salin dari Master Biaya Lain');
  if (isset($_REQUEST['prchps'])) PrcHpsMasterBiaya($kdj, $bea);
  if (isset($_REQUEST['prccopy'])) PrcCopyMasterBiaya($kdj, $bea);
  if (EmptyMasterBiaya($kdj, $bea)) DispHeaderCopyMaster($kdj, $bea, 0);
  else DisplayHeader($fmtErrorMsg, "Master Biaya untuk jurusan: <b>$kdj</b><br>
    Kode Biaya: <b>$bea</b> tidak kosong. <br>
	Pilihan: <a href='sysfo.php?syxec=masterbiayacopy&kdj=$kdj&bea=$bea&prchps=1'>Hapus Master Lama</a> |
	<a href='sysfo.php?syxec=masterbiaya&kdj=$kdj&bea=$bea'>Batalkan</a><br>");
?>