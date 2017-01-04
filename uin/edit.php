<body>
<?php
$id=$_GET['id'];
include"../uin/koneksi.php";
$select="Select * from register where id='$id'";
$hasil= mysql_query($select);
while($buff=mysql_fetch_array($hasil)){
	?>
	<h2> EDIT DATA</h2><br>
	<form action="edit2.php" method="post">
	<form action="edit2.php" method="post">
<table width="487" border="0">
<input type="hidden" name="id" value="<?php echo $buff['id'];?>"/>
<tr>
	<td width="150">Nama Depan</td>
	<td width="327"><input type="text" name="namedepan" placeholder="<?php echo $buff['namadep'];?>"/></td>
</tr> 
<tr>
	<td>Nama Belakang</td>
	<td><input type="text" name="namebelakang" placeholder="<?php echo $buff['namabel'];?>"/></td>
</tr>
<tr>
	<td>Username</td>
	<td><input type="text" name="username" placeholder="<?php echo $buff['username'];?>"/></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type="password" name="password" placeholder="<?php echo $buff['password'];?>"/></td>
</tr>
<tr>
	<td>Usia</td>
	<td><input type="text" name="usia" placeholder="<?php echo $buff['usia'];?>"/></td>
</tr>
<tr>
	<td>Jenis Kelamin</td>
	<td><input type="text" name="jk" placeholder="<?php echo $buff['jk'];?>"/></td>
</tr>
<tr>
	<td>Tempat Tanggal Lahir</td>
	<td><input type="text" name="ttl" placeholder="<?php echo $buff['ttl'];?>"/></td>
</tr>
<tr>
	<td>Email</td>
	<td><input type="text" name="email" placeholder="<?php echo $buff['email'];?>"/></td>
</tr>
<tr>
	<td>No Telp</td>
	<td><input type="text" name="notel" placeholder="<?php echo $buff['notel'];?>"/></td>
</tr>
<tr>
	<td height="68" align="right"><input type="reset" value="reset"/></td>
	<td><input type="submit" value="submit" /></td>
</tr>
</table>
</form>
<?php
};
mysql_close();
?>
