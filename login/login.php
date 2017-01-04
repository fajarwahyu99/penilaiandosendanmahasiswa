<?php
include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query    = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$runquery = $connect->query($query);

if($runquery->num_rows > 0){
	session_start();
	$_SESSION['username'] = $username;
	header("Location: home.php");
} else {
	echo '<h1>Salah</h1>';
}

?>