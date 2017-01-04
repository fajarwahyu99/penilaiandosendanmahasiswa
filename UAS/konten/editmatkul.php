<?php
	include "koneksi.php";
	if(isset($_POST['kode'])){
	$edit="UPDATE kuliah SET kode='$_POST[kode]', nipdosen='$_POST[nipdosen]', matkul='$_POST[matkul]' WHERE kode='$_POST[kode]'";
	
	mysql_query($edit);
	echo"<script>alert('Data Berhasil Diedit');window.location.href='?module=lihatmatkul';</script>";
	}
	
	$id=$_GET['id'];
	$select="SELECT * FROM kuliah WHERE kode='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>
<h1>Edit Mata Kuliah</h1>
<form method="post">
<table align="center">
<tr>
<td width="200px">Kode Mata Kuliah</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['kode'];?>" name="kode" required/></td>
</tr>
<tr>
<td>NIP Dosen</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nipdosen'];?>" name="nipdosen" required/></td>
</tr>
<tr>
<td>Mata Kuliah</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['matkul'];?>"name="matkul" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>