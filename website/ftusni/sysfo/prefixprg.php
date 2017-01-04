<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi ***
  function EditPrefixProgram($md, $kdj, $jpid) {
    if ($md == 0) {
	  $arr = GetFields('jurprg', "ID", $jpid, '*');
	  $Prefix = $arr['Prefix'];
	  if ($arr['NotActive'] == 'Y') $NA = 'checked'; else $NA = '';
	  $optkdj = $arr['KodeJurusan'];
	  $optkdp = $arr['KodeProgram'];
	}
	else {
	  $kdp = '';
	  $Prefix = '';
	  $NA = '';
	  $optkdj = GetOption2('jurusan', "concat(Kode, ' - ', Nama_Indonesia)", 'Nama_Indonesia', $kdj, '', 'Kode');
	  $optkdp = GetOption2('program', "concat(Kode, ' - ', Nama_Indonesia)", 'Nama_Indonesia', $kdp, '', 'Kode');
	  $optkdj = "<select name='kdj'>$optkdj</select>";
	  $optkdp = "<select name='kdp'>$optkdp</select>";
	}
	$sid = session_id();
	$snm = session_name();
    echo <<<EOF
	<table class=box cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='prefixprg'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name='jpid' value='$jpid'>
	<tr><th class=ttl colspan=2>Prefix Program</th></tr>
	<tr><td class=uline>Jurusan</td><td class=uline>$optkdj</td></tr>
	<tr><td class=uline>Program</td><td class=uline>$optkdp</td></tr>
	<tr><td class=uline>Prefix Prg</td><td class=uline><input type=text name='Prefix' value='$Prefix' size=5 maxlength=5></td></tr>
	<tr><td class=uline colspan=2><input type=submit name='prcprf' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'>&nbsp;
	  <input type=reset name='Batal' value='Batal' onClick="location='sysfo.php?syxec=prefixnim&$snm=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcPrefixProgram() {
    global $fmtErrorMsg;
    $md = $_REQUEST['md'];
	  $sid = session_id();
	  $snm = session_name();
	$Prefix = $_REQUEST['Prefix'];
	$jpid = $_REQUEST['jpid'];
	if ($md == 0) {
	  $s = "update jurprg set Prefix='$Prefix' where ID=$jpid";
	  $r = mysql_query($s) or die(mysql_error());
	  GoToPrefixNIM();
	}
	else {
	  $kdj = $_REQUEST['kdj'];
	  $kdp = $_REQUEST['kdp'];
	  $ada = GetaField("jurprg", "NotActive='N' and KodeJurusan='$kdj' and KodeProgram", $kdp, 'ID');
	  if (empty($ada)) {
	    $s = "insert into jurprg (KodeJurusan, KodeProgram, Prefix, NotActive)
	      values ('$kdj', '$kdp', '$Prefix', 'N')";
	    $r = mysql_query($s) or die(mysql_error());
		GoToPrefixNIM();
	  }
	  else DisplayHeader($fmtErrorMsg, "Sub Prefix Program untuk Jurusan <b>$kdj</b> dan Program <b>$kdp</b> sudah ada.");
	}
  }
  function GoToPrefixNIM() {
    $snm = session_name();
	$sid = session_id();
    echo <<<EOF
	<script language='JavaScript'>
    var popOldOL = window.onload;
	window.onload = function(){ if (popOldOL) popOldOL(); location="sysfo.php?syxec=prefixnim&$snm=$sid"; }
    </script>
EOF;
  }
  
  // *** Parameter2 ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = 1;
  if (isset($_REQUEST['kdj'])) $kdj = $_REQUEST['kdj']; else $kdj = '';
  if (isset($_REQUEST['jpid'])) $jpid = $_REQUEST['jpid']; else $jpid = 0;
  if (isset($_REQUEST['prcprf'])) PrcPrefixProgram();
  
  if ($md == 0) $jdl = 'Edit Prefix Program';
  elseif ($md == 1) $jdl = 'Tambah Prefix Program';
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, $jdl);
  EditPrefixProgram($md, $kdj, $jpid);

?>