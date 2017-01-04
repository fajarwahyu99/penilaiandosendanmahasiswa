<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, Agustus 2003
  

  // *** FUngsi2 ***
  function MigrasiNilaiMhsw() {
    global $strCantQuery;
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <tr><td class=box valign=top>
	  Tahap 1<br>
	<ol>";

	/*
    $s = "select k.*, m.KodeJurusan as kdj
	  from _krs k left outer join mhsw m on k.NIM=m.NIM
	  order by k.NIM";
	$r = mysql_query($s) or die("$strCantQuery: Tahap 1: $s.<br>".mysql_error());
	$n = '';
	$kdj = '';
	while ($w = mysql_fetch_array($r)) {
	  if ($n != $w['NIM']) {
	    $n = $w['NIM'];
	    //echo "<li>$w[NIM], $w[IDDosen].</li>";
	  }
	  if ($w['Tahun'] == 'PRG.S') $Tahun = '19980';
	  else {
	    if (strpos($w['Tahun'], '/') === false)	$Tahun = $w['Tahun'];
		else $Tahun = substr($w['Tahun'], 0, 4) . $w['Sesi'];
	  }
	  $IDMK = GetaField('matakuliah', "Kode", $w['KodeMK'], 'ID');
	  //$IDDosen = GetaField('dosen', 'OldID', $w['IDDosen'], 'ID');
	  $IDDosen = $w['IDDosen'];
	  $GRD = $w['GradeNilai']. $w['GradeNilai2'];
	  $kdj = $w['kdj'];
	  $BBT = GetBobot($kdj, $GRD);
	  if ($w['Setara'] == 'A') $SET = 'Y'; else $SET = 'N';
	  $s0 = "insert into krs (NIM, Tahun, Sesi, IDMK, KodeMK, NamaMK, SKS,
	  Status, IDDosen, Tanggal, Hadir, Tugas1, Tugas2, Tugas3, Tugas4,
	  NilaiMID, NilaiUjian, Nilai, GradeNilai, Bobot, Setara) values
	  ('$w[NIM]', '$Tahun', '$w[Sesi]', '$IDMK', '$w[KodeMK]', '$w[NamaMK]', '$w[SKS]',
	  '$w[Status]', '$IDDosen', now(), '$w[Hadir]', '$w[Tugas1]', '$w[Tugas2]', '$w[Tugas3]', '$w[Tugas4]',
	  '$w[NilaiMID]', '$w[NilaiUjian]', '$w[Nilai]', '$GRD', '$BBT', '$SET')
	  ";
	  $r0 = mysql_query($s0) or die("$strCantQuery: $s0.<br>".mysql_error());
	}


	*/

	echo "</ol>selesai tahap 1
	  </td><td class=box valign=top><ol>";


//-------

	$s = "select IDDosen from _krs group by IDDosen";
	$r = mysql_query($s) or die("$strCantQuery: Tahap 2: $s.<br>".mysql_error());
	while ($w = mysql_fetch_array($r)) {
	  $ID = GetaField('dosen', 'OldID', $w['IDDosen'], 'ID');
	  if (empty($ID)) $ID = 0;
	  echo "<li>$w[IDDosen] -> $ID</li>";
	  $s0 = "update krs set IDDosen='$ID' where IDDosen='$w[IDDosen]'";
	  $r0 = mysql_query($s0) or die("$strCantQuery: Detil Tahap 2: $s0<br>".mysql_error());
	}
	echo "</ol></td></tr></table>";
  }

  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, "Migrasi Nilai Mhsw");
  MigrasiNilaiMhsw();
?>