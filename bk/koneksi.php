<?php
$host = "localhost";
$user ="root";
$pass ="";
$db ="bukutamu_db";

$koneksi = mysql_connect($host,$user,$pass);

mysql_select_db($db) or die ("Database tidak ada");

?>