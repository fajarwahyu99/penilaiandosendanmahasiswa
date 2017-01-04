<?php
  // Author : USNI
  
  $opt = "";
  $dr = dir ("./lang");
  while ($isi = $dr->read()) {
    if ($isi!="." and $isi!="..") {
	  $isi = ereg_replace(".php", "", $isi);
	  if ($isi==$Language)
	    $opt = "$opt<option selected>$isi</option>";
	  else $opt = "$opt<option>$isi</option>";
	}
  }
  $dr->close();
?>

<form action="index.php" method="POST">
  <?php echo "$strChangeLanguage:"; ?><br>
  <input type=hidden name="setlang" value=1>
  <select name="uselang" onchange="this.form.submit()">
    <?php echo $opt; ?>
  </select>
</form>