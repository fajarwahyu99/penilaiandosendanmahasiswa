<?php

		$matkul = mysql_query("SELECT * FROM matkul WHERE id_user = '$_SESSION[id]' ") or die(mysql_error());
		$tampil_matkul = mysql_fetch_array($matkul);
 		$user = mysql_query("SELECT * FROM user WHERE id_user = '$_SESSION[id]' ")or die(mysql_error());
		$tampil_user = mysql_fetch_array($user);

?> 

<h1>Daftar Nilai <?php echo $tampil_matkul['nama_matkul'];?></h1><br />
<h1>Mahasiswa : <?php echo $tampil_user['nama'];?></h1>
	<br />
	<table border="1">
    	<tr>
        	
            <th>Matkul</th>
            <th>SKS</th>
            <th>Dosen</th>
            <th>Formatif</th>
            <th>UTS</th>
            <th>UAS</th>
           	<th>Nilai Total</th>
            <th>Huruf</th>
            <th>Predikat</th>     
</tr>

<?php
	include "koneksi.php";
		$total_sks = 0;
				$total_nilai = 0;
	$hasil=mysql_query("SELECT * FROM nilai");
	while($aray = mysql_fetch_array($hasil)){
		
		
	$matkul = mysql_query("SELECT * FROM matkul WHERE id_matkul = '$aray[id_matkul]'") or die(mysql_error());
	$buff = mysql_fetch_array($matkul);
	
	$dosen = mysql_query("SELECT * FROM user WHERE id_user = '$buff[id_user]'")or die(mysql_error());
	$terambil = mysql_fetch_array($dosen);
	
	$sks = $buff['sks'];
	$huruf = $aray['huruf'];
	if($huruf=="A"){
		$nipk = 4;
	}
	else if($huruf=="B"){
		$nipk = 3;
	}
	else if($huruf=="C"){
		$nipk = 2;
	}
	else if($huruf=="D"){
		$nipk = 1;
	}
	
	else if($huruf=="E"){
		$nipk = 0;
	}
	$nilai = $nipk * $sks;
	$total_nilai = $total_nilai + $nilai;
	$total_sks = $total_sks + $sks;
		?>

<tr>
			<td align="center"><?php echo $buff['nama_matkul']; ?></td>
            <td align="center"><?php echo $buff['sks']; ?></td>
            <td align="center"><?php echo $terambil['nama']; ?></td>
			<td align="center"><?php echo $aray['formatif']; ?></td>
			<td align="center"><?php echo $aray['uts']; ?></td>
			<td align="center"><?php echo $aray['uas']; ?></td>
			<td align="center"><?php echo $aray['nilai']; ?></td>
			<td align="center"><?php echo $aray['huruf']; ?></td>
            <td align="center"><?php echo $aray['predikat']; ?></td>
</tr>

<?php
};
?>
</table>

<?php
$ipk = $total_nilai / $total_sks;
$update = mysql_query("UPDATE mhs set ipk='$ipk' WHERE id='$_SESSION[id]'");
?>
<br><br>
<h1>IPK : <?php echo $ipk;?></h1>
