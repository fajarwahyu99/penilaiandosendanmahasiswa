<?php
$host = "localhost";
$user = "root";
$pass = "";
$name = "pemos";
	$connect = mysql_connect("$host","$user") or die ("<h1>Server Not Found</h1>");
	$db = mysql_select_db("$name") or die ("<h1>Database Not Found</h1>")
?>
