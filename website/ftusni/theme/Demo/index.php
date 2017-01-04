 <table class='main' align=center cellspacing=0 cellpadding=2 width=100%>
   <tr><td colspan=3 class='header-part'>
   <?php
     include "$themedir/header.php";
	 //include "header.php";
   ?>
   </td>
   </tr>
   
   <tr> <td colspan=3 class='topmenu-part'>
     <?php
	   include "top.php";
	 ?>
   </td>
   </tr>
 </table>
 
 <table class='main' align=center cellspacing=0 cellpadding=2 width=100%>
   <tr>
     <td width=148 class='left-part'>
	 <?php
	   include "left.php";
	 ?>
	 </td>
	 
	 <td width=* class='main-part'>
	 <?php
	   if ($exec=='main.php' && file_exists("$themedir/main.php")) include "$themedir/main.php";
	   else include $exec;
	 ?>
	 </td>
	 
	 <td width=160 class='right-part'>
	 <?php
	   include "right.php";
	 ?>
	 </td>
   </tr>
   <tr><td colspan=4 class='footer-part'>
   <?php
     include "footer.php";
   ?>
   </td></tr>
 </table>
