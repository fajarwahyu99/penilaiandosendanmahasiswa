<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispBuktiBayar($thn, $nim, $biaid) {
    $arrmhsw = GetFields("mhsw m left outer join jurusan j on m.KodeJurusan=j.Kode", "NIM", $nim,
	  "m.Name, j.Nama_Indonesia");
	$arrbyr = GetFields('bayar b left outer join jenisbayar jb on b.JenisBayar=jb.ID', 'b.ID', 
	  $biaid, "date_format(b.Tanggal, '%d %M %Y') as tgl, b.*, jb.Nama");
	echo <<<EOF
	<center><b>BUKTI PEMBAYARAN</b></center><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=basic>NIM</td><td>:</td><td class=uline>$nim</td></tr>
	<tr><td class=basic>Nama Mahasiswa</td><td>:</td><td class=uline>$arrmhsw[Name]</td></tr>
	<tr><td class=basic>Jurusan</td><td>:</td><td class=uline>$arrmhsw[Nama_Indonesia]</td></tr>
	<tr><td class=basic>Keterangan</td><td>:</td><td class=uline>$arrbyr[NamaBayar]</td></tr>
	<tr><td class=basic># Slip</td><td>:</td><td class=uline>$arrbyr[Nama] $arrbyr[BuktiBayar]</td></tr>
	</table><br>
EOF;
    $s = "select b2.*, bi.NamaBiaya, bi.Catatan
	  from bayar2 b2 left outer join biayamhsw bi on b2.BiayaID=bi.ID
	  where BayarID=$biaid";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$nmr = 0;
	echo "<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><th class=ttl>#</th><th class=ttl>Pembayaran</th><th class=ttl>Jumlah (Rp)</th><th class=ttl>Keterangan</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  $nmr++;
	  $jml = number_format($row['Jumlah'], 0, ',', '.');
	  $ctt = StripEmpty($row['Catatan']);
	  echo <<<EOF
	    <tr><td class=lst>$nmr</td><td class=lst>$row[NamaBiaya]</td>
		<td class=lst align=right>$jml</td><td class=lst>$ctt</td>
		</tr>
EOF;
	}
	$tot = number_format($arrbyr['Jumlah'], 0, ',', '.');
	echo "<tr><td class=basic align=right colspan=2><b>Total :</td><td class=uline align=right><b>$tot</td><td></td></tr>
	</table><p align=right>Jakarta, $arrbyr[tgl]</p>
	<table class=basic width=100% cellspacing=0 cellpadding=2>
	<tr><td width=30% align=center>Diterima oleh</td><td>&nbsp;</td><td align=center width=30%>Mahasiswa</td></tr>
	<tr><td colspan=3>&nbsp;</td></tr>
	<tr><td class=uline align=center>$_SESSION[uname]</td>
	<td></td><td class=uline align=center>$arrmhsw[Name]</td></tr></table>";
  }
  
  // *** Parameter2 ***
  $biaid = $_REQUEST['biaid'];
  $thn = $_REQUEST['thn'];
  $nim = $_REQUEST['nim'];
  
  // *** Bagian Utama ***
  DispBuktiBayar($thn, $nim, $biaid);

?>