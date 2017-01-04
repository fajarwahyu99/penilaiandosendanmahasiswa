<body>
<?php
$id=$_GET['id'];
include"koneksi.php";
$select="select * from dosen where id='$id'";
$hasil=mysql_query($select);
while($buff=mysql_fetch_array($hasil)){
?>
<h2>Edit Data</h2><br/>
<form action="?module=ok" method="post">
<table width="487" border="0">
<input type="hidden" name="id" value="<?php echo $buff['id'];?>" />
	<tr>
		<td width="150">Nama</td>
		<td width="327"><input type="text" name="nama" value="<?php echo $buff['nama'];?>" /></td>
	</tr>
	<tr>
		<td>Status</td>
		<td><input type="text" name="status" value="<?php echo $buff['status'];?>" /></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username" value="<?php echo $buff['username'];?>" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password" value="<?php echo $buff['password'];?>" /></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><input type="text" name="alamat" value="<?php echo $buff['alamat'];?>" /></td>
	</tr>

	<tr>
		<td>Email</td>
		<td><input type="text" name="email" value="<?php echo $buff['email'];?>" /></td>
	</tr>
	<tr>
		<td>No.Telp</td>
		<td><input type="text" name="notel" value="<?php echo $buff['notel'];?>" /></td>
	</tr>
	<tr>
		<td>Tanggal Login</td>
		<td><input type="date" name="tanggal_login" value="<?php echo $buff['tanggal_login'];?>" /></td>
	</tr>
	<tr>
		<td>Total Login</td>
		<td><input type="text" name="total_login" value="<?php echo $buff['total_login'];?>" /></td>
	</tr>
	<tr>
		<td height="68" align="right"><input type="submit" value="ok" /></td>
	</tr>
</table>
</form>
<?php
};
mysql_close();