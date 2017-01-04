<?php
  $ulevel = $_SESSION['ulevel'];
  $nbrw = new newsbrowser;
  $nbrw->query = "select Category from newscategory where Language='$Language'
    and NotActive='N' and Level>=$ulevel and Listed='Y' order by Category";
  $nbrw->headerfmt = DisplayHeader($fmtCategoryList_header, $strNewsCategory, 0);
  $nbrw->detailfmt = $fmtCategoryList_detail;
  $nbrw->footerfmt = $fmtCategoryList_footer;
  echo $nbrw->BrowseNews();      
?>