<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2--3
  // Revisi dari sistem menu sebelumnya. Menu ini cross-platform
  
  function StartMenu($arrMenu) {
    echo "<Script Language='JavaScript1.2'><!--
	  var pMenu = new PopupMenu('pMenu');
	  with (pMenu) {
	    startMenu('root', false, 0, 0, 18, hBar);
	  ";
	for ($i =0; $i < sizeof($arrMenu); $i++) {
	  echo "addItem('$arrMenu[$i]', '$arrMenu[$i]', 'sm:'); \n";
	}
  }
  function AddSubMenu($Menu, $arr) {
    echo "startMenu('$Menu', true, 0, 20, 200, subM); \n";
	for ($i=0; $i < sizeof($arr); $i++) {
	  $arrsub = explode('->', $arr[$i]);
	  if (!isset($arrsub[2])) $tg = 22;
	  else $tg = $arrsub[2] * 20;
	  $link = ltrim($arrsub[1]);
	  echo "addItem('$arrsub[0]', '$link', '', subM, $tg); \n";
//addItem('&nbsp; &nbsp; About', 'mAbout', 'sm:', subM, 22, 0, '&lt;', 3);
	}
  }
  function EndMenu() {
    echo "}
	  -->
	  </script>";
  }


?>