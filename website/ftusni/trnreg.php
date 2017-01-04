<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  include "trnreg.res.php";
  if (isset($_REQUEST['NewsID'])) $NewsID = $_REQUEST['NewsID'];
  else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized));
  
  if (isset($_REQUEST['prc'])) ProcessTrnRegForm();
  else { 
    DisplayHeader($fmtPageTitle, $strRegistration);
    DisplayTrnRegHeader($NewsID);
    DisplayTrnRegForm($NewsID);
  }
?>