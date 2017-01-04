<body>
	<?php 
		$id=$_GET['id'];
		$include = "koneksi.php";
		$row=mysql_fetch_array(mysql_query("SELECT * FROM register where id='$id'"));

		$nama_depan=$row['namadep'];
		$nama_belakang=$row['namabel'];
		$username=$row['username'];
		$password=$row['password'];
		$usia=$row['usia'];
		$jk=$row['jk'];
		$ttl=$row['ttl'];
		$email=$row['email'];
		$notel=$row['notel'];
			
	 ?>

	 <h2>Edit Data</h2>
	 <form action="edit2.php" method="post">
	 <table width="487" border="0">
	 <input type="hidden" name="id" value="<?php echo $id; ?>"/>
	  	<tr>
	  		<td width="150">Nama Depan</td>
	  		<td width="327"><input type="text" name="namadep" placeholder="<?php echo $nama_depann; ?>" /></td>
	 	</tr>
	 	<tr>
	 		<td>Nama belakang</td>
	 		<td><input type="text" name="namabel" placeholder="<?php echo $nama_belakang; ?>"/></td>
	 	</tr>

	 	<tr>
	 		<td>Username</td>
	 		<td><input type="text" name="username" placeholder="<?php echo $username; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Password</td>
	 		<td><input type="text" name="password" placeholder="<?php echo $password; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Usia</td>
	 		<td><input type="text" name="usia" placeholder="<?php echo $usia; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Jenis Kelamin</td>
	 		<td><input type="text" name="jk" placeholder="<?php echo $jk; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>TTL</td>
	 		<td><input type="text" name="ttl" placeholder="<?php echo $ttl; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>Email</td>
	 		<td><input type="text" name="email" placeholder="<?php echo $email; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td>No Telp</td>
	 		<td><input type="text" name="notel" placeholder="<?php echo $notel; ?>"/></td>
	 	</tr>
	 	<tr>
	 		<td height="68" align="right"><input type="reset" value="reset"></td>
	 		<td> <input type="submit" value="submit"></td>
	 	</tr>
	  </table>
</form>

</body>