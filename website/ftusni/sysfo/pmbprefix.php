<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
  include "lib/table.common.php";
  
  function DisplayPMBParameterForm() {
    $_pref = GetPMBPrefix();
	$_desc = GetPMBDescription();
	$_digt = GetPMBDigit();
    echo "<table class=box align=center cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='pmbprefix'>

	    <tr><td class=lst>Ubah Prefix Aktif: </td>
		<td class=lst><input type=text name='newprefix' value='$_pref' size=5 maxlength=10></td></tr>

	    <tr><td class=lst>Jumlah digit stlh Prefix: </td>
		<td class=lst><input type=text name='digit' value='$_digt' size=5 maxlength=10></td></tr>
		
		<tr><td class=lst>Keterangan: </td>
		<td class=lst><input type=text name='description' value='$_desc' size=30 maxlength=100></td></tr>
		
	    <tr><td colspan=2 align=center class=lst>
	    <input type=submit name=submit value='ubah'>
		<input type=reset name=reset value='reset'>
		</td></tr>
	  </form></table>
	  ";
  }
    
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Prefix PMB');
  
  if (!isset($_REQUEST['submit'])) DisplayPMBParameterForm();
  else {
    $newprefix = $_REQUEST['newprefix'];
	$description = $_REQUEST['description'];
	$digit = $_REQUEST['digit'];
	$_sql = "update setup set PMBPrefix='$newprefix', PMBDigit=$digit, PMBDescription='$description'";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	DisplayPMBParameterForm();
  }
?>