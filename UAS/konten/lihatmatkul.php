
<center><img src="konten/a.jpg"/><br><br>
<?php
include"koneksi.php";

	if(isset($_POST['id_user'])){
		$mysql="INSERT INTO matkul (id_matkul, id_user, nama_matkul,sks)
		VALUES ('$_POST[id_matkul]','$_POST[id_user]','$_POST[nama_matkul]','$_POST[sks]')";
		if(!mysql_query($mysql))
			die(mysql_error());

			echo"<script>alert('MATA KULIAH TERDAFTAR');window.location.href='index.php?module=home';</script>";
			mysql_close();
		}
	

?>
<h1>Daftar Mata Kuliah</h1>
<table width="500px" border="1" align="center">
<form method="post">
    	<tr>
		<td width="190px">ID Mata Kuliah</td>
		<td width="10px">:</td>
		<td width="300px"><input type="text" name="id_matkul" required/></td>
	</tr>
	<tr>
		<td>Dosen</td>
		<td>:</td>
		<td><input type="text" placeholder="ISI DENGAN ID DOSEN" name="id_user" required/></td>
	</tr>
	<tr>
		<td>Mata Kuliah</td>
		<td>:</td>
		<td><input type="text" name="nama_matkul" required/></td>
	</tr>
		<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" required/></td>
	</tr>
	<tr>
        <td align="right"><input class="button" type="reset" value="Reset" /></td>
        <td align="right"><input class="button" type="submit" value="Input" /></td>
        <td>&nbsp;</td>
    </tr>
</table>
</form>
<br><br><br>