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
	
?>

<h1>Daftar Dosen</h1>
<center><img src="konten/a.jpg"/></center><br>
	<table border="1">
    	<tr>
        	<th>ID</th>
            <th>Nama</th>
            <th>Email</th>
			<th>Fakultas</th>
            <th>Jurusan</th>
            <th colspan="5">Aksi</th>
		</tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM user WHERE status='Mahasiswa'");
	while($aray = mysql_fetch_array($hasil)){?>
	
	<?php $mhs=mysql_query("SELECT * FROM mhs WHERE is='$aray[id_user]'");
	$ambil = mysql_fetch_array($mhs);?>

		<tr>
			<td align="center"><?php echo $aray['id_user']; ?></td>
			<td align="center"><?php echo $aray['nama']; ?></td>
			<td align="center"><?php echo $aray['email']; ?></td>
			<td align="center"><?php echo $aray['fakultas']; ?></td>
			<td align="center"><?php echo $aray['jurusan']; ?></td>
            
			<td align="center"><a href="index.php?module=editdosen&id=<?php echo $aray['nip']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=hapus&id=<?php echo $aray['nip']; ?>">Hapus</a></td>
            <td align="center"><?php if($aray['terima']==0){?><a href="index.php?module=daftarmahasiswa&aksi=terima&id=<?php echo $aray['id_user']; ?>">Setujui</a><?php } ?></td>
		</tr>
	<?php }
	mysql_close();
?>
	</table>
	<br><br>
	<a href="index.php?module=tambah">++TAMBAHKAN++</a>