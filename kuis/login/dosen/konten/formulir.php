<style type="text/css">
<!--
.style1{
	color:#000099;
	font-weight:bold;
	}
-->
</style>
	<p>&nbsp;</p>
	<div align="center" class="style1">
	<h1>REGISTER</h1>
	</form><br/>
	</div>


<form action="konten/register.php" method="post">
	<table border="0" align="center">
		<tr>
			<td>NID/NIM</td>
			<td><input type="text" name="id_client"/></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td><input type="text" name="nama"/></td>
		</tr>
		<tr>
			<td>Username</td>
			<td><input type="text" name="user_client" /></td>
		</tr>
		<tr>
			<tr>
			<td>Password</td>
			<td><input type="password" name="pass_client" /></td>
		</tr>
		<tr>
			<td>kategori</td>
			<td><select name="kategori">
							<option value="Dosen">Dosen</option>
							<option value="Mahasiswa">Mahasiswa</option>
				</select></td>
		</tr>	
		<tr>
			<td>Email</td>
			<td><input type="text" name="email" /></td>
		</tr>	
		<tr>
		<tr>
			<td>Matkul</td>
			<td><select name="matkul">
							<option value="WEB">WEB</option>
							<option value="ADS">ADS</option>
				</select></td>

		<tr>
			<td height="68" align="right"><input type="reset"/></td>
			<td><input type="submit" value="submit" /></td>
		</tr>
	</table>
	</form>