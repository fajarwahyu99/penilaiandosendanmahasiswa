<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>UIN JAKARTA</title>
</head>

<body>
<h1>Daftar Mata Kuliah</h1><br />
<?php
include"koneksi.php";

	if(isset($_POST['kode'])){
		if(isset($_GET['aksi'])&&$_GET['aksi']=="edit"){
		$hasil=mysql_query("UPDATE kuliah SET kode='$_POST[kode]',nipdosen='$_POST[nipdosen]',matkul='$_POST[matkul]' WHERE kode = $_POST[kode]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diedit');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diedit');</script>";
			}
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
	$hasil=mysql_query("DELETE FROM kuliah WHERE kode=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}
$select="SELECT * FROM kuliah";
$hasil=mysql_query($select);
?>
<table border="1">
    	<tr>
        	<th>Kode Mata Kuliah</th>
            <th>NIP Dosen</th>
            <th>Mata Kuliah</th>
            <th colspan="2">Aksi</th>
		</tr>
<?php
	$hasil=mysql_query("SELECT * FROM kuliah");
	while($aray = mysql_fetch_array($hasil)){?>
		<tr>
			<td align="center"><?php echo $aray['kode']; ?></td>
			<td align="center"><?php echo $aray['nipdosen']; ?></td>
			<td align="center"><?php echo $aray['matkul']; ?></td>
            
			<td align="center"><a href="index.php?module=editmatkul&aksi=edit&id=<?php echo $aray['kode']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=lihatmatkul&aksi=hapus&id=<?php echo $aray['kode']; ?>">Hapus</a></td>
		</tr>
	<?php }
	mysql_close();
?></table><br />
</body>
</html>