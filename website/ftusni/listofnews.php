<?php
   //Author: USNI (human@usni.ac.id), Juni 2010
  
  $unip = $_SESSION['unip'];
  if (!isset($_REQUEST['sr'])) $sr = 0;
  else $sr = $_REQUEST['sr'];
  
  if (empty($_REQUEST['FilterCategory'])) $FilterCategory = "";
  else $FilterCategory = $_REQUEST['FilterCategory'];
  
  if (!empty($FilterCategory)) $strFilterCategory = "and Category='$FilterCategory'";
  else $strFilterCategory = "";

  $ulevel = $_SESSION['ulevel'];
  if ($ulevel < 5) {
  $stropt = GetCategory($FilterCategory, 0, $_SESSION['ulevel']);
  
  DisplayHeader ($fmtPageTitle, $strListofNews. ": $FilterCategory");
?>
<p>
  <form action="index.php" method=GET>
    <?php echo "$strNewsCategory :"; ?>
    <input type=hidden name="exec" value="listofnews">
    <select name="FilterCategory" onchange="this.form.submit()">
      <?php echo $stropt; ?>
    </select>
  </form></p>
  
<?php
  }
  $table = "news where Language='$Language' and Level>=$ulevel $strFilterCategory order by NewsID desc";
  $pagefmt = "<a href='index.php?exec=listofnews&sr==STARTROW=&FilterCategory=$FilterCategory'>=PAGE=</a>";
  $pageoff = "<b>=PAGE=</b>";
    
  $lister = new lister;
  $lister->tables = $table;
  $lister->fields = "*, DATE_FORMAT(NewsDate, '%d %b %y') as tgl ";
  $lister->startrow = $sr;
  $lister->maxrow = $maxrow;
  $lister->headerfmt = "<table class=basic cellspacing=0 cellpadding=2 width=100%>
    <tr><th class=ttl colspan=2>$strListofNews</th></tr>";
  $lister->detailfmt = "<tr><th class=lst>=NOMER=</th>
    <td class=lst><a href='index.php?exec=newsdetail&NewsID==NewsID='>=Title=</a>. 
	<font color=gray>(=ReadCount=)<br>
	=tgl= | =Category= | =Author= | =unip= | =NotActive=</font>
	</td></tr>";
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
