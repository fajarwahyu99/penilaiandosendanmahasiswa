	<?php
include "koneksi.php";
$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
 		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id]' ")or die(mysql_error());
		$tampil_user = mysql_fetch_array($user);

?>

<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM nilai WHERE id_matkul = '$tampil_matkul[id_matkul]'");
	while($aray = mysql_fetch_array($hasil)){
		
		
	$mhs = mysql_query("SELECT * FROM mhs WHERE id = '$aray[id_mhs]'");
		$buff = mysql_fetch_array($mhs);
		?>
<?php
};
?>
		
<form action='?module=nilai' method='POST'>
<center><h1>Input Nilai</h1>
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
    	<tr>
    	<td>        </td>
    	<td colspan='2' align='center' height="68"><input type="submit" style="background-color: #FF0088" name="submit" value="INPUT"/>
    	</td>
    	</tr>
</table>
</form>


<br><br>
</center>