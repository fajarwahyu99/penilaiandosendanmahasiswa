<?php
  // Author: E. Setio Dewo (setio_dewo@telkom.net), April 2003  

  // *** FUngsi2 ***
  function PrcMGM() {
    $PMBID = $_REQUEST['PMBID'];
	$mgm = $_REQUEST['mgm'];
	if ($mgm == 'Y') {
	  $mgmoleh = $_REQUEST['mgmoleh'];
	  $arrpmb = GetFields('pmb', 'PMBID', $PMBID, 'Program, ProgramType, StatusAwal');
	  $hnr = GetaField('honormgm', "KodeProgram='$arrpmb[ProgramType]' and StatusAwal", $arrpmb['StatusAwal'], 'PMBHonor');
	  if (empty($hnr)) $hnr = GetaField('honormgm', "KodeProgram", $arrpmb['ProgramType'], 'PMBHonor');
	}
	else {
	  $mgmoleh = '';
	  $hnr = 0;
	}
	$s = "update pmb set MGM='$mgm', MGMOleh='$mgmoleh', MGMHonor=$hnr where PMBID='$PMBID'";
	$r = mysql_query($s) or die("Gagal Query: $s.<br>".mysql_error());
  }
  
  DisplayHeader ($fmtPageTitle, $strListofNewStudent);
  if (isset($_REQUEST['prcmgm'])) PrcMGM();
  if (isset($_REQUEST['subtitle']))
    DisplayHeader("<center><b>=TITLE=</b></center>", $_REQUEST['subtitle']);
  
  $unip = $_SESSION['unip'];
  if (isset($_REQUEST['pmbsr'])) {
    $sr = $_REQUEST['pmbsr'];
	$_SESSION['pmbsr'] = $sr;
  }
  else {
    if (isset($_SESSION['pmbsr'])) $sr = $_SESSION['pmbsr'];
	else $sr = 0;
  }

  // Action
  if (empty($_SESSION['sysfo'])) $action = 'index.php';
  else $action = 'sysfo.php';
  
  // enable/disable prnures
  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
  else $prn = 0;
    
  // *** Tampilan Fasilitas ***
  // Bikin table biar tampilan fasilitas makin baik
  echo "<table class=box cellspacing=1 cellpadding=2>";
  // --- Urut berdasarkan: ---
  if (isset($_REQUEST['ob'])) {
    $ob = $_REQUEST['ob'];
	$_SESSION['ob'] = $ob;
  }
  else {
    if (isset($_SESSION['ob'])) $ob = $_SESSION['ob'];
	else {
	  $ob = 'Name';
	  $_SESSION['ob'] = $ob;
	}
  }
  $_ob_id = ''; $_ob_nm = '';
  if ($ob == 'PMBID') $_ob_id = 'selected';
  else $_ob_nm = 'selected';
  // ***
  if ($prn == 0) {
    echo "<tr valign=top><td class=uline>Urutkan:</td>
      <form action='$action' method=GET>
      <input type=hidden name='syxec' value='listofnewstudent'>
	  <input type=hidden name='sr' value=$sr>
	  <td class=uline>
	  <select name='ob' onchange=\"this.form.submit()\">
	    <option $_ob_id>PMBID</option>
	    <option $_ob_nm>Name</option>
	  </select></td></form></tr>";
  }

  // --- Pilihan Jurusan ---
  if (isset($_REQUEST['kdj'])) {
    $kdj = $_REQUEST['kdj'];
	$_SESSION['kdj'] = $kdj;
  }
  else {
    if (isset($_SESSION['kdj'])) $kdj = $_SESSION['kdj'];
	else $kdj = '';
  }
  if (!empty($kdj)) $strFilterJurusan = "and p.Program='$kdj'";
  else $strFilterJurusan = '';
  // ***
  if ($prn == 0) {
    $_opt = GetOption2('jurusan',"concat(Kode, ' -- ', Nama_Indonesia)", 'Rank', $kdj, '', 'Kode');
    echo "<tr  valign=top><td class=uline>Jurusan:</td>
      <form action='$action' method=GET>
      <input type=hidden name='syxec' value='listofnewstudent'>
	  <input type=hidden name='ob' value='$ob'>
	  <input type=hidden name='sr' value=$sr>
	  <td class=uline>
	  <select name='kdj' onchange=\"this.form.submit()\">$_opt</select>
      </td></form></tr>";
  }

  // Cari PMBID
  if (isset($_REQUEST['SearchID'])) $SearchID = $_REQUEST['Search'];
  else $SearchID = '';
  if (!empty($SearchID)) $strSearchID = "and p.PMBID like '$SearchID%'";
  else $strSearchID = '';
    
  // Cari Name
  if (isset($_REQUEST['SearchName'])) $SearchName = $_REQUEST['Search'];
  else $SearchName = '';
  if (!empty($SearchName)) $strSearchName = "and p.Name like '%$SearchName%'";
  else $strSearchName = '';
	
  // Pencarian
  if ($prn == 0) {
  echo "<tr valign=top><td class=uline>Cari:</td>
    <form action='$action' method=GET>
    <input type=hidden name='syxec' value='listofnewstudent'>
	<td class=uline>
	<input type=text name='Search' size=10>
	<input type=submit name='SearchID' value='Cari PMBID'>
	<input type=submit name='SearchName' value='Cari Nama'>
	</td></form></tr>";
  }

  // --- tampilkan hanya yg lulus ---
  if (isset($_REQUEST['TestPass'])) {
    $TestPass = $_REQUEST['TestPass'];
	$_SESSION['TestPass'] = $TestPass;
  }
  else {
    if (isset($_SESSION['TestPass'])) $TestPass = $_SESSION['TestPass'];
	else {
	  $TestPass = '';
	  $_SESSION['TestPass'] = $TestPass;
	}
  }
  if (!empty($TestPass)) $strTestPass = "and TestPass='$TestPass'";
  else $strTestPass = '';
  $str_tp_y = ''; $str_tp_n = ''; $str_tp_a = '';
  if ($TestPass == 'Y') $str_tp_y = 'checked';
  else if ($TestPass == 'N') $str_tp_n = 'checked';
  else if ($TestPass == '') $str_tp_a = 'checked';
  
  // tampilkan hanya yg sudah bayar
  if (isset($_REQUEST['Paid'])) {
    $Paid = $_REQUEST['Paid'];
	$_SESSION['Paid'] = $Paid;
  }
  else {
    if (isset($_SESSION['Paid'])) $Paid = $_SESSION['Paid'];
	else {
	  $Paid = '';
	  $_SESSION['Paid'] = '';
	}
  }
  if (!empty($Paid)) $strPaid = "and PMBPaid='$Paid'";
  else $strPaid = '';
  $str_p_y = ''; $str_p_n = ''; $str_p_a = '';
  if ($Paid == 'Y') $str_p_y = 'checked';
  else if ($Paid == 'N') $str_p_n = 'checked';
  else if ($Paid == '') $str_p_a = 'checked';

  if ($prn == 0) {
    // Yg Lulus
    echo "<tr valign=top><td class=uline>Daftar Kelulusan</td>
      <form action='$action' method=GET>
      <input type=hidden name='syxec' value='listofnewstudent'>
	  <td class=uline>
	    <input type=radio name='TestPass' value='Y' id='tp_y' $str_tp_y>
	    <label for='tp_y'>Yg Lulus</label>
	    <input type=radio name='TestPass' value='N' id='tp_n' $str_tp_n>
	    <label for='tp_y'>Tidak Lulus</label>
	    <input type=radio name='TestPass' value='' id='tp_a' $str_tp_a>
	    <label for='tp_y'>Semua</label>
	  <input type=submit name='SubmitTestPass' value='Refresh'>
	  </td></form></tr>";
	  
	// Yg sudah Bayar
    echo "<tr valign=top><td class=uline>Pembayaran PMB</td>
      <form action='$action' method=GET>
      <input type=hidden name='syxec' value='listofnewstudent'>
	  <td class=uline>
	    <input type=radio name='Paid' value='Y' id='tp_y' $str_p_y>
	    <label for='tp_y'>Sudah Bayar</label>
	    <input type=radio name='Paid' value='N' id='tp_n' $str_p_n>
	    <label for='tp_y'>Belum</label>
	    <input type=radio name='Paid' value='' id='tp_a' $str_p_a>
	    <label for='tp_y'>Semua</label>
	  <input type=submit name='SubmitPaid' value='Refresh'>
	  </td></form></tr>";
  }
  echo "</table>";
  
  // *** Bagian Penting ***
  include "lib/table.common.php";
  $prefix = GetPMBPrefix();
  $ulevel = $_SESSION['ulevel'];
  if ($ulevel > 3)
    $pmb_det = "<tr>
	<td class=lst>=PMBID=</td>
	<td class=lst>=Name=</td>
	<td class=lst>=Program=</td>
	<td class=lst>=PRG=</td>
	<td class=lst align=right>=TestScore=</td>
	<td class=lst align=center><img src='image/=TestPass=.gif'></td>
	<td class=lst align=center><img src='image/=PMBPaid=.gif'></td><td class=lst>=STA=</td>
	<td class=uline></td><td class=uline></td></tr>";
  else
    $pmb_det = "<tr>
    <td class=lst><a href='$action?syxec=pmbform&PMBID==PMBID='>=PMBID=</a></td>
    <td class=lst>=Name=</td>
	<td class=lst>=JUR=</td>
	<td class=lst>=PRG=</td>
	<td class=lst align=right><a href='$action?syxec=editscore&PMBID==PMBID='>=TestScore=</a></td>
	<td class=lst align=center><img src='image/=TestPass=.gif' border=0></td>
	<td class=lst align=center><a href='$action?syxec=editpayment&PMBID==PMBID='><img src='image/=PMBPaid=.gif' border=0></a></td>
	<td class=lst>=STA=</td>
	<td class=lst align=center><a href='$action?syxec=pmbgetmbr&PMBID==PMBID=&md=0' title='Oleh: =MGMOleh=\n=Oleh='><img src='image/mgm=MGM=.gif' border=0></a></td>
	<td class=lst align=center><a href='$action?syxec=pmbcheck&PMBID==PMBID='><img src='image/check.gif' border=0></a></td>
    </tr>";

  // *** TABLE ***
  $table = "pmb p left outer join jurusan j on p.Program=j.Kode
    left outer join statusawalmhsw st on p.StatusAwal=st.Kode
	left outer join program pr on p.ProgramType=pr.Kode
	left outer join mbrgetmbr m on p.MGMOleh=m.ID
    where p.PMBID like '$prefix%' $strFilterJurusan $strSearchID $strSearchName $strTestPass $strPaid order by p.$ob";
  
  $pagefmt = "<a href='$action?syxec=listofnewstudent&pmbsr==STARTROW='>=PAGE=</a>";
  $pageoff = "<b>=PAGE=</b>";
    
  $lister = new lister;
  $lister->tables = $table;
  $lister->fields = "p.*, DATE_FORMAT(p.BirthDate, '%d %b %y') as tgl, concat(j.Kode, ' - ', j.Nama_Indonesia) as JUR, 
    st.Nama as STA, pr.Nama_Indonesia as PRG, m.Nama as Oleh ";
  $lister->startrow = $sr;
  $lister->maxrow = $maxrow;
  $lister->headerfmt = "<table class='basic' cellspacing=0 cellpadding=2 width=100%>
    <tr><th class=ttl>PMBID</th><th class=ttl>Nama</th>
	<th class=ttl>Jurusan</th><th class=ttl>Program</th><th class=ttl>Nilai</th><th class=ttl>Lulus</th>
	<th class=ttl>Bayar</th><th class=ttl>Status</th>
	<th class=ttl><img src='image/mgmY.gif' border=0></th><th></th></tr>";
  $lister->detailfmt = $pmb_det;
  $lister->footerfmt = "</table>";
  $halaman = $lister->WritePages ($pagefmt, $pageoff);
  $TotalNews = $lister->MaxRowCount;

  if ($prn == 0) {
    $Jurusan = GetaField('jurusan', 'Kode', $kdj, 'Nama_Indonesia');
    DisplayPrinter("print.php?print=sysfo/listofnewstudent.php&Jurusan=$Jurusan&ob=$ob&TestPass=$TestPass&Paid=$Paid&feat=0&prn=1&subtitle=Jurusan: $Jurusan, Urut: $ob, Bayar: $Paid, Lulus: $TestPass");
	echo "<br>";
  }
  echo "$strPage: $halaman<br>";
  echo $lister->ListIt ();
  if ($prn == 0) echo "<p>$strPage: $halaman</p>";  
  echo "$strTotalData: $TotalNews";
  
  echo "<table class=basic cellspacing=0 cellpadding=2>
    <tr><td class=uline><img src='image/mgmY.gif' border=0></td><td class=uline>Member Get Member</td></tr>
	<tr><td class=uline><img src='image/check.gif' border=0></td><td class=uline>Check List</td></tr>
	</table>";

  $MaxRowOption = "";
  for ($i=1; $i < 10; $i++) {
    $jml = $i * 5;
    if ($jml == $maxrow)
      $MaxRowOption = $MaxRowOption."<option selected>$jml</option>";
    else
      $MaxRowOption = $MaxRowOption."<option>$jml</option>";
  }
  $MaxRowOption = "$MaxRowOption<option>1000</option>";
  
  if ($prn == 0) {
?>
<hr>
<form action='<?php echo $action; ?>' method=GET>
  <?php echo "$strChangeMaxRowTo: "; ?>
  <input type=hidden name='syxec' value='listofnewstudent'>
  <select name='maxrow' onchange="this.form.submit()">
    <?php echo $MaxRowOption; ?>
  </select>
</form>

<?php
  }
?>