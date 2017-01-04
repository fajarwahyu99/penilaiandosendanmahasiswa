<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  
  // *** FUngsi ^^^
  function GetPMBID() {
    echo <<<EOF
	<table class=basic cellspacing=0 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='pmbgetmbr'>
	<tr><td class=uline>ID PMB: </td><td class=uline><input type=text name='PMBID' size=20>&nbsp;<input type=submit name='Cari' value='Cari'></td></tr>
	</form></table>
EOF;
  }
  function EditMGM($id) {
    global $strCantQuery;
	$s = "select p.*, j.Kode as kdj, j.Nama_Indonesia as JUR,
	  pr.Kode as kdp, pr.Nama_Indonesia as PRG
	  from pmb p left outer join jurusan j on p.Program=j.Kode
	  left outer join program pr on p.ProgramType=pr.Kode
	  where p.PMBID='$id' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) die ("Data tidak ditemukan.<br>Menu: <a href='sysfo.php?syxec=listofnewstudent'>Daftar PMB</a>");
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='listofnewstudent'>
	  <input type=hidden name='PMBID' value='$id'> ";
	$w = mysql_fetch_array($r);
	$mgmy = ''; $mgmn = '';
	if ($w['MGM'] == 'Y') $mgmy = 'checked'; else $mgmn = 'checked';
	$optoleh = GetOption2('mbrgetmbr', "Nama", "Nama", $w['MGMOleh'], "", "ID");
	$hnr = GetaField('honormgm', "KodeProgram='$w[kdp]' and StatusAwal", $w['StatusAwal'], 'PMBHonor');
	if (empty($hnr)) $hnr = GetaField('honormgm', "KodeProgram", $w['kdp'], 'PMBHonor');
	$hnr = number_format($hnr, 0, ',', '.');
	$sid = session_id();
	echo <<<EOF
	  <tr><td class=uline>PMBID</td><td class=uline>: $w[PMBID]</td></tr>
	  <tr><td class=uline>Nama</td><td class=uline>: $w[Name]</td></tr>
	  <tr><td class=uline>Jurusan</td><td class=uline>: $w[Program] - $w[JUR]</td></tr>
	  <tr><td class=uline rowspan=2>Member Get Member</td><td class=uline><input type=radio name='mgm' value='Y' $mgmy> Ya&nbsp;&nbsp;
	  <select name='mgmoleh'>$optoleh</select></td></tr>
	  <tr><td class=uline><input type=radio name='mgm' value='N' $mgmn> Bukan <br></td></tr>
	  <tr><td class=uline>Honor MGM</td><td class=uline>: Rp. $hnr</td></tr>
	  <tr><td class=uline colspan=2><input type=submit name='prcmgm' value='Simpan'>&nbsp;
	  <input type=reset name='reset' value='Reset'>&nbsp;
	  <input type=button name='balik' value='Kembali' onClick="location='sysfo.php?syxec=listofnewstudent&PHPSESSID=$sid'"></td></tr>
EOF;
	echo "</form></table>";
  }

  // *** Program Utama ***
  DisplayHeader($fmtPageTitle, 'Program Member Get Member');
  if (isset($_REQUEST['PMBID'])) EditMGM($_REQUEST['PMBID']);
  else GetPMBID();
?>