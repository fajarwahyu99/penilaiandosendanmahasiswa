<h1>TAMBAH USER</h1>
</div>
Data Pengguna Wajib Diisi Lengkap
<br>
<form action="?module=tambahproses" method="post">
<p>&nbsp;</p>
<table border="0" align="center">
	<tr>
    	<td>Status</td>
        <td>:</td>
        <td><select name="status">
 		<option value="Dosen">Dosen</option>
  		<option value="Mahasiswa">Mahasiswa</option>
        </select></td>
    </tr>
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
		<td><input type="text" name="email" placeholder="xxxxx@mail.com"required/></td>
	</tr>
    <tr>
		<td>Nomor Telpon</td>
		<td>:</td>
		<td><input type="text" name="notel" required/></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type="text" name="alamat" placeholder="Kota Tempat Tinggal" required/></td>
		
	</tr>
	<tr>
	<td>SUDAH YAKIN?</td>
	</tr>
		<tr height="68">
		<td><input class="button" type="reset" value="RESET"/></td>
		<td>                 </td>
		<td  align="right"><input class"button" type="submit" style="background-color: #789CCC" value="SUBMIT"/></td>
		
		
	</tr>
</table>
</form>