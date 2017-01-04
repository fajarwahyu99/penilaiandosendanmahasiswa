<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** Fungsi2 ***
  function DispPMBEmptyDlg() {
    global $fmtMessage;
	$sid = session_id();
	$msg = "Anda akan mengosongkan tabel <b>PMB</b>.<br>Gunakan perintah ini dengan hati-hati.<br>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='pmbempty'>
	  <input type=submit name='prcempty' value='Kosongkan'>&nbsp;
	  <input type=button name='batal' value='Batal' onClick=\"location='sysfo.php?PHPSESSID=$sid'\">
	  ";
    DisplayItem($fmtMessage, "Konfirmasi", $msg);
  }
  function PrcEmpty() {
    global $fmtMessage;
	$s = "delete from pmb";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	DisplayItem($fmtMessage, "Berhasil", "Pengosongan tabel <b>PMB</b> telah dilaksanakan.<br>
	  Pilihan: <a href='sysfo.php' class=lst>Kembali</a>");
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Kosongkan Tabel PMB");
  if ($_SESSION['ulevel'] != 1) DisplayHeader($fmtErrorMsg, "Anda tidak berhak menjalankan modul ini!");
  else {
    if (isset($_REQUEST['prcempty'])) PrcEmpty();
	else DispPMBEmptyDlg();
  }
?>