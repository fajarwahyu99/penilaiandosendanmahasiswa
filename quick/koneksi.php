<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "pilkada";
$koneksi=@mysql_connect($host,$user,$password);
if(!$koneksi){
    echo "Gagal melakukan koneksi <br/>:".mysql_error();
    exit();
    
}
$pilihdb=@mysql_select_db($db,$koneksi);
if(!$pilihdb){
    exit ("Gagal melakukan hubungan dengan database<br> Kesalahan :".mysql_error());
}
?>
