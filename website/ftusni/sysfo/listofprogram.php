<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, Mei 2003

  // *** Fungsi2 ***
  function DisplayListofProgram() {
    global $strCantQuery;
	$_sql = "select p.*,k.Kampus,f.Nama_Indonesia as Fak_Indonesia,f.Nama_English as Fak_English from program p
	  left outer join fakultas f on p.KodeFakultas=f.Kode left outer join kampus k on p.KodeKampus=k.Kode
	  order by p.Nama_Indonesia";
	
    $nbrw = new newsbrowser;
    $nbrw->query = $_sql;
    $nbrw->headerfmt = "<table class='basic' width=100% cellspacing=0 cellspacing=0 cellpadding=2>
	  <tr><th class=ttl>Kode</th><th class=ttl>Program</th>
	  <th class=ttl>Kampus</th><th class=ttl>Fakultas</th>
	  <th class=ttl>Tdk Aktif</th></tr>";
    $nbrw->detailfmt = "<tr>
	  <td class=lst><a href='sysfo.php?syxec=listofprogram&md=0&kd==Kode='>=Kode=</a></td>
	  <td class=lst>=Nama_Indonesia=</td>
	  <td class=lst>=Kampus=</td><td class=lst>=Fak_Indonesia=</td>
	  <td class=lst align=center>=NotActive=</td></tr>";
    $nbrw->footerfmt = "</table>";
	
    echo $nbrw->BrowseNews();  
  }
  function GetKodeName($md=0,$tbl,$kd) {
    if ($md==0) $_sql = "select Nama_Indonesia as hsl from $tbl where Kode='$kd'";
	else $_sql = "select Kode as hsl from $tbl where Nama_Indonesia='$kd'";
	$_res = mysql_query($_sql);
	if (mysql_num_rows($_res) == 0) return '';
	else return mysql_result($_res, 0, 'hsl');
  }
  function DisplayProgramForm($md=1,$Kode='',$act='sysfo.php') {
    global $strCantQuery,$fmtPageTitle;
	global $Language;
    if ($md==0) {
	  $Judul = 'Edit Program';
	  $_sql = "select * from program where Kode='$Kode'";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  if (mysql_num_rows($_res)==0) die("Tabel kosong");
	  $Nama_Indonesia = mysql_result($_res,0,'Nama_Indonesia');
	  $Nama_English = mysql_result($_res,0,'Nama_English');
	  $KodeKampus = mysql_result($_res,0,'KodeKampus');
	  $Fak = mysql_result($_res,0,'KodeFakultas');
	  $NotActive = mysql_result($_res,0,'NotActive');
	  $Keterangan = mysql_result($_res,0,'Keterangan');
	  $strKode = "<input type=hidden name='Kode' value='$Kode' size=10 maxlength=10><b>$Kode</b>";
	}
	elseif ($md==1) {
	  $Judul = 'Tambah Program';
	  $Nama_Indonesia = '';
	  $Nama_English = '';
	  $KodeKampus = '';
	  $Fak = '';
	  $NotActive = 'N';
	  $Keterangan = '';
	  $strKode = "<input type=text name='Kode' value='$Kode' size=10 maxlength=10>";
	}
	DisplayHeader($fmtPageTitle,$Judul);
	$fakultas = GetaField('fakultas', 'Kode', $Fak, "Nama_$Language");
	$fakjur = GetOption('fakultas', 'Nama_Indonesia', '', $fakultas);
	
	$kampus = GetaField('kampus','Kode',$KodeKampus, 'Kampus');
	$kmps = GetOption('kampus','Kampus','',$kampus);
	if ($NotActive=='Y') $strna = 'checked';
	else $strna = '';
	$sid = session_id();
	echo <<<EOF
	  <form action='$act' method=GET>
	  <input type=hidden name='syxec' value='listofprogram'>
	  <input type=hidden name='mode' value=$md>
	  <table class=box cellspacing=1 cellpadding=2>
	    <tr><td class=lst>Kode Program</td><td class=lst>$strKode</td></tr>
	    <tr><td class=lst>Nama Indonesia</td>
		  <td class=lst><input type=text name='Nama_Indonesia' value='$Nama_Indonesia' size=40 maxlength=100></td></tr>
	    <tr><td class=lst>Nama English</td>
		  <td class=lst><input type=text name='Nama_English' value='$Nama_English' size=40 maxlength=100></td></tr>

        <tr><td class=lst>Kampus</td>
		  <td class=lst><select name='Kmps'>$kmps</select></td></tr>

        <tr><td class=lst>Fakultas/Jurusan</td>
		  <td class=lst><select name='Fak'>$fakjur</select></td></tr>
		  
		<tr><td class=lst>Tidak Aktif</td><td class=lst><input type=checkbox name='NotActive' value='Y' $strna></td></tr>
		<tr><td class=lst>Keterangan</td><td class=lst><textarea name='Keterangan' cols=35 rows=3>$Keterangan</textarea></td></tr>
		<tr><td class=lst colspan=2 align=center><input type=submit name='prc' value='simpan'>&nbsp;
		  <input type=reset name=reset value=reset>&nbsp;
		  <input type=button name=balik value='Kembali' onClick="location='sysfo.php?syxec=listofprogram&PHPSESSID=$sid'"></td></tr>
	  </table></form>
EOF;
  }
  function ProcessProgramForm() {
    global $strCantQuery, $fmtErrorMsg;
    $mode = $_REQUEST['mode'];
	$Nama_Indonesia = FixQuotes($_REQUEST['Nama_Indonesia']);
	$Nama_English = FixQuotes($_REQUEST['Nama_English']);
	$Kode = FixQuotes($_REQUEST['Kode']);
	$Fak = $_REQUEST['Fak'];
	$Kmps = $_REQUEST['Kmps'];
	$Keterangan = FixQuotes($_REQUEST['Keterangan']);
	$Fakultas = GetaField('fakultas','Nama_Indonesia',$Fak,'Kode');
	$Kampus = GetaField('kampus','Kampus',$Kmps,'Kode');
	if (!isset($_REQUEST['NotActive'])) $NotActive='N';
	else $NotActive = $_REQUEST['NotActive'];
	$login = $_SESSION['unip'];
	if ($mode==0) {
	  $_sql = "update program set Kode='$Kode', Nama_Indonesia='$Nama_Indonesia',
	    Nama_English='$Nama_English', KodeFakultas='$Fakultas', KodeKampus='$Kampus',
		Keterangan='$Keterangan',NotActive='$NotActive'
		where Kode='$Kode'  ";
	}
	elseif ($mode==1) {
	  $_chk = GetaField('program','Kode',$Kode,'Kode');
	  if (!empty($_chk)) die(DisplayHeader($fmtErrorMsg,"Kode <b>$Kode</b> sudah ada.",0));
	  $_sql = "insert into program (Kode,Nama_Indonesia,Nama_English,KodeFakultas,KodeKampus,
	    Keterangan,Login,Tgl,NotActive) 
		values('$Kode','$Nama_Indonesia','$Nama_English',
		'$Fakultas','$Kampus','$Keterangan','$login',now(),'$NotActive')";
	}
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
  }

  // *** Bagian Utama ***
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
  else $prn = 0;
  
  if (isset($_REQUEST['md'])) {
    if ($_REQUEST['md']==0) DisplayProgramForm(0,$_REQUEST['kd']);
	elseif ($_REQUEST['md']==1) DisplayProgramForm(1);
  }
  else {
    DisplayHeader($fmtPageTitle, "Program");
    if (isset($_REQUEST['prc'])) ProcessProgramForm();
    if ($prn == 0) {
      DisplayPrinter("print.php?print=sysfo/listofprogram.php&prn=1");
	  echo "<br>";
      echo "<a href='sysfo.php?syxec=listofprogram&md=1'>Tambah Program</a>";
    }
    DisplayListofProgram();
  }

?>