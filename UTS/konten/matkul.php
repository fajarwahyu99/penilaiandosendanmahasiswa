<?php
		if(isset($_POST['nipdosen'])){
		include "koneksi.php";
		$mysql="INSERT INTO kuliah (kode, nipdosen, matkul) VALUES ('$_POST[kode]','$_POST[nipdosen]','$_POST[matkul]')";
		
		if(!mysql_query($mysql))
		die(mysql_error());
		
		echo"<script>alert('Mata Kuliah Terdaftar');window.location.href='index.php?module=lihatmatkul';</script>";
		mysql_close();
		}
?>
<h1>Mata Kuliah</h1>
<table width="500px" border="0" align="center">
<form method="post">
	<tr>
		<td width="190px">Kode Mata Kuliah</td>
		<td width="10px">:</td>
		<td width="300px"><input type="text" name="kode" required/></td>
	</tr>
	<tr>
		<td>NIP Dosen</td>
		<td>:</td>
		<td><input type="text" name="nipdosen" required/></td>
	</tr>
	<tr>
		<td>Mata Kuliah</td>
		<td>:</td>
		<td><input type="text" name="matkul" required/></td>
	</tr>
	<tr>
        <td align="right"><input class="button" type="reset" value="Reset" /></td>
        <td align="right"><input class="button" type="submit" value="Input" /></td>
        <td>&nbsp;</td>
    </tr>
</table>
</form>