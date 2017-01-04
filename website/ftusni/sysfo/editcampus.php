<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003


  if (isset($_REQUEST['prc'])) {
  }
  else {
    if (isset($_REQUEST['add'])) {
      DisplayHeader($fmtPageTitle, 'Tambah Kampus');
    } else {
      DisplayHeader($fmtPageTitle, 'Edit Kampus');
    }
  }
?>