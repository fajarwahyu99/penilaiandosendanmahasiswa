<?php
  if (isset($_GET['NewsID'])) {
    $NewsID = $_GET ['NewsID'];
  }
  else if (isset($_GET['NewsCategory'])) {
    $NewsCategory = $_GET['NewsCategory'];
    $sql = "select NewsID from news where Category='$NewsCategory' order by NewsID desc limit 1";
	$res = mysql_query($sql) or die ($strCantQuery);
	if (mysql_num_rows($res) == 0) die ($strNotAuthorized);
	$NewsID = mysql_result($res, 0, 'NewsID');
  }
  //else die ($strNotAuthorized);
  $sql = "update news set ReadCount=ReadCount+1 where NewsID=$NewsID";
  $res = mysql_query($sql) or die ($strCantQuery);

  $det0 = "<p><center><h3>=Title=</h3></center></p>
    <p>
	<table class=box width=90% cellspacing=1 cellpadding=4 align=center>
	<tr><td class=basic>
	<b>=Description=</td></tr></table></p><p>=Content=</p>";

  $det1 = "<p><center><h3>=Title=</h3></center></p>
    <p><font color=silver>$strPostedBy: =Author=, =tgl=, $strRead: =ReadCount=x</font><br>
	<table class=basic width=100% cellpadding=4><tr><td class=ttl>
	<b>=Description=</td></tr></table></p><p>=Content=</p>";
	
  $_sql = "select Author from news where NewsID=$NewsID";
  $_res = mysql_query($_sql) or die($strCantQuery);
  $auth = mysql_result($_res, 0, 'Author');
  if (empty($auth) || ($auth == ' ')) $_det = $det0;
  else $_det = $det1;
  
  $nbrw = new newsbrowser;
  $nbrw->query = "select *,DATE_FORMAT(NewsDate, '%d-%b-%y %H:%i:%s') as tgl from news where NewsID='$NewsID'
    and Language='$Language' order by NewsID desc limit 1";
  $nbrw->headerfmt = '';
  $nbrw->detailfmt = $_det;
  $nbrw->footerfmt = '';
  echo $nbrw->BrowseNews();    

  if ($_SESSION['ulevel']==1 or $_SESSION['unip']==mysql_result($nbrw->sqlres, 0, 'unip')) {
    if (isset($_REQUEST['toex'])) $toex = $_REQUEST['toex'];
	else $toex = 'postnews';
    echo "<hr size=1 color=silver>$strAdministrator: 
	  <a href='index.php?exec=$toex&NewsID=$NewsID'>
	  <img src='./image/edit.gif' border=0></a>";
  }


?>