<?php
//panggil file config.php untuk menghubung ke server
include"koneksi/koneksi.php";

//tangkap data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$namalengkap = $_POST['namalengkap'];
$email = $_POST['email'];

//simpan data ke database
$query = mysql_query("insert into user values('', '$username', '$password', '$namalengkap', '$email')") or die(mysql_error());

if ($query) {
	header('location:index1.php?message=success');
}
?>