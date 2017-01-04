<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003
  
  function GetAlbum($dir) {
    $arr = array();
	$i = 0;
    $dr = dir ($dir);
    while ($isi = $dr->read()) {
      if ($isi!="." and $isi!="..") {
	    $isi = ereg_replace(".php", "", $isi);
		$arr[$i] = $isi;
		$i++;
	  }
    }
    $dr->close();
	sort($arr);
	return $arr;
  }


?>