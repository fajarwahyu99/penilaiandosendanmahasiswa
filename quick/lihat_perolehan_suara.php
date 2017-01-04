<?php

require_once('koneksi.php');
$awal=0;
$byk_tampil=10;
if(isset($_GET['hal'])){
    $awal=$_GET['hal']*$byk_tampil;
}
$perintah="SELECT*FROM data_kampanye ORDER BY id DESC";
$limit="limit $awal,$byk_tampil";
$per_limit=sprintf("%s %s",$perintah,$limit);
$rsalkampanye=@mysql_query($perintah,$koneksi);
$rskampanye=@mysql_query($per_limit,$koneksi);
$baris=mysql_num_rows($rsalkampanye);
?>
<html>
<head>
<title>Menampilkan Data Kampanye</title>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-family: Arial, Helvetica, sans-serif; }
-->
.style4 {
	color:#000000; 
	font:Arial, Helvetica, sans-serif;
	font-weight: bold;
 }
.style7 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
</style>
<link rel="stylesheet" href="style.css" type="text/css" /> 
<style type="text/css">
<!--
.style8 {color: #000000}
.style9 {font-weight: bold}
.style11 {color: #FFFFFF; font-size: 14px; }
-->
</style>
</head>
<body>

	<p align="center" class="style4">HASIL PEROLEHAN SEMENTARA PILKADA PANGANDARAN 2015 </p>        
	     
<table width="672" height="73" align="center" bordercolor="#0000FF" cellpadding="2" cellspacing="1" border="1">
  <tr>
    <td width="37" bordercolor="#0000FF" bgcolor="#99FF00"><div align="center" class="style3 style8 style9">
      <div align="center">NO</div>
    </div></td>
    <td width="114" bgcolor="#99FF00"><div align="center" class="style8 style3"><strong>KECAMATAN</strong></div></td>
    <td width="103" bgcolor="#99FF00"><div align="center" class="style8 style3"><strong>NO URUT 1 </strong></div></td>
    <td width="106" bgcolor="#99FF00"><div align="center" class="style8 style3"><strong>NO URUT 2 </strong></div></td>
    <td width="116" bgcolor="#99FF00"><div align="center" class="style8 style3"><strong>NO URUT 3 </strong></div></td>
    <td width="151" bgcolor="#99FF00"><div align="center" class="style8 style3"><strong>KETERANGAN </strong></div></td>
  </tr>
<?php
$no=$awal+1;
while($data=mysql_fetch_array($rskampanye)){

    ?>


 
  <tr>
    <td height="42" bordercolor="#FF0000" bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $no;?></div></td>
    <td align="left" bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $data['kecamatan'];?></div></td>
    <td bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $data['pasangan_no_satu'];?></div></td>
    <td bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $data['pasangan_no_dua'];?></div></td>
    <td bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $data['pasangan_no_tiga'];?></div></td>
    <td bgcolor="#99CCFF" class="<?php echo $no%2==0?tdc1:tdc2?>"><div align="center" class="style7"><?php echo $data['keterangan'];?></div></td>
  </tr>
  
 <?php $no+=1;}?>
</table>

<table width="672" border="1" align="center" cellpadding="8">
  <tr>
   
    <td width="144" bgcolor="#99CCFF"><div align="center"><strong>JUMLAH</strong></div></td>
    <td width="91" bgcolor="#FF0000"><div align="center" class="style11">
      <?php
  $sql = "SELECT SUM(pasangan_no_satu) AS total_suara FROM `data_kampanye` ";
$result = mysql_query($sql) or die (mysql_error());
$t = mysql_fetch_array($result);
echo "" . number_format($t['total_suara']) . " </b>";
   ?>
    </div></td>
    <td width="93" bgcolor="#FF0000"><div align="center" class="style11">
      <?php $sql = "SELECT SUM(pasangan_no_dua) AS total_suara FROM `data_kampanye` ";
$result = mysql_query($sql) or die (mysql_error());
$t = mysql_fetch_array($result);
echo "" . number_format($t['total_suara']) . " </b>";
   ?>
    </div></td>
    <td width="104" bgcolor="#FF0000"><div align="center" class="style11">
      <?php  $sql = "SELECT SUM(pasangan_no_tiga) AS total_suara FROM `data_kampanye` ";
$result = mysql_query($sql) or die (mysql_error());
$t = mysql_fetch_array($result);
echo "" . number_format($t['total_suara']) . " </b>";
   ?>
    </div></td>
    <td width="136" bgcolor="#99CCFF">&nbsp;</td>
  </tr>
</table>







</body>
</html>
