<?php
  // file: cekcookie.php
  // desc: masalah yg berhubungan dengan cookie ada di sini.
  //       Please be carefull if you want to change this content.
  // author: USNI (human@usni.ac.id)
  // Maret 2003

  $isErrorLogin = false;  
  session_start();

  function ResetSession() {
    $_SESSION ['sudahlogin'] = 0;
	$_SESSION ['uname'] = "";
	$_SESSION ['uid'] = 0;
	$_SESSION ['uemail'] = "";
	$_SESSION ['unip'] = "";
	$_SESSION ['ulevel'] = 5;
	$_SESSION ['level'] = "";
	$_SESSION['sysfo'] = "";
  }
  
  if (!isset($_SESSION ['sudahlogin'])) ResetSession();
  // fungsi utk menuliskan bahasa yg dipakai di cookie
  function WriteCookie ($variabel, $value) {
    $nextyear = mktime (0,0,0,date("m"),date("d"),date("Y")+1);
    setcookie($variabel,$value,$nextyear);
  }

  function CheckAdmin ($level) {
    Global $mbr_ismediator, $mbr_isadmin;
    if ($level == 1) {
      return ($mbr_ismediator == 'Y');
    }
    else if ($level == 2) {
      return ($mbr_isadmin == 1);
    }
    else return false;
  }

  // perbaharui cookie maxrow
  if (!isset($_COOKIE ['maxrow'])) {
    $maxrow = $DefaultMaxRow;
    WriteCookie ('maxrow', $maxrow);
  }
  else {
    $maxrow = $_COOKIE ['maxrow'];
    WriteCookie ('maxrow', $maxrow);
  }
  // Jika ada perubahan jumlah $maxrow
  $mrchg = 0;
  if (!empty($_GET['maxrow'])) {
    $maxrow = $_GET ['maxrow'];
    WriteCookie ('maxrow', $maxrow);
  }
  
  // Cek jika ada perintah perubahan bahasa
  if (!isset($_REQUEST ['setlang'])) $SetLang=0;
  else $SetLang = $_REQUEST ['setlang'];

  // jika tidak ada perintah perubahan bahasa:
  if ($SetLang==0) {
    // Jika cookie belum diset, gunakan bahasa default: Indonesia
    if (empty ($_COOKIE ['uselang'])) {
      $Language = 'Indonesia';
      WriteCookie ('uselang', $Language);
    }
    else {
      // refresh cookie untuk pemakaian 1 tahun lagi.
      $Language = $_COOKIE ['uselang'];
      WriteCookie ('uselang', $Language);
    }
  }
  else if ($SetLang==1) {
    $UseLang = $_POST ['uselang'];
    $Language = $UseLang;
    WriteCookie ('uselang', $Language);
  }
  // Jangan lupa file bahasa di-include
  include "lang/$Language.php";
  
  // Update theme
  if (empty($_COOKIE['theme'])) {
    $theme = $DefaultTheme;
	WriteCookie('theme', $theme);
  }
  else {
    $theme = $_COOKIE ['theme'];
	WriteCookie('theme', $theme);
  }
  // Jika ada perubahan Theme
  if (!empty($_GET['theme'])) {
    $theme = $_GET['theme'];
	WriteCookie('theme', $theme);
  }
  $themedir = "./theme/$theme";

  include "display.func.php";
  include "./lib/common.php";
  include "./setup/level.setup.php";
  include "$themedir/displayset.php";
  include "connectdb.php";
  include "./class/lister.class.php";
  include "./class/newsbrowse.class.php";
  
  if (empty($_GET['exec'])) {
    if (empty($_POST['exec'])) $exec = "main";
	else $exec = $_POST['exec'];
  }
  else $exec = $_GET['exec'];

  if (!isset($_REQUEST['syxec'])) $syxec = "$exec.php";
  else {
    $syxec = $_REQUEST['syxec'];
	$exec = "sysfo/$syxec";
	$syxec = "sysfo/$syxec.php";
  }
  
  // process login
  if ($exec=='proclogin') include "proclogin.php";
  
  // proses logout
  if (isset($_REQUEST['logout'])) {
    ResetSession();
	//session_destroy();
	$exec = "main";
  }
  $exec = "$exec.php";
  
?>
