<?php
	include "koneksi.php";
	if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
		$hasil=mysql_query("DELETE FROM user WHERE id_user='$_GET[id]'");
		$hapus=mysql_query("DELETE FROM mhs WHERE id='$_GET[id]'");
		if($hasil && $hapus){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}
	
?>

<center><h1>Daftar Mahasiswa</h1></center>
<br/>
	<table border="1" style="width:100%;">
    	<tr>
        	<th>ID</th>
            <th>Nama</th>
       	    <th>Email</th>
            
            <th colspan="5">Aksi</th>
		</tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM user WHERE status='Mahasiswa'");

	while($aray = mysql_fetch_array($hasil)){?>
    <?php 	$mhs=mysql_query("SELECT * FROM mhs WHERE id='$aray[id_user]'");
				$ambil = mysql_fetch_array($mhs);?>
		<tr>
			<td align="center"><?php echo $aray['id_user']; ?></td>
			<td align="center"><?php echo $aray['nama']; ?></td>
			<td align="center"><?php echo $aray['email']; ?></td>
         
            
			<td align="center"><a href="index.php?module=editmhs&id=<?php echo $aray['id_user']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=daftarmhs&aksi=hapus&id=<?php echo $aray['id_user']; ?>">Hapus</a></td>
            
		</tr>
	<?php }
	mysql_close();
?>
	</table>
    <br/>
    <a href="index.php?module=tambah">++Tambahkan++</a>
    <br />
    <br />
    <br />