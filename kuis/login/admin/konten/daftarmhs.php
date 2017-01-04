<h1>Daftar Mahasiswa</h1>
<?php
include"koneksi/koneksi.php";
$select="select * from mhs";
$hasil=mysql_query($select);
?>
<table width="825" border="1">
		<tr align="center">
			<td><h3>NIM</h3></td>
			<td><h3>Nama</h3></td>
			<td><h3>Username</h3></td>
			<td><h3>Password</h3></td>
			<td><h3>Email</h3></td>
			<td><h3>Matkul</h3></td>
			<td><h3>Kategori</h3></td>
            <td><h3>Status</h3></td>
			<td><h3>Ket</h3></td>
		</tr>

	
<?php
while($buff=mysql_fetch_array($hasil)){
?>

		<tr align="center">
			<td><?php echo $buff['id_mhs'];?></td>
			<td><?php echo $buff['nama'];?></td>
			<td><?php echo $buff['user_mhs'];?></td>
			<td><?php echo $buff['pass_mhs'];?></td>
			<td><?php echo $buff['email'];?></td>
			<td><?php echo $buff['matkul'];?></td>
			<td><?php echo $buff['kategori'];?></td>
            <td><?php echo $buff['status'];?></td>
			<td><a href="konten/hapusmhs.php?id=<?php echo $buff['id_mhs'];?>">Hapus</a></td>
		</tr>

<?php
};
mysql_close();
?><br /></table>
<p>&nbsp </p>