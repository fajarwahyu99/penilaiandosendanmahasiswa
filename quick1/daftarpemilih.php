<!DOCTYPE html>
<center><html>
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
#paragraf2 { font-family: Georgia, serif; }

</style>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">
  </head>
<body bgcolor="#fff666">

	<h2>DATA PEMILIH TETAP</h2>

	<!-- <p><a href="guru/login.php" button type="button" class="btn btn-info"><font color = "#ffffff">PILIH KETUA OSIS(UNTUK GURU)</font></a></button> -->      <a href="siswa/login.php"button type="button" class="btn btn-info"><font color = "#ffffff">PILIH KETUA OSIS (UNTUK SISWA)</font></a></button>
<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' >
		<tr bgcolor="#CCCCCC">
		<th>no</th>
			<th>Login ID</th>
			<th>Karakter Unik</th>
			<th>Status</th>
			<th>NIM</th>
			
			
		</tr>
		
		<?php
		//iclude file koneksi ke database
		include('koneksi.php');
		
		//query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
		$query = mysql_query("SELECT * FROM discussion_topics ORDER BY login_id ") or die(mysql_error());
		
		//cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
		if(mysql_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong
			
			//jika data kosong, maka akan menampilkan row kosong
			echo '<tr><td colspan="6">Tidak ada data!</td></tr>';
			
		}else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)
			
			//jika data tidak kosong, maka akan melakukan perulangan while
			$no = 1;	//membuat variabel $no untuk membuat nomor urut
			while($data = mysql_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database
				
				//menampilkan row dengan data di database
				echo '<tr>';
					echo '<td>'.$no.'</td>';	//menampilkan nomor urut
					echo '<td>'.$data['login_id'].'</td>';	//menampilkan data nis dari database
					echo '<td>'.$data['charac'].'</td>';	//menampilkan data nama lengkap dari database
					echo '<td>'.$data['stat_us'].'</td>';	//menampilkan data kelas dari database
					echo '<td>'.$data['nim'].'</td>';	//menampilkan data jurusan dari database
					
				echo '</tr>';
				
				$no++;	//menambah jumlah nomor urut setiap row
				
			}
			
		}
		?>
	</table>
	<!-- <p><a href="user.php" button type="button" class="btn btn-info"><font color = "#ffffff">Tambah Pemilih</font></a></button> -->
	<p><a href="index.php" button type="button" class="btn btn-info"><font color = "#ffffff">HOME</font></a></button>
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
<p>&copy;MPK 2016/2017</p>
</html></center>