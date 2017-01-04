<?php
	if(isset($_POST['nip'])){
	include "koneksi.php";
	$mysql="INSERT INTO user (nip, nama, ttl, alamat, notelp, username, password) VALUES ('$_POST[nip]', '$_POST[nama]', '$_POST[ttl]', '$_POST[alamat]', '$_POST[notelp]', '$_POST[username]', '$_POST[password]')";
	
	if(!mysql_query($mysql))
	die (mysql_error());
	echo"<script>alert('Selamat, anda telah terdaftar mohon menunggu konfirmasi dari admin');</script>";
	mysql_close();
	}
?>

<h1>Registrasi</h1>
<table width="500px" border="0" align="center">
	<form method="post">
        	<tr>
            	<td width="190px">NIP</td>
                <td width="10px">:</td>
            	<td width="300px"><input type="text" name="nip" required /></td>
            </tr>
            <tr>
            	<td>Nama</td>
                <td>:</td>
            	<td><input type="text" name="nama" required /></td>
            </tr>
            <tr>
            	<td>Tempat Tanggal Lahir</td>
                <td>:</td>
            	<td><input type="text" name="ttl" required /></td>
            </tr>
			<tr>
            	<td>Nomor Telepon</td>
                <td>:</td>
            	<td><input type="text" name="notelp" required /></td>
            </tr>
            <tr>
            	<td>Alamat</td>
                <td>:</td>
            	<td><input type="text" name="alamat" required /></td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="username" required /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" name="password" required /></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            </tr>
            <tr>
            	<td align="right"><input class="button" type="reset" value="Reset" /></td>
                <td align="right"><input class="button" type="submit" value="Input" /></td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </form>