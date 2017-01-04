<?php
	include "koneksi.php";
	$nip = $_SESSION['nip'];
	$dosen = mysql_query("select * from user");
    if(isset($_POST['nim'])){
		$edit="UPDATE mahasiswa SET nim='$_POST[nim]', nama_mhs='$_POST[nama_mhs]', nilai='$_POST[nilai]' WHERE nim='$_POST[nim]'";
		$hasil = mysql_query($edit);
		$jml_edit = $_POST['jumlahedit'];
		if($hasil){
			$update = mysql_query("update user set jumlahedit = '$jml_edit' where nip = '$nip' ");	
		}else{
			mysql_error();
		}
		echo"<script>alert('Data Berhasil Diedit');window.location.href='?module=lihatnilai';</script>";
	}
	
	
	$id=$_GET['id'];
	$select="SELECT * FROM mahasiswa WHERE nim='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>
<h1>Edit Nilai</h1>
<form method="post">
<input type="hidden" name="nim" value="<?php echo $buff['nim'];?>"/>
<table align="center">
<tr>
<td width="200px">NIM</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['nim'];?>" name="nim" required/></td>
</tr>
<tr>
<td>Nama Mahasiswa</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nama_mhs'];?>" name="nama_mhs" required/></td>
</tr>
<tr>
<td>Nilai</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nilai'];?>"name="nilai" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>