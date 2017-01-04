<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003

  // *** Fungsi2 ***
function GetDataKiri() {
  global $strCantQuery, $Kali;
	$s = "select distinct b.Nama, b.Kali
	  from biaya2 b left outer join setupkeuwajib s on b.Nama=s.Nama
	  where b.Kali='$Kali' and s.Nama is NULL
	  order by b.Nama";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = '<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Nama Kolom</th><th></th></tr>';
	while ($w = mysql_fetch_array($r)) {
	 $a .= "<tr><td class=uline>$w[Nama]</td><td class=uline><a href='sysfo.php?syxec=setupkeuwajib&Kali=$w[Kali]&nma=$w[Nama]&prcins=1'><img src='image/kanan.gif' border=0></a></td></tr>";
	}
	return $a . '</table>';
}

function GetDataKanan() {
  global $strCantQuery, $Kali;
	$s = "select * from setupkeuwajib where Kali='$Kali' order by Rank";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$a = "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>No.</th><th class=ttl>Nama Kolom</th><th class=ttl colspan=3>Aksi</th></tr>";
	$mx = mysql_num_rows($r);
	while ($w = mysql_fetch_array($r)) {
	  if ($w['Rank'] <= 1) $ats = '<td class=uline>&nbsp;</td>';
	  else $ats = "<td class=uline><a href='sysfo.php?syxec=setupkeuwajib&up=$w[Rank]&nma=$w[Nama]'><img src='image/atas.gif' border=0></a></td>";
	  if ($w['Rank'] == $mx) $bwh = '<td class=uline>&nbsp;</td>';
	  else $bwh = "<td class=uline><a href='sysfo.php?syxec=setupkeuwajib&dw=$w[Rank]&nma=$w[Nama]'><img src='image/bawah.gif' border=0></a></td>";
	  $a .= "<tr><td class=nac>$w[Rank]</td><td class=uline>$w[Nama]</td>
		$ats $bwh
	    <td class=uline><a href='sysfo.php?syxec=setupkeuwajib&del=$w[Rank]'><img src='image/del.gif' border=0></a></td>
		</tr>";
	}
  return $a . '</table>';
}

function TambahKolom() {
  if (isset($_REQUEST['nma'])) {
	  $nma = $_REQUEST['nma'];
	  $Kali = $_REQUEST['Kali'];
	  $arrada = GetaField('setupkeuwajib', 'Nama', $nma, 'Nama');
	  if (empty($arrada)) {
	    $r0 = mysql_query("select max(Rank) as rnk from setupkeuwajib");
	    $rnk = mysql_result($r0, 0, 'rnk') + 1;
	    $s = "insert into setupkeuwajib (Rank, Nama, Kali) values($rnk, '$nma', '$Kali')";
	    $r = mysql_query($s);
	  }
	}
}
  function HapusKolom() {
    $rnk = $_REQUEST['del'];
	mysql_query("delete from setupkeuwajib where Rank=$rnk");
	mysql_query("update setupkeuwajib set Rank=Rank-1 where Rank>$rnk");
  }
  function NaikKolom() {
    $up = $_REQUEST['up']; $nma = $_REQUEST['nma'];
	$dw = $up-1;
	mysql_query("update setupkeuwajib set Rank=Rank+1 where Rank=$dw");
	mysql_query("update setupkeuwajib set Rank=Rank-1 where Nama='$nma'");
  }
  function TurunKolom() {
    $dw = $_REQUEST['dw']; $nma = $_REQUEST['nma'];
	$up = $dw+1;
	mysql_query("update setupkeuwajib set Rank=Rank-1 where Rank=$up");
	mysql_query("update setupkeuwajib set Rank=Rank+1 where Nama='$nma'");
  }

  // *** Bagian Utama ***
$Kali = GetSetVar('Kali', -1);

if ($Kali == 1) $jdl = 'Setup Laporan Kewajiban Mahasiswa'; 
elseif ($Kali == -1) $jdl = 'Setup Laporan Potongan Mahasiswa';
  DisplayHeader($fmtPageTitle, $jdl);
  if (isset($_REQUEST['prcins'])) TambahKolom();
  if (isset($_REQUEST['del'])) HapusKolom();
  if (isset($_REQUEST['up'])) NaikKolom();
  if (isset($_REQUEST['dw'])) TurunKolom();
  $ki = GetDataKiri();
  $ka = GetDataKanan();
  echo <<<EOF
  <table class=basic cellspacing=2 cellpadding=2>
  <tr><th class=ttl>Kolom yg tersedia</th><th style='border-right:solid 1px silver'>&nbsp;</th><th class=ttl>Kolom yg ditampilkan</th></tr>
  <tr><td class=basic valign=top>$ki</td><td class=basic style='border-right:solid 1px silver'>&nbsp;</td>
  <td class=basic valign=top>$ka</td></tr>
  </table>
EOF;
?>