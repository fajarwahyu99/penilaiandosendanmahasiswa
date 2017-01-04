<?php
  // Author : USNI
  
  $opt = "";
  $dr = dir ("./theme");
  while ($isi = $dr->read()) {
    if ($isi!="." and $isi!="..") {
	  //$isi = ereg_replace(".php", "", $isi);
	  if ($isi==$theme)
	    $opt = "$opt<option selected>$isi</option>";
	  else $opt = "$opt<option>$isi</option>";
	}
  }
  $dr->close();
?>

<form action="index.php" method="GET">
  <?php echo "$strChangeTheme:"; ?><br>
  <select name="theme" onchange="this.form.submit()">
    <?php echo $opt; ?>
  </select>
</form>
