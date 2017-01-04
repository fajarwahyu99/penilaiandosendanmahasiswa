<html>
<head>
<title>input nilai</title>
</head>

<body>
<?php
$id=$_GET['id'];
include"../koneksi/koneksi.php";
$select="select * from mhs where id_mhs='$id'";
$hasil=mysql_query($select);
while($buff=mysql_fetch_array($hasil)){
?>
<h2><center>Input Nilai</center></h2><br/>
<form action="input2.php" method="post">
<form action="input2.php" method="post">
<table border="0" align="center">

		<tr>
			<td>NIM</td>
			<td><input type="text/html" name="id_mhs" value="<?php echo $buff['id_mhs'];?>"/></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td><input type="text/html" name="nama" value="<?php echo $buff['nama'];?>"/></td>
		</tr>
		<tr>
			<td>Formatif</td>
			<td><input type="text/html" name="formatif" value="<?php echo $buff['formatif'];?>"/></td>
		</tr>
		<tr>
			<td>UTS</td>
			<td><input type="text/html" name="uts" value="<?php echo $buff['uts'];?>"/></td>
		</tr>
		<tr>
			<td>UAS</td>
			<td><input type="text/html" name="uas" value="<?php echo $buff['uas'];?>"/></td>
		</tr>
		<tr>
			<td width="68" align="right"><input type="reset" value="reset"/></td>
			<td><input type="submit" value="submit" /></td>
		</tr>
</table>
</form>
<?php
};
mysql_close();
?><br/>
</body>
</html>