<?php
   Author: USNI (human@usni.ac.id), Juni 2010
    
  $unip = $_SESSION['unip'];
  if (!isset($_REQUEST['sr'])) $sr = 0;
  else $sr = $_REQUEST['sr'];
  
  if (empty($_REQUEST['FilterCategory'])) $FilterCategory = "";
  else $FilterCategory = $_REQUEST['FilterCategory'];
  
  if (!empty($FilterCategory)) $strFilterCategory = "and Category='$FilterCategory'";
  else $strFilterCategory = "";
  
  if (isset($_REQUEST['judul'])) $judul = $_REQUEST['judul'];
  else $judul = $FilterCategory;
  DisplayHeader ($fmtPageTitle, $judul);

  $ulevel = $_SESSION['ulevel'];
  
  if (!(strpos($newsadmin_level, $ulevel)===false)) {
    echo "<a href='index.php?exec=posttrn&Category=$FilterCategory'>$strAdd $judul</a><br>";
  }
  $table = "news where Language='$Language' and Level>=$ulevel $strFilterCategory and NotActive='N' order by NewsID desc";
  
  $pagefmt = "<a href='index.php?exec=listoftrn&sr==STARTROW=&FilterCategory=$FilterCategory'>=PAGE=</a>";
  $pageoff = "<b>=PAGE=</b>";
    
  $lister = new lister;
  $lister->tables = $table;
  $lister->fields = "*, DATE_FORMAT(DateExpired, '%d %b %y') as tgl,
    DATE_FORMAT(DateExpired, '%H:%i') as jam ";
  $lister->startrow = $sr;
  $lister->maxrow = $maxrow;
  $lister->headerfmt = "<table class=basic width=100% cellspacing=0 cellpadding=1>
    <tr><th class=ttl>#</th>
	<th class=ttl>$judul</th>
	<th class=ttl>$strSpeaker</th>
	<th class=ttl>$strDate</th>
	<th class=ttl>$strTime</th>
	<th class=ttl>$strCharge</th>
	<th class=ttl>$strLocation</th></tr>";
  $lister->detailfmt = "<tr><td class=lst>=NOMER=</td>
    <td class=lst><a href='index.php?exec=trndetail&toex=posttrn&NewsID==NewsID='>=Title=</a></td>
	<td class=lst>=Author=</td>
	<td class=lst>=tgl=</td>
	<td class=lst>=jam=</td>
	<td class=lst>=Charge=</td>
	<td class=lst>=Location=</td>
	<tr>";
  $lister->footerfmt = "</table>";
  $halaman = $lister->WritePages ($pagefmt, $pageoff);
  $TotalNews = $lister->MaxRowCount;

  echo "$strPage: $halaman<br>";
  echo $lister->ListIt ();
  echo "<p>$strPage: $halaman</p>";  
  echo "$strTotalData: $TotalNews";

  $MaxRowOption = "";
  for ($i=1; $i < 10; $i++) {
    $jml = $i * 5;
    if ($jml == $maxrow)
      $MaxRowOption = $MaxRowOption."<option selected>$jml</option>";
    else
      $MaxRowOption = $MaxRowOption."<option>$jml</option>";
  }
  $MaxRowOption = "$MaxRowOption<option>1000</option>";
?>
<hr>
<form action='index.php' method=GET>
  <?php echo "$strChangeMaxRowTo: "; ?>
  <input type=hidden name='exec' value='listofnews'>
  <input type=hidden name='FilterCategory' value='<?php echo $FilterCategory; ?>'>
  <select name='maxrow' onchange="this.form.submit()">
    <?php echo $MaxRowOption; ?>
  </select>
</form>
