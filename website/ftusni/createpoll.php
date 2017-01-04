<?php
  function GetPollChoice($maxchoice) {
    global $strChoice;
    $tmp = "";
    for ($i=1; $i < $maxchoice+1; $i++)
	  $tmp = "$tmp\n<tr><td class=lst>$strChoice $i</td>
		<td class=lst><input type=text name='pollchoice[]' size=30 maxlength=100></td></tr>";
	return $tmp;
  }
  function DisplayPollForm() {
    global $strPollData, $strPollTitle, $strDescription, $strAuthor, $strEmail,
	  $strPollChoice, $Max_Poll_Choice, $strSubmit, $strReset;
	$choice = GetPollChoice($Max_Poll_Choice)  ;
	$_author = $_SESSION['uname'];
	$_email = $_SESSION['uemail'];
    echo "<form action='index.php' method=POST>
	  <input type=hidden name='exec' value='createpoll'>
	  <table class=basic cellspacing=0 cellpadding=2>
	    <tr><th class=ttl colspan=2>$strPollData</th></tr>
	    <tr><td class=lst>$strPollTitle</td><td class=lst>
	      <input type=text name='title' size=30 maxlength=50></td></tr>
	    <tr><td class=lst>$strDescription</td><td class=lst>
	      <textarea name='description' cols=35 rows=3 maxlength=255></textarea></td></tr>
	    <tr><td class=lst>$strAuthor</td><td class=lst>
	      <input type=text name='author' value='$_author' size=30 maxlength=50></td></tr>
	    <tr><td class=lst>$strEmail</td><td class=lst>
	      <input type=text name='email' value='$_email' size=30 maxlength=50></td></tr>
		<tr><th class=ttl colspan=2>$strPollChoice
		  </th></tr>$choice
		<tr><td colspan=2 class=lst align=center>
		  <input type=submit name=submit value=$strSubmit>
		  <input type=reset name=reset value=$strReset>
	  </table>
	  </form>";
  }

  // *** Bag. Utama ***
  if (strpos($polladmin_level, $_SESSION['ulevel']) === false) die ($strNotAuthorized);
  DisplayHeader($fmtPageTitle, $strCreatePoll);
  if (!isset($_POST['submit'])) DisplayPollForm();
  else {
    $cho = $_POST['pollchoice'];
	//echo sizeof($cho);
	$tmp = "";
	//echo count($cho);
    if (EmptyArray($cho)) die (DisplayHeader($fmtErrorMsg, $strNoChoiceAvailable));
	// buat angket
	$_title = FixQuotes($_POST['title']);
	$_description = FixQuotes($_POST['description']);
	$_author = FixQuotes($_POST['author']);
	$_email = FixQuotes($_POST['email']);
	$_unip = $_SESSION['unip'];
	
	$sqlins = "insert into polling (PollDate, Title, Description,
	  unip, Author, Email) values(now(), '$_title', '$_description',
	  '$_unip', '$_author', '$_email')";
	$resins = mysql_query($sqlins) or die("$strCantQuery: $sqlins");
	
	$sqlid = "select last_insert_id() as ID";
	$resid = mysql_query($sqlid) or die ("$strCantQuery");
	$PollID = mysql_result($resid, 0, 'ID');
	for ($i=0; $i < count($cho); $i++) {
	  if (!empty($cho[$i])) {
	    $_desc = stripslashes($cho[$i]);
		$sqlitm = "insert into pollitem (PollID, Description) 
		  values ($PollID, '$_desc')";
		$resitm = mysql_query($sqlitm) or die ($sqlitm);
	  }
	}
	DisplayItem($fmtMessage, $strPollCreationTitle, $strPollCreationSuccess);
    include "pollresult.php";
	DisplayPollResult($PollID);
	DisplayPollList();
  }
?>
