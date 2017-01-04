<?php
  //echo "<h3>CEK LOGIN.PHP</h3>";

  if ($isErrorLogin == true) {
    $isErrorLogin = false;
    DisplayHeader ($fmtErrorMsg, $strCantLogin);  
  }
  DisplayLoginForm();

?>