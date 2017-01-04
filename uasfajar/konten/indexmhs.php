<?php
	session_start();
	if(isset($_SESSION['username'])){
?>
<h2 style="font-style:italic;">Welcome <?php echo"<strong>$_SESSION[username]</strong>"; ?> </h2> 
<hr/>


<table width="800" align="center">
<tr>
	
<td align="center">
	<h3>Lihat Nilai</h3>
	<a href="?module=nilai"><a href=""><input type="submit" value="Ke Halaman Lihat Nilai"/></a>
    
<td align="center">
	<h3>Lihat IPK</h3>
	<a href="?module=nilai"><input type="submit" value="Ke Halaman Lihat IPK"/></a>
    
</td>
</table>

<hr/>
</thead>
<?php
	{
?>
</tbody>
<?php
	}
?>
</table>


<hr/>
<a href="?module=logout"><input type="submit" style="font-size:20;" value="Logout"/></a>

<?php
}
else{
	echo"<script>alert('Gagal masuk, silahkan login terlebih dahulu!');window.location.href='?module=home';</script>";
}
?>