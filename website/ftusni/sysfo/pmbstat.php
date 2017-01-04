<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003, Happy Easter.
  DisplayHeader($fmtPageTitle, 'Statistik Pendaftaran Mahasiswa Baru per Program');
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
  else $prn = 0;
  
  if ($prn == 0) DisplayPrinter("print.php?print=sysfo/pmbstat.php&prn=1&PHPSESSID=".session_id());
  if ($_SESSION['sysfo'] != session_id()) die ($strNotAuthorized);

  // *** Bagian Utama ***
  $__h = 4;
  include "lib/table.common.php";
  $_pref = GetPMBPrefix();
  
  $_sj = "select count(*) as Total from pmb where PMBID like '$_pref%'";
  $_rj = mysql_query($_sj) or die("$strCantQuery: $_sj");
  $__tot = mysql_result($_rj, 0, 'Total');

  echo "<table class='basic' width=100% cellspacing=0 cellpadding=2>
    <tr>
    <th class=ttl colspan=2>Program</th><th class=ttl>Pendaftar</th><th class=ttl colspan=2>Persen</th>
	<th class=ttl>Lulus</th><th class=ttl>Tdk Lulus</th>
	</tr>";
  // querying
  $_mainsql = "select j.Nama_$Language, j.Kode, jj.Nama as JEN
    from jurusan j left outer join jenjangps jj on j.Jenjang=jj.Kode
	order by jj.Nama,Nama_$Language";
  $_main = mysql_query($_mainsql) or die("$strCantQuery: $_mainsql");
  
  for ($i=0; $i < mysql_num_rows($_main); $i++) {
    $__Program = mysql_result($_main, $i, "Kode");
	$__NamaPrg = mysql_result($_main, $i, "Nama_$Language");
	$__Kode = mysql_result($_main, $i, 'Kode');
	$__JEN = mysql_result($_main, $i, 'JEN');
	
	// Hitung jumlah Pendaftar
	$_sql = "select count(PMBID) as Jumlah from pmb where Program='$__Program' and PMBID like '$_pref%'";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$__Jumlah = mysql_result($_res, 0, 'Jumlah');
	$__Persen = $__Jumlah / $__tot * 100;
	$__Sisa = 100 - $__Persen;
	
	// Hitung yg Lulus
	$_sql = "select count(PMBID) as Lulus from pmb where Program='$__Program'
	  and PMBID like '$_pref%' and TestPass='Y'";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$__Lulus = mysql_result($_res, 0, 'Lulus');
	
	$__TdkLulus = $__Jumlah - $__Lulus;
	// Tampilkan hasilnya
	echo "<tr>
	  <td class=lst>$__JEN</td>
	  <td class=lst><a href='sysfo.php?syxec=listofnewstudent&Kode=$__Kode'>
	  $__NamaPrg</a></td>
	  <td class=lst align=center>$__Jumlah</td>
	  <td class=lst valign=center width=102>
	    <img src='image/pollbar.jpg' width=$__Persen height=$__h border='0'><img src='image/emptybar.jpg' width=$__Sisa height=$__h border='0'></td>
	  <td class=lst align=right>".sprintf ("%01.2f", $__Persen).
	  "</td>
	  <td class=lst align=center>$__Lulus</td>
	  <td class=lst align=center>$__TdkLulus</td>
	  </tr>";
  }
  
  echo "</table>";
  echo "<p>Total Pendaftar: $__tot</p>";

?>