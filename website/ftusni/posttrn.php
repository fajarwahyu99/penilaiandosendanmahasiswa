<?
  // file: postnews.php
  // desc: Mau kirim berita? Pakai script ini.
  // author: E. Setio Dewo, Maret 2003

  // fungsi utk menampilkan form berita
  function DisplayTrnForm ($__NewsID, $defCat='') {
    Global $strPost, $strTitle, $strDescription, $strCategory, $strCantQuery,
           $strSpeaker, $strEmail, $strContent, $strLocation, $strDate, $strTime, $strCharge,
	       $strNewsApproved, $strNewsReaderLevel, $strNotActive, $newsadmin_level,
		   $strNotAuthorizedtoChangeData, $strPostedBy;

    if ($__NewsID > 0) {
      $sqlget = "select * from news where NewsID=$__NewsID";
      $resget = mysql_query ($sqlget) or die ("$strCantQuery: $sqlget");

      $__Category = mysql_result ($resget, 0, 'Category');
      $__Title = mysql_result ($resget, 0, 'Title');
	  //echo "<p><b>$__Title</b></p>";
      $__Author = mysql_result ($resget, 0, 'Author');
      $__Email = mysql_result ($resget, 0, 'Email');
      $__Description = mysql_result ($resget, 0, 'Description');
      $__Content = mysql_result ($resget, 0, 'Content');
	  $__Level = mysql_result ($resget, 0, 'Level');
	  $__Location = mysql_result($resget, 0, 'Location');
	  $__Charge = mysql_result($resget, 0, 'Charge');
	  $__DateExpired = mysql_result($resget, 0, 'DateExpired');
	  $__NotActive = mysql_result($resget, 0, 'NotActive');
	  if (empty($__DateExpired)) $__DateExpired = date('Y-m-d H:i:00');
      if (mysql_result ($resget, 0, 'NotActive') == 'Y') $__NotActive = 'checked="checked"';
      else $__NotActive = "";
	  $unip = mysql_result ($resget, 0, 'unip');
	  // Validasi User
	  if (strpos($newsadmin_level, $_SESSION['ulevel']) === false) {
	    if ($unip != $_SESSION['unip']) die ($strNotAuthorizedtoChangeData);
	  }
    }
    else {
      $__Category = $defCat;
      $__Title = "";
      $__Author = $_SESSION['uname'];
      $__Email = $_SESSION['uemail'];
      $__Description = "";
      $__Content = "";
	  $__Level = $_SESSION['ulevel'];
	  $__Location = '';
	  $__Charge = '';
	  $__DateExpired = date('Y-m-d H:i:00');
      $__NotActive = "";
	  $unip = $_SESSION['unip'];
    }

	//echo "<p><b>$__DateExpired</b></p>";
	$__DateExpired = strtotime($__DateExpired);
	$__Tahun = date("Y", $__DateExpired);
	$__Bulan = date('m', $__DateExpired);
	$__Hari = date('d', $__DateExpired);
	$__Jam = date('H', $__DateExpired);
	$__Menit = date('i', $__DateExpired);
	$optTahun = GetNumberOption(2003, 2006, $__Tahun);
	$optBulan = GetMonthOption($__Bulan);
	$optHari = GetNumberOption(1, 31, $__Hari);
	$optJam = GetNumberOption(1, 24, $__Jam);
	$optMenit = GetNumberOption(0, 50, $__Menit, 10);
	//echo "$__Jam:$__Menit  $__Hari:$__Bulan:$__Tahun";
    $stropt = GetCategory ("$__Category", 1, $_SESSION['ulevel']);
	$strlevelopt = GetLevelUp ($__Level);

    // ini bagian utk menampilkan form.
    echo "<form action='index.php' method=POST>".
         "<input type=hidden name='exec' value='posttrn'>".
	 "<input type=hidden name='NewsID' value=$__NewsID>".
	 "<input type=hidden name='postit' value=1>".
	 "<input type=hidden name='unip' value='$unip'>".

	 "<table class='basic'>".
	 "<tr><td>$strCategory</td><td>:</td>".
	 "<td><select name='Category'>$stropt</select></td></tr>".

	 "<tr><td>$strNewsReaderLevel</td><td>:</td>".
	 "<td><select name='Level'>$strlevelopt</select></td></tr>".
	 
	 "<tr><td>$strSpeaker</td><td>:</td>".
	 "<td><input type=text name='Author' size=30 value='$__Author'></td></tr>".

	 "<tr><td>$strEmail</td><td>:</td>".
	 "<td><input type=text name='Email' size=30 value='$__Email'></td></tr>".

	 "<tr><td>$strTitle</td><td>:</td>".
	 "<td><input type=text name='Title' size=30 maxlength=100 value='$__Title'></td></tr>".

	 "<tr><td>$strDescription</td><td>:</td>".
	 "<td><textarea name='Description' rows=2 cols=35 wrap=virtual>$__Description</textarea></td></tr>".

	 "<tr><td>$strLocation</td><td>:</td>".
	 "<td><input type=text name='Location' size=30 maxlength=100 value='$__Location'></td></tr>".

	 "<tr><td>$strDate</td><td>:</td>".
	 "<td><select name='_Hari'>$optHari</select><select name='_Bulan'>$optBulan</select><select name='_Tahun'>$optTahun</select>
	 </td></tr>".
	 
	 "<tr><td>$strTime</td><td>:</td>".
	 "<td><select name='_Jam'>$optJam</select><select name='_Menit'>$optMenit</select></td></tr>".

	 "<tr><td>$strCharge</td><td>:</td>".
	 "<td><input type=text name='Charge' size=30 maxlength=100 value='$__Charge'></td></tr>".

	 "<tr><td>$strContent</td><td>:</td>".
	 "<td><textarea name='Content' rows=15 cols=35 wrap=virtual>$__Content</textarea></td></tr>";
	 
	echo "<tr><td>$strPostedBy</td><td>:</td><td>$unip</td></tr>";
    echo "<tr><td colspan=3><input type=checkbox name='NotActive' value='Y' id='NA_id' $__NotActive>".
	   "<label for='NA_id'>$strNotActive</label>";

    echo "<tr><td colspan=3 align=center><input type=submit value='$strPost'>&nbsp;".
	 "<input type=reset></td></tr>".

	 "</table></form>";
  }

  // *** MAIN PART ***

  if (!isset($_REQUEST['NewsID'])) $NewsID = 0;
  else $NewsID = $_REQUEST['NewsID'];
  if ($_SESSION['ulevel']>4) die ($strNotAuthorized);

  if (!isset($_REQUEST ['postit'])) {
    if (isset($_REQUEST['Category'])) $Category = $_REQUEST['Category'];
	else $Category = '';
    DisplayTrnForm ($NewsID, $Category);
  }
  else {
    $NewsID = $_REQUEST ['NewsID'];
    $Category = FixQuotes($_REQUEST ['Category']);
	$unip = FixQuotes($_REQUEST['unip']);
	$Level = substr($_POST['Level'], 0, 1);
    $Author = FixQuotes($_REQUEST['Author']);
    $Email = $_REQUEST['Email'];
    $Title = FixQuotes($_REQUEST ['Title']);
	$Location = FixQuotes($_REQUEST['Location']);
	$_Tahun = $_REQUEST['_Tahun'];
	$_Bulan = str_pad($_REQUEST['_Bulan'], 2, '0', STR_PAD_LEFT);
	$_Hari = str_pad($_REQUEST['_Hari'], 2, '0', STR_PAD_LEFT);
	$_Jam = str_pad($_REQUEST['_Jam'], 2, '0', STR_PAD_LEFT);
	$_Menit = str_pad($_REQUEST['_Menit'], 2, '0', STR_PAD_LEFT);
	$DateExpired = "$_Tahun-$_Bulan-$_Hari $_Jam:$_Menit:00";
	//$DateExpired = strtotime($DateExpired);
	$Charge = FixQuotes($_REQUEST['Charge']);
	//echo "<p><b>$DateExpired</b></p>";
	if (!isset($_REQUEST['NotActive'])) $NotActive = 'N';
	else $NotActive = $_REQUEST ['NotActive'];

    if (!isset($_REQUEST ['NotActive'])) $Approved = 'N';
    else $NotActive = $_REQUEST ['NotActive'];
	
    $Description = sqling($_REQUEST ['Description']);
    $Content = sqling($_REQUEST ['Content']);

    if ($NewsID == 0) {
      $sqlpost = "insert into news (NewsDate, Language, Title, Description, Level, Category, ".
        "Author, Email, Location, DateExpired, Charge, NotActive, Content, unip) 
		values (now(), '$Language', '$Title', '$Description', ".
		"$Level, '$Category', '$Author', '$Email', '$Location', '$DateExpired', '$Charge',
		'$NotActive', '$Content', '$unip')";
      $respost = mysql_query ($sqlpost) or die ("$strCantQuery: $sqlpost");
	  $sqlID = "select Last_Insert_ID() as NewsID";
	  $resID = mysql_query($sqlID) or die("$strCantQuery: $sqlID");
	  $NewsID = mysql_result($resID, 0, 'NewsID');
    }
    else {
      $sqlupd = "update news set Title='$Title', Level=$Level, 
	    Description='$Description', Category='$Category', ".
        "Author='$Author', Email='$Email', Location='$Location', DateExpired='$DateExpired',
		Charge='$Charge',
		NotActive='$NotActive', Content='$Content', ".
	    "unip='$unip' where NewsID=$NewsID ";
      $resupd = mysql_query ($sqlupd) or die ("$strCantQuery: $sqlupd");
    }
	
    DisplayHeader ($fmtPageTitle, "$strPost $Category");
    echo "$strThanksforPostingNews. <p>$strOptions:
		 <a href='index.php?exec=trndetail&NewsID=$NewsID'>$strView</a> |
         <a href='index.php?exec=listoftrn&FilterCategory=$Category'>$strListof $Category</a> |
	     <a href='index.php'>$strFrontPage</a>
		 </p>";
	include "upload.php";
  }

?>
