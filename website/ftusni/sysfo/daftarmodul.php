<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Juli 2003

  // *** Fungsi2 ***
  function DispAllModules() {
    global $strCantQuery, $fmtPageTitle;
	DisplayHeader($fmtPageTitle, "Daftar Modul Standar USNI");
	$s = "select * from modul order by GroupModul, Modul";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	$mdl = '';
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>Judul</th><th class=ttl>Lev</th><th class=ttl>Keterangan</th>
	  <th class=ttl>Script</th><th class=ttl>Author</th></tr>";
	while ($row = mysql_fetch_array($r)) {
	  if ($row['GroupModul'] != $mdl) {
	    echo "<tr><th class=nac colspan=5 bgcolor=white>$row[GroupModul]</th></tr>";
		$mdl = $row['GroupModul'];
	  }
	  echo <<<EOF
	  <tr><td class=lst>$row[Modul]</td><td class=lst>$row[Level]</td>
	  <td class=lst>$row[Description]</td><td class=lst>$row[Link]</td>
	  <td class=lst><a href='mailto:$row[EmailAuthor]'>$row[Author]</td>
	  </tr>
EOF;
	}
	$r1 = mysql_query("select count(*) as jml from modul");
	$jml = mysql_result($r1, 0, 'jml');
	echo "</table><br>
	Total Modul: <b>$jml</b><br>
	SisFo FT USNI oleh USNI";
  }
  function DispAdditionalModules() {
    global $strCantQuery, $fmtPageTitle;
	DisplayHeader($fmtPageTitle, "Daftar Modul Tambahan - Spesifik");
	$scriptdir = "sysfo/script/";
	echo "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl>#</th><th class=ttl>Nama</th><th class=ttl>Keterangan</th><th class=ttl>Script</th>
	  <th class=ttl>Author</th></tr>";
	$dr = dir ($scriptdir);
	$nmr = 0;
    while ($isi = $dr->read()) {
      if ($isi != "." and $isi != "..") {
        //echo "$Download_dir$isi<br>";
        //$sz = filesize("$Source_dir$isi");
	    //$dt = date('d-M-y', fileatime("$Source_dir$isi"));
        //$fl = "$fl $isi - $sz<br>";
		include_once "$scriptdir$isi";
		$nmr++;
		$nm = str_replace('.php', '', $isi);
		$fn = $nm.'0';
		$arr = $fn();
		echo <<<EOF
		<tr><td class=ttl>$nmr</td><td class=lst>$arr[0]</td><td class=lst>$arr[1]</td><td class=lst>$nm</td>
		<td class=lst><a href='mailto:$arr[3]'>$arr[2]</td>
		</tr>
EOF;
	  }
    }
	$dr->close();
	echo "</table><br>
	  Jumlah Modul/Script Tambahan: <b>$nmr</b>";
  }
  
  // *** Bagian Utama ***
  if (isset($_REQUEST['md'])) $md = $_REQUEST['md']; else $md = -1;
  if ($md == -1) DispAllModules();
  elseif ($md == 1) DispAdditionalModules();
?>