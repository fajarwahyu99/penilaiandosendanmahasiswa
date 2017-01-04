<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispBuktiTarik($thn, $nim, $biaid) {
    $arrmhsw = GetFields('mhsw', 'NIM', $nim, 'Name,KodeJurusan');
	$kdj = $arrmhsw['KodeJurusan']; $NamaMhsw = $arrmhsw['Name'];
	$nmathn = GetaField('tahun', "KodeJurusan='$kdj' and Kode", $thn, 'Nama');
	$arrbyr = GetFields('bayar byr left outer join jenisbayar jb on byr.JenisBayar=jb.ID', 
	  'byr.ID', $biaid, "byr.*, jb.Nama as BYR, date_format(byr.Tanggal, '%d %M %Y, %H:%i:%s') as tgl");
	$jml = NUMI($arrbyr['Jumlah']);
    echo <<<EOF
	<center><b>BUKTI PENGAMBILAN KELEBIHAN PEMBAYARAN</b></center><br>
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=basic># Transaksi</td><td>:</td><td class=uline>$arrbyr[ID]. $arrbyr[tgl]</td></tr>
	<tr><td class=basic>Tahun Akademik </td><td>:</td><td class=uline>$thn - $nmathn</td></tr>
	<tr><td class=basic>NIM </td><td>:</td><td class=uline>$nim</td></tr>
	<tr><td class=basic>Nama Mahasiswa </td><td>:</td><td class=uline>$NamaMhsw</td></tr>
	<tr><td class=basic>Jumlah Pengambilan </td><td>:</td><td class=uline>Rp. $jml,-</td></tr>
	<tr><td class=basic>Jenis Pengambilan</td><td>:</td><td class=uline>$arrbyr[BYR]</td></tr>
	<tr><td class=basic># Bukti/Slip</td><td>:</td><td class=uline>$arrbyr[BuktiBayar]</td></tr>
	<tr><td class=basic>Keterangan</td><td>:</td><td class=uline>$arrbyr[Catatan]</td></tr>
	</table><br>
EOF;
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2 width=100%>
	<tr><td width=50%>Jakarta, $arrbyr[tgl]</td><td></tr>
	<tr><td align=center>Bagian Keuangan,</td><td align=center>Diterima oleh,</td></tr>
	<tr><td>&nbsp;</td><td></td></tr>
	<tr><td align=center>___________________</td><td align=center>___________________</td></tr>
	</table>
EOF;
  }
  
  // *** Parameter2 ***
  $biaid = $_REQUEST['biaid'];
  $thn = $_REQUEST['thn'];
  $nim = $_REQUEST['nim'];

  // *** Bagian Utama ***
  DispBuktiTarik($thn, $nim, $biaid);

?>