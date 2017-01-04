<?php

$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id_user]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
 		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id_user]' ")or die(mysql_error());
		$tampil_user = mysql_fetch_array($user);

?> 


<center> <h1>PENILAIAN MAHASISWA </h1> </center>
<table border="1">
<tr>
<th>Daftar Nilai</th> 
<th>Dosen : </th> 
</tr> 

<tr>
<td><?php echo $tampil_matkul['nama_matkul'];?></td>
<td><?php echo $tampil_user['nama'];?></td></tr>
</table>
	<?php
include"koneksi.php";
if(isset($_POST['id_nilai'])){
	if(isset($_GET['aksi'])&&$_GET['aksi']=="edit"){
		$hasil=mysql_query("UPDATE nilai SET formatif='$_POST[formatif]', uts='$_POST[uts]', uas='$_POST[uas]' WHERE id_nilai='$_POST[id_nilai]'");
		if($hasil){
			echo"<script>alert('Data Berhasil Diedit');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diedit');</script>";
			}
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
	$hasil=mysql_query("DELETE FROM nilai WHERE id_nilai=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}

?>
	<table border="1">
    	<tr>
        	
            <th>Nama Mahasiswa</th>
            <th>Formatif</th>
            <th>UTS</th>
            <th>UAS</th>
           	<th>Nilai Total</th>
            <th>Huruf</th>
            <th>Predikat</th>
            <th colspan="1">Aksi</th>     
</tr>

<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM nilai WHERE id_matkul = '$tampil_matkul[id_matkul]'");
	while($aray = mysql_fetch_array($hasil)){
		
		
	$mhs = mysql_query("SELECT * FROM mhs WHERE id = '$aray[id_mhs]'");
		$buff = mysql_fetch_array($mhs);
		?>

<tr>
			<td align="center"><?php echo $buff['nama_mhs']; ?></td>
			<td align="center"><?php echo $aray['formatif']; ?></td>
			<td align="center"><?php echo $aray['uts']; ?></td>
			<td align="center"><?php echo $aray['uas']; ?></td>
			<td align="center"><?php echo $aray['nilai']; ?></td>
			<td align="center"><?php echo $aray['huruf']; ?></td>
            <td align="center"><?php echo $aray['predikat']; ?></td>
            <td align="center"><a href="index.php?module=edit&id=<?php echo $aray['id_nilai']; ?>">Edit</a></td>
</tr>

<?php
};
?>
</table>
<br><br>
<a href="index.php?module=tambahnilai"> INPUT NILAI </a>