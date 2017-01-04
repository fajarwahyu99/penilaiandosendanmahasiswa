<?php
include"koneksi.php";
$dosen = mysql_fetch_array(mysql_query("SELECT * FROM dosen WHERE username = '$_SESSION[username]'"));
$select = "select * from nilai where id_dosen = '$dosen[id]'";
$hasil = mysql_query($select);
?>
<h3 align="center">Data Mata Kuliah</h3>
<!--Table Matkul-->
<table align="center" border="1px">
<thead align="center" style="background:#eee;font-size:14;">
<tr>
    <th style="text-align:center;" width="50">No</th>
	<th style="text-align:center;" width="200">Nama Mahasiswa</th>
	<th style="text-align:center;" width="200">Mata Kuliah</th>
	<th style="text-align:center;" width="200">Nilai</th>
	<th style="text-align:center;" width="auto">Huruf</th>
	<th style="text-align:center;" width="auto">Predikat</th>
</tr>
</thead>
<?php
    	$no = 1;
	while($buff=mysql_fetch_array($hasil)){
	$mahasiswa = mysql_fetch_array(mysql_query("SELECT * FROM mahasiswa WHERE id = '$buff[id_mahasiswa]'"));
	$matkul = mysql_fetch_array(mysql_query("SELECT * FROM mata_kuliah WHERE id = '$buff[id_matkul]'"));
?>
<tbody>
<tr>
    <td style="text-align:center;"><?php echo $no?></td>
	<td><?php echo $mahasiswa['nama'];?></td>
	<td><?php echo $matkul['pelajaran'];?></td>
	<td><?php echo $buff['nilai'];?></td>
	<td><?php echo $buff['huruf'];?></td>
	<td><?php echo $buff['predikat'];?></td>
</tr>
</tbody><?php $no++;};?>
</table>
<!--End table Matkul-->