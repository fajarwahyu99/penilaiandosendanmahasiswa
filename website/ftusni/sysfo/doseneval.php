<?php
  // Author: E. Setio Dewo, setio_dewo@sisfokampus.net, November 2003
  
  // *** Fungsi2 ***
  function DispHeaderDosenEval() {
    echo "<tr><td class=nac align=center><img src='image/bawah.gif'></td><th class=nac>#</th>
	  <th class=nac>Kode MK</th><th class=nac>Mata Kuliah</th>
	  <th class=nac>Kinerja Dosen</th></tr>";
  }
  function DispDosenEval($thn, $kdj) {
    $s = "select j.*, concat(d.Name, ', ', d.Gelar) as DSN
	  from jadwal j left outer join dosen d on j.IDDosen=d.ID
	  where j.Tahun='$thn' and j.KodeJurusan='$kdj'
	  order by d.Name";
	$r = mysql_query($s) or die(mysql_error());
	$no = 0;
	$did = 0;
	echo "<br><table class=basic cellspacing=0 cellpadding=2>";
	while ($w = mysql_fetch_array($r)) {
	  if ($did != $w['IDDosen']) {
	    $did = $w['IDDosen'];
		$no = 0;
		echo "<tr><td>&nbsp;</td></tr>
		  <tr><td class=ttl colspan=5><b>$w[DSN]</td></tr>";
		DispHeaderDosenEval();
	  }
	  $no++;
	  echo <<<EOF
	  <tr><td align=center><img src='image/brch.gif'></td>
	  <th class=ttl>$no</th>
	  <td class=lst>$w[KodeMK]</td><td class=lst>$w[NamaMK]</td>
	  <form action='sysfo.php' method=POST>
	  <input type=hidden name='syxec' value='doseneval'>
	  <input type=hidden name='jid' value=$w[ID]>
	  <td class=lst><input type=text name='ipd' value='$w[IPDosen]' size=5 maxlength=5>
	  <input type=submit name='prcipdosen' value='Simpan'></td>
	  </form></tr>
EOF;
	}
	echo "</table><br>";
  }
  function PrcIPDosen() {
    $jid = $_REQUEST['jid'];
	$ipd = $_REQUEST['ipd'];
	mysql_query("update jadwal set IPDosen='$ipd' where ID=$jid") or die(mysql_error());
  }
  
  // *** Parameter2 ***
  $kdj = GetSetVar('kdj');
  $thn = GetSetVar('thn');
  if (isset($_REQUEST['prcipdosen'])) PrcIPDosen();
  
  // *** Bagian Utama ***
  DisplayHeader($fmtPageTitle, 'Evaluasi Dosen');
  DispOptJdwl0('doseneval');
  if (!empty($thn) && !empty($kdj)) {
    DispDosenEval($thn, $kdj);
  }

?>