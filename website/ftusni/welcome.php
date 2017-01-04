<?php
  DisplayItem($fmtMessage, $strWelcome,
    "$strWelcome <b>$_SESSION[uname]</b> - $_SESSION[level]<br>
	Menu: <a href='index.php' class=lst>$strFrontPage</a> | 
	<a href='sysfo.php' class=lst>USNI</a>
	");
?>