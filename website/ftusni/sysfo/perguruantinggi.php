<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Mei 2003
  
  include "../lib/common.php";
  if (isset($_REQUEST['_kode'])) $_kode = $_REQUEST['_kode']; else $_kode = '';
  if (isset($_REQUEST['_nilai'])) $_nilai = $_REQUEST['_nilai']; else $_nilai = '';
  echo <<<EOF
    <script>
    <!--
    function remote2(kode,PT){
      creator.f1.$_kode.value=kode;
      creator.f1.$_nilai.value=PT;
      window.close();
    }
    //-->
   </script>
EOF;
?>


<?php

  include "../connectdb.php";
  include "../class/lister.class.php";
  include "../printer.css";
  
  echo "<p><h3>Daftar Perguruan Tinggi</h3></p>";

  function SearchPT($def='') {
    global $_kode, $_nilai;
	// Tuliskan JavaScript
	//      win2=window.open('sysfo\perguruantinggi.php?Kode=1&_kode=$_kode&_nilai=$_nilai&ni='+frm.ni.value, 'width=600,height=400,scrollbars,status');
	echo <<<EOF
	<script>
	<!--
	function subremote(frm,kd) {
	  w2=window.open("perguruantinggi.php?"+kd+"=1&_kode=KodePT&_nilai=NamaPT&ni="+frm.ni.value, "", "width=600,height=600,scrollbars,status");
	  w2.creator=self.creator;
	  window.close();
	}
	//-->
	</script>
EOF;

    echo <<<EOF
	  <form action='perguruantinggi.php' method=GET>
	  <input type=hidden name='_kode' value='$_kode'>
	  <input type=hidden name='_nilai' value='$_nilai'>
	  Cari: <input type=text name='ni' value='$def' size=10 maxlength=10>
	  <input type=button name='Kode' value='Cari Kode PT' onClick="subremote(this.form,'Kode')">
	  <input type=submit name='Nama' value='Cari Nama PT' onClick="subremote(this.form,'Nama')">
	  <input type=submit name='Semua' value='Semua' onClick="subremote(this.form,'Semua')">
	  </form>
EOF;
  }
  function DispPTList($sr=0, $src='', $ni='') {
    global $_kode, $_nilai;
	echo <<<EOF
	<script>
	<!--
	function sbrmt(sr) {
	  w2=window.open("perguruantinggi.php?sr="+sr+"&_kode=KodePT&_nilai=NamaPT", "", "width=600,height=600,scrollbars,status");
	  w2.creator=self.creator;
	  window.close();
	}
	//-->
	</script>
EOF;
    //$pagefmt = "<a href='perguruantinggi.php?sr==STARTROW=&_kode=$_kode&_nilai=$_nilai'>=PAGE=</a>";
	$pagefmt = "<font style='cursor:hand' onClick='sbrmt(=STARTROW=)'>=PAGE=</font>";
    $pageoff = "<b>=PAGE=</b>";
  
    if (!empty($src)) $strsrc = "where $src like '%$ni%'"; else $strsrc = '';
    $lister = new lister;
    $lister->tables = "perguruantinggi $strsrc order by Kode";
	//echo $lister->tables;
    $lister->fields = "* ";
    $lister->startrow = $sr;
    $lister->maxrow = 40;
    $lister->headerfmt = "<table class=basic width=100%>
	  <tr><th class=ttl>Kode</th><th class=ttl>Nama</th><th class=ttl>Kota</th></tr>";
    $lister->detailfmt = "<tr><td class=lst><a href=\"javascript:remote2('=Kode=','=Nama=')\">=Kode=</a></td>
	  <td class=lst>=Nama=</td><td class=lst>=Kota=</td></tr>";
    $lister->footerfmt = "</table>";
    $halaman = $lister->WritePages ($pagefmt, $pageoff);
    $TotalNews = $lister->MaxRowCount;
    $usrlist = "<p>Hal.: $halaman<br>".
    $lister->ListIt () .
	  "Hal.: $halaman</p>";
    echo $usrlist;
  }
  
  // *** Bagian Utama ***
  if (isset($_REQUEST['sr'])) $sr = $_REQUEST['sr']; else $sr = 0;
  if (isset($_REQUEST['Kode'])) $src = 'Kode';
  elseif (isset($_REQUEST['Nama'])) $src = 'Nama';
  else $src = '';
  if (isset($_REQUEST['ni'])) $ni = $_REQUEST['ni']; else $ni = '';
  
  SearchPT($ni);
  DispPTList($sr, $src, $ni);
  
  include "../disconnectdb.php";
?>