<?php
//mulai proses edit data

//cek dahulu, jika tombol simpan di klik
	$TOT_SU=$TOT_SU+1;
	//inlcude atau memasukkan file koneksi ke database
	include('koneksi.php');
	
	
	//melakukan query dengan perintah UPDATE untuk update data ke database dengan kondisi WHERE no_urut='$no_urut' <- diambil dari inputan hidden id
	$update = mysql_query("UPDATE siswa SET TOT_SU='TOT_SU+$a' WHERE no_urut='1'") or die(mysql_error());
	
	
//jika query update sukses
	if($update){
		
		echo 'Data berhasil di simpan! ';		//Pesan jika proses simpan sukses
		echo '<a href="index.php'.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit
		
	}else{
		
		echo 'Gagal menyimpan data! ';		//Pesan jika proses simpan gagal
		echo '<a href="index.php'.$id.'">Kembali</a>';	//membuat Link untuk kembali ke halaman edit
		
	}


?>