<?php
include "koneksi.php";
$mysql = "INSERT INTO wilayah_kel (id_wilayahkel, kelurahan, jml_DPTkel, hakpilih_kel, s1_kel, s2_kel, s3_kel, suara_sahkel, suara_tdksahkel, total_suarakel) VALUES ('$_POST[kelurahan]', '$_POST[jml_DPTkel]', '$_POST[hakpilih_kel]', '$_POST[s1_kel]', '$_POST[s2_kel]','$_POST[s3_kel]','$_POST[suara_sahkel]','$_POST[suara_tdksahkel]','$_POST[total_suarakel]')";
if(!mysql_query($mysql))
die (mysql_error());
echo"<script>alert('Data Berhasil Ditambahkan');window.location.href='?module=rekap';</script>";
mysql_close();
?>