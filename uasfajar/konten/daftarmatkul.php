<center><h1>Daftar Matkul</h1>
<br/>
	<table border="1" width="100%">
    	<tr  style="background-color:#ccc;">
        	<th>ID</th>
            <th>Nama Matkul</th>
            <th>Dosen</th>
			<th>SKS</th>
			<th>Waktu</th>
			<th>Tempat</th>
            </tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM matkul ");
	while($aray = mysql_fetch_array($hasil)){?>
    <?Php
	$dosen = mysql_query ("SELECT * FROM user WHERE id_user = '$aray[id_user]'");
	$ambil = mysql_fetch_array($dosen);
	?>
		<tr>
			<td align="center"><?php echo $aray['id_matkul']; ?></td>
			<td align="center"><?php echo $aray['nama_matkul']; ?></td>
            <td align="center"><?php echo $ambil['nama']; ?></td>
			<td align="center"><?php echo $aray['sks']; ?></td>
			   <td align="center"><?php echo $aray['Waktu']; ?></td>
			   <td align="center"><?php echo $aray['Tempat']; ?></td>         
		</tr>
	<?php }
	mysql_close();
?>
	</table></center>
    <br/>
    	<center><a href="home.php?module=tambahmatkul"><img src="images/button.png" width="50" /></a></center>
    	<br />
    	<br />
