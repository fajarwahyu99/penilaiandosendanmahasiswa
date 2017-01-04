<?php

$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
 		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id]' ")or die(mysql_error());
		$tampil_user = mysql_fetch_array($user);

?> 

<h1>Daftar Nilai <?php echo $tampil_matkul['nama_matkul'];?></h1><br />
<h1>Dosen : <?php echo $tampil_user['nama'];?></h1>
	<br />
	<table border="1">
    	<tr>
        	
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
<br><br>

<form action='?module=nilai' method='POST'>
<h1>Input Nilai</h1>
<br/>
<input type="hidden" name="id_matkul" value="<?php echo $tampil_matkul['id_matkul'];?>" />
<table width="500px" border="0" align="center">
	<tr>
    	<td>Nama Mahasiswa</td>
        <td>:</td>
        <td><select name="id_mhs"><?php  
include "koneksi.php";
$query="SELECT * FROM user WHERE status='Mahasiswa'";
$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
while($buff=mysql_fetch_array($hasil)){
 ?>	
 		<option value="<?php echo $buff['id_user'];?>"> <?php echo $buff['nama'];?> </option>
   <?php  }   
   ?>
        </select></td>
    </tr>
	<tr>
		<td>Formatif</td>
		<td>:</td>
		<td><input type="text" name="formatif" required/></td>
	</tr>
	<tr>
		<td>UTS</td>
		<td>:</td>
		<td><input type="text" name="uts" required/></td>
	</tr>
	<tr>
		<td>UAS</td>
		<td>:</td>
		<td><input type="text" name="uas" required/></td>
	</tr>
    	<tr><td colspan='2' align='center' height="68"><input type="submit" name="submit"/></td></tr>
</table>
</form>


<br><br>
</center>
