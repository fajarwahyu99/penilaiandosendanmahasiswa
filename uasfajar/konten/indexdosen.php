<?php
	session_start();
	if(isset($_SESSION['username'])){
?>
<h2 style="font-style:italic;">Selamat Datang <?php echo"<strong>$_SESSION[username]</strong>"; ?> </h2> 
<hr/>


<table width="800" align="center">
<tr>
	
<td align="center">
	<h3>Memasukkan Nilai</h3>
	<a href="?module=inputnilai"><input type="submit" value="Ke Halaman Penilaian"/></a>
    
    
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