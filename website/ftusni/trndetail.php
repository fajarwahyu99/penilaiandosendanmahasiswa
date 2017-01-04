<?php
  if (isset($_GET['NewsID'])) {
    $NewsID = $_GET ['NewsID'];
  }
  else if (isset($_GET['FilterCategory'])) {
    $NewsCategory = $_GET['FilterCategory'];
    $sql = "select NewsID from news where Category='$FilterCategory' order by NewsID desc limit 1";
	$res = mysql_query($sql) or die ($strCantQuery);
	if (mysql_num_rows($res) == 0) die ($strNotAuthorized);
	$NewsID = mysql_result($res, 0, 'NewsID');
  }
  //else die ($strNotAuthorized);
  $sql = "update news set ReadCount=ReadCount+1 where NewsID=$NewsID";
  $res = mysql_query($sql) or die ($strCantQuery);

  $det0 = "<p><center><h3>=Title=</h3></center></p>
    <p>
	<table class=basic width=100% cellspacing=1 cellpadding=4>
	<tr><td class=ttl>
	<b>=Description=</td></tr></table>
	<table class=basic width=100% cellspacing=1 cellpadding=2>
	<tr><td class=lst>$strSpeaker:</td><td class=lst>=Author=</td></tr>
	<tr><td class=lst>$strDate:</td><td class=lst>=tgl=</td></tr>
	<tr><td class=lst>$strTime:</td><td class=lst>=jam=</td></tr>
	<tr><td class=lst>$strLocation:</td><td class=lst>=Location=</td></tr>
	<tr><td class=lst>$strCharge:</td><td class=lst>=Charge=</td></tr>
	<tr><td class=lst colspan=2>
	<a href='index.php?exec=trnreg&NewsID==NewsID='><img src='icon/polling.gif' height=20 border=0>$strRegistration Online</a></td></tr>
	</table>
	
	</p><p>=Content=</p>";

  $_sql = "select Author from news where NewsID=$NewsID";
  $_res = mysql_query($_sql) or die($strCantQuery);
  $auth = mysql_result($_res, 0, 'Author');
  
  $nbrw = new newsbrowser;
  $nbrw->query = "select *,DATE_FORMAT(DateExpired, '%d-%b-%y') as tgl,
    DATE_FORMAT(DateExpired, '%H:%i:%s') as jam from news where NewsID='$NewsID'
    and Language='$Language' order by NewsID desc limit 1";
  $nbrw->headerfmt = "";
  $nbrw->detailfmt = $det0;
  $nbrw->footerfmt = "";
  echo $nbrw->BrowseNews();    

  if ($_SESSION['ulevel']==1 or $_SESSION['unip']==mysql_result($nbrw->sqlres, 0, 'unip')) {
    if (isset($_REQUEST['toex'])) $toex = $_REQUEST['toex'];
	else $toex = 'posttrn';
    echo "<hr size=1 color=silver>$strAdmin
	: 
	  <a href='index.php?exec=$toex&NewsID=$NewsID'>
	  <img src='./image/edit.gif' border=0></a>";
  }


?>