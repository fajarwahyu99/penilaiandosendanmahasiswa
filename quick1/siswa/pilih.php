<!DOCTYPE html>
<center><html>
<head><title>QUICK COUNT PEMILIHAN KETUA OSIS PERIODE 2016/2017</title>
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
table { font-family: Cambria,"Times New Roman",serif;}

</style>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
</head>
<body bgcolor="#fff666">
<?php
	//proses mengambil data ke database untuk ditampilkan di form edit berdasarkan siswa_id yg didapatkan dari GET id -> edit.php?id=siswa_id

	//include atau memasukkan file koneksi ke database
	include('koneksi.php');

	//membuat variabel $id yg nilainya adalah dari URL GET id -> pilih.php?id=no_urut
	$id = $_GET['id'];

	//melakukan query ke database dg SELECT table siswa dengan kondisi WHERE no_urut = '$id'
	$show = mysql_query("SELECT * FROM siswa WHERE no_urut='$id'");

	session_start();
  $_SESSION['id'] = $id;

	?>

	<h2>QUICK COUNT PEMILIHAN KETUA OSIS PERIODE 2016/2017</h2>

	<p><a href="index.php" button type="button" class="btn btn-info"><font color = "#ffffff">Beranda</a></font></button> </p>

	<h3>Tambah Suara</h3>

	<center><form action="tambah.php" method="post">
		<table cellpadding="3" cellspacing="0">

				<td></td>
				<td></td>
				<td>
					<select name="status" required>
						<option value="siswa">Siswa</option>
						
					</select>
				</td>
			</tr></center>

			<tr>
				<td>&nbsp;</td>
				<td></td>
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
				<td><input type="submit" name="tambah" value="Tambah"<button type="button" class="btn btn-success"><font color = "#ffffff"></td>
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
</html>
