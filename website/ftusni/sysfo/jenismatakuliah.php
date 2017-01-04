<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function DisplayJenisMataKuliah0 () {
    echo "<table class=basic width=100% cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>-- Pilih Fakultas -- </th></tr>
	  <tr><td class=lst>Pilih salah satu fakultas dari daftar fakultas di bagian kanan
	  untuk melihat 'Jenis Mata Kuliah' untuk fakultas tersebut.</td></tr>
	  </table>";
  }
  function DisplayJenisMataKuliah($kd, $act='jenismatakuliah') {
    global $Language;
    $fak = GetaField ('fakultas', 'Kode', $kd, "Nama_$Language");
    $jmk = new NewsBrowser;
	$jmk->query = "select * from jenismatakuliah where KodeFakultas='$kd' order by Rank";
	$jmk->headerfmt = "<table class=basic width=100% cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=6>$fak</th></tr>
	  <tr><td class=lst colspan=6><a href='sysfo.php?syxec=$act&kd=$kd&md=1'>Tambah Jenis Mata Kuliah</a></td></tr>
	  <tr><th class=ttl>#</th>
	  <th class=ttl>Kode</th><th class=ttl>Nama</th>
	  <th class=ttl>Wajib</th><th class=ttl>TA</th><th class=ttl>NA</th></tr>";
	$jmk->detailfmt = "<tr><td class=lst>=Rank=</td>
	  <td class=lst><a href='sysfo.php?syxec=$act&kd=$kd&md=0&kdjns==Kode='>=Kode=</a></td>
	  <td class=lst>=Nama=</td>
	  <td class=lst align=center><img src='image/=Wajib=.gif' border=0></td>
	  <td class=lst align=center><img src='image/=TA=.gif' border=0></td>
	  <td class=lst align=center><img src='image/=NotActive=.gif' border=0></td></tr>";
	$jmk->footerfmt = "</table><br>";
	echo $jmk->BrowseNews();
	echo <<<EOF
	  <table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=ttl>TA</td><td class=lst>Tugas Akhir</td></tr>
	  <tr><td class=ttl>NA</td><td class=lst>Not Active, Tidak Aktif</td></tr>
	  </table>
EOF;
  }
  function DisplayJenisMataKuliahForm($md=0, $kd='', $kdjns='', $act='jenismatakuliah') {
    global $strCantQuery, $fmtErrorMsg, $strNotAuthorized, $Language;
	if ($md==0) {
	  $_sjns = "select * from jenismatakuliah where Kode='$kdjns'";
	  $_rjns = mysql_query($_sjns) or die("$strCantQuery: $_sjns");
	  if (mysql_num_rows($_rjns)==0) die(DisplayHeader($fmtErrorMsg, $strNotAuthorized));
	  $Rank = mysql_result($_rjns, 0, 'Rank');
	  $Nama = mysql_result($_rjns, 0, 'Nama');
	  $Wajib = mysql_result($_rjns, 0, 'Wajib');
	  if (mysql_result($_rjns, 0, 'TA') == 'Y') $TA = 'checked'; else $TA = '';
	  $NotActive = mysql_result($_rjns, 0, 'NotActive');
	  $strkdjns = "<input type=hidden name=kdjns value='$kdjns'>$kdjns";
	  $judul = 'Edit Jenis Mata Kuliah';
	}
	elseif ($md==1) {
	  $Rank = 0;
	  $Kode = '';
	  $Nama = '';
	  $Wajib = 'N';
	  $TA = '';
	  $NotActive = 'N';
	  $strkdjns = "<input type=text name='kdjns' size=15 maxlength=10>";
	  $judul = 'Tambah Jenis Mata Kuliah';
	}
	$Fakultas = GetaField('fakultas','Kode', $kd, "Nama_$Language");
	if ($Wajib=='Y') $strwa = 'checked';
	else $strwa = '';
	if ($NotActive=='Y') $strna = 'checked';
	else $strna = '';
	
	// tampilkan form
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='kd' value='$kd'>
	  <input type=hidden name='md' value=$md>
	  <table class=basic width=100% cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>$judul</th></tr>
	  <tr><td class=lst>Fakultas</td><td class=lst><b>$Fakultas</b></td></tr>
	  <tr><td class=lst>Kode</td><td class=lst>$strkdjns</td></tr>
	  <tr><td class=lst>Urutan Tampilan</td>
	    <td class=lst><input type=text name='Rank' size=10 maxlength=3 value='$Rank'></td></tr>
	  <tr><td class=lst>Jenis Mata Kuliah</td>
	    <td class=lst><input type=text name='Nama' size=30 maxlength=100 value='$Nama'></td></tr>
	  <tr><td class=lst>Wajib diambil</td>
	    <td class=lst><input type=checkbox name='Wajib' value='Y' $strwa></td></tr>
	  <tr><td class=lst>Tugas Akhir</td>
	    <td class=lst><input type=checkbox name='TA' value='Y' $TA></td></tr>
	  <tr><td class=lst>Tdk Aktif</td>
	    <td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
	  <tr><td class=basic colspan=2 align=center>
	    <input type=submit name='prc' value='Simpan'>
		<input type=reset name='reset' value='Reset'></td></tr>
	
	  </table></form>";
  }
  function ProcessJenisMataKuliahForm() {
    global $strCantQuery, $md, $kd, $kdjns;
	global $fmtErrorMsg, $strNotAuthorized;
	$md = $_REQUEST['md'];
	$kd = $_REQUEST['kd'];
	$kdjns = $_REQUEST['kdjns'];
	$Rank = $_REQUEST['Rank'];
	$Nama = FixQuotes($_REQUEST['Nama']);
	if (isset($_REQUEST['Wajib'])) $Wajib = $_REQUEST['Wajib'];	else $Wajib = 'N';
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];	else $NotActive = 'N';
	if (isset($_REQUEST['TA'])) $TA = $_REQUEST['TA']; else $TA = 'N';
	if ($md==0) {
	  $_sql = "update jenismatakuliah set Rank=$Rank, Nama='$Nama', Wajib='$Wajib', 
	    TA='$TA', NotActive='$NotActive'
	    where Kode='$kdjns'";
	}
	elseif ($md==1) {
	  $_sql = "insert into jenismatakuliah (Kode, Rank, Nama, KodeFakultas, Wajib, TA, NotActive)
	    values ('$kdjns', $Rank, '$Nama', '$kd', '$Wajib', '$TA', '$NotActive')";
	}
	else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized));
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$md = -1;
  }
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Jenis Mata Kuliah');
 
  //include "fakjur.res.php";
$kdf = GetSetVar('kdf');
if (isset($_REQUEST['md'])) $md = $_REQUEST['md'];
else $md = -1;
  
if (isset($_REQUEST['kdjns'])) $kdjns = $_REQUEST['kdjns'];
else $kdjns = '';
  
if (isset($_REQUEST['prc'])) ProcessJenisMataKuliahForm();
?>

<table class=basic width=100% cellspacing=1 cellpadding=1>
<tr>
<td width=50% valign=top>
  <?php
    if (!empty($kdf)) {
	  if ($md==-1) DisplayJenisMataKuliah($kdf);
	  else DisplayJenisMataKuliahForm($md, $kdf, $kdjns);
	}
	else DisplayJenisMataKuliah0 ();
  ?>
</td>
<td width=2 background='image/vertisilver.gif'></td>

<td valign=top>
  <?php
    DisplayListofFaculty('jenismatakuliah');
  ?>
</td>
</tr>
</table>