<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003
  
  // *** Fungsi2 ***
  function DispStatusMhsw($nim, $act='statusmhsw') {
    global $strCantQuery;
	$s = "select k.*, st.Nama as STA, st.Nilai, m.KodeJurusan as kdj
	  from khs k left outer join statusmhsw st on k.Status=st.Kode
	  left outer join mhsw m on k.NIM=m.NIM
	  where k.NIM='$nim' order by k.Tahun";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<a href='sysfo.php?syxec=$act&nim=$nim&md=0&md2=1' class=lst>Tambah Sesi/Semester</a>
	  <table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>Sesi</th><th class=ttl>Tahun</th><th class=ttl>Biaya</th>
	  <th class=ttl>Status</th><th class=ttl>Catatan Status</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['Nilai'] == 0) $cls = 'class=nac'; else $cls = 'class=lst';
	  $ctt = StripEmpty($row['Catatan']);
	  echo <<<EOF
	  <tr><td $cls><a href='sysfo.php?syxec=$act&nim=$nim&md=0&md2=0&kid=$row[ID]&kdj=$row[kdj]'>$row[Sesi]</a></td>
	  <td $cls>$row[Tahun]</td>
	  <td $cls>$row[KodeBiaya]</td>
	  <td $cls>$row[STA]</td>
	  <td $cls>$ctt</td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function EditStatusMhsw($md2, $nim, $kid, $act='statusmhsw') {
    global $strCantQuery, $kdj;
	if ($md2 == 0) {
	  $s = "select * from khs where ID=$kid limit 1";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  $thn = mysql_result($r, 0, 'Tahun');
	  $ssi = mysql_result($r, 0, 'Sesi');
	  $sta = mysql_result($r, 0, 'Status');
	  $ctt = mysql_result($r, 0, 'Catatan');
	  $jdl = 'Edit Sesi/Semester Mahasiswa';
	  $strssi = "<input type=hidden name='ssi' value='$ssi'>$ssi";
	  $strthn = "<input type=hidden name='thn' value='$thn'>$thn";
	  $bea = mysql_result($r, 0, 'KodeBiaya');
	}
	else {
	  $thn = '0';
	  $ssi = '0';
	  $sta = '';
	  $ctt = '';
	  $jdl = 'Tambah Sesi/Semester Mahasiswa';
	  $strssi = "<input type=text name='ssi' size=5 maxlength=3>";
	  $strthn = "<input type=text name='thn' size=5 maxlength=5>";
	  $bea = '';
	}
	$sid = session_id();
	$optsta = GetOption2('statusmhsw', 'Nama', 'Kode', $sta, '', 'Kode');
	$optbea = GetOption2('biaya', "Concat(Kode, ' - ', Nama, ' (na=', NotActive, ')')", 'Kode desc', $bea, "KodeJurusan='$kdj'", 'Kode', 1);
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='nim' value='$nim'>
	  <input type=hidden name='md' value=0>	  
	  <input type=hidden name='md2' value='$md2'>
	  <input type=hidden name='kid' value='$kid'>
	  <tr><th class=ttl colspan=2>$jdl</th></tr>
	  <tr><td class=lst>Sesi/Semester ke-</td><td class=lst>$strssi</td></tr>
	  <tr><td class=lst>Tahun Akademis</td><td class=lst>$strthn</td></tr>
	  <tr><td class=lst>Master Biaya</td><td class=lst><select name='bea'>$optbea</select></td></tr>
	  <tr><td class=lst>Status Semester</td><td class=lst><select name='sta'>$optsta</select></td></tr>
	  <tr><td class=lst>Catatan Status</td><td class=lst><textarea name='ctt' cols=30 rows=2>$ctt</textarea></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prcsta' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name=batal value='Batal' onClick="location='sysfo.php?syxec=$act&md=0&md2=-1&nim=$nim&PHPSESSID=$sid'">
	  </td></tr>
	  </form></table>
EOF;
  }
  function PrcStatus() {
    global $strCantQuery, $fmtErrorMsg;
    $md = $_REQUEST['md'];
	$md2 = $_REQUEST['md2'];
	$nim = $_REQUEST['nim'];
	$kid = $_REQUEST['kid'];
	$ssi = $_REQUEST['ssi'];
	$thn = $_REQUEST['thn'];
	$bea = $_REQUEST['bea'];
	$sta = $_REQUEST['sta'];
	$ctt = FixQuotes($_REQUEST['ctt']);
	if ($md2 == 0) {
	  $s = "update khs set KodeBiaya='$bea', Status='$sta', Catatan='$ctt' where ID='$kid'";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	}
	else {
	  $cek = GetaField('khs', "Tahun='$thn' and NIM", $nim, 'ID');
	  if (empty($cek)) {
	    $s = "insert into khs (NIM, Tahun, KodeBiaya, Sesi, Status, Catatan) values
	      ('$nim', '$thn', '$bea', '$ssi', '$sta', '$ctt')  ";
		$r = mysql_query($s) or die("$strCantQuery: $s");
	  }
	  else DisplayHeader($fmtErrorMsg, "Tahun Akademik $thn sudah dilalui mahasiswa ini.");
	}
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
  if (isset($_REQUEST['md2'])) $md2 = $_REQUEST['md2']; else $md2 = -1;
  if (isset($_REQUEST['kid'])) $kid = $_REQUEST['kid']; else $kid = 0;

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Perubahan Status Mahasiswa');
  if (isset($_REQUEST['prcsta'])) $md2 = PrcStatus();
  DispJur($kdj, 0, 'statusmhsw');
  DispSearchMhsw($srcmhsw, 'statusmhsw');
  if ($md == -1) DispDaftarMhsw($kdj, $prcsrc, $srcmhsw, 'statusmhsw');
  else {
    DispHeaderMhsw($nim, 'statusmhsw');
	echo "<br/>";
	if ($md2 == -1)	DispStatusMhsw($nim, 'statusmhsw');
	else EditStatusMhsw($md2, $nim, $kid, 'statusmhsw');
  }
?>