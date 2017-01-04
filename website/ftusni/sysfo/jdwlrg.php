<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003
  
  include "jdwlkuliah.res.php";
  function DispRgLst($kam='', $sr=0) {
    global $maxrow, $strCantQuery, $strPage;
    $pagefmt = "<a href='sysfo.php?syxec=jdwlrg&sr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
  
    $lister = new lister;
    $lister->tables = "ruang where KodeKampus='$kam' order by Kode";
	//echo $lister->tables;
    $lister->fields = "* ";
    $lister->startrow = $sr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic cellspacing=0 cellpadding=2>
      <tr>
	  <th class=ttl>#</th><th class=ttl>Kode</th>
	  <th class=ttl>Nama</th>
	  <th class=ttl>Kaps</th>
	  <th class=ttl>NA</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class=basic width=18 align=right>=NOMER=</td>
	  <td class='lst'>
	  <a href='sysfo.php?syxec=jdwlrg&rg==Kode='>=Kode=</a></td>
	  <td class=lst>=Nama=</td>
	  <td class='lst' align=right>=Kapasitas=</td>
	  <td class='lst'><center>=NotActive=</td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<p>$strPage: $halaman<br>".
    $lister->ListIt () .
	  "$strPage: $halaman</p>";
    return $usrlist;
  }
  
  // *** Bagian Utama ***
  // Catatan: $kam telah menjadi variabel global. Lihat di sysfo.php

  //if (isset($_REQUEST['kam'])) $kam = $_REQUEST['kam']; else $kam = '';
  if (isset($_REQUEST['rg'])) $rg = $_REQUEST['rg']; else $rg = '';
  DisplayHeader($fmtPageTitle, 'Jadwal Ruang Kelas');
  DispOptRg($kam, $rg);
  $rglst = DispRgLst($kam);
  $rgjdwl = DispMatrixRg($kam, $rg);

  echo "<table class=basic width=100% border=0>
    <tr><td width=250 valign=top>$rglst</td>
	<td width=* valign=top>$rgjdwl</td></tr>
    </table>";

?>