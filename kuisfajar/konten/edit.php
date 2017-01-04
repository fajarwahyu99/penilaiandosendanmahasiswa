<?php 
	include "koneksi.php";
	$proses = "SELECT * FROM kuliah where id='$_GET[id]'";
	$hasil = mysql_query($proses);
	while ($data = mysql_fetch_array($hasil)) {
 ?>
 <form action="konten/editproc.php" method="POST">
 	
 	
 <table>
 	<caption>EDIT MATA KULIAH</caption>

 		<tr>
 			<td>NAMA DOSEN </td><td> :</td>
 			<td><input type="text" name="dosen" value="<?php echo $data['dosen']; ?>"></td>
 		</tr>
 		<tr>
 			<td>MATA KULIAH </td><td> :</td>
 			<td><input type="text" name="mata_kuliah" value="<?php echo $data['mata_kuliah']; ?>"></td>
 		</tr>
 		<tr>
 			<td>HARI </td><td> :</td>
 			<td><input type="text" name="hari" value="<?php echo $data['hari']; ?>"></td>
 		</tr>
 		<tr>
 			<td>WAKTU</td><td> :</td>
 			<td><input type="text" name="waktu" value="<?php echo $data['waktu']; ?>"></td>
 		</tr>
		<tr>
 			<td>SKS</td><td> :</td>
 			<td><input type="text" name="sks" value="<?php echo $data['sks']; ?>"></td>
 		</tr>
 		<tr>
 			<td><input type="hidden" name="id" value="<?php echo $data['id']; ?>"></td><td> </td>
 			<td><input type="submit"  value="EDIT"></td>
 		</tr>
		<?php } ?>
 </table>
 </form>