<?php
  // Author : E. Setio Dewo {setio_dewo@telkom.net}, April 2003

  $fmtLink = "<tr><td class='menuitem'><a href==LINK=>=ITEM=</a></td></tr>";
  echo "<font color=gray><center>".date('d-M-Y')."</center></font>";  
  // Menu
  DisplayHeader ($fmtMenu_header, $strMenu);
  if ($_SESSION['sudahlogin']==0) DisplayDetail ($fmtMenu_item, 'index.php?exec=login', $strLogin);
  else DisplayDetail ($fmtMenu_item, 'index.php?logout=1', $strLogout);
  DisplayDetail ($fmtMenu_item, 'index.php', $strFrontPage);
  //DisplayDetail($fmtMenu_item, 'index.php?exec=download', $strDownloadArea);
  //DisplayDetail($fmtMenu_item, 'index.php?syxec=pmb', $strNewStudentRegistration);
  //DisplayDetail($fmtMenu_item, 'index.php?syxec=listofnewstudent', $strListofNewStudent);
  echo $fmtMenu_footer;
  
  // Menu anggota
  if ($_SESSION['sudahlogin']==1) {
    DisplayHeader ($fmtMenu_header, $_SESSION['uname']);
	DisplayHeader ($fmtMenu_note, $_SESSION['level']);
	DisplayDetail ($fmtMenu_item, 'index.php?exec=editpref', $strEditPref);
	DisplayDetail ($fmtMenu_item, 'index.php?exec=postnews', $strPostNews);
	DisplayDetail ($fmtMenu_item, 'index.php?exec=listofnews', $strListofNews);
	if (!(strpos($upload_level, $_SESSION['ulevel']) === false)) {
	  DisplayDetail ($fmtMenu_item, 'index.php?exec=upload', $strUploadFile);
	  DisplayDetail ($fmtMenu_item, 'index.php?exec=upload2download', $strUpload2DownloadFile);
	}
	if (!(strpos($polladmin_level, $_SESSION['ulevel']) === false))
	  DisplayDetail($fmtMenu_item, 'index.php?exec=createpoll', $strCreatePoll);
	// *** Administrator Mode ***
	if ($_SESSION['ulevel'] == 1) {
	  DisplayDetail($fmtMenu_item, 'index.php?exec=editcategory', $strEditCategory);
	  DisplayDetail($fmtMenu_item, 'index.php?exec=editadmin', $strEditSefak);
	  DisplayDetail($fmtMenu_item, 'index.php?exec=editadmin&lvl=2', "$strAdmin: kajur");
	  DisplayDetail($fmtMenu_item, 'index.php?exec=editadmin&lvl=3', "$strAdmin: dosen");
	}
	// *** e-Campus ***
	if (!(strpos($sysfo_level, $_SESSION['ulevel']) === false)) {
	  DisplayDetail($fmtMenu_item, 'sysfo.php', 'SisFo FT USNI');
	}
	
	echo $fmtMenu_footer;
  }  
  
  // About
/*  if ($_SESSION['sudahlogin']==0) {
    DisplayHeader ($fmtMenu_header, $strAbout);
    DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/visionmission', $strVisionMission);
    DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/profile', $strProfile);
	DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/faculty', $strFaculty);
    DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/sitemap', $strSiteMap);
    //DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/lecturer', $strLecturer);
    DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/studymethod', $strStudyMethod);
    DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/facility', $strFacility);
    //DisplayDetail ($fmtMenu_item, 'index.php?exec=./about/kalbegroup', $strKalbeGroup);
    echo $fmtMenu_footer;
  }
  */
?>