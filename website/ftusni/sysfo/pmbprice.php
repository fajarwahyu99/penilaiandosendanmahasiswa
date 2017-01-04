<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003
  
  function DisplayProgramPrice($print=0) {
    if ($print == 0)
	  $det = "<tr><td class=lst>=NOMER=</td>
	    <td class=lst>=Kode=</td><td class=lst>=Jurusan=</td>
	      <form action='sysfo.php' method=POST>
	    <td class=lst>
		  <input type=hidden name='syxec' value='pmbprice'>
		  <input type=hidden name='Kode' value='=Kode='>
		  <input type=hidden name='jurusan' value='=Jurusan='>
		  <input type=text name='price' value='=PMBPrice=' size=10 maxlength=10>
		  <input type=submit name=submit value='Ubah'>
	    </td>
		  </form>
	    </tr>";
	else $det = "<tr><td class=lst>=NOMER=</td>
	    <td class=lst>=Kode=</td>
	    <td class=lst>=Jurusan=</td>
	    <td class=lst align=right>=PMBPrice=
	    </td>
	    </tr><tr><td colspan=4 bgcolor=silver height=1></td>
	    </tr>";
    $nbrw = new newsbrowser;
    $nbrw->query = "select Kode, Nama_Indonesia as Jurusan, PMBPrice from jurusan where 
	  NotActive='N' order by Rank";
    $nbrw->headerfmt = "<table class=basic cellspacing=1 cellpadding=2>
	  <tr><th class=ttl colspan=2>Kode</th><th class=ttl>Jurusan</th><th class=ttl>Harga</th></tr>";
    $nbrw->detailfmt = $det;
    $nbrw->footerfmt = "</table>";
    echo $nbrw->BrowseNews();  
  }


  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Biaya Pendaftaran');

  if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn'];
  else $prn = 0;

  if ($prn == 0) DisplayPrinter("print.php?print=sysfo/pmbprice.php&prn=1");  
  if (!isset($_REQUEST['submit'])) {
    DisplayProgramPrice($prn);
  }
  else {
    $_kode = $_REQUEST['Kode'];
    $_jurusan = $_REQUEST['jurusan'];
	$_price = $_REQUEST['price'];
	settype($_price, "int");
	DisplayItem($fmtMessage, 'Pengubahan Sukses', "Harga pendaftaran jurusan <b>$_kode: $_jurusan</b>
	  telah diubah menjadi Rp. $_price");
	$_sql = "update jurusan set PMBPrice=$_price where Kode='$_kode'";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	DisplayProgramPrice($prn);
  }
?>