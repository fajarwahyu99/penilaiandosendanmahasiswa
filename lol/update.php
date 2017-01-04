<?php
include"koneksi/koneksi.php";

//tangkap data dari form
$id = $_POST['id'];
$password = $_POST['password'];
$namalengkap = $_POST['namalengkap'];
$email = $_POST['email'];

//update data di database sesuai user_id
$query = mysql_query("update user set password='$password', namalengkap='$namalengkap', email='$email' where id='$id'") or die(mysql_error());

if ($query) {
	header('location:view.php?message=success');
}
?>