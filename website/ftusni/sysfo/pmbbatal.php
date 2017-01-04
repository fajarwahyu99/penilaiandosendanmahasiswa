<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, Desember 2003
  
  // *** Fungsi2 ***
  function DispPanelBatal() {
	echo <<<EOF
	<table class=box cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='pmbbatal'>
	<tr><th class=ttl colspan=2>Pembatalan Penerimaan</th></tr>
	<tr><td class=uline>PMB ID</td><td class=uline><input type=text name='pmbid' size=20 maxlength=20>
	<input type=submit name='prcbtl0' value='Proses Pembatalan'></td></tr>
	</form></table><br>
EOF;
  }
  function GetHistoryKHSMhsw($nim) {
	$s = "Select Tahun, Sesi from khs where NIM='$nim' order by Tahun";
	$r = mysql_query($s) or die("Gagal Query: $s<br>".mysql_error());
	$ret = '';
	while ($w = mysql_fetch_array($r)) {
	  $ret .= "$w[Sesi]. $w[Tahun]<br>";
	}
	if (empty($ret)) return "Belum aktif";
	else return $ret;
  }
  function GetTrxBayarMhsw($nim) {
	$tot = GetaField('bayar', 'NIM', $nim, "sum(Jumlah)");
	return number_format($tot, 0, ',', '.');
  }
  function DispConfirmBatal($pmbid) {
	global $fmtErrorMsg;
    $arrpmb = GetFields('pmb', 'PMBID', $pmbid, '*');
    if (!empty($arrpmb['PMBID']) && $arrpmb['Terima'] == 'Y') {
	  $nim = GetaField('mhsw', 'PMBID', $pmbid, 'NIM');
	  $strkdj = GetaField('jurusan', 'Kode', $arrpmb['Program'], 'Nama_Indonesia');
	  $strkdp = GetaField('program', 'Kode', $arrpmb['ProgramType'], 'Nama_Indonesia');
	  $strkhs = GetHistoryKHSMhsw($nim);
	  $strbyr = GetTrxBayarMhsw($nim);
	  $snm = session_name(); $sid = session_id();
      echo <<<EOF
      <table class=box cellspacing=1 cellpadding=2>
      <form action='sysfo.php' method=POST>
      <input type=hidden name='syxec' value='pmbbatal'>
      <input type=hidden name='pmbid' value='$pmbid'>
      <tr><th class=ttl colspan=3>Konfirmasi Pembatalan</th></tr>
      <tr><td rowspan=10 class=uline><img src='image/caution.gif' align=left></td>
      <td class=uline colspan=2><font color=red>
      Betulkah Anda akan membatalkan penerimaan mahasiswa dengan data di bawah ini?<br>
      Dengan pembatalan ini, maka data akademik yang telah dibuatnya juga akan dihapus.<br>
      Konfirmasikan dengan bagian Akademik untuk penghapusan ini.<br>
      Data yang telah dihapus tidak dapat dikembalikan lagi.</td></tr>
      <tr><td class=uline>PMB ID</td><td class=uline><b>$arrpmb[PMBID]</td></tr>
      <tr><td class=uline>NIM</td><td class=uline><b>$nim</td></tr>
      <tr><td class=uline>Nama</td><td class=uline><b>$arrpmb[Name]</td></tr>
      <tr><td class=uline>Jurusan</td><td class=uline><b>$arrpmb[Program] - $strkdj</td></tr>
      <tr><td class=uline>Program</td><td class=uline><b>$arrpmb[ProgramType] - $strkdp</td></tr>
      <tr><th class=ttl colspan=2>Cek Data Transaksi Mahasiswa</th></tr>
      <tr><td class=uline>Semester</td><td class=uline>$strkhs</td></tr>
      <tr><td class=uline>Transaksi Pembayaran</td><td class=uline>$strbyr</td></tr>
      <tr><td class=uline colspan=3><input type=submit name='prcbtl1' value='Proses Pembatalan'>&nbsp;
        <input type=button name='batal' value='Tidak jadi' onClick="location='sysfo.php?syxec=pmbbatal&$snm=$sid'"></td></tr>
      </form></table><br>
EOF;
    }
    else DisplayHeader($fmtErrorMsg, "Mahasiswa dengan Nomer PMB <b>$pmbid</b> tidak ditemukan.");
  }
  function PrcBatal($pmbid) {
	global $fmtErrorMsg, $fmtMessage;
	$s = "update pmb set Terima='N' where PMBID='$pmbid'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	
	$nim = GetaField('mhsw', 'PMBID', $pmbid, 'NIM');
	$s = "delete from mhsw where PMBID='$pmbid'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	
	$s = "delete from khs where NIM='$nim'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	
	$s = "delete from krs where NIM='$nim'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	
	$s = "delete from khs where NIM='$nim'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
	
	DisplayDetail($fmtMessage, "Berhasil", "Pembatalan penerimaan mahasiswa dengan
	  PMBID <b>$pmbid</b> telah berhasil dilaksanakan.");
  }
  
  // *** Parameter2 ***
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Pembatalan Penerimaan Mahasiswa Baru');
  DispPanelBatal();
  if (isset($_REQUEST['prcbtl0'])) DispConfirmBatal($_REQUEST['pmbid']);
  if (isset($_REQUEST['prcbtl1'])) PrcBatal($_REQUEST['pmbid']);
?>