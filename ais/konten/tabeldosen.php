<?php
include"koneksi.php";
$select = "select * from dosen";
$hasil = mysql_query($select);
    if (isset($_GET['cari'])){
        $nama=$_GET['cari'];
        $pilih="select * from dosen where nama like '%$nama%'";
        $hasil=mysql_query($pilih);
    }
    else{
        $hasil=mysql_query($select);
    }
?>
<h3 align="center">Data Dosen</h3>
<!--Table Dosen-->
<table align="center" border="1px">
<thead align="center" style="background:#eee;font-size:14;">
<tr>
    	<th style="text-align:center;" width="50">No</th>
	<th style="text-align:center;" width="200">Nama</th>
	<th style="text-align:center;" width="auto">Status</th>
	<th style="text-align:center;" width="auto">Username</th>
	<th style="text-align:center;" width="auto">Password</th>
    	<th style="text-align:center;" width="auto">Alamat</th>
	<th style="text-align:center;" width="auto">Email</th>
	<th style="text-align:center;" width="auto">No. Telp</th>
	<th style="text-align:center;" width="auto">Tanggal Login</th>
	<th style="text-align:center;" width="auto">Total Login</th>
	<th style="text-align:center;" colspan="4">Aksi</th>
</tr>
</thead>
<?php
    	$no = 1;
	while($buff=mysql_fetch_array($hasil)){
?>
<tbody>
<tr>
    <td style="text-align:center;"><?php echo $no?></td>
	<td><?php echo $buff['nama'];?></td>
	<td><?php echo $buff['status'];?></td>
	<td><?php echo $buff['username'];?></td>
	<td><?php echo $buff['password'];?></td>
	<td><?php echo $buff['alamat'];?></td>
	<td><?php echo $buff['email'];?></td>
	<td><?php echo $buff['notel'];?></td>
    <td><?php echo $buff['tanggal_login'];?></td>
	<td><?php echo $buff['total_login'];?></td>
	<td align="center" width="80"><a href="?module=aktifkan&id=<?php echo $buff['id'];?>">
		<input type="submit" value="aktifkan" /></input>
	</td>
	<td align="center" width="80"><a href="?module=nonaktifkan&id=<?php echo $buff['id'];?>">
		<input type="submit" value="nonaktifkan" /></input>
	</td>
    <td align="center" width="50"><a href="?module=edit3&id=<?php echo $buff['id'];?>">Edit</a></td>
	<td align="center" width="50"><a href="?module=hapus&id=<?php echo $buff['id'];?>">Hapus</a></td>
</tr>
</tbody><?php $no++;};?>
</table>
<!--End table Dosen-->