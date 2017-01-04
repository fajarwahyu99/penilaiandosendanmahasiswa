<?php
  // Author: E Setio Dewo, setio_dewo@telkom.net, Juni 2003


  // *** FUNGSI2 ***
  function GetNilaiCaption($nil) {
    if (empty($nil)) return '';
	elseif ($nil == 'Hadir') return 'Kehadiran/Absensi';
	elseif ($nil == 'NilaiMID') return 'Ujian Tengah Semester (UTS)';
	elseif ($nil == 'NilaiUjian') return 'Ujian Akhir Semester (UAS)';
	elseif ($nil == 'Tugas1') return 'Tugas #1';
	elseif ($nil == 'Tugas2') return 'Tugas #2';
	elseif ($nil == 'Tugas3') return 'Tugas #3';
	elseif ($nil == 'Tugas4') return 'Tugas #4';
	elseif ($nil == 'Tugas5') return 'Tugas #5';
  }
  function DispOptNilaiMK($nil, $jid, $act='cetaknilai') {
    if (empty($nil)) $strempty = 'selected'; else $strempty = '';
	if ($nil == 'Hadir') $strhdr = 'selected'; else $strhdr = '';
	if ($nil == 'NilaiMID') $strmid = 'selected'; else $strmid = '';
	if ($nil == 'NilaiUjian') $strujn = 'selected'; else $strujn = '';
	if ($nil == 'Tugas1') $strtgs1 = 'selected'; else $strtgs1 = '';
	if ($nil == 'Tugas2') $strtgs2 = 'selected'; else $strtgs2 = '';
	if ($nil == 'Tugas3') $strtgs3 = 'selected'; else $strtgs3 = '';
	if ($nil == 'Tugas4') $strtgs4 = 'selected'; else $strtgs4 = '';
	if ($nil == 'Tugas5') $strtgs5 = 'selected'; else $strtgs5 = '';
    $opt = "<option value='' $strempty></option>
	  <option value='Hadir' $strhdr>Hadir/Absensi</option>
	  <option value='Tugas1' $strtgs1>Tugas 1</option>
	  <option value='Tugas2' $strtgs2>Tugas 2</option>
	  <option value='Tugas3' $strtgs3>Tugas 3</option>
	  <option value='Tugas4' $strtgs4>Tugas 4</option>
	  <option value='Tugas5' $strtgs5>Tugas 5</option>
	  <option value='NilaiMID' $strmid>Ujian Tengah Semester (UTS)</option>
	  <option value='NilaiUjian' $strujn>Ujian Akhir Semester (UAS)</option>
	";
	echo "<table class=basic cellspacing=0 cellpadding=2>
	  <form action='sysfo.php' method=GET>
	  <input type=hidden name='syxec' value='$act'>
	  <input type=hidden name='jid' value='$jid'>
	  <tr><td class=lst width=100>Nilai: </td>
	  <td class=lst><select name='nil' onChange='this.form.submit()'>$opt</select></td>
	  </tr></form></table>	";
  }
  function DispNilaiUjian($jid, $nil) {
    global $strCantQuery;

    $s = "select k.NIM, m.Name, k.$nil as NIL, k.Tunda, j.KodeFakultas as KDF
	  from krs k left outer join mhsw m on k.NIM=m.NIM
	  left outer join jadwal j on k.IDJadwal=j.ID
	  where k.IDJadwal=$jid order by k.NIM ";
	$r = mysql_query($s) or die("$strCantQuery: $s");
	echo "<table class=basic cellspacing=0 cellpadding=1>
	  <tr><th class=ttl>NIM</th><th class=ttl>Mahasiswa</th>
	  <th class=ttl>Nilai</th><th class=ttl>Grade</th>
	  <th class=ttl>Status</th>
	  </tr>  ";
	while ($row = mysql_fetch_array($r)) {
	  $grd = GetGrade($row['KDF'], $row['NIL']);
	  if ($row['Tunda'] == 'Y') {
	    $cls = 'class=nac';
		$strtnd = 'Ditunda';
	  }
	  else {
	    $cls = 'class=lst';
		$strtnd = '-';
	  }
	  echo <<<EOF
	    <tr><td $cls>$row[NIM]</td>
		<td $cls>$row[Name]</td>
		<td $cls align=right>$row[NIL]</td>
		<td $cls>$grd[0]</td>
		<td $cls align=center>$strtnd</td>
		</tr>
EOF;
	}
	echo "</table>";
  }
  
  // *** PARAMETER2 ***
$ujn = GetSetVar('ujn');
$thn = GetSetVar('thn');
$kdj = GetSetVar('kdj');
$nil = GetSetVar('nil');
if (isset($_REQUEST['prn'])) $prn = $_REQUEST['prn']; else $prn = 0;
if (isset($_REQUEST['jid'])) $jid = $_REQUEST['jid']; else $jid = 0;

  
  // *** BAGIAN UTAMA ***
  $jdl = GetNilaiCaption($nil);
  DisplayHeader($fmtPageTitle, "Nilai $jdl");
  DispOptJdwl0('cetaknilai');
  echo "<br>";
  if (!empty($thn) && !empty($kdj)) {
    DispJadwalMK($thn, $kdj, $jid, $act='cetaknilai');
    if ($jid > 0) {
	  if ($prn == 0) DispOptNilaiMK($nil, $jid);
	  if (!empty($nil)) {
        if ($prn == 0) {
          $sid = session_id();
		  
	      DisplayPrinter("print.php?print=sysfo/cetaknilai.php&prn=1&nil=$nil&jid=$jid&PHPSESSID=$sid");
        }
	    DispNilaiUjian($jid, $nil);
	  }
	}
  }
?>