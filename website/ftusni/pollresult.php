<?php
  // Author : E. Setio Dewo (setio_dewo@telkom.net), April 2003
  // versi: 1.1, 11 Juli 2003
  
  function DisplayPollResult($_PollID) {
    global $strTotalVoter, $strVoter, $strPostedBy;
	global $strCantQuery;
    $sqlpol = "select * from polling where PollID=$_PollID";
    $sqlres = mysql_query($sqlpol) or die ($strCantQuery);
    $_PollDate = mysql_result($sqlres, 0, 'PollDate');
    $_Title = mysql_result($sqlres, 0, 'Title');
    $_Description = mysql_result($sqlres, 0, 'Description');
	$_Author = mysql_result($sqlres, 0, 'Author');
	$_Email = mysql_result($sqlres, 0, 'Email');
  
    // hitung jumlah total
	$sqltot = "select sum(Count) as Jml from pollitem where PollID=$_PollID";
	$restot = mysql_query($sqltot) or die ($strCantQuery);
	$_totalvoter = mysql_result($restot, 0, 'Jml');
	
	// tampilkan versi 1.1
	$s = "select b.*, a.Title, a.Description as PollDescription, $_totalvoter as Total,
	  ROUND(Count / $_totalvoter * 100) as Persen
	  from pollitem b inner join polling a on b.PollID=a.PollID where b.PollID=$_PollID";
	$r = mysql_query($s) or die ("$strCantQuery: $s");
	if (mysql_num_rows($r) > 0) {
	  echo <<<EOF
	    <center><h3>$_Title</h3></center>
	    <table class=basic cellspacing=0 cellpadding=2 width=100%>
		<tr><th class=ttl colspan=4>$_Description</th></tr>
EOF;
	  while ($row = mysql_fetch_array($r)) {
	    if (isset($row['Persen'])) $psn = $row['Persen']; else $psn = 0;
	    echo <<<EOF
		<tr><td class=lst>$row[Description]</td>
		<td class=lst><img src='image/pollbar.jpg' height=18 width=$psn border=0></td>
		<td class=lst align=right>$psn%</td>
		<td class=lst align=right>$row[Count]/$_totalvoter</td></tr>
EOF;
	  }
	  echo "</table><br>";
	}
	echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<tr><td class=lst>$strPostedBy</td><td class=ttl><a href='mailto:$_Email'>$_Author</a></td></tr>
	<tr><td class=lst>$strTotalVoter</td><td class=ttl>$_totalvoter $strVoter</td></tr>
	</table>
EOF;
  }  
  function DisplayPollList(){
    global $strListofPoll, $strResult, $maxrow;
	// tampilkan versi 1.1
    $nbrw = new newsbrowser;
    $nbrw->query = "select * from polling order by PollID desc limit $maxrow";
    $nbrw->headerfmt = "<p class=ttl><b>$strListofPoll</b></p><ul>";
    $nbrw->detailfmt = "<li><a href='index.php?exec=postpolling&submit=$strResult&PollID==PollID=' class=lst>
      =Title=.</a> <font color=silver>=PollDate= =unip=</font></li>";
    $nbrw->footerfmt = "</ul></p>";
	echo $nbrw->BrowseNews();
  }
?>