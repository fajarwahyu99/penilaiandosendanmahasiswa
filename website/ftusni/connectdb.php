<?php
  // file: connectdb.php
  // author: USNI, Juni 2010

  $db_username = "herman";
  $db_hostname = "localhost";
  $db_password = "123456";
  $db_name = "ftusni";

  $linksvr = mysql_connect($db_hostname, $db_username, $db_password)
    or die ("Tidak dapat berhubungan dengan database server");

  $linkdb = mysql_select_db($db_name, $linksvr)
    or die ("Tidak dapat membuka database <b>$db_name</b>.");

?>
