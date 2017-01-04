<?php
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu Desti</title>
 
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Buku Tamu Desti</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Beranda</a></li>
                    <li class="active"><a href="data.php">Data Buku Tamu</a></li>
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container" style="margin-top: 50px">
        <h1>Data Buku Tamu!</h1>
        <hr />
        <?php
		//menampilkan data buku tamu
		$res = $koneksi->query("SELECT * FROM bukutamu ORDER BY id DESC") or die($koneksi->error);
		
		if($res->num_rows){
			while($row = $res->fetch_assoc()){
				echo '
				<table class="table table-condensed table-striped">
					<tr>
						<th width="150">TANGGAL TULIS</th>
						<th width="10">:</th>
						<td>'.$row['tanggal'].'</td>
					</tr>
					<tr>
						<th width="150">NAMA LENGKAP</th>
						<th width="10">:</th>
						<td>'.$row['nama'].'</td>
					</tr>
					<tr>
						<th>EMAIL</th>
						<th>:</th>
						<td>'.$row['email'].'</td>
					</tr>
					<tr>
						<th>WEBSITE</th>
						<th>:</th>
						<td>'.$row['website'].'</td>
					</tr>
					<tr>
						<th>JUDUL PESAN</th>
						<th>:</th>
						<td>'.$row['judul'].'</td>
					</tr>
					<tr>
						<th>ISI PESAN</th>
						<th>:</th>
						<td>'.$row['pesan'].'</td>
					</tr>
				</table>
				';
			}
		}else{
			echo 'Belum ada data buku tamu';
		}
		
		?>
    </div>    
 
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>