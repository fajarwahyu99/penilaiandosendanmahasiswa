<?php
	include"koneksi.php";
	$select = "select * from dosen";
	$hasil = mysql_query($select);
?>


<form action="?module=tambahmatkulproc" method="post" enctype="multipart/form-data">
		<p>&nbsp;</p>
  		<div align="center" class="style1">
			<p>TAMBAH MATA KULIAH </p>
		</div>
	<table width="500" border="0" align="center" class="style3">
		<tr>
			<td width="163">Nama Dosen :  </td>
			<td width="317">
				<select name="id_dosen">
					<?php while($buff=mysql_fetch_array($hasil)){ ?>
						<option value=<?php echo $buff['id']?>><?php echo $buff['nama']?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Mata Kuliah: </td>
			<td><input type="text" name="pelajaran" required/></td>
		</tr>
		<tr>
			<td>Jam : </td>
			<td><input type="time" placeholder="JJ:MM:DD" name="jam" required/></td>
		</tr>
		<tr>
			<td>Tempat :</td>
			<td><input type="text" name="tempat" required/></td>
		</tr>
		<tr>
			<td></td>
			<td height="68" align="right"><input type="reset" value="reset"/></td>
			<td><input type="submit" value="submit" name="saave"/></td>
		</tr>
	</table>
</form>