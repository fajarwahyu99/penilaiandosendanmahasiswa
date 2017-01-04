<?php
		if(isset($_POST['id_user'])){
		include "koneksi.php";
		$mysql="INSERT INTO matkul (id_user,id_matkul, nama_matkul, sks, Waktu, Tempat) 
		VALUES ('$_POST[id_user]','$_POST[id_matkul]','$_POST[nama_matkul]','$_POST[sks]','$_POST[Waktu]' ,'$_POST[Tempat]')";
		
		if(!mysql_query($mysql))
		die(mysql_error());
		
		echo"<script>alert('Mata Kuliah Terdaftar');window.location.href='home.php?module=daftarmatkul';</script>";
		mysql_close();
		}
?>
<h1>Mata Kuliah</h1>
<br/>
<table width="500px" border="0" align="center">
<form method="post">
<tr>
    	<td>ID Dosen</td>
        <td>:</td>
        <td><select name="id_user"><?php  
include "koneksi.php";
$query="SELECT * FROM user WHERE status='Dosen'";
$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
while($buff=mysql_fetch_array($hasil)){
 ?>	
 		<option value="<?php echo $buff['id_user'];?>"> <?php echo $buff['id_user'];?> </option>
   <?php  }   
   ?>
        </select></td>
    </tr>
	<tr>
		<td width="190px">ID Mata Kuliah</td>
		<td width="10px">:</td>
		<td width="300px"><input type="text" name="id_matkul" required/></td>
	</tr>
	
	<tr>
		<td>Mata Kuliah</td>
		<td>:</td>
		<td><input type="text" name="nama_matkul" required/></td>
	</tr>
    <tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" required/></td>
	</tr>
	<tr>
		<td>Waktu</td>
		<td>:</td>
		<td><input type="text" name="Waktu" placeholder="Hari dan WAktu" required/></td>
	</tr>
	<tr>
		<td>Tempat</td>
		<td>:</td>
		<td><input type="text" name="Tempat" required/></td>
	</tr>
	<tr height="60">

        <td ><input class="button" type="reset" style="background-color: #ff0000"value="Reset" /></td>
<td>                                                                   </td>
        <td ><input class="button" type="submit" style="background-color: #789CCC" value="Input" /></td>
        <td>&nbsp;</td>
    </tr>
</table>
</form>
<br>
<br>
<br>