<!DOCTYPE html>
<html>
<head>
	<title>Pertemuan 8</title>
</head>
<body>
	<style type="text/css"></style>
		<!-- style1 {
				color: #000099;
				font-weight: bold;
		} -->
<center><p>	<font size="20" color="red">REGISTER </font></p> <br>
		
Cari member
	<form action="module/cari.php" method="get">
		<input type="text" name="username" placeholder="ketikan Username">
		<input type="submit" value="cari">
	</form><br>
</center>

<form action="register.php" method="post">
		<p>&nbsp;</p>
<div align="center" class="style1">

<img src="../memberuin/images/logouin.jpg" /><br><br>
<marquee> Selamat Datang di UIN Syarifhidayatullah Jakarta </marquee> <br><br>



<table width="496" border="0" align="enter">	
		<tr>	
				<td width="163"> Nama Depan : </td>
				<td width="317"><input type="text" name="namadep"/></td>
		</tr>
		<tr>
				<td> Nama Belakang : </td>
				<td><input type="text" name="namabel"></td>
		</tr>
		<tr>
				<td>Username : </td>
				<td><input type="text" name="username"></td>
		</tr>
		<tr>	
				<td>Password : </td>
				<td><input type="password" name="password"></td>
		</tr>
		<tr>	
				<td>Usia : </td>
				<td><input type="text" name="usia"></td>
		</tr>
		<tr>	
				<td>jenis Kelamin : </td>
				<td><input type="text" name="jk"></td>
		</tr>
		<tr>
				<td>TTL : </td>
				<td><input type="text" name="ttl"></td>
		</tr>
		<tr>	
				<td>Email : </td>
				<td><input type="text" name="email"></td>
		</tr>
		<tr>	
				<td>Nome Telepon : </td>
				<td><input type="text" name="notel"></td>
		</tr>
		<tr>	
				<td>&nbsp;</td>
				<td><input type="submit" value="input"></td>
		</tr>
		<tr>
				<td><input type="reset" value="reset" color="red"></td>

		</tr>

</table>

</div>


</form>
<a href="module/lihat.php"> lihat daftar member -----></a>


</body>
</html>
		

