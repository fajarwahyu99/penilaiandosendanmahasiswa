<?php
  // desc : file utama dalam usniweb
  // author : USNI (human@usni.ac.id)
  // date : Juni 2010
  include_once "sysfo/sysfo.common.php";
?>

<table class=main width=100% border=0 align=center cellspacing=0 cellpadding=2>
  <tr>
    <td class='header-part' colspan=2>
	<?php
	  if (file_exists("$themedir/header.php"))
	    include "$themedir/header.php";
	  else include "header.php";
	?>
	</td>
  </tr>
  <tr>
    <td class='topmenu-part' colspan=2>
	<?php 
      include "sysfo/topmenu.php";
	?>
	</td>
  </tr>
</table>
<table class=main width=100% border=0 align=center cellspacing=0 cellpadding=2>
  <tr>
    <td class='left-part' width=150>
	<?php include "sysfo/left.php";
	?>
	</td>
	
	<td class='main-part' width=*>
	<?php
	  //echo "<b>$syxec</b>";
	  if ($syxec == 'main.php') $syxec = "sysfo/main.php";
	  if (file_exists($syxec)) include "$syxec";
	  else DisplayHeader($fmtErrorMsg, "Modul yang Anda jalankan tidak ditemukan.<br>
	    Hubungi Sekretaris Fakultas untuk keterangan lebih lanjut.<br>
		Atau sistem yang Anda install adalah versi DEMO.");
	?>
	</td>
  </tr>
</table>
<table class=main width=100% border=0 align=center cellspacing=0 cellpadding=2>
  <tr><td class='footer-part' colspan=2>
    <?php
	  include "sysfo/footer.php";
	?>
  </td>
  </tr>
</table>