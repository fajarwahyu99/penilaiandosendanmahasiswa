<?php 
  // Author : E. Setio Dewo, setio_dewo@telkom.net

  // polling terbaru
  $sqlpoll = "select * from polling order by PollID desc limit 1";
  $respoll = mysql_query($sqlpoll) or die ($strCantQuery);
  if (mysql_num_rows($respoll)>0) {
    $_PollID = mysql_result($respoll, 0, 'PollID');
	$_Title = mysql_result($respoll, 0, 'Title');
	$_PollDate = mysql_result($respoll, 0, 'PollDate');
	$_Description = mysql_result($respoll, 0, 'Description');
	
    $nbrw = new newsbrowser;
    $nbrw->query = "select * from pollitem where PollID=$_PollID";
    $nbrw->headerfmt = "<table class=box cellspacing=2 cellpadding=2 width=100% bgcolor=white>
	  <tr><th class=ttl>$strPolling</th></tr>
	  <tr><th class=lst><b>$_Title</b></th><tr>
	  <tr>
	  <form action='index.php' method=GET>
	  <input type=hidden name='exec' value='postpolling'>
	  <input type=hidden name='PollID' value=$_PollID>
	  <td class=basic>$_Description <br>";
    $nbrw->detailfmt = "<input type=radio name='PollItemID' value==PollItemID= id='=PollItemID='>
	  <label for='=PollItemID'>=Description=</label><br>";
    $nbrw->footerfmt = "</td></tr>
	  <td class=lst align=center><input type=submit name=submit value=$strPost>&nbsp;
	  <input type=submit name=submit value=$strResult></center>
	  </font></td></form></tr></table>";

    echo $nbrw->BrowseNews();
  }
  else echo "<p class=ttl>$strNoPolling</p>";
?>