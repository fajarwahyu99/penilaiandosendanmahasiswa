<?php
//mengabaikan pesan Notice
error_reporting(E_ALL ^ (E_NOTICE));
 
//melakukan koneksi ke database dengan MySQLi
$koneksi = new mysqli("localhost", "root", "", "untukdesti");
if($koneksi->connect_errno) {
	echo "Gagal melakukan koneksi ke MySQL: " . $koneksi->connect_error;
}
?>