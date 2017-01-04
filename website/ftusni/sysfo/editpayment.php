<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
  function DisplayEditPaymentForm($_ID) {
    $_sql = "select Name,Program,ProgramType,PMBPaid,PMBPrice
	  from pmb where PMBID=$_ID";
	$_res = mysql_query($_sql) or die($_sql);
	$_name = mysql_result($_res, 0, 'Name');
	$_program = mysql_result($_res, 0, 'Program');
	$_programtype = mysql_result($_res, 0, 'ProgramType');
	$_pmbpaid = mysql_result($_res, 0, 'PMBPaid');
	$_pmbprice = mysql_result($_res, 0, 'PMBPrice');
	
	if ($_pmbprice == 0) {
	  include "lib/table.common.php";
	  $_pmbprice = GetPMBPrice($_program);
	}

	$str_py = ''; $str_pn = '';
	if ($_pmbpaid=='Y') $str_py = 'checked';
	else $str_pn = 'checked';
    echo "<table class=box cellspacing=1 cellpadding=2>
      <tr><th class=ttl colspan=2>Edit Pembayaran</th></tr>
	  <form action='sysfo.php' method=POST>
	    <input type=hidden name='exec' value='sysfo/editpayment'>
	    <input type=hidden name='syxec' value='editpayment'>
	    <input type=hidden name='PMBID' value='$_ID'>
		  <tr>
		    <td class=uline>Nama</td><td class=uline>$_name</td>
		  </tr>
		  <tr>
		    <td class=uline>Pilihan</td><td class=uline>$_program</td>
		  </tr>
		  <tr>
		    <td class=uline>Program</td><td class=uline>$_programtype</td>
		  </tr>
		  <tr>
		    <td class=uline>Sudah Dibayar</td>
			<td class=uline>
			  <input type=radio name='PMBPaid' value='Y' id='py' $str_py>
			  <label for='py'>Sudah</label>
			  <input type=radio name='PMBPaid' value='N' id='pn' $str_pn>
			  <label for='pn'>Belum</label>
		  </tr>
		  <tr>
		    <td class=uline>Harga Form Pendaftaran</td>
			<td class=uline><input type=text name='PMBPrice' value=$_pmbprice size=20></td>
		  </tr>
		  <tr>
		    <td class=uline colspan=2 align=center>
			  <input type=submit name='submit' value='submit'>
			  <input type=reset name='reset' value='reset'>
			</td>
		  </tr>
	  </form></table>";
  }


  // *** Bagian Utama ***
  // Action
  if (empty($_SESSION['sysfo'])) $action = 'index.php';
  else $action = 'sysfo.php';

  if (isset($_REQUEST['PMBID'])) $PMBID = $_REQUEST['PMBID'];
  else die($strNotAuthorized);
  
  if (!isset($_POST['submit'])) {
    DisplayHeader($fmtPageTitle, 'Edit Pembayaran');
    DisplayEditPaymentForm($PMBID);
  }
  else {
    if (isset($_POST['PMBPrice'])) $PMBPrice = $_POST['PMBPrice'];
	else $PMBPrice = 0;
	if (isset($_POST['PMBPaid'])) $PMBPaid = $_POST['PMBPaid'];
	else $PMBPaid = 'N';
    $_sql = "update pmb set PMBPrice=$PMBPrice, PMBPaid='$PMBPaid' where PMBID=$PMBID";
	$_res = mysql_query($_sql) or die($strCantQuery);
	DisplayItem($fmtMessage, 'Edit Pembayaran', 'Penyuntingan Administrasi Pembayaran Berhasil');
	include "sysfo/listofnewstudent.php";
  }
?>