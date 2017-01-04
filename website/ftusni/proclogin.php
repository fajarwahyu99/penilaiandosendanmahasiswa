<?php
    $NIP = $_POST ['NIP'];
	$arrlvl = explode(". ", $_POST['level']);
	$Level = $arrlvl[0];
	$LevelName = $arrlvl[1];
	$Password = $_POST ['password'];
	
	//echo "$NIP<br>$Level<br>$Password";
	if ($Level==1) $logintable = 'mhsw';
	else if ($Level==2) $logintable = 'kajur';
	else if ($Level==3) $logintable = 'dosen';
	else if ($Level==4) $logintable = 'sefak';
	else die(DisplayHeader($fmtErrorMsg, "$strNotAuthorized", 0));
	
	// cek from DB
/*	$sql = "select ID, Login, Name, Email from $logintable where Login='$NIP' and 
	  Password=LEFT(PASSWORD('$Password'),10) and NotActive='N'";*/
	$sql = "select ID, Login, Name, Email from $logintable where Login='$NIP' and 
	  Password='$Password' and NotActive='N'";	  
	$res = mysql_query($sql) or die ($strCantQuery."<br>".mysql_error());
	if (mysql_num_rows($res)==1) {
	  $_SESSION['sudahlogin'] = 1;
	  $_SESSION['ulevel'] = $Level;
	  $_SESSION['level'] = $LevelName;
	  $_SESSION['uname'] = mysql_result($res, 0, 'Name');
	  $_SESSION['uid'] = mysql_result($res, 0, 'ID');
	  $_SESSION['unip'] = mysql_result($res, 0, 'Login');
	  $_SESSION['uemail'] = mysql_result($res, 0, 'Email');
	  if (strpos($sysfo_level, $_SESSION['ulevel'])=== false) {
		$_SESSION['sysfo'] = "";
	  }
	  else $_SESSION['sysfo'] = session_id();
	  //DisplayItem($fmtMessage, $strWelcome, "$strWelcome ".$_SESSION['uname']);
      $exec = "welcome";
	  $syxec = "welcome.php";
	}
	else {
      $isErrorLogin = true;
	  $exec = "login";
	}
?>