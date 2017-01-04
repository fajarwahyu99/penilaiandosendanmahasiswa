<?php
  // Author : E. Setio Dewo (setio_dewo@telkom.net), April 2003

  if (!isset($_REQUEST['submit'])) $_submit = "";
  else $_submit = $_REQUEST['submit'];
  //echo "$_submit<br>$strPost";
  if ($_submit==$strPost) {
    $_PollID = $_REQUEST['PollID'];
    if (isset($_REQUEST['PollItemID'])) {
	  $_PollItemID = $_REQUEST['PollItemID'];
	  $sqlupd = "update pollitem set Count=Count+1 where PollItemID=$_PollItemID";
	  $sqlres = mysql_query($sqlupd) or die ($strCantQuery);
	  include "pollresult.php";
	  DisplayPollResult ($_PollID);
	  DisplayPollList();
	}
	else DisplayHeader ($fmtErrorMsg, $strNoPollChoice);
  }
  else {
    include "pollresult.php";
	if (isset($_REQUEST['PollID']))	
	  DisplayPollResult($_REQUEST['PollID']);
	DisplayPollList();
  }
?>