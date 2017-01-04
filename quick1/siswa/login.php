<?php session_start(); ?>
<center><html>
<head>
<meta charset="utf-8">
    <title>QUICK COUNT PEMILIHAN KETUA BEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
         <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

<style type="text/css">
body { font-family: Tahoma, Geneva, sans-serif; }
h2 { font-family: Cambria,"Times New Roman",serif; }
<td> { font-family: Georgia, serif; }

</style>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">

</head>
<body bgcolor="#fff666">
</head>
<body>
 
    <?php

// KONEKSI KE DATABASE
$koneksi = mysql_connect("localhost", "root", "") or die("Tidak bisa terhubung ke Database!");
mysql_select_db("pemos") or die("Tidak ada Database yang dipilih!");

 if(isset($_POST['login']))
{
 
  $charac= $_POST['charac'];
$id = $row['id'];

 
  $ambildata = mysql_query("SELECT * FROM `discussion_topics` WHERE `charac`='$charac'");
$ambil= mysql_query("SELECT * FROM `discussion_topics` WHERE `stat_us`='bisa'");
$data = mysql_fetch_assoc($ambildata);
$count = mysql_num_rows($ambildata);
$id = $data['login_id'];	
$stat_us = $data['stat_us'];


  if(empty($charac))
  {
    echo "

<div class='error'><b>ERROR:</b>

 Uniq Code Belum Diisi!

</div>


";
  }
  else

 if($stat_us == "tidak"){
    echo "

<div class='error'><b>ERROR:</b>

 Akun Ini Sudah Digunakan!

</div>

";
  }
  else

 if($count == 0){
    echo "

<div class='error'><b>ERROR:</b>

 Akun Tidak Ditemukan!

</div>


";
  }
  else

  {
    $baris = mysql_fetch_array($ambildata);

    if($baris['charac']==1)
    {
       
$_SESSION['login_id'] = $id;
       header('location: index.php');
    }
    else
    {
      $_SESSION['charac'] = $charac;
      header('location: index.php');
    }
  }

}
?>

<P>SILAHKAN MASUKKAN KARAKTER UNIK YANG TERTERA PADA KARTU PEMILIH ANDA</P>
   
    <!--/ FORM LOGIN /-->
 <form action="" method="post">
    <table>
     <tr>
         <td></td><td></td><td><input type="text" name="charac"/></td>
        </tr>
        
        <tr>
         <td></td><td></td><td><input type="submit" name="login" value="login" button type="button" class="btn btn-info"><font color = "#ffffff"/></td>
        </tr> 
    </table>
    </form>
 <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html></center>
