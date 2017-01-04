<?php
include"koneksi.php";
$select = "select * from mata_kuliah";
$hasil = mysql_query($select);
    if (isset($_GET['cari'])){
        $dosen=$_GET['cari'];
        $pilih="select * from mata_kuliah where dosen like '%$dosen%'";
        $hasil=mysql_query($pilih);
    }
    else{
        $hasil=mysql_query($select);
    }
?>
<h3 align="center">Data Mata Kuliah</h3>
<!--Table Matkul-->
<table align="center" border="1px">
<thead align="center" style="background:#eee;font-size:14;">
<tr>
    <th style="text-align:center;" width="50">No</th>
	<th style="text-align:center;" width="200">Dosen</th>
	<th style="text-align:center;" width="200">Pelajaran</th>
	<th style="text-align:center;" width="200">Jam</th>
	<th style="text-align:center;" width="auto">Tempat</th>
</tr>
</thead>
<?php
    	$no = 1;
	while($buff=mysql_fetch_array($hasil)){
	$dosen = mysql_fetch_array(mysql_query("SELECT * FROM dosen WHERE id = '$buff[id_dosen]'"));
?>
<tbody>
<tr>
    <td style="text-align:center;"><?php echo $no?></td>
	<td><?php echo $dosen['nama'];?></td>
	<td><?php echo $buff['pelajaran'];?></td>
	<td><?php echo $buff['jam'];?></td>
	<td><?php echo $buff['tempat'];?></td>
</tr>
</tbody><?php $no++;};?>
</table>
<!--End table Matkul-->