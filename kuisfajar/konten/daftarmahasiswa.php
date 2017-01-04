<?php
	include "koneksi.php";
	if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
		$hasil=mysql_query("DELETE FROM user WHERE nip=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="terima"){
		$hasil=mysql_query("UPDATE user SET terima=1 WHERE nip=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data gagal Diterima');</script>";
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="jumlahedit"){
		$hasil=mysql_query("UPDATE user SET jumlahedit=0 WHERE nip=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diterima');</script>";
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="jumlahlogin"){
		$hasil=mysql_query("UPDATE user SET jumlahlogin=0 WHERE nip=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diterima');</script>";
		}
	}
?>

<h1>Daftar Dosen</h1>
<center><img src="konten/a.jpg"/></center><br>
	<table border="1">
    	<tr>
        	<th>NIP</th>
            <th>Nama</th>
            <th>TTL</th>
			<th>Nomor Telepon</th>
            <th>Alamat</th>
            <th colspan="5">Aksi</th>
		</tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM user WHERE status='Mahasiswa'");
	while($aray = mysql_fetch_array($hasil)){?>
		<tr>
			<td align="center"><?php echo $aray['nip']; ?></td>
			<td align="center"><?php echo $aray['nama']; ?></td>
			<td align="center"><?php echo $aray['ttl']; ?></td>
			<td align="center"><?php echo $aray['notelp']; ?></td>
			<td align="center"><?php echo $aray['alamat']; ?></td>
            
			<td align="center"><a href="index.php?module=editdosen&id=<?php echo $aray['nip']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=hapus&id=<?php echo $aray['nip']; ?>">Hapus</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=jumlahlogin&id=<?php echo $aray['nip']; ?>">Reset Login</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=jumlahedit&id=<?php echo $aray['nip']; ?>">Reset Edit</a></td>
            <td align="center"><?php if($aray['terima']==0){?><a href="index.php?module=daftarmahasiswa&aksi=terima&id=<?php echo $aray['nip']; ?>">Setujui</a><?php } ?></td>
		</tr>
	<?php }
	mysql_close();
?>
	</table>
	<br><br>