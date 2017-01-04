<?php 
include('config.php');
?>

<html>
<head>
<title>Belajar PHP</title>
</head>

<body>
<h1>Form Input Data</h1>

<?php 
$id = $_GET['id'];

$query = mysql_query("select * from penjualan where id='$id'") or die(mysql_error());

$data = mysql_fetch_array($query);
?>

<form name="update_data" action="update.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table border="0" cellpadding="5" cellspacing="0">
    <tbody>
    	<tr>
        	<td>Tahun</td>
        	<td>:</td>
        	<td><select name="tahun" required="required" />
			<option> 2008 </option>
			<option> 2009 </option>
			<option> 2010 </option>
			</select>
			</td>
        </tr>
    	<tr>
        	<td>Bulan</td>
        	<td>:</td>
        	<td><select name="bulan" required="required" />
			<option> 1 </option>
			<option> 2 </option>
			<option> 3 </option>
			<option> 4 </option>
			<option> 5 </option>
			<option> 6 </option>
			<option> 7 </option>
			<option> 8 </option>
			<option> 9 </option>
			<option> 10 </option>
			<option> 11 </option>
			<option> 12 </option>
			</select>
			</td>
        </tr>
    	<tr>
        	<td>Kode Cabang</td>
        	<td>:</td>
        	<td><input type="text" name="kodecabang" maxlength="100" required="required" value="<?php echo $data['kodecabang']; ?>" /></td>
        </tr>
    	<tr>
        	<td>Kode Produk</td>
        	<td>:</td>
        	<td><input type="text" name="kodeproduk" required="required" value="<?php echo $data['kodeproduk']; ?>" /></td>
        </tr>
    	<tr>
        	<td>Nama Produk</td>
        	<td>:</td>
        	<td><input type="text" name="namaproduk" required="required" value="<?php echo $data['namaproduk']; ?>" /></td>
        </tr>
    	<tr>
        	<td>Jumlah</td>
        	<td>:</td>
        	<td><input type="text" name="jumlah" maxlength="14" required="required" value="<?php echo $data['jumlah']; ?>" /></td>
        </tr>
		<tr>
        	<td>Pendapatan</td>
        	<td>:</td>
        	<td><input type="text" name="pendapatan" required="required" value="<?php echo $data['pendapatan']; ?>" /></td>
        </tr>
        <tr>
        	<td align="right" colspan="3"><input type="submit" name="submit" value="Simpan" /></td>
        </tr>
    </tbody>
</table>
</form>

<a href="view.php">Lihat Data</a>

</body>
</html>