<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
  function DisplayEditScoreForm($_ID) {
    $_sql = "select Name,Program,ProgramType,TestScore,TestPass
	  from pmb where PMBID=$_ID";
	$_res = mysql_query($_sql);
	$_score = mysql_result($_res, 0, 'TestScore');
	$_name = mysql_result($_res, 0, 'Name');
	$_program = mysql_result($_res, 0, 'Program');
	$_programtype = mysql_result($_res, 0, 'ProgramType');
	$_testpass = mysql_result($_res, 0, 'TestPass');
	
	$str_py = ''; $str_pn = '';
	if ($_testpass=='Y') $str_py = 'checked';
	else $str_pn = 'checked';
    echo "
	  <form action='sysfo.php' method=POST>
	    <input type=hidden name='exec' value='sysfo/editscore'>
	    <input type=hidden name='syxec' value='editscore'>
	    <input type=hidden name='PMBID' value='$_ID'>
		
		<table class=box cellspacing=1 cellpadding=2>
		  <tr>
		    <th class=ttl>Nama</th><th class=ttl>$_name</th>
		  </tr>
		  <tr>
		    <td class=lst>Pilihan</td><td class=lst>$_program</td>
		  </tr>
		  <tr>
		    <td class=lst>Program</td><td class=lst>$_programtype</td>
		  </tr>
		  <tr>
		    <td class=lst>Nilai Ujian</td>
			<td class=lst><input type=text name='TestScore' value=$_score size=3></td>
		  </tr>
		  <tr>
		    <td class=lst>Lulus Ujian</td>
			<td class=lst>
			  <input type=radio name='_TestPass' value='Y' id='py' $str_py>
			  <label for='py'>Lulus</label>
			  <input type=radio name='_TestPass' value='N' id='pn' $str_pn>
			  <label for='pn'>Tidak</label>
		  </tr>
		  <tr>
		    <td class=lst colspan=2 align=center>
			  <input type=submit name='submit' value='submit'>
			  <input type=reset name='reset' value='reset'>
			</td>
		  </tr>
		</table>
	  </form>";
  }


  // *** Bagian Utama ***
  // Action
  if (empty($_SESSION['sysfo'])) $action = 'index.php';
  else $action = 'sysfo.php';

  if (isset($_REQUEST['PMBID'])) $PMBID = $_REQUEST['PMBID'];
  else die($strNotAuthorized);
  
  if (!isset($_POST['submit'])) {
    DisplayHeader($fmtPageTitle, 'Edit Nilai Ujian');
    DisplayEditScoreForm($PMBID);
  }
  else {
    if (isset($_POST['TestScore'])) $score = $_POST['TestScore'];
	else $score=0;
	if (isset($_POST['_TestPass'])) $pass = $_POST['_TestPass'];
	else $pass='N';
    $_sql = "update pmb set TestScore=$score, TestPass='$pass' where PMBID=$PMBID";
	$_res = mysql_query($_sql) or die($strCantQuery);
	DisplayItem($fmtMessage, 'Edit Nilai Ujian', 'Penyuntingan Nilai Ujian Berhasil');
	include "sysfo/listofnewstudent.php";
  }
?>