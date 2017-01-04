<?php
  $ulevel = $_SESSION['ulevel'];
  $nbrw = new newsbrowser;
  $nbrw->query = "select NewsID,Title,DATE_FORMAT(NewsDate, '%d %b %y') as tgl,Author 
    from news where Language='$Language'
    and Category='$strVacancy'
    and NotActive='N' and Level>=$ulevel order by NewsID Desc limit 4";
  $nbrw->headerfmt = DisplayHeader($fmtOpinion_header, $strVacancy, 0);
  $nbrw->detailfmt = $fmtOpinion_detail;
  $nbrw->footerfmt = $fmtOpinion_footer;
  echo $nbrw->BrowseNews();      
?>