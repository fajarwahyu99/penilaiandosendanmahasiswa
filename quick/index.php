<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>Home Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
//Ensure correct for language. English is "January 1, 2004"
var TODAY = monthname[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
</script>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#3366CC">
    <td width="382" colspan="3" rowspan="2"><img src="mm_travel_photo.jpg" alt="Header image" width="382" height="127" border="0" /></td>
    <td width="378" height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">Aplikasi Quick Count </td>
    <td width="100%">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="64" colspan="3" id="tagline" valign="top" align="center"><p>PILKADA KAB. PANGANDARAN 2015</p>
    </td>
	<td width="100%">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25">&nbsp;&nbsp;<script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>	</td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="165" valign="top" bgcolor="#E6F3FF">
	<table border="0" cellspacing="0" cellpadding="0" width="165" id="navigation">
        <tr>
          <td width="165">&nbsp;<br />
		 &nbsp;<br /></td>
        </tr>
        <tr>
          <td width="165"><a href="index.php" class="navText">Beranda</a></td>
        </tr>
        <tr>
          <td width="165"><a href="index.php?page=masukan_data_suara" class="navText">Masukan Data </a></td>
        </tr>
        <tr>
          <td width="165"><a href="index.php?page=lihat_perolehan_suara" class="navText">Lihat Data   </a></td>
        </tr>
      </table>
 	 <br />
  	&nbsp;<br />
  	&nbsp;<br />
  	&nbsp;<br /> 	</td>
    <td width="50"><img src="mm_spacer.gif" alt="" width="50" height="1" border="0" /></td>
    <td width="305" colspan="2" valign="top"><img src="mm_spacer.gif" alt="" width="305" height="1" border="0" /><br />
	&nbsp;<br />
	&nbsp;<br />
	<table width="449" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
        <tr bgcolor="#00FFFF">
          <td width="449" class="pageName"><p align="center"><strong>PILKADA PANGANDARAN 2015</strong></p>
          </td>
		</tr>

		<tr>
          <td class="bodyText" ><?php

$page = (isset($_GET['page']))? $_GET['page'] : "main";
switch ($page) {
case 'masukan_data_suara' : include "masukan_data_suara.php"; break;
case 'lihat_perolehan_suara' : include "lihat_perolehan_suara.php"; break;




case 'main' :
default : include 'welcome.php';
}
?>

		</td>
        </tr>
      </table>
	   <br />	  </td>
    <td width="50"><img src="mm_spacer.gif" alt="" width="50" height="1" border="0" /></td>
        <td width="190" valign="top"><br />
		&nbsp;<br />
		<table width="190" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
			<td colspan="3" class="subHeader" align="center">&nbsp;</td>
			</tr>

			<tr>
			<td width="40"><img src="mm_spacer.gif" alt="" width="40" height="1" border="0" /></td>
			<td width="110" class="smallText" id="sidebar"><div align="center"><br />
			  <br />
			  &nbsp;<br />			
			  </div></td>
			<td width="40">&nbsp;</td>
			</tr>
		</table>	</td>
	<td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td width="165">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="167">Aplikasi Quick Qount Pilkada Pangandaran 2015 </td>
    <td width="138"> <div align="right">by : 473</div></td>
    <td width="50">&nbsp;</td>
    <td width="190">&nbsp;</td>
	<td width="100%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
