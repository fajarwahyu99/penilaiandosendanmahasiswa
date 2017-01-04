<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003  

  include "tab.class.css";
  function DisplayTitle($title) {
    return "<table cellpadding=4 width=100%>
	    <tr><td class=ttl>$title</td></tr></table>";  
  }
?>
<script language=JavaScript>
  function highlight(obj,cls) {
    tid = eval(obj).id;
	obj.className=cls;
  }
</script>

<?php
  
  function DisplayTab($arrt, $aidx=0, $imglist, $img, $action='') {
    $jml = count($arrt);
	$jml1 = $jml+1;
	$rs = $jml +2;
	if (empty($action)) $action = $_SERVER["SCRIPT_NAME"];
	settype($aidx, 'int');
	echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	echo "<tr><td width=150 valign=top>
	  <table width=150 cellspacing=0 cellpadding=4 border=0>
	  <tr><td class=tabe>&nbsp;</td></tr>";
	// gambarkan tab
	for ($i=0; $i < $jml; $i++) {
	  $jdl = $arrt[$i];
	  $lnkjdl = urlencode($jdl);
	  if ($i === $aidx) echo "<tr><td class='taba'>$jdl</td></tr>";
	  else {
	    if ($i < $aidx) $na = 'tabna';
		else $na = 'tabnb';
	  echo "<tr><td id='$jdl' class=$na onClick='location=\"$action?tab=$i&alb=$lnkjdl\"' onMouseLeave=\"highlight(this,'$na');\" onMouseOver=\"highlight(this,'tabmo');\">$jdl</td></tr>";
	  }
	}
	echo "</table>";
	
    $_album = $arrt[$aidx];
	$_imglist = "<center><b>Daftar</b></center><hr>";
	//"<img src='empty.bmp' width=1><br>";
	for ($i=0; $i < count($imglist); $i++) {
	  $_nm = $imglist[$i];
	  $_nm = urlencode($_nm);
	  $_imglist = "$_imglist <a href='$action?tab=$aidx&alb=$_album&img=$_nm'>$_nm</a><br>";
	}
	if (!empty($img))
	  $content = DisplayTitle("Gambar: <b>$img</b>") .
	    "<img src='album/$_album/$img'>";
	else $content = DisplayTitle('Tidak ada gambar');
	echo "<td class=tabc rowspan=2 valign=top>$_imglist</td>";
	echo "<td style='padding: 4;' rowspan=2 valign=top>$content</td></tr>";
	//echo "<tr><td class=tabe valign=top heigh=1000>end album</td></tr>";

	echo "</table>";
  }
?>