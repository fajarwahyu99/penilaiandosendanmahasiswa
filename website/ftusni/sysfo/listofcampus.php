<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003

  if (isset($_REQUEST['prc'])) {
    ProcessCampusForm();
	//DisplayCampusList();
  }
  
  if (isset($_REQUEST['add'])) DisplayCampusForm(1);
  else {
    if (isset($_REQUEST['kd'])) DisplayCampusForm(0, $_REQUEST['kd']);
    else {
      DisplayHeader($fmtPageTitle, 'Kampus');
	  echo "<a href='sysfo.php?syxec=listofcampus&add=1'>Tambah Kampus</a>";
      DisplayCampusList();
    }
  }

?>