<?php
        include "koneksi.php";
		$kuliah = mysql_query("SELECT * FROM kuliah WHERE nipdosen = $_SESSION[nip]");      
    $mtdia = mysql_num_rows($kuliah);
	
if($mtdia==1){
    if(isset($_POST['nilai'])){
		
        $jumlah = mysql_fetch_array(mysql_query("SELECT jumlahedit FROM user WHERE nip = $_SESSION[nip]"));

        if($jumlah['jumlahedit']<=2){
            
			$input = "INSERT INTO mahasiswa (nim, nama_mhs, kode_matkul, nilai) VALUES ('$_POST[nim]','$_POST[nama_mhs]','$_POST[kode_matkul]','$_POST[nilai]')";
			
    		
			if(!mysql_query($input))
    			die (mysql_error());
				
				echo "<script>
    				alert('Penilaian Berhasil');
					window.location.href='?module=lihatnilai';
    			</script>";
				
    		if(!mysql_query($mysql))
    			die (mysql_error());
            if(!mysql_query($a))
                die (mysql_error());
    		
    		
        }else{
            echo "<script>
                    alert('Anda telah mencapai batas penilaian');
					window.location.href='?module=home';
                </script>";
        }
	}
    $nilai = mysql_fetch_array(mysql_query("SELECT nilai FROM mahasiswa WHERE nim = $_SESSION[nip]"));
    mysql_close();
?>
<h1>Penilaian</h1>
<table width="500px" border="0" align="center">
	<form method="post">
			<tr>
            	<td width="190px">NIM</td>
                <td width="10px">:</td>
                <td width="300px"><input type="text" name="nim" required /></td>
            </tr>
            <tr>
            	<td>Nama Mahasiswa</td>
                <td>:</td>
                <td><input type="text" name="nama_mhs" required /></td>
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