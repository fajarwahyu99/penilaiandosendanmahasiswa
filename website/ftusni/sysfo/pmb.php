<?php
  // Author: E. Setio Dewo (setio_dewo@telkom.net), April 2003

  if (!isset($_GET['agree'])) {
    DisplayHeader($fmtPageTitle, $strNewStudentRegistration);
    include "about/pmbnote.$Language.php";
  }
  else {
    if ($_GET['agree'] == $strAgree) include "sysfo/pmbform.php";
	else DisplayHeader($fmtErrorMsg, $strRegistrationCanceled);
  }

?>
