<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispJabatanOrganisasi($kjo) {
    $s = "select * from jabatanorganisasi order by Rank";
	$r = mysql_query($s) or die(mysql_error());
	$str = "<a href='sysfo.php?syxec=jbtnorg&md=1'>Tambah Jabatan Organisasi</a><br>
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td></td><th class=ttl>Urutan</th><th class=ttl>Kode</th>
	  <th class=ttl>Nama</th><th class=ttl>SKS</th><th class=ttl>NA</th><td></td></tr>";
	while ($w = mysql_fetch_array($r)) {
	  if ($kjo == $w['Kode']) {
	    $ki = "<img src='image/kanan.gif' border=0>";
		$ka = "<img src='image/kiri.gif' border=0>";
		$cls = 'class=nac';
	  }
	  else {
	    $ki = ''; $ka = ''; $cls = 'class=lst';
	  }
	  $str .= <<<EOF
	  <tr><td align=center>$ki</td>
	  <td $cls>$w[Rank]</td>
	  <td $cls><a href='sysfo.php?syxec=jbtnorg&md=0&kjo=$w[Kode]'>$w[Kode]</a></td>
	  <td $cls>$w[Nama]</td><td $cls align=right>$w[SKS]</td>
	  <td $cls align=center><img src='image/$w[NotActive].gif' border=0></td>
	  <td align=center>$ka</td></tr>
EOF;
	}
	return "$str</table>";
  }
  function DispFormJabatanOrganisasi($md, $kjo) {
    if ($md == 0) {
	  $arr = GetFields('jabatanorganisasi', 'Kode', $kjo, '*');
	  $Kode = $arr['Kode'];
	  $Rank = $arr['Rank'];
	  $Nama = $arr['Nama'];
	  $SKS = $arr['SKS'];
	  if ($arr['NotActive'] == 'Y') $NA = 'checked'; else $NA = '';
	  $jdl = 'Edit Jabatan Organisasi';
	  $strkd = "<input type=hidden name='kjo' value='$Kode'><b>$Kode";
	}
	else {
	  $Kode = '';
	  $Rank = 0;
	  $Nama = '';
	  $SKS = 0;
	  $NA = '';
	  $jdl = 'Tambah Jabatan Organisasi';
	  $strkd = "<input type=text name='kjo' size=10 maxlength=10>";
	}
	$str = <<<EOF
	<table class=box cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='jbtnorg'>
	<input type=hidden name='md' value='$md'>
	<tr><th class=ttl colspan=2>$jdl</th></tr>
	<tr><td class=uline>Urutan:&nbsp;</td><td class=uline><input type=text name='Rank' value='$Rank' size=5 maxlength=2></td></tr>
	<tr><td class=uline>Kode Jabatan Org:&nbsp;</td><td class=uline>$strkd</td></tr>
	<tr><td class=uline>Jabatan:&nbsp;</td><td class=uline><input type=text name='Nama' value='$Nama' size=20 maxlength=20></td></tr>
	<tr><td class=uline>SKS:</td><td class=uline><input type=text name='SKS' value='$SKS' size=5 maxlength=5> <font color=red>*)</td></tr>
	<tr><td class=uline>Not Active:&nbsp;</td><td class=uline><input type=checkbox name='NA' value='Y' $NA></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcjo' value='Simpan'>&nbsp;<input type=reset name=Reset value='Reset'></td></tr>
	</form></table>
EOF;
    return $str;
  }
  function PrcJabatanOrganisasi() {
    global $fmtErrorMsg;
    $md = $_REQUEST['md'];
	$Kode = strtoupper($_REQUEST['kjo']);
	$Rank = $_REQUEST['Rank'];
	$Nama = $_REQUEST['Nama'];
	$SKS = $_REQUEST['SKS'];
	if (isset($_REQUEST['NA'])) $NA = $_REQUEST['NA']; else $NA = 'N';
	if ($md == 0) {
	  $s = "update jabatanorganisasi set Rank=$Rank, Nama='$Nama', SKS='$SKS', NotActive='$NA'
	    where Kode='$Kode'";
	  $r = mysql_query($s) or die(mysql_error());
	  return 0;
	}
	else {
	  $ada = GetaField('jabatanorganisasi', 'Kode', $Kode, 'Kode');
	  if (empty($ada)) {
	    $s = "insert into jabatanorganisasi (Kode, Rank, Nama, SKS, NotActive) 
	      values (ucase('$Kode'), '$Rank', '$Nama', '$SKS', '$NA')";
		$r = mysql_query($s) or die(mysql_error());
		return 0;
	  }
	  else {
	    DisplayHeader($fmtErrorMsg, "Kode <b>$Kode</b> telah ada. Gunakan Kode lain.");
		return 1;
	  }
	}
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = 1;
  if (isset($_REQUEST['kjo'])) $kjo = $_REQUEST['kjo']; else $kjo = '';
  if (isset($_REQUEST['prcjo'])) $md = PrcJabatanOrganisasi();
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Master Jabatan Organisasi');
  $kiri = DispJabatanOrganisasi($kjo);
  $kanan = DispFormJabatanOrganisasi($md, $kjo);

  echo <<<EOF
  <table class=basic cellspacing=2 cellpadding=2>
  <tr><td valign=top style='border-right: 1px silver dotted'>$kiri</td>
  <td valign=top>$kanan</td>
  </tr>
  </table>
EOF;
?>
<table class=basic cellspacing=1 cellpadding=2>
<tr><td class=uline><font color=red>*)</font></td>
<td class=uline>Adalah batas SKS pengajaran. Jika melebihi SKS yang ditentukan ini, maka dosen dengan jabatan
tersebut akan mendapatkan honor dan transport per kelebihan Mata Kuliah/SKS.</td>
</tr>
</table>
