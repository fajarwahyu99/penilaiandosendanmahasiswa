<?php
	include "koneksi.php";
	if(isset($_POST['nip'])){
	$edit="UPDATE user SET nama='$_POST[nama]', ttl='$_POST[ttl]', notelp='$_POST[notelp]', alamat='$_POST[alamat]' WHERE nip='$_POST[nip]'";
	mysql_query($edit);
	echo"<script>alert('Data Berhasil Diedit');window.location.href='?module=daftardosen';</script>";
	}
	
	$id=$_GET['id'];
	$select="SELECT * FROM user WHERE nip='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>
<h1>Edit Dosen</h1>
<form method="post">
<table align="center">
<input type="hidden" name="nip" value="<?php echo $buff['nip'];?>"/>
<tr>
<td width="200px">Nama</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['nama'];?>" name="nama" required/></td>
</tr>
<tr>
<td>Tempat Tanggal Lahir</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['ttl'];?>" name="ttl" required/></td>
</tr>
<tr>
<td>Nomor Telepon</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['notelp'];?>"name="notelp" required/></td>
</tr>
<tr>
<td>Alamat</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['alamat'];?>"name="alamat" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>