<?php
        include "koneksi.php";
		$kuliah = mysql_query("SELECT * FROM kuliah WHERE nipdosen = '$_SESSION[nip]'");      
    $mtdia = mysql_num_rows($kuliah);
	
if($mtdia==1){
    if(isset($_POST['nilai'])){
		
        $jumlah = mysql_fetch_array(mysql_query("SELECT jumlahedit FROM user WHERE nip = '$_SESSION[nip]'"));
        if($jumlah['jumlahedit']<1){
		$input = "INSERT INTO mahasiswa (nim, nama_mhs, kode_matkul, nilai) VALUES ('$_POST[nim]','$_POST[nama_mhs]','$_POST[kode_matkul]','$_POST[nilai]')";
   if(!mysql_query($input))
    			die (mysql_error());

   $now = $jumlah['jumlahedit']+1;
	$update = mysql_query("UPDATE user SET jumlahedit='$now' where nip='$_SESSION[nip]'");
	
				echo"<script>
    				alert('Penilaian Berhasil');
					window.location.href='?module=lihatnilai';
    			</script>";

        }else{
            echo "<script>
                    alert('Anda telah mencapai batas penilaian');
					window.location.href='?module=home';
                </script>";
        }
	}
    $nilai = mysql_query("SELECT nilai FROM mahasiswa WHERE nim = $_SESSION[nip]");
    mysql_close();
?>
<h1>Penilaian</h1>
<table width="500px" border="0" align="center">
	<form method="post">
			<tr>
            	<td width="190px">NIM</td>
                <td width="10px">:</td>
                <td width="300px"><select name="nim"><?php  
include "koneksi.php";
$query="SELECT * FROM user WHERE status='Mahasiswa'";
$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
while($buff=mysql_fetch_array($hasil)){
 ?> 
        <option value="<?php echo $buff['nip'];?>"> <?php echo $buff['nip'];?> </option>
   <?php  }   
   ?>
        </select></td>
            </tr>
            <tr>
        <td hidden>Nama Mahasiswa</td>
        <td hidden>:</td>
        <td><input type="text" name="nama_mhs" hidden/></td>
    </tr>
        	<tr>
            	<td>Nilai</td>
                <td>:</td>
            	<td><input type="text" name="nilai" value="<?php echo $nilai['nilai']; ?>" required /></td>
            </tr>
            <tr>
            	<td align="right"><input class="button" type="reset" value="Reset" /></td>
                <td>&nbsp;</td>
            	<td><input class="button" type="submit" value="Input" /></td>
            </tr>
        </table>
    </form>
    <?php } else {
        echo"
                <script>
                    alert('Anda belum mengajar');
                    window.location.href='?module=home';
                </script>";
    }?>