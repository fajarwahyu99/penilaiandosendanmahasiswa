<html>
<?php
include "koneksi.php";


?>
<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<script src="assets/js/jquery.min.js"></script>
<center><h2>BUKUTAMU DESTI</h2></center>

<form action='bukutamu_proses.php' method='post'>

<div class="container">
  <div class="form-info">
    <div id='valform'></div>
    <div class='form-group'>
      <label class='form'>Nama *</label>
      <input type='text' name='nama' class='form-control' placeholder="nama">
    </div>
  </div>
  
  <div class="form-info">
    <div id='valform'></div>
    <div class='form-group'>
      <label class='form'>Email *</label>
      <input type='email' name='email' class='form-control' placeholder="email">
    </div>
  </div>
  
  <div class="form-info">
    <div id='valform'></div>
    <div class='form-group'>
      <label class='form'>Pesan *</label>
       <textarea name='pesan'  class='form-control'></textarea>
    </div>
  </div>
  <div class="form-info">
    <div id='valform'></div>
    <div class='form-group'>
    <input type='submit' value='KIRIM'  class="btn btn-default">
    </div>
  </div>

    
  </form>

</table>


<h2>Pesan bukutamu</h2>
<table class='table'>
<?php
$query = mysql_query("select * from bukutamu");
while($data=mysql_fetch_array($query))
	{
  echo "

  
  <tr class='alert alert-info role='alert'>
  <td>
  $data[1] - $data[2] - <i>$data[4]</i> 
  <blockquote><h3>$data[3]</h3></blockquote>
  </td>
  </tr>
  <td><p>
  <tr>

  </tr>

";


}
?>
</html>