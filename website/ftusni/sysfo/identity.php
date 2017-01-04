<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  function DispIdentityForm() {
    global $strCantQuery;
	$s = "select * from identitas limit 1";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$Kode = mysql_result($r, 0, 'Kode');
	$KodeHukum = mysql_result($r, 0, 'KodeHukum');
	$Nama = mysql_result($r, 0, 'Nama');
	$TglMulai = mysql_result($r, 0, 'TglMulai');
	$Alamat1 = mysql_result($r, 0, 'Alamat1');
	$Alamat2 = mysql_result($r, 0, 'Alamat2');
	$Kota = mysql_result($r, 0, 'Kota');
	$KodePos = mysql_result($r, 0, 'KodePos');
	$Telp = mysql_result($r, 0, 'Telp');
	$Fax = mysql_result($r, 0, 'Fax');
	$Email = mysql_result($r, 0, 'Email');
	$Website = mysql_result($r, 0, 'Website');
	$NoAkta = mysql_result($r, 0, 'NoAkta');
	$TglAkta = mysql_result($r, 0, 'TglAkta');
	$NoSah = mysql_result($r, 0, 'NoSah');
	$TglSah = mysql_result($r, 0, 'TglSah');
	$Logo = mysql_result($r, 0, 'Logo');
	if (file_exists($Logo)) $strLogo = "<img src='$Logo' border=0 width=75>";
	else $strLogo = "Logo";
	
	$tm = explode('-',$TglMulai);
	$opttm_y = GetNumberOption(1940, 2010, $tm[0]);
	$opttm_m = GetMonthOption($tm[1]);
	$opttm_d = GetNumberOption(1, 31, $tm[2]);

	$ta = explode('-', $TglAkta);
	$optta_y = GetNumberOption(1940, 2010, $ta[0]);
	$optta_m = GetMonthOption($ta[1]);
	$optta_d = GetNumberOption(1, 31, $ta[2]);

	$ts = explode('-', $TglSah);
	$optts_y = GetNumberOption(1940, 2010, $ts[0]);
	$optts_m = GetMonthOption($ts[1]);
	$optts_d = GetNumberOption(1, 31, $ts[2]);

	echo <<<EOF
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='identity'>
	  <table class=box cellspacing=1 cellpadding=2 width=100%>
	  <tr><th class=ttl colspan=3>Identitas Perguruan Tinggi</th></tr>
	  <tr><td class=uline rowspan=15 valign=top align=center>$strLogo</td>
	  <td class=uline>Kode PT</td><td class=uline><input type=text name='Kode' value='$Kode' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>Kode Badan Hukum</td><td class=uline><input type=text name='KodeHukum' value='$KodeHukum' size=10 maxlength=10></td></tr>
	  <tr><td class=uline>Nama</td><td class=uline><input type=text name='Nama' value='$Nama' size=40 maxlength=100></td></tr>
	  <tr><td class=uline>Tgl Berdiri</td><td class=uline><select name='tm_d'>$opttm_d</select>
	    <select name='tm_m'>$opttm_m</select>
	    <select name='tm_y'>$opttm_y</select></td></tr>
	  <tr><td class=uline rowspan=2>Alamat</td><td class=uline><input type=text name='Alamat1' value='$Alamat1' size=40 maxlength=100></td></tr>
	  <tr><td class=uline><input type=text name='Alamat2' value='$Alamat2' size=40 maxlength=100></td></tr>
	  <tr><td class=uline>Kota & Kode Pos</td><td class=uline><input type=text name='Kota' value='$Kota' size=25 maxlength=50> <input type=text name='KodePos' value='$KodePos' size=10 maxlength=20></td></tr>
	  <tr><td class=uline>Telp & Fax</td><td class=uline><input type=text name='Telp' value='$Telp' size=15 maxlength=20> <input type=text name='Fax' value='$Fax' size=15 maxlength=20></td></tr>
	  <tr><td class=uline>E-mail</td><td class=uline><input type=text name='Email' value='$Email' size=40 maxlength=50></td></tr>
	  <tr><td class=uline>Website</td><td class=uline><input type=text name='Website' value='Website' size=40 maxlength=50></td></tr>
	  <tr><td class=uline>Nomer Akta</td><td class=uline><input type=text name='NoAkta' value='$NoAkta' size=40 maxlength=50></td></tr>
	  <tr><td class=uline>Tgl Akta</td><td class=uline><select name='ta_d'>$optta_d</select>
	    <select name='ta_m'>$optta_m</select>
	    <select name='ta_y'>$optta_y</select></td></tr>

	  <tr><td class=uline>Nomer Pengesahan PN/LN</td><td class=uline><input type=text name='NoSah' value='$NoSah' size=40 maxlength=50></td></tr>
	  <tr><td class=uline>Tgl Pengesahan</td><td class=uline><select name='ts_d'>$optts_d</select>
	    <select name='ts_m'>$optts_m</select>
	    <select name='ts_y'>$optts_y</select></td></tr>

	  <tr><td class=uline colspan=3 align=center>
	    <input type=submit name='prc' value='Simpan'>
		<input type=reset name='reset' value='Reset'>
	  </td></tr>
	  
	  </table></form>
EOF;
  }
  function PrcIdentityForm() {
    global $strCantQuery, $fmtErrorMsg, $fmtMessage;
	$Kode = FixQuotes($_REQUEST['Kode']);
	$KodeHukum = FixQuotes($_REQUEST['KodeHukum']);
	$Nama = FixQuotes($_REQUEST['Nama']);
	  $tm_d = $_REQUEST['tm_d'];
	  $tm_m = $_REQUEST['tm_m'];
	  $tm_y = $_REQUEST['tm_y'];
	$TglMulai = "$tm_y-$tm_m-$tm_d";

	$Alamat1 = FixQuotes($_REQUEST['Alamat1']);
	$Alamat2 = FixQuotes($_REQUEST['Alamat2']);
	$Kota = FixQuotes($_REQUEST['Kota']);
	$KodePos = FixQuotes($_REQUEST['KodePos']);
	$Telp = FixQuotes($_REQUEST['Telp']);
	$Fax = FixQuotes($_REQUEST['Fax']);
	$Email = FixQuotes($_REQUEST['Email']);
	$Website = FixQuotes($_REQUEST['Website']);
	$NoAkta = FixQuotes($_REQUEST['NoAkta']);
	  $ta_d = $_REQUEST['ta_d'];
	  $ta_m = $_REQUEST['ta_m'];
	  $ta_y = $_REQUEST['ta_y'];
	$TglAkta = "$ta_y-$ta_m-$ta_d";

	$NoSah = FixQuotes($_REQUEST['NoSah']);
	  $ts_d = $_REQUEST['ts_d'];
	  $ts_m = $_REQUEST['ts_m'];
	  $ts_y = $_REQUEST['ts_y'];
	$TglSah = "$ts_y-$ts_m-$ts_d";

	$s = "update identitas set Kode='$Kode', KodeHukum='$KodeHukum', Nama='$Nama', TglMulai='$TglMulai',
	  Alamat1='$Alamat1', Alamat2='$Alamat2', Kota='$Kota', KodePos='$KodePos', Telp='$Telp', Fax='$Fax',
	  Email='$Email', Website='$Website', NoAkta='$NoAkta', TglAkta='$TglAkta', NoSah='$NoSah',
	  TglSah='$TglSah'	";
	$r = mysql_query($s) or die(DisplayHeader($fmtErrorMsg, "Tidak dapat menyimpan identitas.<br>Query: $s".mysql_error(), 0));
	DisplayItem($fmtMessage, 'Telah Disimpan', 'Perubahan Identitas Perguruan Tinggi telah disimpan dengan baik.');
  }
  
  DisplayHeader($fmtPageTitle, "Perguruan Tinggi");
  if (isset($_REQUEST['prc'])) PrcIdentityForm();
  DispIdentityForm();
?>