<?php
	include "koneksi.php";
	if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
		$hasil=mysql_query("DELETE FROM user WHERE id_user=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}
	
?>

<center><h1>Daftar Dosen</h1>
<br/>
	<table border="1">
    	<tr>
        	<th>ID</th>
            <th>Nama</th>
            <th>Username</th>
			<th>Password</th>
            <th>Email</th>
			<th>Foto</th>
            <th colspan="5">Aksi</th>
		</tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM user WHERE status='Dosen'");
	while($aray = mysql_fetch_array($hasil)){?>
		<tr>
			<td align="center"><?php echo $aray['id_user']; ?></td>
			<td align="center"><?php echo $aray['nama']; ?></td>
			<td align="center"><?php echo $aray['username']; ?></td>
			<td align="center"><?php echo $aray['password']; ?></td>
			<td align="center"><?php echo $aray['email']; ?></td>
            <td><img src="<?php echo $aray['gambar']; ?>.png" width="150px" height="100px"/></td>
			<td align="center"><a href="index.php?module=editdosen&id=<?php echo $aray['id_user']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=hapus&id=<?php echo $aray['id_user']; ?>">Hapus</a></td>
            <td align="center"><a href="index.php?module=kamera&id=<?php echo $aray['id_user']; ?>">Tambahfoto profil</a></td>
		</tr>
	<?php }
	mysql_close();
?>
	</table></center>
    <br/>
    	<a href="index.php?module=tambah">++Tambahkan++</a>