<table width="700" align="center" border="1">
	<caption>DAFTAR TAMU</caption>
	<thead>
		<tr>
			<th>NAMA</th>
			<th>ALAMAT</th>
			<th>TTL</th>
			<th>NO TELEPON</th>
			<th>EMAIL</th>
			<th colspan="2">ACTION</th>
		</tr>
	</thead>
<?php 
			include "koneksi.php";
			$proses = "SELECT * FROM registrasi";
			$hasil = mysql_query($proses);
			while ($data = mysql_fetch_array($hasil)) {
		 ?>


	
		<tr>
			<td><?php echo $data['Nama']; ?></td>
			<td><?php echo $data['Alamat']; ?></td>
			<td><?php echo $data['TTL']; ?></td>
			<td><?php echo $data['No_telp']; ?></td>
			<td><?php echo $data['Email']; ?></td>
			<td width="100"><a href="?module=edit&id=<?php echo $buff['nama'];?>">Edit</a></td>
			<td width="96"><a href="?module=hapus&id=<?php echo $buff['nama'];?>">Hapus</a></td>
		</tr>
<?php 
	}
 ?>
</table>