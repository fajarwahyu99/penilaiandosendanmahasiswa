<?php
	include"koneksi.php";
	$select = "select * from mahasiswa";
	$hasil = mysql_query($select);
	
	#untuk menampilkan pilihan matakuliah yang diajar oleh dosen tertentu
	$pilih = mysql_fetch_array(mysql_query("SELECT * FROM dosen WHERE username = '$_SESSION[username]'"));
	$dosen = "select * from mata_kuliah where id_dosen = '$pilih[id]'";
	$hasil2 = mysql_fetch_array(mysql_query($dosen));
?>

<form action="?module=inputnilaiproc" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id_matkul" value="<?php echo $hasil2['id']?>" />
	<input type="hidden" name="id_dosen" value="<?php echo $pilih['id']?>" />
	<table border="1px">
		<tr>
			<td>NIM</td>
			<td>Nama</td>
			<td>Matkul</td>
			<td>Nilai</td>
		</tr>
		<?php while($buff=mysql_fetch_array($hasil)){ ?>
		<tr>
			<td><?php echo $buff['nim'] ?></td>
			<td><?php echo $buff['nama'] ?></td>
			<td>
				<?php
				echo $hasil2['pelajaran'];
				?>
			</td>
			<td><input name="nilai_<?php echo $buff['id']?>" type="number" min="0" max="100" required/></td>
		</tr>
		<input type="hidden" name="id_mahasiswa_<?php echo $buff['id']?>" value="<?php echo $hasil2['id']?>" />
		<?php } ?>
		
			
	</table>
	<input type="reset" value="reset"/></td>
	<input type="submit" value="submit" name="save"/>
</form>