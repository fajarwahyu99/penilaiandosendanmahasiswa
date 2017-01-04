<?php
		
		$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id]' " or die(mysql_error()));
		$tampil_user = mysql_fecth_array($user);
		
	?>
		
	<h1>Daftar Nilai <?php echo $tampil_matkul['nama_matkul'];?></h1><br />
	<h1>Mahasiwa : <?php echo $tampil_user['nama'];?></h1>
		<br />
		<table border="1">
			<tr>
			
				<th>Matkul</th>
				<th>SKS</th>
				<th>Dosen</th>
				<th>Formatif</th>
				<th>UTS</th>
				<th>UAS</th>
				<th>Nilai Total</th>
				<th>Huruf</th>
				<th>Predikat</th>
	</tr>
	
	<?php
		include "koneksi.php";
		
		$hasil=mysql_query("SELECT * FROM nilai");
		while($array = mysql_fetch_array($hasil)){
		
		
		$matkul = mysql_query(SELECT * FROM matkul WHERE id_matkul = '$array[id_matkul]'") or die(mysql_error());
		$buff = mysql_fecth_array($matkul);
		
		$dosen= mysql_query(SELECT * FROM user WHERE id_user = '$buff[id_user]'")or die(mysql_error());
		$terambil = mysql_fecth_array($dosen);
		
		
			?>
			
		<tr>
				<td align="center"><?php echo $buff['nama_matkul']; ?></td>
				<td align="center"><?php echo $buff['sks']; ?></td>
				<td align="center"><?php echo $buff['nama']; ?></td>
				<td align="center"><?php echo $buff['formatif']; ?></td>
				<td align="center"><?php echo $buff['uts']; ?></td>
				<td align="center"><?php echo $buff['uas']; ?></td>
				<td align="center"><?php echo $buff['nilai']; ?></td>
				<td align="center"><?php echo $buff['huruf']; ?></td>
				<td align="center"><?php echo $buff['predikat']; ?></td>
</tr>

<?php
};
?>
</table>
<br><br>
				
		