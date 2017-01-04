<?php
session_start();
if(!isset($_SESSION['username'])) {
	header("Location: index.php?access_denied");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
	<style>
	.welcome {
		color: #11bb22;
		font-size: 35pt;
		font-weight: 900;
		font-family: Centaur;
	}
	</style>
</head>
<body>

<h1 class="welcome">Selamat Datang <?php echo $_SESSION['username']; ?>!</h1>

<a href="logout.php">Log Out >></a>

</body>
</html>

