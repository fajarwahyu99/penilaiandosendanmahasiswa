               <?php 
			   include"koneksi.php";
					$query="select * from data_suara";
					$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
					
			   ?>
	<!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
 
    <!-- Custom Google Web Font -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
    
    <!-- Custom CSS-->
    <link href="../css/general.css" rel="stylesheet">
    
     <!-- Owl-Carousel -->
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="../css/magnific-popup.css"> 
    
    <script src="../js/modernizr-2.8.3.min.js"></script>  <!-- Modernizr /-->
    <!--[if IE 9]>
        <script src="js/PIE_IE9.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
        <script src="js/PIE_IE678.js"></script>
    <![endif]-->

    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
    <![endif]-->



<a name="input"></a>
    <div class="content-section-b">

      <div class="container">

         
                    <div class="panel-body">
                        <!-- <hr class="intro-divider" /> -->
                        <h2 align="center">Input Data</h2>
                        
                        <div class="col-lg-12">  
                        <form action="?module=inputdata_proses" method="post">
                        	
                         
                        <div class="dropdown">
                          <label>Kecamatan</label>
                          <select class="btn btn-primary">
                           	<?php $query1="select * from wilayah";
					$hasil1=mysql_query($query1) or die("gagal melakukan query."); 
									while($buff=mysql_fetch_array($hasil1)){
							?>
                              <option value="volvo"><?php echo $buff['kecamatan'] ?></option>
                           <?php } ?>
                          </select>     
                        </div>  

                                           
                            <div class="form-group">
                            <label>Kelurahan</label>
                          <select class="btn btn-primary">
                           	<?php $query1="select * from wilayah_kel";
					$hasil1=mysql_query($query1) or die("gagal melakukan query."); 
									while($buff=mysql_fetch_array($hasil1)){
							?>
                              <option value="volvo"><?php echo $buff['kelurahan'] ?></option>
                           <?php } ?>
                          </select>
                            </div>
                            
                            <div class="form-group">
                            <label>Total DPT</label><br>
                            <input class="form-control" placeholder="Enter text" name="jml_DPTkel" required /></div>
                            
                            
                            <div class="form-group">
                            <label>Pengguna Hak Pilih</label>
                            <input class="form-control" placeholder="Enter text" name="hakpilih_kel" required /></div>
                                                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 1</label>
                            <input class="form-control" placeholder="Enter text" name="s1_kel" required /></div>
                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 2</label>
                            <input class="form-control" placeholder="Enter text" name="s2_kel" required /></div>
                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 3</label>
                            <input class="form-control" placeholder="Enter text" name="s3_kel" required /></div>
                            
                            <div class="form-group">
                            <label>Suara Sah</label>
                            <input class="form-control" placeholder="Enter text" name="suara_sahkel" required /></div>
                            
                            <div class="form-group">
                            <label>Suara Tidak Sah</label>
                            <input class="form-control" placeholder="Enter text" name="suara_tdksahkel" required /></div>
                                
                            <div class="form-group">
                            <label>Total Suara</label>
                            <input class="form-control" placeholder="Enter text" name="total_suarakel" required /></div>
                          

                            <input class="btn btn-primary btn-outline" type="submit"></input>                            
                            <input class="btn  btn-danger btn-outline" type="reset"></input>
                            </form>
                            
                            <?php
                                  //};
							mysql_close();
							?>
                            
                        </div>
                    </div>
                        </div>
                    </div>
                  </div>
                  </div>