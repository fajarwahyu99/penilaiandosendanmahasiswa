<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net

  // *** Fungsi2 ***
  function GetStatusAwalMhsw() {
    $r = mysql_query("select Kode, Nama from statusawalmhsw order by Kode");
	$res = '<table class=basic cellspacing=0 cellpadding=2>
	  <tr><th class=ttl colspan=2>Keterangan</th></tr>';
	while ($row=mysql_fetch_array($r))
	  $res .= "<tr><th class=ttl>$row[Kode]</th><td class=uline>$row[Nama]</td></tr>";
	return $res . '</table>';
  }
  function GetCheckListPMB($sya) {
    $r = mysql_query("select * from pmbsyarat order by Rank");
	$res = '<table class=basic cellspacing=0 cellpadding=2>';
	$max = mysql_num_rows($r);
	$cnt = 0;
	$leg = GetStatusAwalMhsw();
	while ($row = mysql_fetch_array($r)) {
	  if (strpos($sya, "|$row[ID]|") === false) 
	    $res .= "<tr><td class=uline><input type=checkbox name='check[]' value='$row[ID]'>$row[Nama]</td><td class=uline>$row[StatusAwal]</td>";
	  else $res .= "<tr><td class=uline><input type=checkbox name='check[]' value='$row[ID]' checked>$row[Nama]</td><td class=uline>$row[StatusAwal]</td>";
	  if ($cnt == 0) $res .= "<td class=basic rowspan=$max valign=top>$leg</td></tr>";
	  else $res .= "</tr>";
	  $cnt++;
	}
	return $res."</table>";
  }
  function DispCheckPMB($PMBID) {
    global $strCantQuery;
	$s = "select p.Name, j.Nama_Indonesia as JUR, p.PMBSyarat, p.PMBKurang, p.StatusAwal, p.StatusPotongan,
	  p.DosenID, p.ProgramType, p.PMBKurang, p.Setara
	  from pmb p left outer join jurusan j on p.Program=j.Kode
	  where PMBID='$PMBID' limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	if (mysql_num_rows($r) == 0) die("Data tidak ditemukan.");
	$nme = mysql_result($r, 0, 'Name');
	$jur = mysql_result($r, 0, 'JUR');
	$Setara = mysql_result($r, 0, 'Setara');
	$PMBKurang = mysql_result($r, 0, 'PMBKurang');
	$optdsn = GetOption2('dosen', "concat(Name, ', ', Gelar)", 'Name', mysql_result($r, 0, 'DosenID'), '', 'ID');
	$optstat = GetOption2('statusawalmhsw', 'Nama', 'Nama', mysql_result($r, 0, 'StatusAwal'), '', 'Kode');
	$optstatp = GetOption2('statuspotongan', 'Nama', 'Nama', mysql_result($r, 0, 'StatusPotongan'), '', 'Kode');
	$optcheck = GetCheckListPMB(mysql_result($r, 0, 'PMBSyarat'));
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', mysql_result($r, 0, 'ProgramType'), '', 'Kode');
	$sid = session_id();
	echo <<<EOF
	<table class=box cellspacing=1 cellpadding=2>
	<form action='sysfo.php' method=POST>
	<input type=hidden name='syxec' value='pmbcheck'>
	<input type=hidden name='PMBID' value='$PMBID'>
	<tr><th class=ttl colspan=2>Check List PMB</th></tr>
	<tr><td class=uline>Nama</td><td class=uline>$nme</td></tr>
	<tr><td class=uline>Jurusan</td><td class=uline>$jur</td></tr>
	<tr><td class=uline>Status</td><td class=uline><select name='sta'>$optstat</select></td></tr>
	<tr><td class=uline>Status Potongan</td><td class=uline><select name='statp'>$optstatp</select></td></tr>
	<tr><td class=uline>Total Penyetaraan</td><td class=uline><input type=text name='Setara' value='$Setara' size=5 maxlength=3></td></tr>
	<tr><td class=uline>Penasehat Akademik</td><td class=uline><select name='dsn'>$optdsn</select></td></tr>
	<tr><td class=uline>Program/Kelas</td><td class=uline><select name='prg'>$optprg</select></td></tr>
	<tr><td class=uline>Persyaratan</td><td class=uline>$optcheck</td></tr>
	<tr><td class=uline>Catatan Persyaratan</td><td class=uline><textarea name='PMBKurang' cols=30 rows=4>$PMBKurang</textarea></td></tr>
	<tr><td class=basic colspan=2><input type=submit name='prccek' value='Simpan'>&nbsp;
	<input type=reset name='reset' value='Reset'>&nbsp;
	<input type=button name='balik' value='Kembali' onClick="location='sysfo.php?syxec=listofnewstudent&PHPSESSID=$sid'"></td></tr>
	</form></table>
EOF;
  }
  function PrcCheckListPMB() {
    global $strCantQuery;
    $PMBID = $_REQUEST['PMBID'];
	$sta = $_REQUEST['sta'];
	$statp = $_REQUEST['statp'];
	$dsn = $_REQUEST['dsn'];
	$prg = $_REQUEST['prg'];
	$krg = FixQuotes($_REQUEST['PMBKurang']);
	if (isset($_REQUEST['check'])) $cek = $_REQUEST['check']; else $cek = array();
	$str = '|';
	if (EmptyArray($cek)) $str = '';
	else {
	  for ($i=0; $i < sizeof($cek); $i++)
	    if (!empty($cek[$i])) $str .= "$cek[$i]|";
	}
	$s = "update pmb set StatusAwal='$sta', StatusPotongan='$statp',
	  DosenID='$dsn', PMBSyarat='$str', ProgramType='$prg', PMBKurang='$krg' where PMBID='$PMBID'";
	$r = mysql_query($s) or die("$strCantQuery: $s");
  }

  // *** Bagian Utama ***
  if (isset($_REQUEST['PMBID'])) $PMBID = $_REQUEST['PMBID']; else die ("Modul ini memerlukan parameter.").
  
  DisplayHeader($fmtPageTitle, "Check List Persyaratan PMB");
  if (isset($_REQUEST['prccek'])) PrcCheckListPMB();
  DispCheckPMB($PMBID);
?>