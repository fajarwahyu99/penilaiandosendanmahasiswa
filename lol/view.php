<?php 
include"koneksi/koneksi.php";
?>
<html xmlns="http://wwww.w3.org/1999/xhtml">
<head>
<title>ADMIN</title>

	<link href="style/style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="container">
		<div id="header">
		</div>

		<div id="sidebar">
			<h3>navigasi</h3>
			<ul id="navmenu">
				<li><a href="index.php">HOME</a></li>
				<li><a href="?module=kontak#pos">KONTAK</a></li>
				<li><a href="?module=about#pos">ABOUT</a></li>
			</ul>
					<div id="login"><pre>
<form action="?module=loginproc#pos" method="post">			
USERNAME
<input type="text" name="username"/>

PASSWORD
<input type="password" name="password"/>
<input type="submit" value="LOGIN"/>
</form>
<a href="index1.php"><input type="submit" value="REGISTER"/></a>
</pre>
</div>
		</div>
		

			<div id="page"><?php if(isset($_GET['module']))
			include"konten/$_GET[module].php";
			else
			include "konten/home.php";?>
		<center> <h1>Data User</h1>

<?php 
if (!empty($_GET['message']) && $_GET['message'] == 'success') {
	echo '<h3>Berhasil meng-update data!</h3>';
} else if (!empty($_GET['message']) && $_GET['message'] == 'delete') {
	echo '<h3>Berhasil menghapus data!</h3>';
}
?>

<a href="index1.php">+ Tambah Admin Baru</a>

<table border="1" cellpadding="5" cellspacing="0">
	<thead>
    	<tr>
        	<td>No.</td>
        	<td>Username</td>
        	<td>Password</td>
			<td>Nama Lengkap</td>
			<td>Email</td>
			<td>OPSI</td>
        </tr>
    </thead>
    <tbody>
    <?php 
	$query = mysql_query("select * from user");
	
	$no = 1;
	while ($data = mysql_fetch_array($query)) {
	?>
    	<tr>
        	<td><?php echo $no; ?></td>
        	<td><?php echo $data['username']; ?></td>
        	<td><?php echo $data['password']; ?></td>
			<td><?php echo $data['namalengkap']; ?></td>
			<td><?php echo $data['email']; ?></td>
            <td>
            	<a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a> || 
                <a href="delete.php?id=<?php echo $data['id']; ?>">Hapus</a>
            </td>
        </tr>
    <?php 
		$no++;
	} 
	?>
    </tbody>
</table>
<a href='?module=logout#pos'><input type="submit" value="KELUAR"/></a>
</center>
		</div>

			<div id="clear"></div>
		
			<div id="footer">
				<p>&copy; 2010</p>
			</div>

</div>
</body>
</html>