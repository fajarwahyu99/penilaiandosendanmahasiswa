<?php
include('config.php');

//tangkap data dari form
$id = $_POST['user_id'];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$agama = $_POST['agama'];
$no_hp = $_POST['no_hp'];
$domisili = $_POST['domisili'];

//update data di database sesuai user_id
$query = mysql_query("update user set password='$password', fullname='$fullname', email='$email', agama='$agama', no_hp='$no_hp', domisili='$domisili' where user_id='$id'") or die(mysql_error());

if ($query) {
	header('location:view.php?message=success');
}
?>