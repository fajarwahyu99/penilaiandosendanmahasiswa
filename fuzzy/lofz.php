<?php
	mysql_connect("localhost","root","");
	mysql_select_db("ai");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Logika Fuzzy</title>
<style>
	body
		{
			font-family:Verdana;
			font-size:12px;
		}
</style>
</head>

<body>
<?php
	function derajat_keanggotaan($nilai, $bawah, $tengah, $atas)
		{
			$selisih=$atas-$bawah;	
			if($nilai<$bawah)
				{
					$DA=0;	
				}
			elseif(($nilai>=$bawah) && ($nilai<=$tengah))
				{
					if($bawah<=0)
						{
							$DA=1;
						}
					else
						{
							$DA=($nilai-$bawah) / ($tengah-$bawah);	
						}
				}
			elseif(($nilai>$tengah) && ($nilai<=$atas))
				{
					$DA=($atas-$nilai) / ($atas-$tengah);	
				}	
			elseif($nilai>$atas)
				{
					$DA=0;	
				}
			return $DA;	
				
		}
	$kelompok		=isset($_GET['kelompok'])?$_GET['kelompok']*1:0;
	$sql_kelompok	="SELECT * FROM tb_kelompok WHERE id='$kelompok'";
	$hasil_kelompok	=mysql_query($sql_kelompok);
	$row_kelompok	=mysql_fetch_assoc($hasil_kelompok);
	
	$sql			="SELECT * FROM tb_kriteria";
	$hasil			=mysql_query($sql);
	$jumkol			=mysql_num_rows($hasil);
	
?>
<strong>Karyawan berdasarkan : <?php echo $row_kelompok['nama_kelompok'];?></strong>
<table border="1" cellpadding="3">
	<tr>
    	<td width="17" rowspan="2"><strong>ID</strong></td>
        <td width="221" rowspan="2"><strong>Nama</strong></td>
        <td width="28" rowspan="2"><strong>Usia</strong></td>
        <td width="37" rowspan="2"><strong>Masa Kerja</strong></td>
        <td width="78" rowspan="2"><strong>Gaji</strong></td>
        
        <td colspan="<?php echo $jumkol; ?>"><strong>Derajat Keanggotaan (&#956;[x])</strong></td>
       
    </tr>
	<tr>
	<?php
			$sql	="SELECT * FROM tb_kriteria WHERE kelompok='$kelompok'";
			$hasil	=mysql_query($sql);
			while($row=mysql_fetch_assoc($hasil))
				{
		?>	
	  <td><strong><?php echo $row['nama_kriteria'];?></strong></td>
 <?php
				}
		?>
  </tr>
    <?php
    	$sql	="SELECT * FROM tb_emp";
			$hasil	=mysql_query($sql);
			while($row=mysql_fetch_assoc($hasil))
				{
	?>
	
	<tr>
	  <td><?php echo $row['id']; ?></td>
	  <td><?php echo $row['nama']; ?></td>
	  <td><?php echo $row['usia']; ?></td>
      <td><?php echo $row['masakerja']; ?></td>
      <td><?php echo number_format($row['gaji'],0,",","."); ?></td>
      <?php
	  		$sql2	="SELECT * FROM tb_kriteria WHERE kelompok='$kelompok'";
			$hasil2	=mysql_query($sql2);
			while($row2=mysql_fetch_assoc($hasil2))
				{
		?>	
        <td ><?php echo  number_format(derajat_keanggotaan($row[$row_kelompok['field_akses']], $row2['bawah'], $row2['tengah'], $row2['atas']),2,",",".");?></td>
        <?php
				}
		?>
        
        
  </tr>
  <?php
				}
  ?>
</table>
</body>
</html>