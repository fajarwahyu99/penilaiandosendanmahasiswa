<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Oktober 2003
  
  // *** Fungsi2 ***
  function PrcDelTemp() {
    global $fmtMessage;
	$mod = "sysfo/temp";
    $dr = dir ($mod);
	$cnt = 0;
	while ($isi = $dr->read()) {
	  if ($isi != '.' && $isi != '..') {
	    unlink("$mod/$isi");
		//echo "Hapus: $mod/$isi<br>";
		$cnt++;
	  }
	}
	$dr->close();
	DisplayItem($fmtMessage, "Penghapusan Berhasil", "Penghapusan file2 temporary telah dilaksanakan.<br>
	Telah dihapus <b>$cnt</b> file.");
  }
  // *** Parameter ***
  
  // Bagian Utama
  DisplayHeader($fmtPageTitle, 'Hapus File-file Temporary');
  if (isset($_REQUEST['prctmp'])) PrcDelTemp();
  else DisplayHeader($fmtErrorMsg, "Anda akan menghapus file-file di direktori <b><code>sysfo/temp</code></b>.<br>
    Perintah ini dilakukan untuk pemeliharaan server.<br>
	Semua file2 temporary akan dihapus sehingga space harddisk server akan dihemat.<hr>
    Pilihan: <a href='sysfo.php?syxec=hapustemp&prctmp=1'>HAPUS</a> | <a href='sysfo.php'> BATAL</a>");
?>