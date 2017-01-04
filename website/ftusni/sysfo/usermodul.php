<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function DisplayUserBrief($usr, $usrid) {
    global $strCantQuery;
    $_sql = "select Name,Login,Phone,Description,NotActive from $usr where ID=$usrid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	$_Name = mysql_result($_res, 0, 'Name');
	$_Login = mysql_result($_res, 0, 'Login');
	$_Phone = mysql_result($_res, 0, 'Phone');
	$_Description = mysql_result($_res, 0, 'Description');
	$_NotActive = mysql_result($_res, 0, 'NotActive');
	echo "<table class=basic width=100% cellspacing=1 cellpadding=1>
	  <tr><th colspan=2 class=ttl>User - $usr</th></tr>
	  <tr><td class=lst>Nama</td><td class=lst>
	  <a href='sysfo.php?syxec=useraccess&usrid=$usrid&usr=$usr'>$_Name</a></td></tr>
	  <tr><td class=lst>Login</td><td class=lst>$_Login</td></tr>
	  <tr><td class=lst>Telepon</td><td class=lst>$_Phone</td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst>$_Description</td></tr>
	  <tr><td class=lst>Tidak Aktif</td><td class=lst>$_NotActive</td></tr>
	  </table><br>";
  }

  function DisplayAvailableModule($usr, $usrid) {
    $lvl = GetaField('level', 'usr', $usr, 'Level');
    $mdl = new NewsBrowser;
	$mdl->query = "select md.* 
	  from modul md left join usermodul um on md.ModulID=um.ModulID and um.UserID='$usrid'
	  where LOCATE($lvl, md.Level)=0 and md.InMenu='Y'
      order by md.GroupModul,md.Modul";
	$mdl->headerfmt = "<table width=100% class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=3>Modul yg Tersedia</th></tr>
	  <tr><th class=ttl>+</th>
	  <td class=ttl>Group</td><td class=ttl>Modul</td></tr>";
	$mdl->detailfmt = "<tr><td class='lst' width=5>
	  <a href='sysfo.php?syxec=usermodul&usr=$usr&usrid=$usrid&add==ModulID='>
	  <img src='sysfo/image/arrow-left.gif' border=0></a></td>
	  <td class=lst>=GroupModul=</td>
	  <td class=lst>=Modul=</td></tr>";
	$mdl->footerfmt = "</table><br>";
	echo $mdl->BrowseNews();
  }
  function DisplayDefaultModule($usr, $usrid) {
    $lvl = GetaField('level', 'usr', $usr, 'Level');
    $mdl = new NewsBrowser;
	$mdl->query = "select * from modul where LOCATE($lvl, Level)>0 and InMenu='Y' order by GroupModul,Modul";
	$mdl->headerfmt = "<table width=100% class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=3>Default Modul utk Level $usr</th></tr>
	  <tr><td class=ttl>Group</td><td class=ttl>Modul</td></tr>";
	$mdl->detailfmt = "<tr>
	  <td class=lst>=GroupModul=</td>
	  <td class=lst>=Modul=</td></tr>";
	$mdl->footerfmt = "</table><br>";
	echo $mdl->BrowseNews();
  }
  function DisplayUserModule($usr, $usrid) {
    $lvl = GetaField('level', 'usr', $usr, 'Level');
    $mdl = new NewsBrowser;
	$mdl->query = "select um.*, m.Modul 
	  from usermodul um left outer join modul m
	  on um.ModulID = m.ModulID
	  where um.Level=$lvl and um.UserID=$usrid and m.InMenu='Y' order by um.GroupModul,m.Modul";
	$mdl->headerfmt = "<table width=100% class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=3>Modul Tambahan</th></tr>
	  <tr>
	  <td class=ttl>Group</td><td class=ttl>Modul</td>
	  <th class=ttl>-</th></tr>";
	$mdl->detailfmt = "<tr>
	  <td class=lst>=GroupModul=</td>
	  <td class=lst>=Modul=</td>
	  <td class='lst' width=5>
	  <a href='sysfo.php?syxec=usermodul&usr=$usr&usrid=$usrid&del==ModulID='>
	  <img src='image/filedelete.gif' border=0></a></td></tr>";
	$mdl->footerfmt = "</table><br>";
	echo $mdl->BrowseNews();
  }
  function DelModule($usr, $usrid, $modid) {
    global $strCantQuery;
    $lvl = GetaField('level', 'usr', $usr, 'Level');
	$_sql = "delete from usermodul where Level=$lvl and UserID=$usrid and ModulID=$modid";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
  }
  function AddModule($usr, $usrid, $modid) {
    global $strCantQuery, $fmtErrorMsg;
	$lvl = GetaField('level', 'usr', $usr, 'Level');
	// Cek dulu ah... siapa tahu sudah pernah didaftarin
	$_sck = "select ModulID from usermodul where ModulID=$modid and Level=$lvl and UserID=$usrid";
	$_rck = mysql_query($_sck) or die("$strCantQuery: $_sck");
	if (mysql_num_rows($_rck) == 0) {
	  $gm = GetaField('modul', 'ModulID', $modid, 'GroupModul');
	  $_sql = "insert into usermodul (Level,UserID,GroupModul,ModulID) 
	    values ($lvl, $usrid, '$gm', $modid)";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	else DisplayHeader($fmtErrorMsg, "Modul sudah didaftarkan.");
  }

  // *** Parameter2 ***
  if (isset($_REQUEST['usr'])) $usr = $_REQUEST['usr'];
  else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
  if (isset($_REQUEST['usrid'])) $usrid = $_REQUEST['usrid'];
  else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
  if (isset($_REQUEST['add'])) AddModule($usr, $usrid, $_REQUEST['add']);
  if (isset($_REQUEST['del'])) DelModule($usr, $usrid, $_REQUEST['del']);

  DisplayHeader($fmtPageTitle, "Adm. Module $usr");
?>

<table class=basic width=100%>
<tr>
<td width=50% valign=top>
  <?php
    DisplayUserBrief($usr, $usrid);
	DisplayUserModule($usr, $usrid);
  ?>
</td>
<td background='image/vertisilver.gif' width=1></td>
<td valign=top>
  <?php
    DisplayAvailableModule($usr, $usrid);
	DisplayDefaultModule($usr, $usrid);
  ?>
</td>
</tr>
</table>