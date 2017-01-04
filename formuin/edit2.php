<?php
include"../formuin/koneksi.php";
if(isset($_POST['id'])){
	$edit="update register set 
	namadepan='$_POST[namadepan]',namabelakang='$_POST[namabelakang]', username='$_POST[username]', password='$_POST[password]', usia='$_POST[usia]', jk='$_POST[jk]', ttl='$_POST[ttl]', email='$_POST[email]', notel='$_POST[notel]' where id='$_POST[id]'";
$hasil=mysql_query($edit);
if($hasil){
	echo"<script>alert('DATA BERHASIL DIEDIT');window.location.href='lihat.php';</script>";
}} ?>