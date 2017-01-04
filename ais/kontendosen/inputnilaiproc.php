<?php
include "koneksi.php";
$select = "select * from mahasiswa";
$hasil = mysql_query($select);

while($buff=mysql_fetch_array($hasil)){
$id_mahasiswa = "id_mahasiswa_".$buff['id'];
$nilai = "nilai_".$buff['id'];

if ($_POST[$nilai] >= 80)
{
	$huruf = "A";
	$predikat = "Sangat Baik";
}else if($_POST[$nilai] >= 70){
	$huruf = "B";
	$predikat = "Baik";
}else if($_POST[$nilai] >= 60){
	$huruf = "C";
	$predikat = "Cukup";
}else if($_POST[$nilai] >= 50){
	$huruf = "D";
	$predikat = "Buruk";
}else if($_POST[$nilai] < 50){
	$huruf = "E";
	$predikat = "Sangat Buruk";
}

$mysql = mysql_query("INSERT INTO nilai (id_matkul, id_dosen, id_mahasiswa, nilai, huruf, predikat) 
VALUES('$_POST[id_matkul]', '$_POST[id_dosen]', '$buff[id]', '$_POST[$nilai]', '$huruf', '$predikat')");

}

echo"<script>alert('Sukses Tambah Nilai');window.location.href='?module=home';</script>";

mysql_close();
?>