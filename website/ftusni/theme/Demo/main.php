<?php
  echo GetLastNewsContent('FrontPage');
?>
<table class=box width=100% cellspacing=1 cellpadding=2>
<tr>
  <td bgcolor=white>
<a href='index.php?exec=listofnews&FilterCategory=Opini'><b>Opini</b></a> |
<a href='index.php?exec=listofnews&FilterCategory=Kegiatan'><b>Kegiatan</b></a> |</td>
</tr>
</table>

<table class='basic' width=100%>
  <tr>
    <td width=50% valign=top> <?php DisplayNewsIn($strAnnouncement); ?></td>
    <td valign=top> <?php DisplayNewsIn($strArticle); ?></td>
  </tr>
</table><br>


<table class='basic' width=100%>
  <tr>
    <td width=50% valign=top> <?php DisplayNewsIn($strSeminar); ?></td>
    <td valign=top> <?php DisplayNewsIn($strTraining); ?></td>
  </tr>
</table>