<?php
  //Author: USNI, human@usni.ac.id, Juni 2010
  
  if (isset($_REQUEST['fl'])) $fl = $_REQUEST['fl']; else $fl = '';


?>
<HTML>
  <HEAD><TITLE>Download Utility by Dewo</TITLE></HEAD>
<BODY onLoad="location='<?php echo $fl; ?>'">
  Download file "<?php echo $fl; ?>"
</BODY>
</HTML>