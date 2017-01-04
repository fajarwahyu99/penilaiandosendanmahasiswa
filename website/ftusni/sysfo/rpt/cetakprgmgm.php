<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  include_once "lib/table.common.php";
  
  // *** Fungsi2 ***
  function DispMbrGetMbr() {
    global $strCantQuery;
	$pref = GetPMBPrefix();
	$s = "select p.PMBID, m.Nama, count(p.PMBID) as Jml, sum(p.MGMHonor) as HNR
	  from mhsw p left outer join mbrgetmbr m on p.MGMOleh=m.ID
	  where p.MGMOleh > 0 and p.PMBID like '$pref%'
	  group by m.ID";
	$r = mysql_query($s) or die("$strCantQuery: $s.<br>".mysql_error());
	$cnt = 0;
	$tot = 0;
	$sid = session_id();
	SimplePrinter("print.php?print=sysfo/rpt/cetakprgmgm.php&PHPSESSID=$sid", 'Cetak');
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Nama Anggota</th><th class=ttl>Jumlah</th>
	  <th class=ttl>Total Honor</th><th class=ttl>Cetak</th></tr>";
	while ($w = mysql_fetch_array($r)) {
	  $cnt++;
	  $tot += $w['HNR'];
	  $hnr = number_format($w['HNR'], 0, ',', '.');
	  echo <<<EOF
	  <tr><td class=lst>$cnt</td><td class=lst>$w[Nama]</td>
	  <td class=lst align=right>$w[Jml]</td><td class=lst align=right>$hnr</td>
	  <td class=lst align=center><img src='image/printer.gif' width=14></td></tr>
EOF;
	}
	$tot = number_format($tot, 0, ',', '.');
	echo "<tr><td colspan=3 align=right>Total Honor:</td><td class=ttl align=right><b>$tot</b></td><td></td></tr>
	</table>";
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['mid'])) $mid = $_REQUEST['mid']; else $mid = 0;
  // *** Bagian Utama ***
  $desc = GetPMBDescription();
  DisplayHeader($fmtPageTitle, "Program Member Get Member<br><font size=-1>$desc</font>");
  if ($mid == 0) DispMbrGetMbr();

?>