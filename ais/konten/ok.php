<?php
include"koneksi.php";
if(isset($_POST['id'])){
$edit="update dosen set
nama='$_POST[nama]',status='$_POST[status]',username='$_POST[username]',password='$_POST[password]',alamat='$_POST[alamat]',email='$_POST[email]',notel='$_POST[notel]',tanggal_login='$_POST[tanggal_login]',total_login='$_POST[total_login]' where id='$_POST[id]'";
$hasil=mysql_query($edit);
if($hasil) {
	echo"<script>alert('Data Berhasil di Edit');window.location.href='?module=tabeldosen';</script>";
}
}
?>