<h2>Hasil Pencarian</h2></br>
<?php
include"koneksi.php";
$id_user=$_POST['id_user'];
$select="select * from user where id_user like '%$id_user%'";
$hasil=mysql_query($select);
?>
<CENTER>
<table border="1" width="100%">
    	<tr>
            <th>Username</th>
            <th>Status</th>
		</tr>

<?php
while($buff=mysql_fetch_array($hasil)){
?>

<tr>
     
			<td align="center"><?php echo $buff['username']; ?></td>
            <td align="center"><?PHP echo $buff['status'];	?></td>
       
           
           </tr>
</table>
</CENTER>
<br>
<br>
<br>
<?php
};

?>
