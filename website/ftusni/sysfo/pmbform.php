<SCRIPT LANGUAGE="JavaScript">
<!--
  function CheckForm(form) {
    strs = ""
    if (form.Name.value == "")
	  strs += "Nama Kosong\n"
	if (form.BirthPlace.value == "")
	  strs += "Tempat Lahir Kosong\n"
	if (form.Address1.value == "")
	  strs += "Alamat kosong\n"
	if (form.City.value == "")
	  strs += "Kota kosong\n"
	if (form.Religion.value == "")
	  strs += "Agama kosong\n"
	if (form.ParentName.value == "")
	  strs += "Nama orang tua kosong\n"
	if (form.FromSchool.value == "")
	  strs += "Asal sekolah kosong\n"
	  
	if (strs != "") alert(strs)
    return strs == ""
  }
-->
</SCRIPT>
<?php
  // Author : E. Setio Dewo, setio_dewo@telkom.net, April 2003
  $Language = $_COOKIE['uselang'];
  
  function ResetPMBForm() {
    global $Name, $Sex, $BirthPlace, $Email,
	  $BirthDateDay, $BirthDateMonth, $BirthDateYear,
	  $Address1, $Address2, $RT, $RW, $City, $PostalCode,
	  $Phone, $MobilePhone, $AgamaID, $Nationality,
	  $Company, $CompanyAddress1, $CompanyAddress2, $CompanyPhone,
	  $CompanyFacsimile, $ParentName, $ParentWork, 
	  $ParentAddress1, $ParentAddress2, $ParentRT, $ParentRW,
	  $ParentCity, $ParentPostalCode, $ParentPhone, $ParentMobilePhone,
	  $FromSchool, $SchoolType, $SchoolCity, $SchoolMajor, $GraduateYear,
	  $NotGraduated, $CertificateNumber, $Program, $ProgramType, $ProgramSchedule,
	  $TestScore, $TestPass, $strKampus, $Keterangan;
	global $Default_BirthYear, $strCantQuery;
      $Name = "";
	  $Sex = "L";
	  $BirthPlace = "";
	  $BirthDateDay = "";
	  $BirthDateMonth = "";
	  $BirthDateYear = $Default_BirthYear;
	  $Email = "";
	  $Address1 = "";
	  $Address2 = "";
	  $RT = "";
	  $RW = "";
	  $City = "";
	  $PostalCode = "";
	  $Phone = "";
	  $MobilePhone = "";
	  $AgamaID = "";
	  $Nationality = "";
	  $CompanyName = "";
	  $CompanyAddress1 = "";
	  $CompanyAddress2= "";
	  $CompanyPhone = "";
	  $CompanyFacsimile = "";
	  $ParentName = "";
	  $ParentWork = "";
	  $ParentAddress1 = "";
	  $ParentAddress2= "";
	  $ParentRT = "";
	  $ParentRW = "";
	  $ParentCity = "";
	  $ParentPostalCode = "";
	  $ParentPhone = "";
	  $ParentMobilePhone = "";
	  $FromSchool = "";
	  $SchoolType = "";
	  $SchoolCity = "";
	  $SchoolMajor = "";
	  $GraduateYear = 0;
	  $NotGraduated = 'N';
	  $CertificateNumber = "";
	  $Program = "";
	  $ProgramType = "";
	  $ProgramSchedule = "";
	  $TestScore = 0;
	  $TestPass = 'N';
	  $KodeKampus = '';
	  $strKampus = '';
	  $Keterangan = '';
  }

  function DisplayPMBForm($PMBID='') {
    global $Name, $Sex, $BirthPlace,
	  $BirthDateDay, $BirthDateMonth, $BirthDateYear, $Email,
	  $Address1, $Address2, $RT, $RW, $City, $PostalCode,
	  $Phone, $MobilePhone, $AgamaID, $Nationality,
	  $CompanyName, $CompanyAddress1, $CompanyAddress2, $CompanyPhone,
	  $CompanyFacsimile, $ParentName, $ParentWork, 
	  $ParentAddress1, $ParentAddress2, $ParentRT, $ParentRW,
	  $ParentCity, $ParentPostalCode, $ParentPhone, $ParentMobilePhone,
	  $FromSchool, $SchoolType, $SchoolCity, $SchoolMajor, $GraduateYear,
	  $NotGraduated, $CertificateNumber, $Program, $ProgramType, $ProgramSchedule,
	  $TestScore, $TestPass, $strKampus, $Keterangan;
	global $arr_Month, $Student_MinYear, $Student_MaxYear, $Student_DefaultYear,
	  $strRegister, $action;

	if (empty($PMBID)) {
	  ResetPMBForm();
	}
	else {
	  // Jika Edit Pendaftaran
	  $_sql = "select *,DATE_FORMAT(BirthDate, '%d') as BirthDateDay,
	    DATE_FORMAT(BirthDate, '%m') as BirthDateMonth,
		DATE_FORMAT(BirthDate, '%Y') as BirthDateYear
	    from pmb where PMBID='$PMBID'";
	  $_res = mysql_query($_sql) or die($strCantQuery);
	  
      $Name = mysql_result($_res, 0, 'Name');
	  $Sex = mysql_result($_res, 0, 'Sex');
	  $BirthPlace = mysql_result($_res, 0, 'BirthPlace');
	  $BirthDate = mysql_result($_res, 0, 'BirthDate');
	  $Email = mysql_result($_res, 0, 'Email');
	  // extract BirthDate
	  $BirthDateDay = mysql_result($_res, 0, 'BirthDateDay');
	  $BirthDateMonth = mysql_result($_res, 0, 'BirthDateMonth');
	  $BirthDateYear = mysql_result($_res, 0, 'BirthDateYear');
	  $Address1 = mysql_result($_res, 0, 'Address1');
	  $Address2 = mysql_result($_res, 0, 'Address2');
	  $RT = mysql_result($_res, 0, 'RT');
	  $RW = mysql_result($_res, 0, 'RW');
	  $City = mysql_result($_res, 0, 'City');
	  $PostalCode = mysql_result($_res, 0, 'PostalCode');
	  $Phone = mysql_result($_res, 0, 'Phone');
	  $MobilePhone = mysql_result($_res, 0, 'MobilePhone');
	  $AgamaID = mysql_result($_res, 0, 'AgamaID');
	  $Nationality = mysql_result($_res, 0, 'Nationality');
	  $CompanyName = mysql_result($_res, 0, 'CompanyName');
	  $CompanyAddress1 = mysql_result($_res, 0, 'CompanyAddress1');
	  $CompanyAddress2= mysql_result($_res, 0, 'CompanyAddress2');
	  $CompanyPhone = mysql_result($_res, 0, 'CompanyPhone');
	  $CompanyFacsimile = mysql_result($_res, 0, 'CompanyFacsimile');
	  $ParentName = mysql_result($_res, 0, 'ParentName');
	  $ParentWork = mysql_result($_res, 0, 'ParentWork');
	  $ParentAddress1 = mysql_result($_res, 0, 'ParentAddress1');
	  $ParentAddress2= mysql_result($_res, 0, 'ParentAddress2');
	  $ParentRT = mysql_result($_res, 0, 'ParentRT');
	  $ParentRW = mysql_result($_res, 0, 'ParentRW');
	  $ParentCity = mysql_result($_res, 0, 'ParentCity');
	  $ParentPostalCode = mysql_result($_res, 0, 'ParentPostalCode');
	  $ParentPhone = mysql_result($_res, 0, 'ParentPhone');
	  $ParentMobilePhone = mysql_result($_res, 0, 'ParentMobilePhone');
	  $FromSchool = mysql_result($_res, 0, 'FromSchool');
	  $SchoolType = mysql_result($_res, 0, 'SchoolType');
	  $SchoolCity = mysql_result($_res, 0, 'SchoolCity');
	  $SchoolMajor = mysql_result($_res, 0, 'SchoolMajor');
	  $GraduateYear = mysql_result($_res, 0, 'GraduateYear');
	  $NotGraduated = mysql_result($_res, 0, 'NotGraduated');
	  $CertificateNumber = mysql_result($_res, 0, 'CertificateNumber');
	  $Program = mysql_result($_res, 0, 'Program');
	  $ProgramType = mysql_result($_res, 0, 'ProgramType');
	  $ProgramSchedule = mysql_result($_res, 0, 'ProgramSchedule');
	  $TestScore = mysql_result($_res, 0, 'TestScore');
	  $TestPass = mysql_result($_res, 0, 'TestPass');
	  $KodeKampus = mysql_result($_res, 0, 'KodeKampus');
	  $strKampus = GetaField('kampus', 'Kode', $KodeKampus, 'Kampus');
	  $Keterangan = mysql_result($_res, 0, 'Keterangan');
	}

	$optKampus = GetOption('kampus', 'Kampus', 'Kampus', $strKampus, '', 'Kode');
	$optAgama = GetOption2('agama', 'Agama', 'AgamaID', $AgamaID, '', 'AgamaID');
	$optprg = GetOption2('program', "concat(Kode, ' -- ', Nama_Indonesia)", 'Kode', $ProgramType, '', 'Kode');
	$str_sexx = "";  $str_sexy = "";
    if ($Sex == 'L') $str_sexy = 'checked';
	else $str_sexx = 'checked';
	
	if ($NotGraduated=='Y') $str_NG = 'checked';
	else $str_NG = "";
	
// --- TULIS FORM --	  
	echo "

<FORM name='PMB' action='$action' method=POST onsubmit=\"return CheckForm(this)\">
  <input type=hidden name='syxec' value='pmbform'>

  <input type=hidden name='PMBID' value='$PMBID'>
  <input type=hidden name='TestScore' value=$TestScore>
  <input type=hidden name='TestPass' value='$TestPass'>
  
<table class=basic width=100%>
<tr>
  <th class=ttl colspan=3>Data Calon Mahasiswa</th>
</tr>
<tr>
  <td class=lst>Nama Mahasiswa</td><td class=lst>:</td>
  <td class=lst><input type=text name='Name' value='$Name' size=30 maxlength=50></td>
</tr>
<tr><td class=lst>Email</td><td class=lst>:</td>
  <td class=lst><input type=text name='Email' value='$Email' size=40 maxlength=50></td></tr>

<tr>
  <td class=lst>Jenis Kelamin</td><td class=lst>:</td>
  <td class=lst><input type=radio name='Sex' value='L' id='sexy' $str_sexy>
    <label for='sexy'>Laki-laki</label>
	<input type=radio name='Sex' value='P' id='sexx' $str_sexx>
	<label for='sexx'>Perempuan</label>
  </td>
</tr>

<tr>
  <td class=lst>Tempat Lahir</td><td class=lst>:</td>
  <td class=lst><input type=text name='BirthPlace' value='$BirthPlace' size=30 maxlength=50></td>
</tr>

<tr>
  <td class=lst>Tgl. Lahir</td><td class=lst>:</td>
  <td class=lst><select name='BirthDateDay'>".GetNumberOption(1, 31, $BirthDateDay)."</select>
    <select name='BirthDateMonth'>".GetMonthOption($BirthDateMonth)."</select>
	<select name='BirthDateYear'>".
	  GetNumberOption($Student_MinYear, $Student_MaxYear, $BirthDateYear)."</select>
  </td>
</tr>

<tr>
  <td class=lst>Alamat Lengkap</td><td class=lst>:</td>
  <td class=lst><input type=text name='Address1' value='$Address1' size=40 maxlength=100><br>
    <input type=text name='Address2' value='$Address2' size=40 maxlength=100><br>
	RT <input type=text name='RT' value='$RT' size=5 maxlength=5> &nbsp;
	RW <input type=text name='RW' value='$RW' size=5 maxlength=5>
  </td>
</tr>

<tr>
  <td class=lst>Kota</td><td class=lst>:</td>
  <td class=lst><input type=text name='City' value='$City' size=18 maxlength=20> &nbsp;
    Kode Pos <input type=text name='PostalCode' value='$PostalCode' size=10 maxlength=10>
  </td>
</tr>

<tr>
  <td class=lst>Telepon</td><td class=lst>:</td>
  <td class=lst><input type=text name='Phone' value='$Phone' size=20 maxlength=20></td>
</tr>

<tr>
  <td class=lst>Handphone</td><td class=lst>:</td>
  <td class=lst><input type=text name='MobilePhone' value='$MobilePhone' size=20 maxlength=20></td>
</tr>

<tr>
  <td class=lst>Agama</td><td class=lst>:</td>
  <td class=lst><select name='AgamaID'>$optAgama</select></td>
</tr>

<tr>
  <td class=lst>Kewarganegaraan</td><td class=lst>:</td>
  <td class=lst><input type=text name='Nationality' value='$Nationality' size=20 maxlength=20></td>
</tr>

<tr><th class=ttl colspan=3>
  <center><b>Bila Sudah Bekerja:</b></center></th></tr>

<tr>
  <td class=lst>Nama Perusahaan</td><td class=lst>:</td>
  <td class=lst><input type=text name='CompanyName' value='$CompanyName' size=40 maxlength=50></td>
</tr>

<tr>
  <td class=lst>Alamat</td><td class=lst>:</td>
  <td class=lst><input type=text name='CompanyAddress1' value='$CompanyAddress1' size=40 maxlength=100><br>
    <input type=text name='CompanyAddress2' value='$CompanyAddress2' size=40 maxlength=100>
  </td>
</tr>

<tr>
  <td class=lst>Telepon</td><td class=lst>:</td>
  <td class=lst><input type=text name='CompanyPhone' value='$CompanyPhone' size=20 maxlength=20></td>
</tr>

<tr>
  <td class=lst>Facsimile</td><td class=lst>:</td>
  <td class=lst><input type=text name='CompanyFacsimile' value='$CompanyFacsimile' size=20 maxlength=20></td>
</tr>
</table><br>


<table class=basic width=100%>
<tr>
  <th class=ttl colspan=3>Data Keluarga</th>
</tr>

<tr>
  <td class=lst>Nama Orangtua/Wali</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentName' value='$ParentName' size=30 maxlength=50></td>
</tr>

<tr>
  <td class=lst>Pekerjaan</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentWork' value='$ParentWork' size=30 maxlength=50></td>
</tr>

<tr>
  <td class=lst>Alamat Lengkap</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentAddress1' value='$ParentAddress1' size=40 maxlength=100><br>
    <input type=text name='ParentAddress2' value='$ParentAddress2' size=40 maxlength=100><br>
	RT <input type=text name='ParentRT' value='$ParentRT' size=5 maxlength=5> &nbsp;
	RW <input type=text name='ParentRW' value='$ParentRW' size=5 maxlength=5>
  </td>
</tr>

<tr>
  <td class=lst>Kota</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentCity' value='$ParentCity' size=18 maxlength=20> &nbsp;
    Kode Pos <input type=text name='ParentPostalCode' value='$ParentPostalCode' size=10 maxlength=10>
  </td>
</tr>

<tr>
  <td class=lst>Telepon</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentPhone' value='$ParentPhone' size=20 maxlength=20></td>
</tr>

<tr>
  <td class=lst>Handphone</td><td class=lst>:</td>
  <td class=lst><input type=text name='ParentMobilePhone' value='$ParentMobilePhone' size=20 maxlength=20></td>
</tr>
</table><br>


<table class=basic width=100%>
<tr>
  <th class=ttl colspan=3>Data Pendidikan</th>
</tr>

<tr>
  <td class=lst>Asal Sekolah/Perg. Tinggi</td><td class=lst>:</td>
  <td class=lst><input type=text name='FromSchool' value='$FromSchool' size=40 maxlength=100></td>
</tr>

<tr>
  <td class=lst>Jenis Asal Sekolah</td><td class=lst>:</td>
  <td class=lst><select name='SchoolType'>".GetOption("schooltype", "SchoolType", "Rank", "$SchoolType")."</select></td>
</tr>

<tr>
  <td class=lst>Kota/Wilayah</td><td class=lst>:</td>
  <td class=lst><input type=text name='SchoolCity' value='$SchoolCity' size=40 maxlength=50>
  </td>
</tr>

<tr>
  <td class=lst>Jurusan</td><td class=lst>:</td>
  <td class=lst><input type=text name='SchoolMajor' value='$SchoolMajor' size=40 maxlength=50>
  </td>
</tr>

<tr>
  <td class=lst>Tahun Lulus</td><td class=lst>:</td>
  <td class=lst><select name='GraduateYear'>".GetNumberOption(1970, date('Y') , date('Y'))."</select>
    <input type=checkbox name='NotGraduated' value='Y' $str_NG>
	Tidak Lulus (Pindahan)
  </td>
</tr>

<tr>
  <td class=lst>No. STTB/Ijasah</td><td class=lst>:</td>
  <td class=lst><input type=text name='CertificateNumber' value='$CertificateNumber' size=20 maxlength=20>
  </td>
</tr>
</table><br>


<table class=basic width=100%>
<tr>
  <th class=ttl colspan=3>Program Studi yg Dipilih</th>
</tr>

<tr>
  <td class=lst>Kampus</td><td class=lst>:</td><td class=lst><select name='KodeKampus'>$optKampus</select></td>
</tr>
<tr>
  <td class=lst>Pilihan</td><td class=lst>:</td>
  <td class=lst><select name='Program'>".GetOption2("jurusan", "concat(Kode, ' -- ', Nama_Indonesia)", "Rank", "$Program", '', 'Kode')."</select>
  </td>
</tr>

<tr>
  <td class=lst>Program</td><td class=lst>:</td>
  <td class=lst><select name='ProgramType'>$optprg</select>
  </td>
</tr>

<tr>
  <td class=lst>Kuliah</td><td class=lst>:</td>
  <td class=lst><select name='ProgramSchedule'>".GetOption("programschedule", "ProgramSchedule", "Rank", "$ProgramSchedule")."</select>
  </td>
</tr>

<tr><th class=ttl colspan=3>Tambahan</th></tr>
<tr><td class=lst colspan=3>Mengetahui STIE SUPRA dari:<br>
<textarea name='Keterangan' cols=40 rows=3>$Keterangan</textarea>
</td></tr>

</table><br>

<center>
  <input type=submit name=submit value='$strRegister'> &nbsp;
  <input type=reset name=reset value=reset>
</center>
</form>

  ";
  }

  DisplayHeader($fmtPageTitle, $strNewStudentRegistration);
  
  // *** Main Program ***
  if (!empty($_REQUEST['PMBID'])) $PMBID = $_REQUEST['PMBID'];
  else $PMBID = '';

  // Action
  if (empty($_SESSION['sysfo'])) $action = 'index.php';
  else $action = 'sysfo.php';

  if (!isset($_POST['submit'])) {
    ResetPMBForm();
    DisplayPMBForm($PMBID);
  }
  else {
    $Name = FixQuotes($_POST['Name']);
	$Email = FixQuotes($_POST['Email']);
	$Sex = $_POST['Sex'];
	$BirthPlace = FixQuotes($_POST['BirthPlace']);
	$BirthDateDay = $_POST['BirthDateDay'];
	$BirthDateMonth = $_POST['BirthDateMonth'];
	$BirthDateYear = $_POST['BirthDateYear'];
	$BirthDate = "$BirthDateYear-$BirthDateMonth-$BirthDateDay";
	$Address1 = FixQuotes($_POST['Address1']);
	$Address2 = FixQuotes($_POST['Address2']);
	$RT = FixQuotes($_POST['RT']);
	$RW = FixQuotes($_POST['RW']);
	$City = FixQuotes($_POST['City']);
	$PostalCode = FixQuotes($_POST['PostalCode']);
	$Phone = FixQuotes($_POST['Phone']);
	$MobilePhone = FixQuotes($_POST['MobilePhone']);
	$AgamaID = FixQuotes($_POST['AgamaID']);
	$Nationality = FixQuotes($_POST['Nationality']);
	$CompanyName = FixQuotes($_POST['CompanyName']);
	$CompanyAddress1 = FixQuotes($_POST['CompanyAddress1']);
	$CompanyAddress2= FixQuotes($_POST['CompanyAddress2']);
	$CompanyPhone = FixQuotes($_POST['CompanyPhone']);
	$CompanyFacsimile = FixQuotes($_POST['CompanyFacsimile']);
	$ParentName = FixQuotes($_POST['ParentName']);
	$ParentWork = FixQuotes($_POST['ParentWork']);
	$ParentAddress1 = FixQuotes($_POST['ParentAddress1']);
	$ParentAddress2= FixQuotes($_POST['ParentAddress2']);
	$ParentRT = FixQuotes($_POST['ParentRT']);
	$ParentRW = FixQuotes($_POST['ParentRW']);
	$ParentCity = FixQuotes($_POST['ParentCity']);
	$ParentPostalCode = FixQuotes($_POST['ParentPostalCode']);
	$ParentPhone = FixQuotes($_POST['ParentPhone']);
	$ParentMobilePhone = FixQuotes($_POST['ParentMobilePhone']);
	$FromSchool = FixQuotes($_POST['FromSchool']);
	$SchoolType = FixQuotes($_POST['SchoolType']);
	$SchoolCity = FixQuotes($_POST['SchoolCity']);
	$SchoolMajor = FixQuotes($_POST['SchoolMajor']);
	$GraduateYear = $_POST['GraduateYear'];
	if (!isset($_POST['NotGraduated'])) $NotGraduated = 'N';
	else $NotGraduated = $_POST['NotGraduated'];
	$CertificateNumber = FixQuotes($_POST['CertificateNumber']);
	$KodeKampus = $_POST['KodeKampus'];
	$Program = FixQuotes($_POST['Program']);
	$ProgramType = FixQuotes($_POST['ProgramType']);
	$ProgramSchedule = FixQuotes($_POST['ProgramSchedule']);
	$TestScore = $_POST['TestScore'];
	$TestPass = $_POST['TestPass'];
	$Keterangan = FixQuotes($_POST['Keterangan']);

	include "lib/table.common.php";
	if (!empty($PMBID)) {
	  // Action
      if (empty($_SESSION['sysfo'])) 
	    $fullaction = "index.php?exec=sysfo/listofnewstudent&Search=$PMBID&SearchID=$strSubmit";
      else $fullaction = "sysfo.php?syxec=listofnewstudent&Search=$PMBID&SearchID=$strSubmit";

	  // EDIT
	  $_sql = "update pmb set Name='$Name', Email='$Email', Sex='$Sex',BirthPlace='$BirthPlace',
	    BirthDate='$BirthDate',Address1='$Address1',Address2='$Address2',
		RT='$RT',RW='$RW',City='$City',PostalCode='$PostalCode',Phone='$Phone',
		MobilePhone='$MobilePhone',AgamaID='$AgamaID',Nationality='$Nationality',
		CompanyName='$CompanyName',CompanyAddress1='$CompanyAddress1',
		CompanyAddress2='$CompanyAddress2',CompanyPhone='$CompanyPhone',
		CompanyFacsimile='$CompanyFacsimile',ParentName='$ParentName',
		ParentWork='$ParentWork',ParentAddress1='$ParentAddress1',
		ParentAddress2='$ParentAddress2',ParentRT='$ParentRT',ParentRW='$ParentRW',
		ParentCity='$ParentCity',ParentPostalCode='$ParentPostalCode',
		ParentPhone='$ParentPhone',ParentMobilePhone='$ParentMobilePhone',
		FromSchool='$FromSchool',SchoolType='$SchoolType',SchoolCity='$SchoolCity',
		SchoolMajor='$SchoolMajor',GraduateYear='$GraduateYear',
		NotGraduated='$NotGraduated',CertificateNumber='$CertificateNumber',
		KodeKampus = '$KodeKampus',
		Program='$Program',ProgramType='$ProgramType',ProgramSchedule='$ProgramSchedule',
		TestScore='$TestScore',TestPass='$TestPass',
		Keterangan='$Keterangan'
		where PMBID='$PMBID'
	    ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	  DisplayItem($fmtMessage, "Berhasil", "Proses Penyuntingan berhasil.<br>
	    Nomer pendaftaran yg disunting adalah: 
		<a href='$fullaction'><b>$PMBID</b></a>.<br>
		Menu: <a href='sysfo.php?syxec=listofnewstudent'>$strListofNewStudent</a>
		");
	}
	else {
	  // INSERT
	  $PMBID = GetNextPMBID();
	  $PMBPrice = GetaField('jurusan', 'Kode', $Program, 'PMBPrice');
	  // Action
      if (empty($_SESSION['sysfo'])) 
	    $fullaction = "index.php?exec=sysfo/listofnewstudent&Search=$PMBID&SearchID=$strSubmit";
      else $fullaction = "sysfo.php?syxec=listofnewstudent&Search=$PMBID&SearchID=$strSubmit";

	  $_sql = "insert into pmb (PMBID, PMBDate, Name, Email, Sex, BirthPlace, BirthDate,
	    Address1, Address2, RT, RW, City, PostalCode, Phone, MobilePhone, AgamaID,
	    Nationality, CompanyName, CompanyAddress1, CompanyAddress2, CompanyPhone,
	    CompanyFacsimile, ParentName, ParentWork, ParentAddress1, ParentAddress2,
	    ParentRT, ParentRW, ParentCity, ParentPostalCode, ParentPhone, ParentMobilePhone,
	    FromSchool, SchoolType, SchoolCity, SchoolMajor, GraduateYear, NotGraduated,
	    CertificateNumber, KodeKampus, Program, ProgramType, ProgramSchedule, 
		TestScore, TestPass, PMBPrice, Keterangan)
	    values ('$PMBID', now(),'$Name', '$Email', '$Sex', '$BirthPlace','$BirthDate',
	    '$Address1','$Address2','$RT','$RW','$City','$PostalCode','$Phone',
	    '$MobilePhone','$AgamaID',
	    '$Nationality','$CompanyName','$CompanyAddress1','$CompanyAddress2','$CompanyPhone',
	    '$CompanyFacsimile','$ParentName','$ParentWork','$ParentAddress1','$ParentAddress2',
	    '$ParentRT','$ParentRW','$ParentCity','$ParentPostalCode','$ParentPhone',
	    '$ParentMobilePhone',
	    '$FromSchool','$SchoolType','$SchoolCity','$SchoolMajor','$GraduateYear','$NotGraduated',
	    '$CertificateNumber','$KodeKampus','$Program','$ProgramType','$ProgramSchedule',
		0,'N', '$PMBPrice', '$Keterangan')   ";
	  $_res = mysql_query($_sql) or die("$strCantQuery: $_sql<br>".mysql_error());
	  DisplayItem($fmtMessage, "Berhasil", "Proses pendaftaran berhasil.<br>
	    Nomer pendaftaran Anda adalah: 
		<a href='$fullaction'><b>$PMBID</b></a>.<br>
		Menu: <a href='sysfo.php?syxec=listofnewstudent'>$strListofNewStudent</a>
		");

	  //mail('to', 'subject', 'msg');
	  mail($PMBEmail_notification, 'Pemberitahuan: PMB',
	    "PMBID: $PMBID \n
		Nama: $Name \n Email: $Email \n
		Kelamin: $Sex \n Tempat/Tanggal Lahir: $BirthPlace, $BirthDate \n
		Alamat1: $Address1 \n Alamat2: $Address2 \n RT/RW: $RT/$RW \n Kota: $City\n KodePos: $PostalCode\n
		Telepon: $Phone \n HandPhone: $MobilePhone \n Agama: $AgamaID \n Kebangsaan: $Nationality \n
		PrshNama: $CompanyName\n PrshAlamat1: $CompanyAddress1 \n PrshAlamat2: $CompanyAddress2 \n
	    PrshPhone: $CompanyPhone \n PrshFax: $CompanyFacsimile \n
		OrtuNama: $ParentName \n OrtuKerja: $ParentWork \n
		OrtuAlamat1: $ParentAddress1 \n OrtuAlamat2: $ParentAddress2 \n
		OrtuRT: $ParentRT, OrtuRW: $ParentRW \n
		Ortu Kota: $ParentCity, Ortu KodePos: $ParentPostalCode \n
		Ortu Telepon: $ParentPhone, Ortu Handphone: $ParentMobilePhone \n\n
		Dari Sekolah: $FromSchool \n Jenis sekolah: $SchoolType \n Kota: $SchoolCity \n
		Konsentrasi: $SchoolMajor\n Tahun Lulus: $GraduateYear, Lulus: $NotGraduated \n
		Nomer Ijazah: $CertificateNumber \n\n Kode Kampus: $KodeKampus\n
		Jurusan: $Program, Program: $ProgramType, Kuliah: $ProgramSchedule\n
		Tahu STIE SUPRA dari: $Keterangan", "From: $AdminEmail");
		
	}
  }
?>
