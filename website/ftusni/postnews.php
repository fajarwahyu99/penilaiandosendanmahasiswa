<?
  // file: postnews.php
  // desc: Mau kirim berita? Pakai script ini.
  // author: E. Setio Dewo, Maret 2003

  // fungsi utk menampilkan form berita
  function DisplayNewsForm ($__NewsID) {
    Global $strPostNews, $strNewsTitle, $strNewsDescription, $strCategory, $strCantQuery,
           $strNewsCategory, $strNewsAuthor, $strNewsEmail, $strNewsContent, $strPostNews,
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
      if (mysql_result ($resget, 0, 'NotActive') == 'Y') $__NotActive = 'checked="checked"';
      else $__NotActive = "";
	  $unip = mysql_result ($resget, 0, 'unip');
	  // Validasi User
	  if (strpos($newsadmin_level, $_SESSION['ulevel']) === false) {
	    if ($unip != $_SESSION['unip']) die ($strNotAuthorizedtoChangeData);
	  }
    }
    else {
      $__Category = "";
      $__Title = "";
      $__Author = $_SESSION['uname'];
      $__Email = $_SESSION['uemail'];
      $__Description = "";
      $__Content = "";
	  $__Level = $_SESSION['ulevel'];
      $__NotActive = "";
	  $unip = $_SESSION['unip'];
    }

    $stropt = GetCategory ("$__Category", 1, $_SESSION['ulevel']);
	$strlevelopt = GetLevelUp ($__Level);

    // ini bagian utk menampilkan form.
    echo "<form action='index.php' method=POST>".
         "<input type=hidden name='exec' value='postnews'>".
	 "<input type=hidden name='NewsID' value=$__NewsID>".
	 "<input type=hidden name='postit' value=1>".
	 "<input type=hidden name='unip' value='$unip'>".

	 "<table class='basic'>".
	 "<tr><td>$strNewsCategory</td><td>:</td>".
	 "<td><select name='Category'>$stropt</select></td></tr>".

	 "<tr><td>$strNewsReaderLevel</td><td>:</td>".
	 "<td><select name='Level'>$strlevelopt</select></td></tr>".
	 
	 "<tr><td>$strNewsAuthor</td><td>:</td>".
	 "<td><input type=text name='Author' size=30 value='$__Author'></td></tr>".

	 "<tr><td>$strNewsEmail</td><td>:</td>".
	 "<td><input type=text name='Email' size=30 value='$__Email'></td></tr>".

	 "<tr><td>$strNewsTitle</td><td>:</td>".
	 "<td><input type=text name='Title' size=30 maxlength=100 value='$__Title'></td></tr>".

	 "<tr><td>$strNewsDescription</td><td>:</td>".
	 "<td><textarea name='Description' rows=2 cols=35 wrap=virtual>$__Description</textarea></td></tr>".

	 "<tr><td>$strNewsContent</td><td>:</td>".
	 "<td><textarea name='Content' rows=15 cols=35 wrap=virtual>$__Content</textarea></td></tr>";
	 
	echo "<tr><td>$strPostedBy</td><td>:</td><td>$unip</td></tr>";
    echo "<tr><td colspan=3><input type=checkbox name='NotActive' value='Y' id='NA_id' $__NotActive>".
	   "<label for='NA_id'>$strNotActive</label>";

    echo "<tr><td colspan=3 align=center><input type=submit value='$strPostNews'>&nbsp;".
	 "<input type=reset></td></tr>".

	 "</table></form>";
  }

  // *** MAIN PART ***
  DisplayHeader ($fmtPageTitle, $strPostNews);  
  if (!isset($_REQUEST['NewsID'])) $NewsID = 0;
  else $NewsID = $_REQUEST['NewsID'];
  if ($_SESSION['ulevel']>4) die ($strNotAuthorized);

  if (!isset($_POST ['postit'])) DisplayNewsForm ($NewsID);
  else {
    $NewsID = $_POST ['NewsID'];
    $Category = FixQuotes($_POST ['Category']);
	$unip = FixQuotes($_POST['unip']);
	$Level = substr($_POST['Level'], 0, 1);
    $Author = FixQuotes($_POST['Author']);
    $Email = $_POST['Email'];
    $Title = FixQuotes($_POST ['Title']);

    $Description = sqling($_REQUEST ['Description']);
    $Content = sqling($_REQUEST ['Content']);
	
	//echo "<p>$Content</p>";
	if (!isset($_POST['NotActive'])) $NotActive = 'N';
	else $NotActive = $_POST ['NotActive'];

    if (!isset($_POST ['NotActive'])) $Approved = 'N';
    else $NotActive = $_POST ['NotActive'];

    if ($NewsID == 0) {
      $sqlpost = "insert into news (NewsDate, Language, Title, Description, Level, Category, ".
        "Author, Email, NotActive, Content, unip) values (now(), '$Language', '$Title', '$Description', ".
		"$Level, '$Category', '$Author', '$Email', '$NotActive', '$Content', '$unip')";
      $respost = mysql_query ($sqlpost) or die ("$strCantQuery: $sqlpost");
	  $sqlID = "select Last_Insert_ID() as NewsID";
	  $resID = mysql_query($sqlID) or die("$strCantQuery: $sqlID");
	  $NewsID = mysql_result($resID, 0, 'NewsID');
    }
    else {
      $sqlupd = "update news set Title='$Title', Level=$Level, 
	    Description='$Description', Category='$Category', ".
        "Author='$Author', Email='$Email', NotActive='$NotActive', Content='$Content', ".
	    "unip='$unip' where NewsID=$NewsID ";
      $resupd = mysql_query ($sqlupd) or die ("$strCantQuery: $sqlupd");
    }
    echo "$strThanksforPostingNews. <p>$strOptions:
		 <a href='index.php?exec=newsdetail&NewsID=$NewsID'>$strView</a> |
         <a href='index.php?exec=listofnews'>$strListofNews</a> |
	     <a href='index.php'>$strFrontPage</a>
		 </p>";
	include "upload.php";
  }

?>
