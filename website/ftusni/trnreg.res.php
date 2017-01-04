<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  function DisplayTrnRegHeader($NI) {
    global $strCantQuery;
	global $strTitle, $strSpeaker, $strDate, $strDate, $strLocation, $strCharge;
	$hd = new NewsBrowser;
	$hd->query = "select * from news where NewsID=$NI";
	$hd->headerfmt = "<table class=basic width=100% cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>Registrasi</th></tr>";
	$hd->detailfmt = "<tr><td class=lst>$strTitle =Category=</td><td class=lst>=Title=</td></tr>
	  <tr><td class=lst>$strSpeaker</td><td class=lst>=Author=</td></tr>
	  <tr><td class=lst>$strDate</td><td class=lst>=DateExpired=</td></tr>
	  <tr><td class=lst>$strLocation</td><td class=lst>=Location=</td></tr>
	  <tr><td class=lst>$strCharge</td><td class=lst>=Charge=</td></tr>";
	$hd->footerfmt = "</table>";
	echo $hd->BrowseNews();
  }
  function DisplayTrnRegForm($NI, $reset=0) {
    global $strRegistrationForm, $strName, $strAddress;
	global $Name, $Address, $strPhone, $strFax, $strEmail;
	global $strSubmit;
    echo "<form action='index.php' method=POST>
	  <input type=hidden name='exec' value='trnreg'>
	  <input type=hidden name='NewsID' value=$NI>
	  <table class=basic width=100% cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=2>$strRegistrationForm</th></tr>
	  <tr><td class=lst>$strName</td><td class=lst><input type=text name='Nama' size=40 maxlength=100></td></tr>
	  <tr><td class=lst>$strAddress</td><td class=lst><textarea name='Alamat' cols=30 rows=3></textarea></td></tr>
	  <tr><td class=lst>$strPhone</td>
	    <td class=lst><input type=text name='Telepon' size=30 maxlength=30></td></tr>
	  <tr><td class=lst>$strFax</td>
	    <td class=lst><input type=text name='Fax' size=30 maxlength=30></td></tr>
	  <tr><td class=lst>$strEmail</td>
	    <td class=lst><input type=text name='Email' size=30 maxlength=100></td></tr>
	
	  <tr><td class=lst colspan=2 align=center><input type=submit name='prc' value='$strSubmit'>
	    <input type=reset name=reset value=Reset></td></tr>
	  </table></form>";
  }
  function ProcessTrnRegForm() {
    global $AdminEmail;
    $NewsID = $_REQUEST ['NewsID'];
	  $_sql = "select Title,Email,Author,Location,DateExpired from news where NewsID=$NewsID";
	  $_res = mysql_query($_sql) or die('Tidak dpt memproses pendaftaran');
	  $Title = mysql_result($_res, 0, 'Title');
	  $Author = mysql_result($_res, 0, 'Author');
	  $Email = mysql_result($_res, 0, 'Email');
	  $Location = mysql_result($_res, 0, 'Location');
	  $Date = mysql_result($_res, 0, 'DateExpired');
	  
	$Nama = $_REQUEST['Nama'];
	$Alamat = $_REQUEST['Alamat'];
	$Telepon = $_REQUEST['Telepon'];
	$Fax = $_REQUEST['Fax'];
	$Email = $_REQUEST['Email'];
	mail($Email, "Pendaftaran: $Title",
	  "Pendaftaran: $Title ($NewsID) \n
	  Pembicara: $Author\n
	  Tanggal: $Date, Lokasi: $Location \n
	  -------------------------------------------
	  Nama: $Nama\n
	  Alamat: $Alamat\n
	  Telepon: $Telepon\n
	  Fax: $Fax\n
	  Email: $Email", 
	  "From: $AdminEmail");
	echo "Terima kasih telah melakukan pendaftaran online.";
  }


?>