<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="description" content="chart created using amCharts live editor" /> <!--  META YANG DIGUNAKAN PIE CHART-->
    <title>Pilkada Kota Tangerang Selatan</title>
    
<!-- AWAL SCRIPT PIE CHART -->
		<!-- amCharts javascript sources -->
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/light.js"></script>

		<!-- amCharts javascript code -->
		<script type="text/javascript">
			AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"angle": 12,
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"depth3D": 15,
					"labelRadius":2,
					"titleField": "category",
					"valueField": "column-1",
					"theme": "light",
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"align": "center",
						"markerType": "circle"
					},
					"titles": [],
					"dataProvider": [
						{
							"category": "suara 1",
							"column-1": 8
						},
						{
							"category": "suara 2",
							"column-1": 6
						},
						{
							"category": "suara 3",
							"column-1": 2
						}
					]
				}
			);
		</script>
<!-- AKHIR SCRIPT PIE CHART -->

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.css" rel="stylesheet" type="text/css">
    <!-- MetisMenu CSS -->
    <link href="css/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="login.php">LOGIN</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#hasil">Hasil Pemilihan</a>
                    </li>
                    <li>
                        <a href="#rekap">Rekapitulasi</a>
                    </li>
                    <li>
                        <a href="#info">Informasi</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Header -->
    
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Selamat Datang</h1>
                        <h3></h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->
	<a  name="hasil"></a>
    <div class="content-section-a">

        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Hasil Hitung TPS Kota Tangerang Selatan</h2>
                    <p class="lead">Keterangan : <br>1. Syinsyina Arifa dan Rakhmat Hidayat<br>Perolehan Suara :<href="http://join.deathtothestockphoto.com/"><br>2. Hj.Airin Rachmi Diany,SH.,MH dan Drs. H. Benyamin Davnie<br>Perolehan Suara :</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
						<div>
                            HASIL PERHITUNGAN SEMENTARA
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
 <!-- BUAT PIE CHART -->    <div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
                            
               <?php 
	include"konten/koneksi.php";
	$query="select * from hasil_hitung";
	$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
	while($buff=mysql_fetch_array($hasil)){		
			   ?>

        	<div class="col-lg-5 col-sm-6">
            	<hr class="section-heading-spacer">
                   <div class="clearfix"></div>
                   <h2 class="section-heading">Hasil Hitung TPS Kota Tangerang Selatan</h2>
                   <p class="lead">Keterangan : 
                   <br>1. Dr. Ikhsan Modjo dan Li Claudia Chandra<br>Perolehan Suara :
				   <?php echo $buff['t_s1'];?> 
                   <br>2. Drs. H. Arsid, M.Si dan dr. Elvier Ariadiannie Soedarto Poetri, MARS<br>Perolehan Suara : <?php
                   echo $buff['t_s2'];?>
                   <br>3. Hj. Airin Rachmi Diany,SH.,MH dan Drs. H.Benyamin Davnie <br>Perolehan Suara : <?php
                   echo $buff['t_s3'];?>
                   </p>
                </div>
                <?php
	}
				?>
            


        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

	<a name="rekap"></a>
    <div class="content-section-b">

      <div class="container">

            <div class="row">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Rekapitulasi Data Wilayah</h2>
                    <p class="lead"></p>
                </div>
               
                     <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Wilayah</th>
                                            <th>Total DPT</th>
                                            <th>Pengguna Hak Pilih</th>
                                            <th>Perolehan Suara Kandidat 1</th>
                                            <th>Perolehan Suara Kandidat 2</th>
                                            <th>Perolehan Suara Kandidat 3</th>
                                            <th>Suara Sah</th>
                                            <th>Suara Tidak Sah</th>
                                            <th>Total Suara</th>
                                        </tr>
                                    </thead>
                                    
            <?php 
			   include"konten/koneksi.php";
					$query="select * from wilayah_kel";
					$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
			   ?>                                   
                                    
                                    <tbody>
                                    <?php
									while($buff=mysql_fetch_array($hasil)){
									?> 
                                        <tr class="odd gradeX">
                                    <td><?php echo $buff['id_wilayahkel'];?></td>
                                    <td><?php echo $buff['kelurahan'];?></td>
                                    <td><?php echo $buff['jml_DPTkel'];?></td>
                                    <td class="center"><?php echo $buff['hakpilih_kel'];?></td>
                                    <td class="center"><?php echo $buff['s1_kel'];?></td>
                                    <td><?php echo $buff['s2_kel'];?></td>
                                    <td><?php echo $buff['s3_kel'];?></td>
                                    <td><?php echo $buff['suara_sahkel'];?></td>
                                    <td><?php echo $buff['suara_tdksahkel'];?></td>
                                    <td><?php echo $buff['total_suarakel'];?></td>
                                    
                                    </tr>   
						           </tbody>
                                   <?php
									};
									mysql_close();
									?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-section-b -->

    <a name="info"></a>
    <div class="content-section-a">

        <div class="container">

            <div class="row">
              <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Informasi</h2>
                    <p class="lead">Ini informasi untuk mengetahui data rekapitulasi .</p>
                </div>
                <div class="col-md-7">
                    <div class="panel panel-default">
                    <div class="panel-heading">
                           Pemilih dan Pengguna Hak Pilih
                        </div>
                    <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Laki-Laki</th>
                                            <th>Perempuan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Pemilih</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                        </tr>
                                        <tr>
                                            <td>Pengguna Hak Pilih</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                        </tr>
                                        <tr>
                                            <td>Partisipasi</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                            <td>123.456</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

	<a  name="contact"></a>
    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Connect to Start Bootstrap:</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                            <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                        </li>
                        <li>
                            <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                            <a href="#hasil">Hasil Pemilihan</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#rekap">Rekapitulasi</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#info">Informasi</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy; Kelompok 3 2015. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Flot Charts JavaScript -->
    <script src="css/flot/excanvas.min.js"></script>
    <script src="css/flot/jquery.flot.js"></script>
    <script src="css/flot/jquery.flot.pie.js"></script>
    <script src="css/flot/jquery.flot.resize.js"></script>
    <script src="css/flot/jquery.flot.time.js"></script>
    <script src="css/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="js/flot-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
