

<!-- 
// 	include "koneksi.php";
// 	$id = $_SESSION['id_user'];

// $nilai= ($_POST['formatif']*0.3)+($_POST['uts']*0.3)+($_POST['uas']*0.4);
// if ($nilai >=80 && $nilai<=100){
// 	$huruf="A";
// 	$predikat="Sangat Baik";
// }
// else if ($nilai >=70 && $nilai<=79){
// 	$huruf="B";
// 	$predikat="Baik";
// }
// else if ($nilai >=60 && $nilai<=69){
// 	$huruf="C";
// 	$predikat="Cukup";
// }
// else if ($nilai >=50 && $nilai<=59){
// 	$huruf="D";
// 	$predikat="Buruk";
// }
// else if ($nilai <50){
// 	$huruf="E";
// 	$predikat="Sangat Buruk";
// }
$asd = "UPDATE nilai (id_mhs, id_matkul, formatif, uts, uas, nilai, huruf, predikat) 
 SET ('$_POST[id_mhs]', '$_POST[id_matkul]', $_POST[formatif], $_POST[uts], $_POST[uas], $nilai, '$huruf', '$predikat') WHERE id_nilai='$_POST[id]'";
 mysql_query($asd); 

// // echo"<script>alert('Nilai Sudah Di Terima');window.location.href='?module=home';</script>";
// // mysql_close();

// $id = $_SESSION['id_user'];
// // $a=$GET['id_nilai'];
// 	$dosen = mysql_query("select * from user");
// 	$edit = "SELECT * FROM nilai where id_nilai='$_GET[a]'";
//     if(isset($_POST['id_nilai'])){
	
//         $jumlah = mysql_fetch_array(mysql_query("SELECT jumlahedit FROM user WHERE id_user = '$_SESSION[id_user]'"));
//         if($jumlah['jumlahedit']<2){
// 		$edit="UPDATE nilai SET formatif='$_POST[formatif]', uts='$_POST[uts]', uas='$_POST[uas]' WHERE id_nilai='$_POST[id_nilai]'";
// 		$hasil = mysql_query($edit);
//    $now = $jumlah['jumlahedit']+1;
// 	$update = mysql_query("UPDATE user SET jumlahedit='$now' where id_user='$_SESSION[id_user]'");
	
// 				echo"<script>
//     				alert('EDIT Berhasil');
// 					window.location.href='?module=inputnilai';
//     			</script>";

//         }else{
//             echo "<script>
//                     alert('Anda telah mencapai batas penilaian');
// 					window.location.href='?module=home';
//                 </script>";
//         }
// 		}
// 		$id=$_GET['id'];
// 	$select="SELECT * FROM mahasiswa WHERE id_nilai='$id'";
// 	$hasil=mysql_query($select);
// 	$buff=mysql_fetch_array($hasil);
		
// 
 -->

 <?php
	include "koneksi.php";
		// $id = $_SESSION['id_user'];
	$id = $_SESSION['id_user'];
	$dosen = mysql_query("select * from user");
	$edit = "SELECT * FROM nilai where id_nilai='$_GET[id]'";

    if(isset($_POST['id_nilai'])){
	
        $jumlah = mysql_fetch_array(mysql_query("SELECT jumlahedit FROM user WHERE id_user = '$_SESSION[id_user]'"));
        
        if($jumlah['jumlahedit']<9){
		$nilai= ($_POST['formatif']*0.3)+($_POST['uts']*0.3)+($_POST['uas']*0.4);
if ($nilai >=80 && $nilai<=100){
	$huruf="A";
	$predikat="Sangat Baik";
}
else if ($nilai >=70 && $nilai<=79){
	$huruf="B";
	$predikat="Baik";
}
else if ($nilai >=60 && $nilai<=69){
	$huruf="C";
	$predikat="Cukup";
}
else if ($nilai >=50 && $nilai<=59){
	$huruf="D";
	$predikat="Buruk";
}
else if ($nilai <50){
	$huruf="E";
	$predikat="Sangat Buruk";
}
		// $edit="UPDATE nilai SET formatif='$_POST[formatif]', uts='$_POST[uts]', uas='$_POST[uas]' WHERE id_nilai='$_POST[id_nilai]'";
		// $asd = mysql_query($edit);
$edit = "UPDATE nilai ( formatif, uts, uas, nilai, huruf, predikat) SET ( $_POST[formatif], $_POST[uts], $_POST[uas], $nilai, '$huruf', '$predikat') WHERE id_nilai='$_POST[id_nilai]'";
 $asd=mysql_query($edit); 
   $now = $jumlah['jumlahedit']+1;
	$update = mysql_query("UPDATE user SET jumlahedit='$now' where id_user='$_SESSION[id_user]'");
	
				echo"<script>
    				alert('EDIT Berhasil');
					window.location.href='?module=inputnilai';
    			</script>";

        }else{
            echo "<script>
                    alert('Anda telah mencapai batas penilaian');
					window.location.href='?module=home';
                </script>";
        }
		}
		
// 		 $nilai= ($_POST['formatif']*0.3)+($_POST['uts']*0.3)+($_POST['uas']*0.4);
// if ($nilai >=80 && $nilai<=100){
// $huruf="A";
// $predikat="Sangat Baik";
// }
// else if ($nilai >=70 && $nilai<=79){
// 	$huruf="B";
// 	$predikat="Baik";
// }
// else if ($nilai >=60 && $nilai<=69){
// 	$huruf="C";
// 	$predikat="Cukup";
// }
// else if ($nilai >=50 && $nilai<=59){
// 	$huruf="D";
// 	$predikat="Buruk";
// }
// else if ($nilai <50){
// 	$huruf="E";
// 	$predikat="Sangat Buruk";
// }
	
	
	// $id=$_GET['id_user'];
	$select="SELECT * FROM nilai WHERE id_nilai='$id'";
	$hasil=mysql_query($select);
	$buff=mysql_fetch_array($hasil);
?>


<h1>Edit Nilai</h1>
<form method="post">
<input type="hidden" name="id_nilai" value="<?php echo $buff['id_nilai'];?>"/>
<table align="center">
<!-- <tr>
<td width="200px">NIM</td>
<td width="5px">:</td>
<td width="200px"><input type="text" value="<?php echo $buff['id_nilai'];?>" name="nim" required/></td>
</tr> -->
<!-- <tr>
<td>Nama Mahasiswa</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['nama_mhs'];?>" name="nama_mhs" required/></td>
</tr> -->
<tr>
<td>Formatif</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['formatif'];?>"name="formatif" required/></td>
</tr>
<tr>
<td>UTS</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['uts'];?>"name="uts" required/></td>
</tr>
<tr>
<td>UAS</td>
<td>:</td>
<td><input type="text" value="<?php echo $buff['uas'];?>"name="uas" required/></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="button" type="submit" value="Submit"/></td>
</tr>
</table>
</form>