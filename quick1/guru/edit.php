<!DOCTYPE html>
<center><html>
<head>
	<title>QUICK COUNT PEMILIHAN KETUA OSIS PERIODE 2016/2017</title>
</head>
<body bgcolor="#fff666">
<?php
	//proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

	//include atau memasukkan file koneksi ke database
	include('koneksi.php');

	//membuat variabel $id yg nilainya adalah dari URL GET id -> pilih.php?id=no_urut
	$id = $_GET['no_urut'];

	//melakukan query ke database dg SELECT table siswa dengan kondisi WHERE no_urut = '$id'
	$show = mysql_query("SELECT * FROM siswa WHERE no_urut='$id'");

	session_start();
	$_SESSION['id'] = $id;

	?>

	<h2>QUICK COUNT PEMILIHAN KETUA OSIS PERIODE 2016/2017</h2>

	<p><a href="guru.php">Beranda</a> / <a href="tambah.php">Tambah Data</a></p>

	<h3>Tambah Data Siswa</h3>

	<form action="tambah.php" method="post">
		<table cellpadding="3" cellspacing="0">

				<td>Status</td>
				<td>:</td>
				<td>
					<select name="status" required>
						<option value="">Pilih Status</option>
						<option value="guru">Guru</option>

					</select>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td></td>
				<input type="hidden" name="name" value="<?php echo $_SESSION['id']; ?>">
				<td><input type="submit" name="tambah" value="Tambah"></td>
			</tr>
		</table>
	</form>
</body>
</html>