<h2>Hasil Pencarian</h2></br>
<?php
include"koneksi.php";
$username=$_POST['username'];
$select="select * from user where username like '%$username%'";
$hasil=mysql_query($select);
?>

<table border="1">
		<tr>
			<th>Username</th>
			<th>Status</th>
		</tr>
		
<?php
while($buff=mysql_fetch_array($hasil)){
?>

<tr>

			<td align="center"><?php echo $buff['username']; ?></td>
			<td align="center"><?php echo $buff['status']; ?></td>
			
			
			</tr>
</table>
<?php
};

?>