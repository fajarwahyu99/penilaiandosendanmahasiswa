
<?php
	include "koneksi.php";
	if(isset($_POST['id_user'])){
	$edit="UPDATE user SET nama='$_POST[nama]', username='$_POST[username]', password='$_POST[password]', email='$_POST[email]' WHERE id_user='$_POST[id_user]'";
	mysql_query($edit);
	echo"<script>alert('Data Berhasil Diedit');window.location.href='?module=daftardosen';</script>";
	}
	
	$id=$_GET['id'];
	$select="SELECT * FROM user WHERE id_user='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>
<h1>Edit Dosen</h1>
<form method="post">
<table align="center">
<input type="hidden" name="id_user" value="<?php echo $buff['id_user'];?>"/>
<tr>
<td width="200px">Nama</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['nama'];?>" name="nama" required/></td>
</tr>
<tr>
<td>Username</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['username'];?>" name="username" required/></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input type="password" value="<?php echo $buff['password'];?>"name="password" required/></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['email'];?>"name="email" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>