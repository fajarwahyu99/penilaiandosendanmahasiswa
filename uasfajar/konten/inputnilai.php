	<?php

$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
 		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id]' ")or die(mysql_error());
		$tampil_user = mysql_fetch_array($user);

?> 
<center>
<h1> PENILAIAN </h1>
<table border="1" width="510" >
<tr  style="background-color:#ccc;"SS>
<th>Daftar Nilai</th>
<th> Dosen </th>
</tr>
<tr>
<td align="center"> <?php echo $tampil_matkul['nama_matkul'];?></td>
<td align="center"><?php echo $tampil_user['nama'];?></td>
</tr>
</table>
	<br />
	<table border="1" width="510">
    	<tr  style="background-color:#ccc;">
        	
            <th>Nama Mahasiswa</th>
            <th>Formatif</th>
            <th>UTS</th>
            <th>UAS</th>
           	<th>Nilai Total</th>
            <th>Huruf</th>
            <th>Predikat</th>     
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
</tr>

<?php
};
?>
</table>
<br><br> <center><a href="home.php?module=tambahnilai"><img src="images/button.png" width="50" /></a></center>
===================================================================

