<?php
  function DisplayHeader ($fmt, $title, $write=1) {
    if ($write==1)
	  echo str_replace('=TITLE=', $title, $fmt);
	return str_replace('=TITLE=', $title, $fmt);
  }
  
  function DisplayItem ($fmt, $link, $item, $write=1) {
	$fmt = str_replace('=LINK=', $link, $fmt);
	$fmt = str_replace('=ITEM=', $item, $fmt);
	if ($write==1)
	  echo $fmt;
	return $fmt;
  }
  function DisplayDetail ($fmt, $link, $item, $item2="", $write=1) {
	$fmt = str_replace('=LINK=', $link, $fmt);
	$fmt = str_replace('=ITEM=', $item, $fmt);
	$fmt = str_replace('=ITEM2=', $item2, $fmt);
	if ($write==1)
	  echo $fmt;
	return $fmt;
  }

  // tampilkan berita
  function DisplayNewsIn($ctgr) {
    global $Language, $DefaultNewsList, 
	  $fmtMainNews_header, $fmtMainNews_detail, $fmtMainNews_footer;
	$_level = $_SESSION['ulevel'];
    $nbrw = new newsbrowser;
    $nbrw->query = "select *,
	  DATE_FORMAT(NewsDate, '%d-%b-%y') as tgl 
      from news where Category='$ctgr' and Level >= $_level and NotActive='N'
      and Language='$Language' order by NewsID Desc limit $DefaultNewsList";
    $nbrw->headerfmt = DisplayHeader($fmtMainNews_header,
	  "<a href='index.php?exec=listofnews&FilterCategory=$ctgr'>$ctgr</a>",0);
    $nbrw->detailfmt = $fmtMainNews_detail;
    $nbrw->footerfmt = $fmtMainNews_footer;
    echo $nbrw->BrowseNews();
  }
  // tampilkan berita
  function DisplayListNewsIn($ctgr) {
    global $Language, $DefaultNewsList, 
	  $fmtOpinion_header, $fmtOpinion_detail, $fmtOpinion_footer;
	$_level = $_SESSION['ulevel'];
    $nbrw = new newsbrowser;
    $nbrw->query = "select *,
	  DATE_FORMAT(NewsDate, '%d-%b-%y') as tgl 
      from news where Category='$ctgr' and Level >= $_level and NotActive='N'
      and Language='$Language' order by NewsID Desc limit $DefaultNewsList";
    $nbrw->headerfmt = DisplayHeader($fmtOpinion_header, 
	  "<a href='index.php?exec=listofnews&FilterCategory=$ctgr'>$ctgr</a>",0);
    $nbrw->detailfmt = $fmtOpinion_detail;
    $nbrw->footerfmt = $fmtOpinion_footer;
    echo $nbrw->BrowseNews();
  }
  // tampilkan berita terakhir
  function GetLastNewsContent($category) {
    global $strCantQuery;
    $_sql = "select * from news where Category='$category' and NotActive='N' order by NewsID desc limit 1";
	$_res = mysql_query($_sql) or die ($strCantQuery);
	if (mysql_num_rows($_res) > 0) return mysql_result($_res, 0, 'Content');
	else return "";
  }
?>