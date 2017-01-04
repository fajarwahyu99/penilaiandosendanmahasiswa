<h1>Daftar Nilai Mahasiswa</h1>
<?php
include"koneksi/koneksi.php";

$user = $_SESSION['user_mhs'];

$select="select * from mhs where user_mhs = '$user'";
$hasil=mysql_query($select);
?>
<table width="780" border="1">
		<tr align="center">
			<td><h3>NIM</h3></td>
			<td><h3>Nama</h3></td>
			<td><h3>Matkul</h3></td>
			<td><h3>Formatif</h3></td>
			<td><h3>UTS</h3></td>
			<td><h3>UAS</h3></td>
			<td><h3>Total</h3></td>
			<td><h3>Predikat</h3></td>
		</tr>

	
<?php
while($buff=mysql_fetch_array($hasil)){
?>

		<tr align="center">
			<td><?php echo $buff['id_mhs'];?></td>
			<td><?php echo $buff['nama'];?></td>
			<td><?php echo $buff['matkul'];?></td>
			<td><?php echo $buff['formatif'];?></td>
			<td><?php echo $buff['uts'];?></td>
			<td><?php echo $buff['uas'];?></td>
			<td><?php echo $buff['total_nilai'];?></td>
			<td><?php echo $buff['predikat'];?></td>
		</tr>

<?php
};
mysql_close();
?><br /></table>
<p>&nbsp </p>