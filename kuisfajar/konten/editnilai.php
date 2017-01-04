<?php
	include "koneksi.php";
	$nip = $_SESSION['nip'];
	$dosen = mysql_query("select * from user");
	$edit = "SELECT * FROM mahasiswa where nim='$_GET[id]'";
    if(isset($_POST['nim'])){
	
        $jumlah = mysql_fetch_array(mysql_query("SELECT jumlahedit FROM user WHERE nip = '$_SESSION[nip]'"));
        if($jumlah['jumlahedit']<2){
		$edit="UPDATE mahasiswa SET nim='$_POST[nim]', nama_mhs='$_POST[nama_mhs]', nilai='$_POST[nilai]' WHERE nim='$_POST[nim]'";
		$hasil = mysql_query($edit);
   $now = $jumlah['jumlahedit']+1;
	$update = mysql_query("UPDATE user SET jumlahedit='$now' where nip='$_SESSION[nip]'");
	
				echo"<script>
    				alert('EDIT Berhasil');
					window.location.href='?module=lihatnilai';
    			</script>";

        }else{
            echo "<script>
                    alert('Anda telah mencapai batas penilaian');
					window.location.href='?module=home';
                </script>";
        }
		}
		
	
	
	
	$id=$_GET['id'];
	$select="SELECT * FROM mahasiswa WHERE nim='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>
<h1>Edit Nilai</h1>
<form method="post">
<input type="hidden" name="nim" value="<?php echo $buff['nim'];?>"/>
<table align="center">
<tr>
<td width="200px">NIM</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['nim'];?>" name="nim" required/></td>
</tr>
<tr>
<td>Nama Mahasiswa</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nama_mhs'];?>" name="nama_mhs" required/></td>
</tr>
<tr>
<td>Nilai</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nilai'];?>"name="nilai" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>