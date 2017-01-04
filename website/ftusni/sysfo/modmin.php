<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net


  // *** FUNGSI2 ***
  // Display Modul utk Administrasi
  function DisplayModuleList($gm='') {
    echo "<a href='sysfo.php?syxec=modmin&modid=0' class=lst>Tambah Modul</a> |
	  <a href='sysfo.php?syxec=modgroup&md=-1' class=lst>Group Modul</a> |";
	SimplePrinter('print.php?print=sysfo/daftarmodul.php', 'Cetak Daftar Modul');
    if (empty($gm)) $strGM = '';
	else $strGM = "where GroupModul = '$gm'";
	
    $nbrw = new newsbrowser;
    $nbrw->query = "select * from modul $strGM order by GroupModul,Modul";
    $nbrw->headerfmt = "<table class=basic cellspacing=1 cellpadding=1 width=100%>
	  <tr><th class=ttl>Group</th><th class=ttl>Modul</th>
	  <th class=ttl>Level</th>
	  <th class=ttl>Menu</th>
	  <th class=ttl>web</th>
	  <th class=ttl>cs</th>
	  <th class=ttl>Modul Link</th>
	  <th class=ttl>Deskripsi</th>
	  <th class=basic></th>
	  </tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst>=GroupModul=</td>
	  <td class=lst><a href='sysfo.php?syxec=modmin&modid==ModulID='>=Modul=</a></td>
	  <td class=lst>=Level=</td>
	  <td class=lst align=center><img src='image/=InMenu=.gif' border=0></td>
	  <td class=lst align=center><img src='image/=web=.gif' border=0></td>
	  <td class=lst align=center><img src='image/=cs=.gif' border=0></td>
	  <td class=lst>=Link=</td>
	  <td class=lst>=Description=</td>
	  <th class=basic><a href='sysfo.php?syxec=modmin&del==ModulID='><img src='image/filedelete.gif' border=0></a></th>
	  </tr>";
    $nbrw->footerfmt = "</table><br>\n
	<table class=basic cellspacing=1 cellpadding=2>
	<tr><td class=ttl>Level</td><td class=lst>Level yang dapat mengakses secara default.</td></tr>
	<tr><td class=ttl>Menu</td><td class=lst>Tampilkan di menu.</td></tr>
	<tr><td class=ttl>web</td><td class=lst>Modul ini versi web.</td></tr>
	<tr><td class=ttl>cs</td><td class=lst>Modul ini versi client-server.</td></tr>
	</table>";
    echo $nbrw->BrowseNews();  
  }
  // Display Module Form
  function DisplayModuleForm($modid, $act='modmin') {
    global $strNotAuthorized;
    //if (empty($modid)) die($strNotAuthorized);
	if ($modid == 0) {
	  $_modul = '';
	  $_grpmdl = '';
	  $_level = '1';
	  $_lnk = '';
	  $_imglnk = '';
	  $_Description = '';
	  $_InMenu = 'checked';
	  $_brs = 1;
	  $_help = '';
	  $_author = '';
	  $_emailauthor = '';
	  $_cs = '';
	  $_web = 'checked';
	}
	else {
      $_sql = "select * from modul where ModulID=$modid";
      $_res = mysql_query($_sql);
      if (mysql_num_rows($_res) == 0) die('Tidak ada modul terinstal');
      $_modul = mysql_result($_res, 0, 'Modul');
      $_grpmdl = mysql_result($_res, 0, 'GroupModul');
      $_level = mysql_result($_res, 0, 'Level');
      $_lnk = mysql_result($_res, 0, 'Link');
      $_imglnk = mysql_result($_res, 0, 'ImgLink');
      $_Description = mysql_result($_res, 0, 'Description');
      if (mysql_result($_res, 0, 'InMenu')=='Y') $_InMenu='checked';
      else $_InMenu = '';
	  $_brs = mysql_result($_res, 0, 'Baris');
	  $_help = mysql_result($_res, 0, 'Help');
	  $_author = mysql_result($_res, 0, 'Author');
	  $_emailauthor = mysql_result($_res, 0, 'EmailAuthor');
	  if (mysql_result($_res, 0, 'cs') == 'Y') $_cs = 'checked'; else $_cs = '';
	  if (mysql_result($_res, 0, 'web') == 'Y') $_web = 'checked'; else $_web = '';
	}
	$_optgm = GetOption('groupmodul', 'GroupModul', 'GroupModul', $_grpmdl);
	$sid = session_id();
	echo "
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='modid' value='$modid'>
	  <table class=box cellspacing=1 cellpadding=2>
	    <tr><td class=lst>Group Modul</td><td class=lst><select name='GroupModul'>$_optgm</select></td></tr>
		<tr><td class=lst>Nama Modul</td><td class=lst><input type=text name='Modul' value='$_modul' maxlength=100 size=40></td></tr>
		<tr><td class=lst>Default Level</td><td class=lst><input type=text name='level' value='$_level' maxlength=10></td></tr>
		<tr><td class=lst>Link Modul</td><td class=lst><input type=text name='Link' value='$_lnk' size=40 maxlength=100></td></tr>
		<tr><td class=lst>Link Image</td><td class=lst><input type=text name='imglnk' value='$_imglnk' size=40></td></tr>
		<tr><td class=lst>Description</td><td class=lst><textarea name='Description'>$_Description</textarea></td></tr>
		<tr><td class=lst>InMenu</td><td class=lst><input type=checkbox name='InMenu' value='Y' $_InMenu></td></tr>
		<tr><td class=lst>Versi Web</td><td class=lst><input type=checkbox name='web' value='Y' $_web></td></tr>
		<tr><td class=lst>Versi Client/Server</td><td class=lst><input type=checkbox name='cs' value='Y' $_cs></td></tr>
		<tr><td class=lst>Jumlah Baris</td><td class=lst><input type=text name='brs' value='$_brs' size=2 maxlenght=2></td></tr>
		<tr><td class=lst>File Help</td><td class=lst><input type=text name='help' value='$_help' size=40></td></tr>
		<tr><td class=lst>Author</td><td class=lst><input type=text name='author' value='$_author' size=40></td></tr>
		<tr><td class=lst>Email Author</td><td class=lst><input type=text name='emailauthor' value='$_emailauthor' size=40></td></tr>
		<tr><td class=lst colspan=2 align=center><input type=submit name=prc value='simpan'>&nbsp;
		<input type=reset name=reset value='reset'>&nbsp;
		<input type=button name=batal value='Kembali' onClick=\"location='sysfo.php?syxec=modmin&PHPSESSID=$sid'\"></td></tr>
	  </table></form>";
  }
  function ProcessModuleForm() {
    global $fmtErrorMsg, $strCantQuery;
    $_modid = $_REQUEST['modid'];
	$_level = $_REQUEST['level'];
	$_Modul = FixQuotes($_REQUEST['Modul']);
	$_GroupModul = $_REQUEST['GroupModul'];
	$_Link = $_REQUEST['Link'];
	$_brs = $_REQUEST['brs'];
	$_help = $_REQUEST['help'];
	$_author = FixQuotes($_REQUEST['author']);
	$_emailauthor = $_REQUEST['emailauthor'];
	if (isset($_REQUEST['imglnk']))	$_imglnk = $_REQUEST['imglnk']; else $_imglnk = '';
	if (isset($_REQUEST['Description'])) $_Description = FixQuotes($_REQUEST['Description']); else $_Description = '';
	if (isset($_REQUEST['InMenu']))	$_InMenu = $_REQUEST['InMenu'];
	else $_InMenu = 'N';
	if (isset($_REQUEST['web'])) $_web = $_REQUEST['web']; else $_web = 'N';
	if (isset($_REQUEST['cs'])) $_cs = $_REQUEST['cs']; else $_cs = 'N';
	if (isset($_REQUEST['NotActive'])) $_NotActive = $_REQUEST['NotActive'];
	else $_NotActive = 'N';
	// *** Query ***
	if ($_modid==0) $_sql = "insert into modul (GroupModul, Modul, Description, InMenu, web, cs, Baris, Link, ImgLink, Help,
	  NotActive, Level, Author, EmailAuthor) 
	  values ('$_GroupModul', '$_Modul', '$_Description', '$_InMenu', '$_web', '$_cs', '$_brs',
	  '$_Link', '$_imglnk', '$_help', '$_NotActive', '$_level', '$_author', '$_emailauthor')";
	else $_sql = "update modul set GroupModul='$_GroupModul', Modul='$_Modul', Description='$_Description',
	  InMenu='$_InMenu', web='$_web', cs='$_cs', Baris='$_brs', Help='$_help', Link='$_Link', 
	  ImgLink='$_imglnk', NotActive='$_NotActive',
	  Level='$_level', Author='$_author', EmailAuthor='$_emailauthor'
	  where ModulID=$_modid";
	$_res = mysql_query($_sql) or die(DisplayHeader($fmtErrorMsg, "$strCantQuery: $_sql", 0));
  }
  function DisplayGroupModuleOption($gm='', $act) {
    global $strCantQuery;
	if (empty($act)) $act = $_SERVER['SCRIPT_NAME'];
    $_sql = "select GroupModul from groupmodul order by GroupModul";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <tr><td class=lst width=100>Group Modul </td><td class=lst>
	  <select name='gm' onChange='submit()'>";
	$_tmp = "<option></option>";
	for ($i=0; $i < mysql_num_rows($_res); $i++) {
	  $_o = mysql_result($_res, $i, 'GroupModul');
	  if ($gm == $_o) $_tmp = "$_tmp<option selected>$_o</option>";
	  else $_tmp = "$_tmp<option>$_o</option>";
	}
	echo "$_tmp</select></td></tr></form></table>";
  }

  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, 'Administrasi Modul');
  
  $ulevel = $_SESSION['ulevel'];
  if ($ulevel != 1) die(DisplayHeader($fmtErrorMsg, $strNotAuthorized));

  if (isset($_REQUEST['gm'])) {
    $gm = $_REQUEST['gm'];
	$_SESSION['gm'] = $gm;
  }
  else {
    if (empty($_SESSION['gm'])) $gm = '';
	else $gm = $_SESSION['gm'];
  }
  if (isset($_REQUEST['del'])) {
    mysql_query("delete from modul where ModulID=".$_REQUEST['del']) or die("$strCantQuery");
  }
  
  DisplayGroupModuleOption($gm, 'modmin');
  
  // *** Bagian Utama ***
  if (isset($_REQUEST['modid'])) {
    if (isset($_REQUEST['prc'])) {
	  ProcessModuleForm();
	  DisplayModuleList($gm);
	}
	else DisplayModuleForm($_REQUEST['modid']);
  }
  else DisplayModuleList($gm);

?>