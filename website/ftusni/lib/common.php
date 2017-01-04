<?php
  // Author: E. Setio Dewo, setio_dewo@telkom.net, April 2003
  

  function sqling($str) {
    $str = stripslashes($str);
	return addslashes($str);
  }
  function FixQuotes($str) {
    $str = stripslashes($str);
	$str = str_replace('"', '&quot;', $str);
	$str = str_replace("'", '&#39;', $str);
	return $str;
  }
  function NUMI($nil=0) {
    return number_format($nil, 0, ',', '.');
  }
  function GetLastID() {
    $sql = "select LAST_INSERT_ID() as ID";
	$res = mysql_query($sql);
	return mysql_result($res, 0, 'ID');
  }
  // ambil Level
  function GetLevelUp ($default) {
    Global $strCantQuery;

	$ulevel = $_SESSION['ulevel'];
    $sqlgrp = "Select * from level where Level>=$ulevel order by Level";
    $sqlres = mysql_query ($sqlgrp) or die ($strCantQuery);
    $strtmp = "";
    for ($i=0; $i < mysql_num_rows ($sqlres); $i++) {
      $strval = mysql_result ($sqlres, $i, "Level");
	  $strnm = "$strval. " . mysql_result($sqlres, $i, 'Name');
      if (isset($default) and ($strval == $default))
        $strtmp = "$strtmp<option selected>$strnm</option>";
      else $strtmp = "$strtmp<option>$strnm</option>";
    }
    return ($strtmp);
  }
  function GetLevel ($default=0) {
    Global $strCantQuery;
    $sqlgrp = "Select * from level order by Level";
    $sqlres = mysql_query ($sqlgrp) or die ($strCantQuery);
    $strtmp = "";
    for ($i=0; $i < mysql_num_rows ($sqlres); $i++) {
      $strval = mysql_result ($sqlres, $i, "Level");
	  $strnm = "$strval. " . mysql_result($sqlres, $i, 'Name');
      if (isset($default) and ($strval == $default))
        $strtmp = "$strtmp<option selected>$strnm</option>";
      else $strtmp = "$strtmp<option>$strnm</option>";
    }
    return ($strtmp);
  }
  // ambil NewsGroup
  function GetCategory ($default, $mode=0, $ulevel=5) {
    Global $Language, $strCantQuery, $NewsGroup;
	// $mode 0 utk melihat
	// $mode 1 utk mengedit
	//$ulevel = $_SESSION['ulevel'];
	if ($mode == 0)
      $sqlgrp = "Select Category from newscategory where Language='$Language' 
	    and NotActive='N' and Level>=$ulevel order by Category";
	else if ($mode == 1)
      $sqlgrp = "Select Category from newscategory where Language='$Language' 
	    and NotActive='N' and EditLevel>=$ulevel order by Category";
    $sqlres = mysql_query ($sqlgrp) or die ($strCantQuery);
    $strtmp = "<option></option>";
    for ($i=0; $i < mysql_num_rows ($sqlres); $i++) {
      $strval = mysql_result ($sqlres, $i, "Category");
      if (isset($default) and ($strval == $default))
        $strtmp = "$strtmp<option selected>$strval</option>";
      else $strtmp = "$strtmp<option>$strval</option>";
    }
    return ($strtmp);
  }
  // Ambil Pilihan Bulan
  function GetMonthOption($_default=0) {
    global $arr_Month;
    $_tmp = "";
	$_max = count($arr_Month) +1;
	for ($i=1; $i<$_max; $i++) {
	  $stri = str_pad($i, 2, '0', STR_PAD_LEFT);
	  if ($_default==$i) $_tmp = "$_tmp <option value='$stri' selected>". $arr_Month[$i-1] ."</option>";
	  else $_tmp = "$_tmp <option value='$stri'>". $arr_Month[$i-1] ."</option>";
	}
	return $_tmp;
  }
  // Buat Pilihan numerik
  function GetNumberOption($_start, $_end, $_default=0, $interval=1, $pad=2) {
    $_tmp = "";
	for ($i=$_start; $i <= $_end; $i+=$interval) {
	  $stri = str_pad($i, $pad, '0', STR_PAD_LEFT);
	  if ($i == $_default) $_tmp = "$_tmp <option selected>$stri</option>";
	  else $_tmp = "$_tmp <option>$stri</option>";
	}
	return $_tmp;
  }
  // Buat pilihan Program Studi
  function GetOption($_table, $_field, $_order='', $_default='', $_where='', $_value='') {
    global $strCantQuery;
	if (!empty($_order)) $str_order = " order by $_order ";
	else $str_order = "";
	if (!empty($_where)) $_where = " and $_where";
	if (!empty($_value)) $_fieldvalue = ", $_value";
	else $_fieldvalue = '';
    $_tmp = "<option value=''></option>";
	$_sql = "select $_field $_fieldvalue from $_table where NotActive='N' $_where $str_order";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql");
	for ($i=0; $i < mysql_num_rows($_res); $i++) {
	  if (!empty($_value)) $_v = "value='" . mysql_result($_res, $i, $_value) . "'";
	  else $_v = '';
	  if ($_default == mysql_result($_res, $i, $_field))
	    $_tmp = "$_tmp <option $_v selected>". mysql_result($_res, $i, $_field) ."</option>";
	  else
	    $_tmp = "$_tmp <option $_v>". mysql_result($_res, $i, $_field) ."</option>";
	}
	return $_tmp;
  }
  function GetOption2($_table, $_field, $_order='', $_default='', $_where='', $_value='', $not=0) {
    global $strCantQuery;
	if (!empty($_order)) $str_order = " order by $_order ";
	else $str_order = "";
	if ($not==0) $strnot = "NotActive='N'"; else $strnot = '';
	if (!empty($_where)) {
	  if (empty($strnot)) $_where = "$_where"; else $_where = "and $_where";
	}
	if (!empty($_value)) {
	  $_fieldvalue = ", $_value";
	  $fk = $_value;
	}
	else {
	  $_fieldvalue = '';
	  $fk = $_field;
	}
    $_tmp = "<option value=''></option>";
	$_sql = "select $_field $_fieldvalue from $_table where $strnot $_where $str_order";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql<br>".mysql_error());

	for ($i=0; $i < mysql_num_rows($_res); $i++) {
	  if (!empty($_value)) $_v = "value='" . mysql_result($_res, $i, $_value) . "'";
	  else $_v = '';
	  if ($_default == mysql_result($_res, $i, $fk))
	    $_tmp = "$_tmp <option $_v selected>". mysql_result($_res, $i, $_field) ."</option>";
	  else
	    $_tmp = "$_tmp <option $_v>". mysql_result($_res, $i, $_field) ."</option>";
	}
	return $_tmp;
}
function GetaField($_tbl,$_key,$_value,$_result) {
  global $strCantQuery;
	$_sql = "select $_result from $_tbl where $_key='$_value' limit 1";
	$_res = mysql_query($_sql) or die("$strCantQuery: $_sql<br>".mysql_error());
	if (mysql_num_rows($_res) == 0) return '';
	else return mysql_result($_res, 0, mysql_field_name($_res, 0));
}
function GetFields($_tbl, $_key, $_value, $_results) {
  global $strCantQuery;
	$s = "select $_results from $_tbl where $_key='$_value' limit 1";
	$r = mysql_query($s) or die ("$strCantQuery: $s<br>".mysql_error());
	if (mysql_num_rows($r) == 0) return '';
	else {
	  $res = array();
	  for ($i=0; $i < mysql_num_fields($r); $i++) {
		$res[mysql_field_name($r, $i)] = mysql_result($r, 0, mysql_field_name($r, $i));
	  }
	  return $res;
	}
}
function DisplayPrinter($Link, $Style='cursor:hand', $Img='image/printer.gif') {
  echo "<img src='$Img' style='$Style' height=16
	  onClick=\"NewWin=window.open('$Link','NewWin','toolbar=no,status=no,width=800,height=500,scrollbars=yes'); \">
    ";
}
function GetPrinter($Link, $Style='cursor:hand', $Img='image/printer.gif') {
  return "<img src='$Img' style='$Style' height=16
	  onClick=\"NewWin=window.open('$Link','NewWin','toolbar=no,status=no,width=800,height=500,scrollbars=yes'); \">
	  ";
}
function SimplePrinter($Link, $Caption, $Class='lst') {
  echo "<font class='$Class' style='cursor:hand; color:red' 
	  onClick=\"NewWin=window.open('$Link','NewWin','toolbar=no,status=no,width=800,height=500,scrollbars=yes'); \">
	  $Caption</font>";
}
function StripEmpty($var) {
  if (empty($var)) return '&nbsp;';
	else return $var;
}
function DisplayLoginForm($act='index.php') {
  global $strLogin, $strNIP, $strLevel, $strPassword;
	$optlevel = GetLevel();
	echo <<<EOF
	<table class=box cellspacing=1 cellpadding=2 align=center>
	<form action='$act' method=POST>
	<input type=hidden name='exec' value='proclogin'>
	<input type=hidden name='proc' value=1>
	<tr><th class=ttl colspan=3>$strLogin</th></tr>
	<tr><td bgcolor=white rowspan=4><img src='image/tux001.jpg'><td bgcolor=white align=right>$strNIP</td><td bgcolor=white><input type=text name='NIP' size=20 maxlength=20></td></tr>
	<tr><td bgcolor=white align=right>$strLevel</td><td bgcolor=white><select name='level'>$optlevel</select></td></tr>
	<tr><td bgcolor=white align=right>$strPassword</td><td bgcolor=white><input type=password name='password' size=20 maxlength=10></td></tr>
	<tr><td bgcolor=white colspan=2 align=center><input type=submit name=submit value='$strLogin'>
	  &nbsp;&nbsp;<input type=reset name=reset value='reset'></td></tr>
	</form></table>
EOF;
}
  function DisplayThemeMenu($action='index.php') {
    $_sid = session_id();
    $dr = dir ("./theme");
	$arr = array();
    while ($isi = $dr->read()) {
      if ($isi!="." and $isi!="..") {
	    $arr[] = "$isi -> $action?theme=$isi&PHPSESSID=$_sid";
	  }
    }
    $dr->close();
	AddSubMenu('', $arr);
  }
  function EmptyArray($arr) {
    $jml = count($arr);
	$tmp = "";
    for ($i=0; $i < $jml; $i++) {
	  if (!empty($arr[$i])) $tmp = $tmp . $arr[$i];
	}
	return empty($tmp);
  }
?>