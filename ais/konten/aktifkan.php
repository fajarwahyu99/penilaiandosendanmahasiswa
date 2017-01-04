<?php
include "koneksi.php";
$get = mysql_query("SELECT * FROM dosen WHERE id='$_GET[id]'");
$buff = mysql_fetch_array($get);
$status = $buff['status'];
$update = mysql_query("UPDATE dosen SET status='aktif'");
if($update){
    echo"<script>alert('Status sukses diubah');window.location.href='?module=tabeldosen';</script>";
}else
{
	mysql_error();
}
?>