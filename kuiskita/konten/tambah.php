<h1>TAMBAH USER</h1>
<form action="?module=tambahproses" method="post">
<p>&nbsp;</p>
<table border="0" align="center">
	<tr>
		<td width="150">ID</td>
		<td>:</td>
		<td width="170"><input type="text" name="id_user" required/></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" required/></td>
	</tr>
    	<td>Username</td>
		<td>:</td>
		<td><input type="text" name="username" required/></td>
    </tr>
        <td>Password</td>
		<td>:</td>
		<td><input type="password" name="password" required/></td>
	<tr>
		<td>Email</td>
		<td>:</td>
		<td><input type="text" name="email" required/></td>
	</tr>
    <tr>
    	<td>Status</td>
        <td>:</td>
        <td><select name="status">
 		<option value="Dosen">Dosen</option>
  		<option value="Mahasiswa">Mahasiswa</option>
        </select></td>
    </tr>
		<tr height="68">
		<td  align="right"><input class"button" type="submit" value="Input"/></td>
		<td> </td>
		<td><input class="button" type="reset" value="Reset"/></td>
	</tr>
</table>
</form>