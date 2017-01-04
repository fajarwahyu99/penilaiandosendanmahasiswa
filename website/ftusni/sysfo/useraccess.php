<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2002, reproduce

  // *** Fungsi2 ***
  function DisplaySearchUser($usr, $nilai, $act='useraccess') {
    echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='usr' value='$usr'>
	  Cari:
	  <input type=text name='nilai' value='$nilai'>
	  <input type=submit name='_Name' value='Cari Nama'>
	  <input type=submit name='_Login' value='Cari Login'>
	  <input type=submit name='_None' value='Semua'>
	  </form>";
  }
  
  function DisplayUserList() {
    global $usr, $usrsr, $strPage, $maxrow, $strwhr, $SearchMode, $nilai;
	$urlnilai = urlencode($nilai);
    $pagefmt = "<a href='sysfo.php?syxec=useraccess&usr=$usr&$SearchMode=1&nilai=$urlnilai&usrsr==STARTROW='>=PAGE=</a>";
    $pageoff = "<b>=PAGE=</b>";
  
    $lister = new lister;
    $lister->tables = "$usr $strwhr order by Name,Login";
	//echo $lister->tables;
    $lister->fields = "ID,Login,Name,Email,Phone,Description,NotActive ";
    $lister->startrow = $usrsr;
    $lister->maxrow = $maxrow;
    $lister->headerfmt = "<table class=basic width=100% cellspacing=1>
      <tr>
	  <th class=ttl>Mod</th><th class=ttl>Nama</th><th class=ttl>Login</th>
	  <th class=ttl>Email</th><th class=ttl>Phone</th>
	  <th class=ttl>NA</th>
      </tr>";
    $lister->detailfmt = "<tr>
	  <td class=lst width=18 align=right>
	  <a href='sysfo.php?syxec=usermodul&usrsr=$usrsr&usr=$usr&usrnip==Login=&usrid==ID=&$SearchMode=1&nilai=$urlnilai'><img src='icon/polling.gif' border=0 width=16></a></td>
	  <td class='lst'>
	  <a href='sysfo.php?syxec=useraccess&usrsr=$usrsr&usr=$usr&usrnip==Login=&usrid==ID=&$SearchMode=1&nilai=$urlnilai'>=Name=</a></td>
	  <td class='lst'>=Login=</td>
	  <td class=lst>=Email=</td>
	  <td class=lst>=Phone=</td>
	  <td class='lst'><center>=NotActive=</td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = $lister->ListIt () .  "<p>$strPage User: $halaman</p>";
    echo $usrlist;
  }

  function DisplayUserForm($usr, $usrid=0, $act='useraccess', $addi='') {
    global $strCantQuery, $usrsr, $SearchMode, $nilai;
	$sid = session_id();
    if ($usrid > 0) {
	  $_susr = "select * from $usr where ID=$usrid";
	  $_rusr = mysql_query($_susr) or die ("$strCantQuery: $_susr");
	  $Name = mysql_result($_rusr, 0, 'Name');
	  $Login = mysql_result($_rusr, 0, 'Login');
	  $Email = mysql_result($_rusr, 0, 'Email');
	  $Password = mysql_result($_rusr, 0, 'Password');
	  $Description = mysql_result($_rusr, 0, 'Description');
	  $Phone = mysql_result($_rusr, 0, 'Phone');
	  $NotActive = mysql_result($_rusr, 0, 'NotActive');
	  $judul = "Edit User - $usr";
	  $usrmodul = "<input type=button name='none' value='Edit Modul' onClick='location=\"sysfo.php?syxec=usermodul&usr=$usr&usrid=$usrid&PHPSESSID=$sid\"'>";
	}
	else {
	  $Name = '';
	  $Login = '';
	  $Email = '';
	  $Password = '';
	  $Description = '';
	  $Phone = '';
	  $NotActive = 'N';
	  $judul = "Tambah User - $usr";
	  $usrmodul = '';
	}
	if ($NotActive=='Y') $strna = 'checked';
	else $strna = '';
	echo "<form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='usrid' value=$usrid>
	  <input type=hidden name='usr' value='$usr'>
	  <input type=hidden name='OldLogin' value='$Login'>
	  <input type=hidden name='OldPassword' value='$Password'>
	  <table width=100% class=basic cellspacing=1 cellpadding=1>
	  <tr><th class=ttl colspan=3>$judul</th></tr>
	  <tr><td class=lst rowspan=8 align=center><img src='image/tux001.jpg'></td>
	  <td class=lst>Nama Login</td><td class=lst><input type=text name='Login' value='$Login' size=20 maxlength=10></td></tr>
	  <tr><td class=lst>Nama Lengkap</td><td class=lst><input type=text name='Name' value='$Name' size=35 maxlength=50></td></tr>
	  <tr><td class=lst>Email</td><td class=lst><input type=text name='Email' value='$Email' size=35 maxlength=50></td></tr>
	  <tr><td class=lst>Password</td><td class=lst><input type=password name='Password' value='$Password' size=20 maxlength=10></td></tr>
	  <tr><td class=lst>Telepon</td><td class=lst><input type=text name='Phone' value='$Phone' size=20 maxlength=30></td></tr>
	  <tr><td class=lst>Tidak aktif</td><td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
	  <tr><td class=lst>Keterangan</td><td class=lst>
	    <textarea name='Description' cols=30 rows=3>$Description</textarea></td></tr>
	  <tr><td class=lst colspan=2 align=center>
	    <input type=submit name='prc' value='Simpan'>
		<input type=reset name='reset' value='Reset'>
		<input type=button name='none' value='Kembali' onClick='location=\"sysfo.php?syxec=$act&usr=$usr&PHPSESSID=$sid\"'>
		$usrmodul
		</td></tr>
	  </table></form>";
  }

  function ProcessUserForm() {
    global $strCantQuery, $usrid;
    $usr = $_REQUEST['usr'];
    $usrid = $_REQUEST['usrid'];
    $Name = FixQuotes($_REQUEST['Name']);
    $Login = FixQuotes($_REQUEST['Login']);
	$OldLogin = FixQuotes($_REQUEST['OldLogin']);
    $Email = FixQuotes($_REQUEST['Email']);
    $Password = FixQuotes($_REQUEST['Password']);
	$OldPassword = FixQuotes($_REQUEST['OldPassword']);
    $Description = FixQuotes($_REQUEST['Description']);
    $Phone = FixQuotes($_REQUEST['Phone']);
	if (isset($_REQUEST['NotActive'])) $NotActive = $_REQUEST['NotActive'];
	else $NotActive = 'N';
	if ($usrid > 0) {
	  // cek perubahan password
	  if ($OldPassword != $Password) {
	    echo "<script language=JavaScript>alert('Terjadi perubahan password');</script>";
		$strChgPwd = ", Password=PASSWORD('$Password') ";
	  }
	  else $strChgPwd = '';
	  // cek perubahan login
	  if ($OldLogin != $Login) {
	    $_sck = "select ID, Login, Name from $usr where Login='$Login' and ID <> $usrid";
	    $_rck = mysql_query($_sck) or die("$strCantQuery: $_sck");
		if (mysql_num_rows($_rck) > 0) {
		  echo "<script language=JavaScript>alert('Perubahan Login tidak dapat dilakukan karena Login telah dipakai user lain');</script>";
		  $strChgLgn = '';
		}
		else $strChgLgn = ", Login='$Login' ";
	  }
	  else $strChgLgn = '';
	  // baru operasi penyimpanan
	  $_sql = "update $usr set Name='$Name', Email='$Email', Description='$Description',
	    Phone='$Phone', NotActive='$NotActive' $strChgPwd $strChgLgn where ID=$usrid";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	}
	elseif ($usrid == 0) {
	  $_sql = "insert into $usr (Name, Login, Email, Password, Description, Phone, NotActive)
	    values('$Name', '$Login', '$Email', PASSWORD('$Password'), '$Description', '$Phone', '$NotActive')";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  $_sls = "select LAST_INSERT_ID() as NMR";
	  $_rls = mysql_query($_sls) or die("$strCantQuery: $_sls");
	  $usrid = mysql_result($_rls, 0, 'NMR');
	}
  }
  // *** Parameter ***
  if (isset($_REQUEST['usr'])) $usr = $_REQUEST['usr'];
  else die(DisplayHeader($fmtErrorMsg, $strNotAuthorized, 0));
  if (isset($_REQUEST['usrid'])) $usrid = $_REQUEST['usrid'];
  else $usrid = -1;
  if (isset($_REQUEST['usrsr'])) $usrsr = $_REQUEST['usrsr'];
  else $usrsr = 0;
  if (isset($_REQUEST['prc'])) ProcessUserForm();
  if (isset($_REQUEST['_Name'])) {
    $SearchMode = '_Name';
	$nilai = $_REQUEST['nilai'];
  }
  elseif (isset($_REQUEST['_Login'])) {
    $SearchMode = '_Login';
	$nilai = $_REQUEST['nilai'];
  }
  elseif (isset($_REQUEST['_None'])) {
    $SearchMode = '_None';
	$nilai = '';
  }
  else {
    if (isset($_SESSION['SearchMode'])) {
	  $SearchMode = $_SESSION['SearchMode'];
	  $nilai = $_SESSION['nilai'];
	}
	else {
      $SearchMode = '_None';
	  $nilai = '';
	}
  }
  $_SESSION['SearchMode'] = $SearchMode;
  $_SESSION['nilai'] = $nilai;

  if ($_SESSION['SearchMode'] != '_None') {
    $key = substr($_SESSION['SearchMode'], 1);
	$strwhr = "where $key like '%" . $_SESSION['nilai'] . "%' ";
  }
  else $strwhr = '';
  
  // *** BAGIAN UTAMA ***
  DisplayHeader($fmtPageTitle, "Adm. Akses User - $usr");
  DisplaySearchUser($usr, $nilai);
  echo "<a href='sysfo.php?syxec=useraccess&usr=$usr&usrid=0'>Tambahkan $usr</a>";
  if (isset($_REQUEST['usrid'])) DisplayUserForm($usr, $usrid, 'useraccess', "$SearchMode=1&nilai=$nilai");
  else DisplayUserList();

?>