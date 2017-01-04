<!DOCTYPE html>
<html>
<head>
	<title>view</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
</head>
<body>
	<h2>Daftar member</h2> <br>

	<?php 
			include "../koneksi.php";
			$select = "SELECT * FROM register";
			$hasil = mysql_query($select);
	 ?>

	 <table class="table table-condensed">
	 	<tr>
	 		<td >ID</td>
	 		<td >Nama Depan</td>
	 		<td >Nama Belakang</td>
	 		<td >Username</td>
	 		<td >Password</td>
	 		<td >Usia</td>
	 		<td >JK</td>
	 		<td >TTL</td>
	 		<td >Email</td>
	 		<td >Notel</td>
	 	</tr>
 
	 </table>

	 <?php 
	 		while ($buff=mysql_fetch_array($hasil)) {		
	  ?>

	  <table class="table table-condensed">
	  	<tr>
	  		<td width="31"><?php echo $buff['id']; ?></td>
	 		<td width="85"><?php echo $buff['namadep']; ?></td>
	 		<td width="99"><?php echo $buff['namabel']; ?></td>
	 		<td width="82"><?php echo $buff['username']; ?></td>
	 		<td width="87"><?php echo $buff['password']; ?></td>
	 		<td width="41"><?php echo $buff['usia']; ?></td>
	 		<td width="87"><?php echo $buff['jk']; ?></td>
	 		<td width="128"><?php echo $buff['ttl']; ?></td>
	 		<td width="182"><?php echo $buff['email']; ?></td>
	 		<td width="152"><?php echo $buff['notel']; ?></td>
  		</tr>
	  </table>

	  <?php 
	  	};

	  	mysql_close();
	  ?>
	  <br>
	  <a href="../index.php"> <---------- kembali ke register</a>
</body>
</html>

