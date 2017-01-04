<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
   
  function GetNextPMBID() {
    // ambil prefix
    $_sql = "select * from setup";
    $_res = mysql_query($_sql) or die("Gagal");
    $_prefix = mysql_result($_res, 0, "PMBPrefix");
    $_digit = mysql_result($_res, 0, "PMBDigit");
  
    // ambil nomer terakhir
    $_sql = "select max(PMBID) as LastID 
	  from pmb where PMBID like '$_prefix%'";
    $_res = mysql_query($_sql) or die("Gagal: $_sql");

    if (mysql_num_rows($_res) == 0) $_last = 0;
    else {
	  $_last = mysql_result($_res, 0, "LastID");
	  //echo "<p><b>_last: $_last</b></p>";
	  $_last = str_replace($_prefix, '', $_last);
	  //echo "<p><b>_last: $_last</b></p>";
	  //settype($_last, 'int');
	  //echo "<p><b>_last->integer: $_last</b></p>";
	  $_last++;
	  settype($_last, 'string');
	  $_last = str_pad($_last, $_digit, '0',0);
	  $_last = "$_prefix$_last";
      //$_last++;
	}
    return $_last;
  }
  function GetPMBPrefix() {
    $_sql = "select PMBPrefix from setup";
	$_res = mysql_query($_sql) or die("Gagal");
	$_prefix = mysql_result($_res, 0, "PMBPrefix");
	return $_prefix;
  }
  function GetPMBDigit() {
    $_sql = "select PMBDigit from setup";
	$_res = mysql_query($_sql) or die("Gagal");
	$_prefix = mysql_result($_res, 0, "PMBDigit");
	return $_prefix;
  }
  function GetPMBDescription() {
    $_sql = "select PMBDescription from setup";
	$_res = mysql_query($_sql) or die("Gagal");
	$_prefix = mysql_result($_res, 0, "PMBDescription");
	return $_prefix;
  }
  function GetPMBPrice($prg) {
    $_sql = "select PMBPrice from jurusan where Kode='$prg'";
	$_res = mysql_query($_sql) or die("Gagal");
	if (mysql_num_rows($_res) > 0) return mysql_result($_res, 0, 'PMBPrice');
	else return 0;
  }
  function DisplayListofUser($lvl) {
    Global $strLogin, $strPassword, $strName, $strEmail, $strPhone,
	  $strDescription, $strNotActive;
	Global $sr, $maxrow, $strPage, $strTotalData;

	if ($lvl==1) $tbl = 'mhsw';
	elseif ($lvl==2) $tbl = 'kajur';
	elseif ($lvl==3) $tbl = 'dosen';
	elseif ($lvl==4) $tbl = 'sefak';
	else die($strNotAuthorized);

	echo "<a href='index.php?exec=editadmin&mode=1&lvl=$lvl'>Tambah</a><br>";

	$pgfmt = "<a href='index.php?exec=editadmin&sr==STARTROW=&lvl=$lvl'>=PAGE=</a>";
	$pgoff = "<b>=PAGE=</b>";
    $nbrw = new lister;
	$nbrw->tables = "$tbl order by Login";
	$nbrw->fields = "Login,Name,Password,Email,Phone,Description,NotActive";
	$nbrw->startrow = $sr;
	$nbrw->maxrow = $maxrow;

    $nbrw->headerfmt = "<table class=basic cellspacing=0 cellpadding=2 width=100%>
	  <tr class='menuheader'>
	  <th class=ttl>$strLogin</th>
	  <th class=ttl>$strName</th>
	  <th class=ttl>$strEmail</th>
	  <th class=ttl>$strPhone</th>
	  <th class=ttl>$strDescription</th>
	  <th class=ttl>$strNotActive</th>
	  </tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst>
	  <a href='index.php?exec=editadmin&mode=0&Login==!Login=&lvl=$lvl'>=Login=</td>
	  <td class=lst>=Name=</td>
	  <td class=lst>
	    <a href='mailto:=Email='>=Email=</a></td>
	  <td class=lst>=Phone=</td>
	  <td class=lst>=Description=</td>
	  <td class=lst>=NotActive=</td></tr>";
    $nbrw->footerfmt = "</table>";
    $halaman = $nbrw->WritePages($pgfmt, $pgoff);
	$total = $nbrw->MaxRowCount;

	echo "$strPage: $halaman<br>";
    echo $nbrw->ListIt();
	echo "$strPage: $halaman<br>";
	echo "$strTotalData: $total.";
  }
  // Form Edit Admin
  function DisplayEditAdminForm($md, $Login, $lvl=1, $link='editadmin', $act='index.php') {
    Global $strLogin, $strPassword, $strName, $strEmail, $strPhone,
	  $strDescription, $strNotActive;
    Global $strCantQuery, $Language, $strSubmit, $strReset, $strNotAuthorized, $strEditPref;
	
	if ($lvl==1) $tbl = 'mhsw';
	elseif ($lvl==2) $tbl = 'kajur';
	elseif ($lvl==3) $tbl = 'dosen';
	elseif ($lvl==4) $tbl = 'sefak';
	else die($strNotAuthorized);

    if ($md == 0) {
	  $sql = "select Login,Name,Password,Email,Phone,Description,NotActive
	    from $tbl admin where Login='$Login'";
	  $res = mysql_query($sql) or die ("$strCantQuery: $sql. <br>".mysql_error());
	  $_Password = mysql_result($res, 0, 'Password');
	  $_Name = mysql_result($res, 0, 'Name');
	  $_Email = mysql_result($res, 0, 'Email');
	  $_Phone = mysql_result($res, 0, 'Phone');
	  $_Description = mysql_result($res, 0, 'Description');
	  $_NotActive = mysql_result($res, 0, 'NotActive');
	}
	else {
	  $_Password = "";
	  $_Name = "";
	  $_Email = "";
	  $_Phone = "";
	  $_Description = "";
	  $_NotActive = 'N';
	}
	// track OldPassword
	$_OldPassword = $_Password;
	if ($_NotActive == 'Y') $str_NotActive = 'checked=checked';
	else $str_NotActive = "";
	
	if (!empty($Login)) $_formLogin = $Login;
	else $_formLogin = "<input type=text name='Login' size=10 maxlength=10 value='$Login'>";
	$sid = session_id();

	echo "<form action='$act' method=REQUEST>
	  <input type=hidden name='exec' value='$link'>
	  <input type=hidden name='mode' value=$md>
	  <input type=hidden name='lvl' value=$lvl>
	  <input type=hidden name='oldLogin' value='$Login'>
	  <input type=hidden name='act' value='$act'>
	  <input type=hidden name='OldPassword' value='$_OldPassword'>
	  <table class=basic cellspacing=0 cellpadding=2>
	    <tr><th class=ttl colspan=2>$strEditPref</th></tr>
	    <tr><td class=lst>$strLogin</td>
		  <td class=lst>$_formLogin</td></tr>
		  
	    <tr><td class=lst>$strPassword</td>
		  <td class=lst>
	      <input type=password name='Password' value='$_Password' 
		    size=10 maxlength=10></td></tr>
		  
	    <tr><td class=lst>$strName</td>
		  <td class=lst>
	      <input type=text name='Name' value='$_Name' size=30 maxlength=50></td></tr>

	    <tr><td class=lst>$strEmail</td>
		  <td class=lst>
	      <input type=text name='Email' value='$_Email' size=30 maxlength=50></td></tr>

	    <tr><td class=lst>$strPhone</td>
		  <td class=lst>
	      <input type=text name='Phone' value='$_Phone' size=30 maxlength=30></td></tr>

	    <tr><td class=lst>$strDescription</td>
		  <td class=lst>
	      <input type=text name='Description' value='$_Description' size=30 maxlength=100></td></tr>
		  
	    <tr><td class=lst>$strNotActive</td>
		  <td class=lst>
	      <input type=checkbox name='NotActive' value='Y' $str_NotActive></td></tr>
		  
		<tr><td class=lst colspan=2><center>
		  <input type=submit name=submit value='$strSubmit'>&nbsp;
		  <input type=reset name=reset value='$strReset'>&nbsp;
		  <input type=button name=batal value='Cancel' onClick=\"location='index.php?PHPSESSID=$sid'\">
		  </center>
		</td></tr>
	  </table>
	  </form>";
  }
  function ProcessEditAdmin() {
	//$oldLogin = stripslashes($_REQUEST['oldLogin']);
	//$Login = stripslashes($_REQUEST['Login']);
	$lvl = $_REQUEST['lvl'];
	if ($lvl==1) $tbl = 'mhsw';
	elseif ($lvl==2) $tbl = 'kajur';
	elseif ($lvl==3) $tbl = 'dosen';
	elseif ($lvl==4) $tbl = 'sefak';
	else die($strNotAuthorized);

	$mode = $_REQUEST['mode'];
	$Password = $_REQUEST['Password'];
	$OldPassword = $_REQUEST['OldPassword'];
	$Description = FixQuotes($_REQUEST['Description']);
	$Name = FixQuotes($_REQUEST['Name']);
	$Email = FixQuotes($_REQUEST['Email']);
	$Phone = FixQuotes($_REQUEST['Phone']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	
	// edit mode
	if ($mode == 0) {
	  if ($Password == $OldPassword) $_pwd = '';
	  else $_pwd = "Password=PASSWORD('$Password'), ";
      $Login = stripslashes($_REQUEST['oldLogin']);
	  $sql = "update $tbl set $_pwd
	    Name='$Name', Email='$Email', Phone='$Phone',
		Description='$Description',
		NotActive='$NotActive'
		where Login='$Login'";
	  //echo $sql;
	  $res = mysql_query($sql) or die (DisplayHeader($fmtErrorMsg, $strCantQuery));
	}
	// insert mode
	else if ($mode == 1) {
      $Login = stripslashes($_REQUEST['Login']);
	  if (empty($Login)) die (DisplayHeader($fmtErrorMsg, $strCantPostData));
	  $sql = "insert into $tbl (Login, Password, Name, Email, Phone,
	    Description, NotActive) 
		values ('$Login', PASSWORD('$Password'), '$Name', '$Email',
		'$Phone', '$Description', '$NotActive')";
	  $res = mysql_query($sql) or die (DisplayHeader($fmtErrorMsg, $strCantQuery));
	  //echo $sql;
	}
  }
?>