<form action="" method="get">
	<table>
		<tr>
			<td>Cari :</td>
		</tr>
		<tr>
			<td><input type="text" name="dosen" placeholder="nama dosen"></td>
			<td><input type="hidden" name="module" value="admin">
			<input type="submit" name="" value="CARI"></td>
		</tr>
	</table>
</form>
<table align="center" width="700" border="1 solid">
	<caption>JADWAL MATA KULIAH</caption>
	<thead>
		<tr>
			<th>NO</th>
			<th>NAMA DOSEN</th>
			<th>MATA KULIAH</th>
			<th>HARI</th>
			<th>WAKTU</th>
			<th>SKS</th>
			<th colspan="2">ACTION</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			include "koneksi.php";
			$proses = "SELECT * FROM kuliah";
			if (isset($_GET['dosen'])) {
				$proses = "SELECT * FROM kuliah where dosen like '%$_GET[dosen]%'";
			}
			$hasil = mysql_query($proses);
			while ($data = mysql_fetch_array($hasil)) {
		 ?>
		 <tr>
		<td width="31" align="center"><?php echo $data['id'];?></td>
		<td width="100" align="center"><?php echo $data['dosen'];?></td>
		<td width="120" align="center"><?php echo $data['mata_kuliah'];?></td>
		<td width="82" align="center"><?php echo $data['hari'];?></td>
		<td width="87" align="center"><?php echo $data['waktu'];?></td>
		<td width="41" align="center"><?php echo $data['sks'];?></td>
		<td width="100"><a href="?module=edit&id=<?php echo $data['id'];?>">Edit</a></td>
		<td width="96"><a href="?module=hapus&id=<?php echo $data['id'];?>">Hapus</a></td>
	</tr>
		<?php 
			}
		 ?>
	</tbody>
</table>