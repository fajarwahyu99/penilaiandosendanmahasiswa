<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003
  
  $sid = session_id();
  $agent = $_SERVER['HTTP_USER_AGENT'];
  if (strpos($agent, 'Win') === false) $strpos = 'absolute'; else $strpos = 'relative';
  echo "<div style='position: $strpos; height:18;'>";
  include "start.menu.js";

//	include "item.menu.js";
  $arrMenu = array('Depan', 'Program',   'Download', 'Beasiswa');
  StartMenu($arrMenu);

  $arrSupra = array("Halaman Depan->index.php?PHPSESSID=$sid", 
    "Profile->index.php?exec=about/profile&PHPSESSID=$sid",
	"Visi & Misi->index.php?exec=about/visionmission&PHPSESSID=$sid",
	"Peta Kampus->index.php?exec=about/sitemap&PHPSESSID=$sid",
	"Fasilitas Kampus->index.php?exec=about/facility&PHPSESSID=$sid" );
  AddSubMenu('Depan', $arrSupra);

  $arrProgram = array("Program S1 & D3 Reguler->index.php?exec=about/prgs1d3&PHPSESSID=$sid");
  AddSubMenu('Program', $arrProgram);
  
  $arrReg = array("Jadwal Pendaftaran->index.php?exec=newsdetail&NewsCategory=Jadwal+PMB&PHPSESSID=$sid",
    "Pendaftaran Online->index.php?syxec=pmb&PHPSESSID=$sid"  );
  AddSubMenu('Pendaftaran', $arrReg);

  $arrEvent = array("Tentang Divisi Training->index.php?exec=newsdetail&toex=posttrn&NewsCategory=PelatihanAbout&PHPSESSID=$sid",
    "Info Training->index.php?exec=listoftrn&FilterCategory=Pelatihan&PHPSESSID=$sid",
	"Info Seminar->index.php?exec=listoftrn&FilterCategory=Seminar&PHPSESSID=$sid",
	"Konsultan Training->index.php?exec=newsdetail&toex=posttrn&NewsCategory=PelatihanKonsultan&PHPSESSID=$sid",
	"Email ke Divisi Training->mailto:infotraining@usni.ac.id",
	"Makalah & Bahan Training->index.php?exec=download&dir=training&PHPSESSID=");
  if (!(strpos($upload_level, $_SESSION['ulevel']) === false))
    $arrEvent[] = "Upload Makalah & Bahan->index.php?exec=upload&dir=training&PHPSESSID=$sid";
  AddSubMenu('Kegiatan', $arrEvent);

/*
   <div Id="_stiescholarship" class="ItemStatic" cmd='index.php?exec=about/scholarship&PHPSESSID=<?php echo $_sid; ?>'><?php echo $strScholarship; ?></div>
*/  
  $arrDown = array("Area Download->index.php?exec=download&PHPSESSID=$sid",
    "Download Formulir Pendaftaran->index.php",
	"Download Jadwal Kuliah->download/jadwalkuliah.doc"
  );
  AddSubMenu('Download', $arrDown);

  $arrBeasiswa = array("Beasiswa->index.php?exec=about/scholarship&PHPSESSID=$sid");
  AddSubMenu('Beasiswa', $arrBeasiswa);
  
  DisplayThemeMenu('index.php');
  
  EndMenu();
  include "end.menu.js";
  echo "</div>";
?>