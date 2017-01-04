<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // *** Fungsi2 ***
  function DispOptMbrGetMbr() {
    $sid = session_id();
    echo "<a href='sysfo.php?syxec=mbrgetmbr&md=1' class=lst>Tambah Anggota</a> |";
	SimplePrinter("print.php?print=sysfo/mbrgetmbr.php&prn=1&PHPSESSID=$sid", 'Cetak Anggota MGM');
  }
  function DispMbrGetMbr($fna = '') {
    global $strCantQuery;
	if (empty($fna)) $strna = ''; else $strna = "where NotActive='$fna'";
	$s = "select * from mbrgetmbr $strna order by Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>ID</th><th class=ttl>Nama Anggota</th><th class=ttl>E-mail</th>
	  <th class=ttl>Telp</th><th class=ttl>HP</th>
	  <th class=ttl>NA</th>
	  </tr>";
	while ($w = mysql_fetch_array($r)) {
	  echo <<<EOF
	  <tr><td class=lst>$w[ID]</td><td class=lst><a href='sysfo.php?syxec=mbrgetmbr&md=0&mid=$w[ID]'>$w[Nama]</a></td>
	  <td class=lst><a href='mailto:$w[Email]'>$w[Email]</a></td>
	  <td class=lst>$w[Telp]</td><td class=lst>$w[HP]</td>
	  <td class=lst><img src='image/book$w[NotActive].gif' border=0></td>
	  </tr>
EOF;
	}
	echo "</table>";
  }
  function DispFormMbrGetMbr($md, $mid=0) {
    global $strCantQuery;
	if ($md == 0) {
	  $arr = GetFields('mbrgetmbr', 'ID', $mid, '*');
	  if (empty($arr)) die ("Data tidak ditemukan.");
	  $Nama = $arr['Nama'];
	  $Email = $arr['Email'];
	  $Telp = $arr['Telp'];
	  $HP = $arr['HP'];
	  $Alamat1 = $arr['Alamat1'];
	  $Alamat2 = $arr['Alamat2'];
	  $Kota = $arr['Kota'];
	  $Bank = $arr['Bank'];
	  $NamaAkun = $arr['NamaAkun'];
	  $NomerAkun = $arr['NomerAkun'];
	  if ($arr['NotActive'] == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = "Edit Anggota";
	}
	else {
	  $Nama = '';
	  $Email = '';
	  $Telp = '';
	  $HP = '';
	  $Alamat1 = '';
	  $Alamat2 = '';
	  $Kota = '';
	  $Bank = '';
	  $NamaAkun = '';
	  $NomerAkun = '';
	  $NA = '';
	  $jdl = "Tambah Anggota";
	}
	$sid = session_id();
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='mbrgetmbr'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='mid' value='$mid'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=uline>Nama</td><td class=uline><input type=text name='Nama' value='$Nama' size=40 maxlength=50></td></tr>
	<tr><td class=uline>E-mail</td><td class=uline><input type=text name='Email' value='$Email' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Telepon</td><td class=uline><input type=text name='Telp' value='$Telp' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Handphone</td><td class=uline><input type=text name='HP' value='$HP' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Alamat1</td><td class=uline><input type=text name='Alamat1' value='$Alamat1' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Alamat2</td><td class=uline><input type=text name='Alamat2' value='$Alamat2' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Kota</td><td class=uline><input type=text name='Kota' value='$Kota' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Nama Bank</td><td class=uline><input type=text name='Bank' value='$Bank' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Nama Akun</td><td class=uline><input type=text name='NamaAkun' value='$NamaAkun' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Nomer Akun</td><td class=uline><input type=text name='NomerAkun' value='$NomerAkun' size=40 maxlength=50></td></tr>
	<tr><td class=uline>Tidak Aktif</td><td class=uline><input type=checkbox name='NA' value='Y' $NA></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcmbr' value='Simpan'>&nbsp;
	<input type=reset name=reset value='Reset'>&nbsp;
	<input type=button name=batal value='Batal' onClick="location='sysfo.php?syxec=mbrgetmbr&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcMbrGetMbr() {
    global $strCantQuery;
    $md = $_REQUEST['md'];
	$mid = $_REQUEST['mid'];
	$Nama = FixQuotes($_REQUEST['Nama']);
	$Email = sqling($_REQUEST['Email']);
	$Telp = FixQuotes($_REQUEST['Telp']);
	$HP = FixQuotes($_REQUEST['HP']);
	$Alamat1 = FixQuotes($_REQUEST['Alamat1']);
	$Alamat2 = FixQuotes($_REQUEST['Alamat2']);
	$Kota = FixQuotes($_REQUEST['Kota']);
	$Bank = FixQuotes($_REQUEST['Bank']);
	$NamaAkun = FixQuotes($_REQUEST['NamaAkun']);
	$NomerAkun = FixQuotes($_REQUEST['NomerAkun']);
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	if ($md == 0)
	  $s = "update mbrgetmbr set Nama='$Nama', Email='$Email', Telp='$Telp', HP='$HP', Alamat1='$Alamat1', 
	    Alamat2='$Alamat2', Kota='$Kota', Bank='$Bank', NamaAkun='$NamaAkun', NomerAkun='$NomerAkun', NotActive='$NA'
		where ID=$mid ";
	else
	  $s = "insert into mbrgetmbr (Tanggal, Nama, Email, Telp, HP, Alamat1, Alamat2, Kota, Bank, 
	    NamaAkun, NomerAkun, NotActive)
		values (now(), '$Nama', '$Email', '$Telp', '$HP', '$Alamat1', '$Alamat2', '$Kota', '$Bank',
		'$NamaAkun', '$NomerAkun', '$NA')  ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	return -1;
  }
  function DispFilterNA($prn, $fna) {
    $y = ''; $n = ''; $a = '';
	if ($fna == 'Y') $y = 'checked';
	elseif ($fna == 'N') $n = 'checked';
	else $a = 'checked';
	if ($prn == 0) {
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='mbrgetmbr'>
	  <tr><td class=uline width=150>Filter Anggota</td><td class=uline>
	  <input type=radio name='fna' value='N' $n onClick='this.form.submit()'>Yg Aktif&nbsp;
	  <input type=radio name='fna' value='Y' $y onClick='this.form.submit()'>Tidak Aktif&nbsp;
	  <input type=radio name='fna' value='' $a onClick='this.form.submit()'>Semua Anggota</td></tr>
	  </form></table>
EOF;
 	}
	else {
	  if ($fna == 'Y') $strna = 'Berikut adalah anggota MGM yang tidak aktif:';
	  elseif ($fna == 'N') $strna = 'Berikut adalah anggota MGM yang masih aktif:';
	  else $strna = 'Berikut adalah daftar semua anggota MGM:';
	  echo $strna;
	}
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if (isset($_REQUEST['mid'])) $mid = $_REQUEST['mid']; else $mid = 0;
  if (isset($_REQUEST['fna'])) {
    $fna = $_REQUEST['fna'];
	$_SESSION['fna'] = $fna;
  }
  else {
    if (isset($_SESSION['fna'])) $fna = $_SESSION['fna'];
	else $fna = '';
  }
  
  // *** Bag. Utama ***
  DisplayHeader($fmtPageTitle, 'Member: Get Member');
  if (isset($_REQUEST['prcmbr'])) $md = PrcMbrGetMbr();
  DispFilterNA($prn, $fna);
  if ($prn == 0) DispOptMbrGetMbr();
  if ($md == -1) DispMbrGetMbr($fna);
  else DispFormMbrGetMbr($md, $mid);
?>