<?php
  // Author : USNI (human@usni.ac.id), Juni 2010
  
  $body_background = "";
  //$body_background = "background='./image/def-bg.gif' bgproperties=fixed";
  // General Format
  $fmtErrorMsg = "<table class=box cellspacing=1 cellpadding=2 align=center>
    <tr><th class=wrn colspan=2>$strError</th></tr>
    <tr><td bgcolor=white><img src='image/tux001.jpg' align=left></td>
	<td bgcolor=white>=TITLE=</td></tr></table><br>";
  $fmtMessage = "<table class=box cellspacing=1 cellpadding=2 align=center>
    <tr><th class=ttl colspan=2>=LINK=</th></tr>
    <tr><td bgcolor=white><img src='image/tux001.jpg' align=left></td>
	<td bgcolor=white>=ITEM=</td></tr></table><br>";
  $fmtPageTitle = "<center><h3>=TITLE=</h3></center>";
	
  // Menu Format
  $fmtMenu_header = "<table class=box cellspacing=1 cellpadding=1 border=0 width=100%>
    <tr><th class=menutitle>=TITLE=</th></tr>";
  $fmtMenu_item = "<tr><td bgcolor=white style='border-bottom: #DEDEDE 1px solid'><a href='=LINK='>=ITEM=</a></td></tr>";
  $fmtMenu_footer = "</table><br>";
  $fmtMenu_note = "<tr><th bgcolor=white style='border-bottom: #DEDEDE 1px solid'>=TITLE=</th></tr>";
  
  // Opinion Format
  $fmtOpinion_header = $fmtMenu_header;
  $fmtOpinion_detail = "<tr><td style='border-bottom: #DEDEDE 1px solid'>
    <a href='index.php?exec=newsdetail&NewsID==NewsID='>=Title=</a><br>
    <font color=gray>=Author=, =tgl=</font></td></tr>";
  $fmtOpinion_footer = $fmtMenu_footer;

  // NewsCategory Format
  $fmtCategoryList_header = "$fmtOpinion_header
    <tr><td width=8 background='image/def-kiritengah.gif'></td>
	<td colspan=2>
    ";
  $fmtCategoryList_detail = "<a href='index.php?exec=listofnews&FilterCategory==Category='>
    =Category=</a>, ";
  $fmtCategoryList_footer = "...</td>
	<td width=8 background='image/def-kanantengah.gif'></td></tr>
    $fmtMenu_footer";

  // Main News Format
  $fmtMainNews_header = "<table class=basic width=100%>
    <tr><td style='border-bottom: silver 1px solid' bgcolor=#CCFFCC><b>=TITLE=</b></td></tr>";
  $fmtMainNews_detail = "<tr><td style='border-bottom: #DEDEDE 1px solid'>
    <a href='index.php?exec=newsdetail&NewsID==NewsID='>=Title=</a><br>
    <font color=gray>=tgl=, =Author=</font></td></tr>";
  $fmtMainNews_footer = "</table>";

?>