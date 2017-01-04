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
	<table border="1" width="100%">
    	<tr style="background-color:#ccc;">
        	<th>ID</th>
            <th>Nama</th>
            <th>Username</th>
			<th>Password</th>
            <!-- <th>Email</th> -->
            
            <th>Alamat</th>
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
			<!-- <td align="center"><?php echo $aray['email']; ?></td> -->
            
			<td align="center"><?php echo $aray['alamat']; ?></td>
			<td align="center"><a href="home.php?module=editdosen&id=<?php echo $aray['id_user']; ?>">Edit</a></td>
            <td align="center"><a href="home.php?module=daftardosen&aksi=hapus&id=<?php echo $aray['id_user']; ?>">Hapus</a></td>
            
		</tr>
	<?php }
	mysql_close();
?>
	</table></center>
    <br/>
    	<center><a href="home.php?module=tambah"><img src="images/button.png" width="50" /></a></center>
    	<br>
    	<br>
    	<br>