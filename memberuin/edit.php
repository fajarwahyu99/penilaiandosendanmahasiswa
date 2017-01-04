<html>
<head>
<meta http-equiv='Content-Type' content="text/html; charset=utf-8"/>
<title> EDIT DATA </title>
</head>


<body>
	<?php 
		$id=$_GET['id'];
		include "koneksi.php";
		$select= "SELECT * FROM register WHERE id='$id'";
		$hasil= mysql_query($select);
		while ($buff=mysql_fetch_array($hasil)) {
			
	 ?>

	 <h2>Edit Data</h2>
	 <form action="edit2.php" method="post">
	 <table width="487" border="0">
	 <input type="hidden" name="id" value="<?php echo $buff['id']; ?>"/>
	  	<tr>
	  		<td width="150">Nama Depan</td>
	  		<td width="327"><input type="text" name="namadep" value="<?php echo $buff['namadep']; ?>" /></td>
	 	</tr>
	 	<tr>
	 		<td>Nama belakang</td>
	 		<td><input type="text" name="namabel" value="<?php echo $buff['namabel']; ?>"/></td>
	 	</tr>

	 	<tr>
	 		<td>Username</td>
	 		<td><input type="text" name="username" value="<?php echo $buff['username']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Password</td>
	 		<td><input type="text" name="password" value="<?php echo $buff['password']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Usia</td>
	 		<td><input type="text" name="usia" value="<?php echo $buff['usia']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Jenis Kelamin</td>
	 		<td><input type="text" name="jk" value="<?php echo $buff['jk']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>TTL</td>
	 		<td><input type="text" name="ttl" value="<?php echo $buff['ttl']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Email</td>
	 		<td><input type="text" name="email" value="<?php echo $buff['email']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>No Telp</td>
	 		<td><input type="text" name="notel" value="<?php echo $buff['notel']; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td height="68" align="right"><input type="reset" value="reset"></td>
	 		<td> <input type="submit" value="submit"></td>
	 	</tr>
	  </table>
</form>
<?php 
	}
 	mysql_close();
 ?>
</body>