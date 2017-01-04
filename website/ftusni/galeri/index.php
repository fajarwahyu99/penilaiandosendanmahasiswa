<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  include "galeri.common.php";
  include "tab.class.php";
  $album = GetAlbum("album");
  $imglist = array();
  
  if (isset($_REQUEST['tab'])) $tab = $_REQUEST['tab'];
  else $tab = 0;
  
  if (isset($_REQUEST['alb'])) $alb = $_REQUEST['alb'];
  else $alb = $album[$tab];

  if (!empty($alb)) $imglist = GetAlbum("album/$alb");
  
  if (isset($_REQUEST['img'])) $img = $_REQUEST['img'];
  else {
    if (!empty($imglist)) $img = $imglist[0];
	else $img = '';
  }
?>

<HTML>
<HEAD>
  <TITLE>Web Photo Galery for <?php echo $_SERVER["SERVER_NAME"] ?></TITLE>
</HEAD>
<BODY>

  <?php
    DisplayTab($album, $tab, $imglist, $img, $action='');
  ?>
  
  <hr size=1 color=silver>
  <font face='verdana' size=1>
  Powered by <a href='credit.htm' target=_blank>dwoGallery</a>
  </font>
</BODY>
</HTML>