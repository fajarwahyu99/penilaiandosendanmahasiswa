<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>UIN JAKARTA</title>
</head>

<body>
<h1>Daftar Nilai</h1><br />
<?php
include"koneksi.php";
if(isset($_POST['nim'])){
	if(isset($_GET['aksi'])&&$_GET['aksi']=="edit"){
		$hasil=mysql_query("UPDATE mahasiswa SET nim='$_POST[nim]', nama_mhs='$_POST[nama_mhs]', nilai='$_POST[nilai]' WHERE nim = $_POST[nim]");
		if($hasil){
			echo"<script>alert('Data Berhasil Diedit');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Diedit');</script>";
			}
		}
	}
	else if(isset($_GET['aksi'])&&$_GET['aksi']=="hapus"){
	$hasil=mysql_query("DELETE FROM mahasiswa WHERE nim=$_GET[id]");
		if($hasil){
			echo"<script>alert('Data Berhasil Dihapus');</script>";
		}
		else{
			echo"<script>alert('Data Gagal Dihapus');</script>";
		}
	}
$select="SELECT * FROM mahasiswa";
$hasil=mysql_query($select);
?>
<table border="1">
    	<tr>
        	<th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Nilai</th>
            <th>Huruf</th>
            <th>Predikat</th>
            <th colspan="2">Aksi</th>
		</tr>
<?php
	$hasil=mysql_query("SELECT * FROM mahasiswa");
	while($aray = mysql_fetch_array($hasil)){?>
		<tr>
			<td align="center"><?php echo $aray['nim']; ?></td>
			<td align="center"><?php echo $aray['nama_mhs']; ?></td>
            <td align="center"><?php echo $aray['nilai'];?></td>
            <td align="center"><?php echo nhuruf($aray['nilai']);?></td>
            <td align="center"><?php echo npredikat($aray['nilai']);?></td>
			<td align="center"><a href="index.php?module=editnilai&id=<?php echo $aray['nim']; ?>">Edit</a></td>
            <td align="center"><a href="index.php?module=lihatnilai&aksi=hapus&id=<?php echo $aray['nim']; ?>">Hapus</a></td>
		</tr>
	<?php }
	mysql_close();
?></table><br />
</body>
</html>
<?php
function nhuruf($nilai){
if($nilai>=80){
                echo "A";
            }else if($nilai>=70){
                echo "B";
            }else if($nilai>=60){
                echo "C";
            }else if($nilai>=50){
                echo "D";
            }else{
                echo "E";
            }
	}
	function npredikat($nilai){
if($nilai>=80){
                echo "Sangat Baik";
            }else if($nilai>=70){
                echo "Baik";
            }else if($nilai>=60){
                echo "Cukup";
            }else if($nilai>=50){
                echo "Buruk";
            }else{
                echo "Sangat Buruk";
            }
	}
?>