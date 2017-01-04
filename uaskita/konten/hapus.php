<?php 
	include "koneksi.php";
	$proses = "DELETE FROM kuliah where id='$_GET[id]'";
	$hasil = mysql_query($proses);
	if($hasil){
		echo "<script>alert('DATA BERHASIL DIHAPUS');window.location.href='../index.php?module=admin'</script>";
	}
	
 ?>