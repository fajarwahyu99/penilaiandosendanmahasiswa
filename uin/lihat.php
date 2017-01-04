<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title> Lihat Hasil </title>
</head>

<body>
<h2>Daftar Member</h2><br>

<?php
include"../uin/koneksi.php";
$select="select * from register";
$hasil=mysql_query($select);
?>

<table width="1124" border="1">
<tr>
	<td width="31">id</td>
	<td width="85">Nama Depan</td>
	<td width="99">Nama Belakang</td>
	<td width="82">Username</td>
	<td width="87">Password</td>
	<td width="41">Usia</td>
	<td width="41">JK</td>
	<td width="128">TTL</td>
	<td width="182">Email</td>
	<td width="152">Notel</td>
	<td colspan="2">AKSI</td>
</tr>
</table>

<?php
while($buff=mysql_fetch_array($hasil)){
	?>
	<table width="1200" border="1">
<tr>
	<td width="31"><?php echo $buff['id'];?></td>
	<td width="85"><?php echo $buff['namadep'];?></td>
	<td width="99"><?php echo $buff['namabel'];?></td>
	<td width="82"><?php echo $buff['username'];?></td>
	<td width="87"><?php echo $buff['password'];?></td>
	<td width="41"><?php echo $buff['usia'];?></td>
	<td width="41"><?php echo $buff['jk'];?></td>
	<td width="128"><?php echo $buff['ttl'];?></td>
	<td width="182"><?php echo $buff['email'];?></td>
	<td width="152"><?php echo $buff['notel'];?></td>
	<td width="100"><a href="edit.php?id=<?php echo $buff['id'];?>">EDIT</a></td>
	<td width="96"><a href="hapus.php?id=<?php echo $buff['id'];?>">HAPUS</a></td>
	</tr>
	</table>
<?php
	};
mysql_close();
?><br>
<a href="../uin/index.php"><---- Kembali Ke Register </a>
</body>
</html>


