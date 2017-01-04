<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
}
.style10 {color: #FFFFFF}
.style4 {	color:#000000; 
	font:Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
</style>
</head>

<body>

  <p align="center" class="style4">MASUKAN DATA  PILKADA PANGANDARAN 2015</p>
  <table width="716" border="0" cellpadding="8" height="50">
    <tr>
      <th width="316" scope="row"><p align="left">Sebelum Memasukan Data Perolehan Suara, Pastikan Anda Untuk Melihat Data Yang Telah Tersimpan Sebelumnya Untuk Menghindari Penyimpanan Data Ganda </p>
      </th>
    </tr>
  </table>

  <form action="proses.php" method="post">
    <table width="726" border="1" align="center" cellpadding="8" bordercolor="#000000">
    
	<tr>
    
      <td width="156" bgcolor="#99FF00"><div align="center"><strong><span class="style1">Pilih Kecamatan</span></strong></div></td>
      <td width="87" bgcolor="#99FF00"><div align="center"><strong><span class="style1"> NO URUT 1 </span></strong></div></td>
      <td width="87" bgcolor="#99FF00"><div align="center"><strong><span class="style1"> NO URUT 2 </span></strong></div></td>
      <td width="88" bgcolor="#99FF00"><div align="center"><strong><span class="style1">NO URUT 3  </span></strong></div></td>
      <td width="204" bgcolor="#99FF00"><div align="center"><span class="style1"><strong>KETERANGAN</strong></span></div></td>
    </tr>
    <tr>
      <th height="40" bgcolor="#99CCFF" scope="row"><select name="kecamatan">
	   <option value="pilih kecamatan">Pilih Kecamatan</option>
        <option value="Parigi">Parigi</option>
        <option value="Cijulang">Cijulang</option>
        <option value="Cimerak">Cimerak</option>
        <option value="Cigugur">Cigugur</option>
		  <option value="Cibenda">Cibenda</option>
		    <option value="Sidamulih">Sidamulih</option>
			  <option value="Pangandaran">Pangandaran</option>
			    <option value="Banjarsari">Banjansari</option>
				  <option value="Langkaplancar">Langkaplancar</option>
      </select></th>
      <td bgcolor="#99CCFF" align="center"><input type="text" name="pasangan_no_satu" id="pasangan_no_satu" size="8" /></td>
      <td bgcolor="#99CCFF" align="center"><input type="text" name="pasangan_no_dua" id="pasangan_no_dua" size="8" /></td>
      <td bgcolor="#99CCFF" align="center"><input type="text" name="pasangan_no_tiga" id="pasangan_no_tiga" size="8" /></td>
      <td bgcolor="#99CCFF" align="center"><input type="text" name="keterangan" id="keterangan" size="30" /></td>
      
    </tr>
	
  </table>
  <table width="135" border="0" cellpadding="5" align="center">
  <tr>
    <th width="72" scope="row"><input type="submit" name="kirim" value="KIRIM" /></th>
    <td width="102"><input type="reset" name="batal" value="BATAL" /></td>
	<td><input type="hidden" name="tanggal" id="tanggal" value="<?php echo date("d-m-y h:i:s");?>" /></td>
	<td><input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" /></td>
  </tr>
</table>

  <p align="center">&nbsp;</p>
</form>
<?php include('lihat_perolehan_suara.php'); ?>

</body>
</html>
