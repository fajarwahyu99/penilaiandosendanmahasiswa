<?php 	
		include "koneksi.php";
		$mysql ="INSERT INTO register (namadep, namabel, username, password, usia, jk, ttl, email, notel)
				VALUES ('$_POST[namadep]','$_POST[namabel]','$_POST[username]','$_POST[password]','$_POST[usia]','$_POST[jk]','$_POST[ttl]','$_POST[email]','$_POST[notel]')";

		if (!mysql_query($mysql)) die(mysql_error());

		echo "<script> alert('Sudah terdatar'); window.location.href='index.php';</script>";

		mysql_close();
 ?>