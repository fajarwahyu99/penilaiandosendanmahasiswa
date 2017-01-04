<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003
  
  function DispThnAkdList($kdj, $sr=0) {
    global $strPage, $maxrow;
	echo "<a href='sysfo.php?syxec=thnakd&md=1'>Buat Tahun Akademik Baru</a>";
    $pagefmt = "<a href='sysfo.php?syxec=thnakd&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
  	if (empty($kdj)) $strkdj = ''; else $strkdj = "where KodeJurusan='$kdj'";
    $lister = new lister;
    $lister->tables = "tahun $strkdj order by KodeJurusan,Kode desc";
	//echo $lister->tables;
    $lister->fields = "* ";
    $lister->startrow = $sr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>Kode</th><th class=ttl>Nama Tahun Akademik</th><th class=ttl>Jurusan</th>
	  <th class=ttl>Stat</th>
	  <th class=ttl colspan=2>BUKA</th><th class=ttl colspan=2>TUTUP</th></tr>";
    $lister->detailfmt = "<tr><td class=lst><a href='sysfo.php?syxec=thnakd&md=0&kd==Kode=&kdj==KodeJurusan='>=Kode=</a></td>
	  <td class=lst>=Nama=</td><td class=lst>=KodeJurusan=</td>
	  <td class=lst align=center><img src='image/book=NotActive=.gif'></td>
	  <td class=lst align=center><a href='sysfo.php?syxec=thnakd&prcbuka==Kode=&kdj==KodeJurusan='><img src='image/gear.gif' border=0 width=14 alt='Proses BUKA Tahun Akademik'></a></td>
	  <td class=nac align=right>=ProsesBuka=</td>
	  <td class=lst align=center><a href='sysfo.php?syxec=thnakd&prcthn==Kode=&kdj==KodeJurusan='><img src='image/gear.gif' border=0 width=14 alt='Proses TUTUP Tahun Akademik'></a></td>
	  <td class=nac align=right>=Proses=</td>
	  </tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<br>$strPage: $halaman<br>".
    $lister->ListIt () .
	  "$strPage: $halaman";
    echo $usrlist;

  }
  function EditThnAkd($kd='', $kdj='', $md=0) {
    global $strCantQuery, $strNotAuthorized;
	echo "<a href='sysfo.php?syxec=thnakd&kdj=$kdj'>Kembali</a>";
	if ($md == 1) {
	  $Nama = '';
	  $NotActive = '';
	  $strkd = "<input type=text name='kd' size=5 maxlength=5>";
	  $strjd = 'Tambah Tahun Akademik Baru';
	  $optfak = GetOption2('jurusan', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $kdj, '', 'Kode');
	  $strkdj = "<select name='kdj'>$optfak</select>";
	}
	elseif ($md == 0) {
	  $s = "select * from tahun where Kode='$kd' and KodeJurusan='$kdj' ";
	  $r = mysql_query($s) or die("$strCantQuery: $s");
	  //if (mysql_num_rows($r) == 0) die ("Tidak ada data");
	  $Nama = mysql_result($r, 0, 'Nama');
	  if (mysql_result($r, 0, 'NotActive') == 'Y') $NotActive = 'checked'; else $NotActive = '';
	  $strkd = "<input type=hidden name='kd' value='$kd'>$kd";
	  $strjd = 'Edit Tahun Akademik';
	  $strkdj = "<input type=hidden name='kdj' value='$kdj'>".
	    GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
	}
	$sid = session_id();
	echo <<<EOF
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='thnakd'>
	  <input type=hidden name='md' value=$md>
	  
	  <table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>$strjd</th></tr>
	  <tr><td class=lst>Jurusan</td><td class=lst>$strkdj</td></tr>
	  <tr><td class=lst>Kode</td><td class=lst>$strkd</td></tr>
	  <tr><td class=lst>Nama Thn Akademik</td><td class=lst><input type=text name='Nama' value='$Nama' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>Tidak Aktif</td><td class=lst><input type=checkbox name='NotActive' value='Y' $NotActive></td></tr>
	  <tr><td class=lst colspan=2><input type=submit name='prc' value='Simpan'>&nbsp;
	  <input type=reset name=reset value='Reset'>&nbsp;
	  <input type=button name=batal value='Batal' onClick="location='sysfo.php?syxec=thnakd&kdj=$kdj&PHPSESSID=$sid'">  </td></tr>
	  </table></form>
EOF;
	
  }
  function PrcThnAkd() {
    global $strCantQuery, $md, $fmtErrorMsg;
	function AdaTahun($kd, $kdj) {
	  $r = mysql_query("select * from tahun where Kode='$kd' and KodeJurusan='$kdj' ");
	  if (mysql_num_rows($r) == 0) return false;
	  else return true;
	}
    $md = $_REQUEST['md'];
    $kd = FixQuotes($_REQUEST['kd']);
	$kdj = $_REQUEST['kdj'];
	$Nama = FixQuotes($_REQUEST['Nama']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive']; else $NotActive = 'N';
	
	if ($md == 0) {
	  $s = "update tahun set Nama='$Nama', NotActive='$NotActive' where Kode='$kd' and KodeJurusan='$kdj'";
	  $r = mysql_query($s) or die ("$strCantQuery: $s");
	  $md = -1;
	}
	elseif ($md == 1) {
	  if (!AdaTahun($kd, $kdj)) {
	    $unip = $_SESSION['unip'];
	    $s = "insert into tahun (Kode, Nama, KodeJurusan, Tgl, unip, NotActive)
		values ('$kd', '$Nama', '$kdj', now(), '$unip', '$NotActive')";
	    $r = mysql_query($s) or die ("$strCantQuery: $s");
		mysql_query("update jurusan set Tahun='$kd', PasswordNilai='N' where Kode='$kdj'") or die(mysql_error());
		$md = -1;
	  }
	  else {
	    DisplayHeader($fmtErrorMsg, "Tahun akademis $kd di $kdj sudah ada. Anda harus menggunakan kode yang lain");
	  }
	}
  }
  function PrcSemester($thn, $kdj) {
    global $fmtErrorMsg;
    $arr = GetFields("tahun", "Kode='$thn' and KodeJurusan", $kdj, 'ProsesBuka,NotActive');
	if ($arr['ProsesBuka'] == 0) die(DisplayHeader($fmtErrorMsg, "Tahun akademik <b>$thn</b> belum di-BUKA. Proses BUKA terlebih dahulu.", 0));
	if ($arr['NotActive'] == 'Y') DisplayHeader($fmtErrorMsg, "Tahun akademik <b>$thn</b> sudah tidak aktif.<br>Proses dibatalkan.");
	else {
	  // *** Proses ***
	  $s = "select k.* 
	    from khs k left outer join mhsw m on k.NIM=m.NIM
	    where k.Tahun='$thn' and m.KodeJurusan='$kdj' order by k.NIM";
	  $r = mysql_query($s) or die (mysql_error());
	  while ($w = mysql_fetch_array($r)) {
	    $arr = GetFields('krs', "Tunda='N' and NotActive='N' and Tahun='$thn' and NIM", $w['NIM'], 
		  "sum(Nilai) as tnil, sum(SKS*Bobot) as tbbt, sum(SKS) as tsks");
		mysql_query("update khs set Nilai='$arr[tnil]', Bobot='$arr[tbbt]', SKS='$arr[tsks]' 
		  where NIM='$w[NIM]' and Tahun='$thn'") or die(mysql_error());
	  }
	  mysql_query("update tahun set Proses=Proses+1 where Kode='$thn' and KodeJurusan='$kdj'") or die(mysql_error());
	}
  }
  function PrcBuka($thn, $kdj) {
    global $fmtMessage, $fmtErrorMsg;
	$thnna = GetaField('tahun', "Kode='$thn' and KodeJurusan", $kdj, 'NotActive');
	if ($thnna == 'Y')
	  DisplayHeader($fmtErrorMsg, "Tahun ajaran <b>$thn</b> tidak aktif.<br>
	  Aktifkan tahun ajaran sehingga dapat di<b>BUKA</b>. Proses tidak dilanjutkan.");
	else {
	  $snm = session_name(); $sid = session_id();
	  $strkdj = GetaField('jurusan', "Kode", $kdj, "Nama_Indonesia");
	  $arrdef = GetFields('statusmhsw', 'Def', 'Y', '*');
      DisplayDetail($fmtMessage, "Konfirmasi Proses",
	  "Anda akan mem<b>BUKA</b> tahun ajaran <b>$thn</b>.<ul>
	  <li>Dalam proses ini akan dibuat tahun ajaran bagi mahasiswa <b>$kdj - $strkdj</b>.</li>
	  <li>Secara default status mahasiswa dalam tahun ajaran ini adalah: <b>$arrdef[Nama]</b>.
	  Jika default seharusnya bukan <b>$arrdef[Nama]</b>, maka Anda dapat mengubahnya di 
	  <a href='sysfo.php?syxec=mastermaster&tbl=statusmhsw'>Master StatusMhsw</a>.</li>
	  <li>Mungkin proses ini akan memakan waktu beberapa menit.</li>
	  </ul><hr>
	  Pilihan: <a href='sysfo.php?syxec=thnakdbuka&prcbuka1=$thn&kdj=$kdj&$snm=$sid' target=_blank>Teruskan Proses</a> | <a href='sysfo.php?syxec=thnakd'>Batalkan</a>");
	}
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Tahun Akademik');
  if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
  if (isset($_REQUEST['kd'])) $kd = $_REQUEST['kd']; else $kd = '';
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  $kdj = GetSetVar('kdj');

  if (isset($_REQUEST['prc'])) PrcThnAkd();
  if (isset($_REQUEST['prcthn'])) PrcSemester($_REQUEST['prcthn'], $_REQUEST['kdj']);
  if (isset($_REQUEST['prcbuka'])) PrcBuka($_REQUEST['prcbuka'], $_REQUEST['kdj']);

  DispJur($kdj, 0, 'thnakd');
  if ($md == -1) {
    if (!isset($_REQUEST['prcbuka'])) DispThnAkdList($kdj, $sr);
  }
  else EditThnAkd($kd, $kdj, $md);

?>