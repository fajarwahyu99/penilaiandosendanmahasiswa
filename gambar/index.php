<?php include "koneksi.php"; ?>

<html>
 <head>
  <title>Capture Webcam dengan JQuery</title>
 </head>
 
<body>
<!--Camera-->
<div style="margin-left:35%;">
<object width="300" height="200" data="croflash.swf" type="application/x-shockwave-flash">
<param name="data" value="croflash.swf" /><param name="src" value="croflash.swf" />
<embed src="croflash.swf" type="application/x-shockwave-flash"  width="300" height="300"></embed>
</object>
</div >
<!--Tampilkan data-->
 <div style="margin-left:25%; margin-top:20px">
 <table border="1" style="text-align:center;">
  <tr style="background-color:#ccc;"><td width='10px'>No</td><td width='250px'>Nama</td><td width='250px'>Gambar</td><td width='50px'>Aksi</td></tr>
  <?php $sql=mysql_query("select * from hasil"); 
     while($tampilkan = mysql_fetch_array($sql)){
  ?>
  <tr>
  <td><?php echo $tampilkan['id']; ?></td>
  <td><?php echo $tampilkan['nama']; ?></td>
  <td><img src="<?php echo $tampilkan['gambar']; ?>.png" width="150px" height="100px"/></td>
  <td><a href="hapus.php?id=<?php echo $tampilkan['id']; ?>">Hapus</a></td>
  </tr>
  <?php } ?>
 </table>
 </div>
</body>
</html>
