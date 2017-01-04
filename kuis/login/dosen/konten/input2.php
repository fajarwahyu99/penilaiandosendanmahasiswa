<?php
include"../koneksi/koneksi.php";
if(isset($_POST['id_mhs'])){
	$edit="update mhs set formatif='$_POST[formatif]', uts='$_POST[uts]',uas='$_POST[uas]'
	where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	$id=$_POST['id_mhs'];
	$pilih="select * from mhs where id_mhs='$id'";
	$select = mysql_query($pilih);
	$syarat = mysql_fetch_array($select);

	$formatif = $syarat['formatif']*30/100;
	$uts = $syarat['uts']*30/100;
	$uas = $syarat['uas']*40/100;
	
	$total = $formatif + $uts + $uas;
	
	$edit="update mhs set total_nilai='$total' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	$id=$_POST['id_mhs'];
	$pilih="select * from mhs where id_mhs='$id'";
	$select = mysql_query($pilih);
	$syarat = mysql_fetch_array($select);
	
	$total = $syarat['total_nilai'];
	
if($total > 79){
	
	$edit="update mhs set nilai_huruf='A', predikat='Sangat baik' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	echo"<script>alert('data berhasil diedit');window.location.href='../indexuser.php?module=daftarnilai#pos';</script>";
	}
	else if($total > 69 && $total < 80){
	
	$edit="update mhs set nilai_huruf='B', predikat='Baik' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	echo"<script>alert('data berhasil diinput');window.location.href='../indexuser.php?module=daftarnilai#pos';</script>";
	}
	else if($total > 59 && $total < 70){
	
	$edit="update mhs set nilai_huruf='C', predikat='Cukup' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	echo"<script>alert('data berhasil diinput');window.location.href='../indexuser.php?module=daftarnilai#pos';</script>";
	}
	else if($total > 49 && $total < 60){
	
	$edit="update mhs set nilai_huruf='D', predikat='Buruk' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	echo"<script>alert('data berhasil diinput');window.location.href='../indexuser.php?module=daftarnilai#pos';</script>";
	}
	else {
	
	$edit="update mhs set nilai_huruf='E', predikat='Sangat buruk' where id_mhs='$_POST[id_mhs]'";
	$hasil=mysql_query($edit);
	
	echo"<script>alert('data berhasil diinput');window.location.href='../indexuser.php?module=daftarnilai#pos';</script>";
	}
}
?>