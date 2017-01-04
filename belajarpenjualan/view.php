<?php 
include('config.php');
?>

<html>
<head>
<title>Belajar PHP</title>
</head>

<body>
<center>
<h1>Data User</h1>

<?php 
if (!empty($_GET['message']) && $_GET['message'] == 'success') {
	echo '<h3>Berhasil meng-update data!</h3>';
} else if (!empty($_GET['message']) && $_GET['message'] == 'delete') {
	echo '<h3>Berhasil menghapus data!</h3>';
}
?>

<a href="index.php">+ Tambah Data</a>
<br>
<br>
<table border="1" cellpadding="5" cellspacing="0">
	<thead>
    	<tr>
        	<td>No.</td>
        	<td>Tahun</td>
        	<td>Bulan</td>
        	<td>Kode Cabang</td>
        	<td>Kode Produk</td>
        	<td>Nama Produk</td>
        	<td>Jumlah</td>
			<td>Pendapatan</td>
        	<td>Opsi</td>
        </tr>
    </thead>
    <tbody>
    <?php 
	$query = mysql_query("select * from penjualan");
	
	$no = 1;
	while ($data = mysql_fetch_array($query)) {
	?>
    	<tr>
        	<td><?php echo $no; ?></td>
        	<td><?php echo $data['tahun']; ?></td>
        	<td><?php echo $data['bulan']; ?></td>
        	<td><?php echo $data['kodecabang']; ?></td>
        	<td><?php echo $data['kodeproduk']; ?></td>
        	<td><?php echo $data['namaproduk']; ?></td>
        	<td><?php echo $data['jumlah']; ?></td>
			<td><?php echo $data['pendapatan']; ?></td>
            <td>
            	<a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a> || 
                <a href="delete.php?id=<?php echo $data['id']; ?>">Hapus</a>
            </td>
        </tr>
    <?php 
		$no++;
	} 
	?>
    </tbody>
</table>
<br>
<br>
<img src="c.png">
</center>
</body>
</html>