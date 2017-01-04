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
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="terima"){
		$hasil=mysql_query("UPDATE user SET terima=1 WHERE id_user=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data gagal Diterima');</script>";
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="jumlahedit"){
		$hasil=mysql_query("UPDATE user SET jumlahedit=0 WHERE id_user=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diterima');</script>";
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="jumlahlogin"){
		$hasil=mysql_query("UPDATE user SET jumlahlogin=0 WHERE id_user=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diterima');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diterima');</script>";
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
            
			<td align="center"><a href="index.php?module=editdosen&id=<?php echo $aray['id_user']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=hapus&id=<?php echo $aray['id_user']; ?>">Hapus</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=jumlahlogin&id=<?php echo $aray['id_user']; ?>">Reset Login</a></td>
            <td align="center"><a href="index.php?module=daftardosen&aksi=jumlahedit&id=<?php echo $aray['id_user']; ?>">Reset Edit</a></td>
            <td align="center"><?php if($aray['terima']==0){?><a href="index.php?module=daftardosen&aksi=terima&id=<?php echo $aray['id_user']; ?>">Setujui</a><?php } ?></td>
		
		</tr>
	<?php }
	mysql_close();
?>
	</table></center>
    <br/>
    	<a href="index.php?module=tambah">++Tambahkan++</a>