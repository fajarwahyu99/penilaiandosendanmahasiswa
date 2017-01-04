<!DOCTYPE html>
<html>
<head>
	<title>View</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<h2>Daftar Member</h2> <br>

	<?php 
			include "../koneksi.php";
			$select = "SELECT * FROM register";
			$hasil = mysql_query($select);
	 ?>

		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Nama Depan</th>
				<th>Nama Belakang</th>
				<th>Username</th>
				<th>Password</th>
				<th>Usia</th>
				<th>JK</th>
				<th>TTL</th>
				<th>Email</th>
				<th>Notel</th>
				<th colspan="2">Aksi</th>
			</tr>
			</thead>


		 <?php 
	 			while ($buff=mysql_fetch_array($hasil)) {		
	 	?>

			<tbody>
			<tr>
		  		<td><?php echo $buff['id']; ?></td>
		 		<td><?php echo $buff['namadep']; ?></td>
		 		<td><?php echo $buff['namabel']; ?></td>
		 		<td><?php echo $buff['username']; ?></td>
		 		<td><?php echo $buff['password']; ?></td>
		 		<td><?php echo $buff['usia']; ?></td>
		 		<td><?php echo $buff['jk']; ?></td>
		 		<td><?php echo $buff['ttl']; ?></td>
		 		<td><?php echo $buff['email']; ?></td>
		 		<td><?php echo $buff['notel']; ?></td>
		 		<td><a href="../edit.php?id=<?php echo $buff['id']; ?>">Edit</a></td>
		 		<td><a href="../hapus.php?id=<?php echo $buff['id']; ?>">Hapus</a></td>
	  		</tr>
			
			</tbody>

		<?php 
	  		};

	  			mysql_close();
	  		?>
			
		</table>

			
			
	  
	  <br>
	  
	  <a href="../index.php"> <---------- kembali ke register</a>
	  <center><img src="../images/logouin.jpg"/></center><br><br>
</body>
</html>

