<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003


  // *** FUNGSI2 ***
  function EditMasterBiayaMhsw($md, $nim) {
    global $strCantQuery, $fmtErrorMsg;
	if ($md == 0) {
	    $s = "select m.NIM, m.Name, st.Nama as STAT, st.Nilai as nSTA, st.Keluar as KLR,
	    m.TahunAkademik, m.KodeBiaya, m.KodeJurusan as kdj
	    from mhsw m left outer join statusmhsw st on m.Status=st.Kode
		  where m.NIM='$nim' limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  if (mysql_num_rows($r) > 0) {
	  $nme = mysql_result($r, 0, 'Name');
	  $thn = mysql_result($r, 0, 'TahunAkademik');
	  $bea = mysql_result($r, 0, 'KodeBiaya');
	  $kdj = mysql_result($r, 0, 'kdj');
	  $optbea = GetOption2('biaya', "Concat(Kode, ' - ', Nama, ' (na=', NotActive, ')')", 'Kode desc', $bea, "KodeJurusan='$kdj'", 'Kode', 1);
	  $sid = session_id();
	  echo <<<EOF
	    <table class=basic cellspacing=0 cellpadding=1>
		<form action='sysfo.php' method=GET>
		<input type=hidden name='syxec' value='mhswmasterkeu'>
		<input type=hidden name='nim' value='$nim'>
		<tr><th class=ttl colspan=2>Edit Master Biaya</th></tr>
		<tr><td class=lst width=100>NIM</td><td class=lst>$nim</td></tr>
		<tr><td class=lst>Nama Mhsw</td><td class=lst>$nme</td></tr>
		<tr><td class=lst>Tahun Masuk</td><td class=lst><input type=text name='thn' value='$thn' size=5 maxlength=5></td></tr>
		<tr><td class=lst>Master Biaya</td><td class=lst><select name='bea'>$optbea</select></td></tr>
		<tr><td class=lst colspan=2><input type=submit name='prcbea' value='Simpan'>&nbsp;
		<input type=button name='batal' value='Batal' onClick="location='sysfo.php?syxec=mhswmasterkeu&PHPSESSID=$sid'"></tr></tr>
		</form></table><br>
EOF;
	}
	}
	else DisplayHeader($fmtErrorMsg, 'Fasilitas ini tidak didukung.');
  }
  function PrcBea() {
    global $strCantQuery, $fmtErrorMsg;
	$nim = $_REQUEST['nim'];
	$thn = $_REQUEST['thn'];
	$bea = $_REQUEST['bea'];
	$s = "update mhsw set TahunAkademik='$thn', KodeBiaya='$bea' where NIM='$nim'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
    return -1;
  }
  
  // *** PARAMETER2 ***
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  } else { if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj']; else $kdj = ''; }
  if (isset($_REQUEST['nim'])) {
    $nim = $_REQUEST['nim'];
	$_SESSION['nim'] = $nim;
  } else { if (isset($_SESSION['nim'])) $nim = $_SESSION['nim']; else $nim = ''; }

  if (isset($_REQUEST['srcmhsw'])) {
    $srcmhsw = $_REQUEST['srcmhsw'];
	$_SESSION['srcmhsw'] = $srcmhsw;
  } else { if (isset($_SESSION['srcmhsw'])) $srcmhsw = $_SESSION['srcmhsw']; else $srcmhsw=''; }
  if (isset($_REQUEST['prcsrc'])) {
    $prcsrc = $_REQUEST['prcsrc'];
	$_SESSION['prcsrc'] = $prcsrc;
  } else { if (isset($_SESSION['prcsrc'])) $prcsrc = $_SESSION['prcsrc']; else $prcsrc=''; }
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;


  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Master Keuangan Mahasiswa');
  if (isset($_REQUEST['prcbea'])) $md = PrcBea();
  DispJur($kdj, 0, 'mhswmasterkeu');
  DispSearchMhsw($srcmhsw, 'mhswmasterkeu');
  if ($md == -1) DispDaftarMhsw($kdj, $prcsrc, $srcmhsw, 'mhswmasterkeu');
  else EditMasterBiayaMhsw($md, $nim);
?>
