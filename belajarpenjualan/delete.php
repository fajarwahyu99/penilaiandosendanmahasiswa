<?php 
include('config.php');

$id = $_GET['id'];

$query = mysql_query("delete from penjualan where id='$id'") or die(mysql_error());

if ($query) {
	header('location:view.php?message=delete');
}
?>