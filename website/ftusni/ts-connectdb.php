<?php
  // file: connectdb.php
  // author: E. Setio Dewo, Maret 2003

  $db_username = "1931";
  $db_hostname = "localhost";
  $db_password = "neuro";

  $linksvr = mysql_connect($db_hostname, $db_username, $db_password)
    or die ($strCantConnect);

  $linkdb = mysql_select_db("db1931n1", $linksvr)
    or die ($strCantOpenDB);

?>
