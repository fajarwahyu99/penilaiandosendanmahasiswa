<?php
include "koneksi.php";

$nama=$_POST['nama'];
$email=$_POST['email'];
$pesan=$_POST['pesan'];

$status=mysql_query ("insert into 
bukutamu (nama,email,pesan,tanggal) 
values('$nama','$email','$pesan',now())
");

if($status) {

		?>
    <script language="JavaScript"> 
		alert('berhasil terkirim'); 
		document.location='index.php'; 
		</script>
    <?php

		
    }else {
		?>
    <script language="JavaScript"> 
		alert('gagal'); 
		document.location='index.php'; 
		</script>
    <?php
}


?>