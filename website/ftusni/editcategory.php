<?php
  //Author:  Author: USNI, human@usni.ac.id, Juni 2010
  function DisplayListofCategory() {
    Global $Language, $strNewsCategory, $strLanguage, $strLevel, $strEditLevel, $strListed,
	  $strDescription, $strNotActive;
	Global $sr, $maxrow, $strPage, $strTotalData;
	echo "<a href='index.php?exec=editcategory&mode=1'>Tambah</a><br>";

	$pgfmt = "<a href='index.php?exec=editcategory&mode=0&sr==STARTROW='>=PAGE=</a>";
	$pgoff = "<b>=PAGE=</b>";
    $nbrw = new lister;
	$nbrw->tables = "newscategory where Language='$Language' order by Category";
	$nbrw->fields = "*";
	$nbrw->startrow = $sr;
	$nbrw->maxrow = $maxrow;

    $nbrw->headerfmt = "<table class='basic' cellspacing=0 cellpadding=2 width=100%>
	  <tr class='menuheader'>
	  <th class=ttl>$strNewsCategory</th>
	  <th class=ttl>$strLevel</th>
	  <th class=ttl>$strEditLevel</th>
	  <th class=ttl>$strListed</th>
	  <th class=ttl>$strDescription</th>
	  <th class=ttl>$strNotActive</th>
	  </tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst>
	  <a href='index.php?exec=editcategory&mode=-1&category==!Category='>=Category=</td>
	  <td class=lst align=center>=Level=</td>
	  <td class=lst align=center>=EditLevel=</td>
	  <td class=lst align=center><img src='image/=Listed=.gif' border=0></td>
	  <td class=lst>=Description=</td>
	  <td class=lst align=center><img src='image/book=NotActive=.gif' border=0></td></tr>";
    $nbrw->footerfmt = "</table>";
    $halaman = $nbrw->WritePages($pgfmt, $pgoff);
	$total = $nbrw->MaxRowCount;

	echo "$strPage: $halaman<br>";
    echo $nbrw->ListIt();
	echo "$strPage: $halaman<br>";
	echo "$strTotalData: $total.";
  }
  function DisplayEditCategoryForm($md, $cat) {
    Global $Language, $strNewsCategory, $strLanguage, $strLevel, $strEditLevel, $strListed,
	  $strDescription, $strNotActive;
    Global $strCantQuery, $Language, $strSubmit, $strReset;

    if ($md == -1) {
	  $sql = "select * from newscategory where Category='$cat'";
	  $res = mysql_query($sql) or die ($strCantQuery);
	  $_Level = mysql_result($res, 0, 'Level');
	  $_EditLevel = mysql_result($res, 0, 'EditLevel');
	  $_Listed = mysql_result($res, 0, 'Listed');
	  $_Description = mysql_result($res, 0, 'Description');
	  $_NotActive = mysql_result($res, 0, 'NotActive');
	}
	else {
	  $_Level = 5;
	  $_EditLevel = $_SESSION['ulevel'];
	  $_Listed = 'N';
	  $_Description = "";
	  $_NotActive = 'N';
	}
	$lvlopt = GetLevel($_Level);
	$edtopt = GetLevel($_EditLevel);
	if ($_Listed == 'Y') $str_Listed = 'checked=checked';
	else $str_Listed = "";
	if ($_NotActive == 'Y') $str_NotActive = 'checked=checked';
	else $str_NotActive = "";
	
	if (!empty($cat)) $_formcat = $cat;
	else $_formcat = "<input type=text name='category' value='$cat'>";

	echo "<form action='index.php' method=GET>
	  <input type=hidden name='exec' value='editcategory'>
	  <input type=hidden name='mode' value=$md>
	  <input type=hidden name='oldcategory' value='$cat'>
	  <table class='basic' cellspacing=1 cellpadding=1>
	    <tr><td class=lst>$strNewsCategory</td>
		  <td class=lst>
	    $_formcat</td></tr>
		
	    <tr><td class=lst>$strLevel</td>
		  <td class=lst>
	      <select name='level'>$lvlopt</select></td></tr>
		  
	    <tr><td class=lst>$strEditLevel</td>
		  <td class=lst>
	      <select name='editlevel'>$edtopt</select></td></tr>
		  
	    <tr><td class=lst>$strListed</td>
		  <td class=lst>
	      <input type=checkbox name='listed' value='Y' $str_Listed></td></tr>
		  
	    <tr><td class=lst>$strDescription</td>
		  <td class=lst>
	      <input type=text name='description' value='$_Description' size=40></td></tr>
		  
	    <tr><td class=lst>$strNotActive</td>
		  <td class=lst>
	      <input type=checkbox name='notactive' value='Y' $str_NotActive></td></tr>
		  
		<tr><td class=lst colspan=2><center>
		  <input type=submit name=submit value='$strSubmit'>&nbsp;
		  <input type=reset name=reset value='$strReset'></center>
		</td></tr>
	  </table>
	  </form>";
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, $strEditCategory);
  if ($_SESSION['ulevel'] <> 1) die (DisplayHeader($fmtErrorMsg, $strNotAuthorized));

  if (!isset($_GET['mode'])) $mode = 0;
  else $mode = $_GET['mode'];
  
  if (!isset($_GET['sr'])) $sr = 0;
  else $sr = $_GET['sr'];

  if (!isset($_GET['submit'])) {
    if ($mode == 0) DisplayListofCategory();
    else {
      if (!isset($_GET['category']) and ($mode==-1)) die (DisplayHeader($fmtErrorMsg, $strNotAuthorized));
	
	  $category = $_GET['category'];
      DisplayEditCategoryForm($mode, $category);
    }
  }
  else {
	$language = $Language;
	$level = substr($_GET['level'], 0, 1);
	$editlevel = substr($_GET['editlevel'], 0, 1);
	if (empty($_GET['listed'])) $listed = 'N';
	else $listed = $_GET['listed'];
	$description = FixQuotes($_GET['description']);
	if (empty($_GET['notactive'])) $notactive = 'N';
	else $notactive = $_GET['notactive'];
	
	if ($mode == -1) {
      $category = FixQuotes($_GET['oldcategory']);
	  $sql = "update newscategory set Level=$level,
	    EditLevel=$editlevel,
		Listed='$listed',
		Description='$description',
		NotActive='$notactive'
		where Category='$category'";
	  //echo $sql;
	  $res = mysql_query($sql) or die (DisplayHeader($fmtErrorMsg, $strCantQuery));
	}
	else if ($mode == 1) {
      $category = sqling($_GET['category']);
	  if (empty($category)) die (DisplayHeader($fmtErrorMsg, $strCantPostData));
	  $sql = "insert into newscategory (Category, Language, Level, EditLevel, Listed,
	    Description, NotActive) values ('$category', '$Language', $level, $editlevel,
		'$listed', '$description', '$notactive')";
	  $res = mysql_query($sql) or die (DisplayHeader($fmtErrorMsg, $strCantQuery));
	  //echo $sql;
	}
	DisplayItem($fmtMessage, $strEditCategory, $strEditCategorySuccess);
	DisplayListofCategory();
  }


?>