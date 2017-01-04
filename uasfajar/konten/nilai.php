<?php
	include "koneksi.php";
	// $id = $_SESSION['id_user'];

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
$asd = "INSERT INTO nilai (id_mhs, id_matkul, formatif, uts, uas, nilai, huruf, predikat) 
VALUES ('$_POST[id_mhs]', '$_POST[id_matkul]', $_POST[formatif], $_POST[uts], $_POST[uas], $nilai, '$huruf', '$predikat')";
mysql_query($asd); 

echo"<script>alert('Nilai Sudah Di Terima');window.location.href='?module=inputnilai';</script>";
mysql_close();

?>
