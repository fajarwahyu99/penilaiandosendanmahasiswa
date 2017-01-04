<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003


  // *** FUngsi2 ***
  function CekPerParam($dat, $param) {
    if ($dat[$param] == 'Y') {
	  $_SESSION[$param] = $_REQUEST[$param];
	  return "&$param=$_REQUEST[$param]";
	}
	else return '';
  }
  function CekPerParamTgl($dat, $param, $pref) {
    $pref_y = $pref.'_y';
	$pref_m = $pref.'_m';
	$pref_d = $pref.'_d';
    if ($dat[$param] == 'Y') {
	  $_SESSION[$pref_y] = $_REQUEST[$pref_y];
	  $_SESSION[$pref_m] = $_REQUEST[$pref_m];
	  $_SESSION[$pref_d] = $_REQUEST[$pref_d];
	  return "&$param=$_REQUEST[$pref_y]-$_REQUEST[$pref_m]-$_REQUEST[$pref_d]";
	}
	else return '';
  }
  function CekPerParamStatusMhsw($dat, $param) {
    if ($dat[$param] == 'Y') {
	  if (isset($_REQUEST[$param])) $sets = $_REQUEST[$param]; else $sets = array();
	  $r = '|';
	  for ($i=0; $i < sizeof($sets); $i++) {
	    $r .= "$sets[$i]|";
	  }
	  $_SESSION['PerStatusMhsw'] = $r;
	  return "&$param=$r";
	} else return '';
  }
  // *** Bagian Utama ***
if (isset($_REQUEST['prc'])) {
  $sid = session_id();
	$rpt = $_REQUEST['rpt'];
	if (isset($_REQUEST['param'])) $param = $_REQUEST['param']; else $param = '';
	if (isset($_REQUEST['PerJur'])) $PerJur = "-".$_REQUEST['PerJur']; else $PerJur = '';
	$dat = GetFields("rptmgr", "Rpt", $rpt, "*");
	$file1 = "sysfo/$dat[Script]$PerJur.php";
	$file0 = "sysfo/$dat[Script].php";
	$prn = '';
	if (file_exists($file1)) $prn = $file1;
	elseif (file_exists($file0)) $prn = $file0;
	if (!empty($prn)) {
	  $PerTahun = CekPerParam($dat, 'PerTahun');
	  $PerMhsw = CekPerParam($dat, 'PerMhsw');
	  $PerJur = CekPerParam($dat, 'PerJur');
	  $PerPrg = CekPerParam($dat, 'PerPrg');
	  $PerJnsByr = CekPerParam($dat, 'PerJnsByr');
	  $PerTglAwal = CekPerParamTgl($dat, 'PerTglAwal', 'PTAW');
	  $PerTglAkhir = CekPerParamTgl($dat, 'PerTglAkhir', 'PTAK');
	  $PerBulan = CekPerParam($dat, 'PerBulan');
	  $PerStatusMhsw = CekPerParamStatusMhsw($dat, 'PerStatusMhsw');
	  $PerAngkDari = CekPerParam($dat, 'PerAngkDari');
	  $PerAngkSampai = CekPerParam($dat, 'PerAngkSampai');
      echo <<<EOF
      <SCRIPT>
      var popOldOL = window.onload;
      window.onload = function(){ if (popOldOL) popOldOL(); 
	    newwin = window.open('print.php?print=$prn$PerTahun$PerMhsw$PerJur$PerPrg$PerJnsByr$PerTglAwal$PerTglAkhir$PerBulan$PerAngkDari$PerAngkSampai$PerStatusMhsw&param=$param&PHPSESSID=$sid'); }
      </SCRIPT>
EOF;
    } else DisplayHeader($fmtErrorMsg, "Script report <b>$dat[Script]</b> tidak ditemukan. <br>Hubungi MIS/IT/Puskom.");
  }
  if (isset($_REQUEST['rpt'])) DispOptRpt($_REQUEST['rpt']);
?>