 <!-- FlatFy Theme - Andrea Galanti /-->
<!DOCTYPE html>
<html lang="en">
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Flatfy Free Flat and Responsive HTML5 Template ">
    
    <meta name="author" content="">

    <title>Aplikasi Quick Count</title>
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
    <link rel="stylesheet" href="css/magnific-popup.css"> 
    
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

</head>

<body id="home">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>
    
    <!-- FullScreen -->
   <!--  <div class="intro-header"> -->
        <div class="col-xs-12 text-center abcen1">
            <h1 class="h1_home wow fadeIn" data-wow-delay="0.4s">Quick Count</h1>
            <h3 class="h3_home wow fadeIn" data-wow-delay="0.6s">DKI  Jakarta</h3>
            <ul class="list-inline intro-social-buttons">
                <li><a href="login.php" class="btn  btn-lg mybutton_cyano wow fadeIn" data-wow-delay="0.8s"><span class="network-name"></span></a>
                </li>
                <li id="download" ><a href="#downloadlink" class="btn  btn-lg mybutton_standard wow swing wow fadeIn" data-wow-delay="1.2s"><span class="network-name"></span></a>
                </li>
            </ul>
        </div>    
        <!-- /.container -->
        <div class="col-xs-12 text-center abcen wow fadeIn">
            <!-- <div class="button_down "> 
                <a class="imgcircle wow bounceInUp" data-wow-duration="1.5s"  href="#whatis"> <img class="img_scroll" src="img/icon/circle.png" alt=""> </a>
            </div> -->
        </div>
    </div>
    
    <!-- NavBar-->
    <nav class="navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#home">Flatfy</a>
            </div>

            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    
                    <li class="menuItem"><a href="indexAdmin.php?module=home">What is?</a></li>
                    <li class="menuItem"><a href="indexAdmin.php?module=inputrelawan#relawan">Use It</a></li>
                    <li class="menuItem"><a href="indexAdmin.php?module=rekap#rekap">Screenshot</a></li>
                    <li class="menuItem"><a href="#credits">Credits</a></li>
                    <li class="menuItem"><a href="#contact">Contact</a></li>
                </ul>
            </div>
           
        </div>
    </nav> 
    
    <!-- What is -->
    <div id="whatis" class="content-section-b" style="border-top: 0">
        <div class="container">

            <div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Rekapitulasi Data Kecamatan</h2>
                </div>
            
                     <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
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
                                    <tbody>
                                   
                                    
                                    <?php 
include"koneksi.php";
                                    $query1="select * from wilayah";
                    $hasil1=mysql_query($query1) or die("gagal melakukan query."); 
                                    while($buff=mysql_fetch_array($hasil1)){
                                    ?>
                                    
                                    <tr class="odd gradeX">
                                    <td><?php echo $buff['id_wilayah'];?></td>
                                    

                                    <td><!--<a href="indexrelawan.php?module=rekap">--><?php echo $buff['kecamatan'];?></a></td>
                                    <td><?php echo $buff['jml_DPT'];?></td>
                                    <td class="center"><?php echo $buff['hakpilih'];?></td>
                                    <td class="center"><?php echo $buff['s1'];?></td>
                                    <td><?php echo $buff['s2'];?></td>
                                    <td><?php echo $buff['s3'];?></td>
                                    <td><?php echo $buff['suara_sah'];?></td>
                                    <td><?php echo $buff['suara_tdksah'];?></td>
                                    <td><?php echo $buff['total_suara'];?></td>
                                    
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
        </div>
    </div>
    
    <!-- Use it -->
    <div id ="useit" class="content-section-a">

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
                                   <?php include"koneksi.php";
                    
                    $query1=mysql_query("select sum(jml_DPT) from wilayah");
                    $query2=mysql_query("select sum(hakpilih) from wilayah");
                    $query3=mysql_query("select sum(total_suara) from wilayah");
                    $hasil1=mysql_fetch_row($query1) ;
                    $hasil2=mysql_fetch_row($query2) ;
                    $hasil3=mysql_fetch_row($query3) ;
                    
                    
               ?>

                                
                                    <thead>
                                        <tr>
                                            <th></th>
                                            
                                            
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Suara</td>
                                            <td><?php echo $hasil1[0];?></td>
                                        </tr>
                                        <tr>
                                            <td>Pengguna Hak Pilih</td>
                                            <td><?php echo $hasil2[0];?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Suara</td>
                                            <td><?php echo $hasil3[0];?></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                   
                                    mysql_close();
                                    ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
    </div>

    <div class="content-section-b"> 

        <div class="container">
            <<div class="row">
            <?php 
    include"koneksi.php";
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
                

                
                 <!-- <div class="col-sm-6 wow fadeInRightBig"  data-animation-delay="200">    
                        <div class="panel panel-default">
        <div class="panel-heading">
        <meta name="description" content="chart created using amCharts live editor" /> <!--  META YANG DIGUNAKAN PIE CHART 
        Total Suara Kota Tangerang Selatan
        
       
        <!-- amCharts javascript sources 
        <script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
        <script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
        <script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/light.js"></script>

        <!-- amCharts javascript code 
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
                            "category": "suara 3",
                            "column-1": <?php echo $buff['p_s1'];?>
                        },
                        {
                            "category": "suara 2",
                            "column-1": <?php echo $buff['p_s2'];?>
                        },
                        {
                            "category": "suara 1",
                            "column-1": <?php echo $buff['p_s3'];?>
                        }
                    ]
                }
            );
        </script>
        <?php
    }
                ?>
        </div> -->
      
<!-- /.panel-heading -->
<div class="panel-body">
    <div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
    
</div>
        </div>
    </div>
</div>
<!-- /.container -->
    </div>
    </div>

   <!--  <div class="content-section-a">

        <div class="container">

             <div class="row">
             
                
             
                <div class="col-sm-6 wow fadeInLeftBig"  data-animation-delay="200">   
                    <h3 class="section-heading">Font Awesome & Glyphicon</h3>
                    <p class="lead">A special thanks to Death to the Stock Photo for 
                    providing the photographs that you see in this template. 
                    </p>
                    
                    <ul class="descp lead2">
                        <li><i class="glyphicon glyphicon-signal"></i> Reliable and Secure Platform</li>
                        <li><i class="glyphicon glyphicon-refresh"></i> Everything is perfectly orgainized for future</li>
                        <li><i class="glyphicon glyphicon-headphones"></i> Attach large file easily</li>
                    </ul>
                </div>           
            </div>
        </div>

    </div> -->

    <!-- Screenshot 
    <div id="screen" class="content-section-b">
        <div class="container">
          <div class="row" >
             <div class="col-md-6 col-md-offset-3 text-center wrap_title ">
                <h2>Screen App</h2>
                <p class="lead" style="margin-top:0">A special thanks to Death.</p>
             </div>
          </div>
            <div class="row wow bounceInUp" >
              <div id="owl-demo" class="owl-carousel">
                
                <a href="img/slide/1.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/1.png" alt="Owl Image">
                    </div>
                </a>
                
               <a href="img/slide/2.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/2.png" alt="Owl Image">
                    </div>
                </a>
                
                <a href="img/slide/3.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/3.png" alt="Owl Image">
                    </div>
                </a>
                
                <a href="img/slide/1.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/1.png" alt="Owl Image">
                    </div>
                </a>
                
               <a href="img/slide/2.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/2.png" alt="Owl Image">
                    </div>
                </a>
                
                <a href="img/slide/3.png" class="image-link">
                    <div class="item">
                        <img  class="img-responsive img-rounded" src="img/slide/3.png" alt="Owl Image">
                    </div>
                </a>
              </div>       
          </div>
        </div>


    </div>
    
    <!-- <div  class="content-section-c ">
        <div class="container">
            <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center white">
                <h2>Get Live Updates</h2>
                <p class="lead" style="margin-top:0">A special thanks to Death.</p>
             </div>
            <div class="col-md-6 col-md-offset-3 text-center">
                <div class="mockup-content">
                        <div class="morph-button wow pulse morph-button-inflow morph-button-inflow-1">
                            <button type="button "><span>Subscribe to our Newsletter</span></button>
                            <div class="morph-content">
                                <div>
                                    <div class="content-style-form content-style-form-4 ">
                                        <h2 class="morph-clone">Subscribe to our Newsletter</h2>
                                        <form>
                                            <p><label>Your Email Address</label><input type="text"/></p>
                                            <p><button>Subscribe me</button></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>  
            </div>>
        </div>
    </div>   -->
    
    <!-- Credits -->
    <div id="credits" class="content-section-a">
        <div class="container">
            <div class="row">
            
            <div class="col-md-6 col-md-offset-3 text-center wrap_title">
                <h2>Credits</h2>
                <p class="lead" style="margin-top:0">A special thanks to Death.</p>
             </div>
             
                <div class="col-sm-6  block wow bounceIn">
                    <div class="row">
                        <div class="col-md-4 box-icon rotate"> 
                            <i class="fa fa-desktop fa-4x "> </i> 
                        </div>
                        <div class="col-md-8 box-ct">
                            <h3> Bootstrap </h3>
                            <p> Lorem ipsum dolor sit ametconsectetur adipiscing elit. Suspendisse orci quam. </p>
                        </div>
                  </div>
              </div>
              <div class="col-sm-6 block wow bounceIn">
                    <div class="row">
                      <div class="col-md-4 box-icon rotate"> 
                        <i class="fa fa-picture-o fa-4x "> </i> 
                      </div>
                      <div class="col-md-8 box-ct">
                        <h3> Owl-Carousel </h3>
                        <p> Nullam mo  arcu ac molestie scelerisqu vulputate, molestie ligula gravida, tempus ipsum.</p> 
                      </div>
                    </div>
              </div>
          </div>
          
          <div class="row tworow">
                <div class="col-sm-6  block wow bounceIn">
                    <div class="row">
                        <div class="col-md-4 box-icon rotate"> 
                            <i class="fa fa-magic fa-4x "> </i> 
                        </div>
                        <div class="col-md-8 box-ct">
                            <h3> Codrops </h3>
                            <p> Lorem ipsum dolor sit ametconsectetur adipiscing elit. Suspendisse orci quam. </p>
                        </div>
                  </div>
              </div>
              <div class="col-sm-6 block wow bounceIn">
                    <div class="row">
                      <div class="col-md-4 box-icon rotate"> 
                        <i class="fa fa-heart fa-4x "> </i> 
                      </div>
                      <div class="col-md-8 box-ct">
                        <h3> Lorem Ipsum</h3>
                        <p> Nullam mo  arcu ac molestie scelerisqu vulputate, molestie ligula gravida, tempus ipsum.</p> 
                      </div>
                    </div>
              </div>
          </div>
        </div>
    </div>
    
    <!-- Banner Download -->
    <!-- <div id="downloadlink" class="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center wrap_title">
                <h2>Download Free</h2>
                <p class="lead" style="margin-top:0">Pay with a Tweet</p>
                <p><a class="btn btn-embossed btn-primary view" role="button">Free Download</a></p> 
             </div>
            </div>
        </div>
    </div> -->
    
    <!-- Contact -->
    <!-- <div id="contact" class="content-section-a">
        <div class="container">
            <div class="row">
            
            <div class="col-md-6 col-md-offset-3 text-center wrap_title">
                <h2>Contact Us</h2>
                <p class="lead" style="margin-top:0">A special thanks to Death.</p>
            </div>
            
            <form role="form" action="" method="post" >
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="InputName">Your Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Enter Name" required>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="InputEmail">Your Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter Email" required  >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="InputMessage">Message</label>
                        <div class="input-group">
                            <textarea name="InputMessage" id="InputMessage" class="form-control" rows="5" required></textarea>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span>
                        </div>
                    </div>

                    <input type="submit" name="submit" id="submit" value="Submit" class="btn wow tada btn-embossed btn-primary pull-right">
                </div>
            </form>
            
            <hr class="featurette-divider hidden-lg">
                <div class="col-md-5 col-md-push-1 address">
                    <address>
                    <h3>Office Location</h3>
                    <p class="lead"><a href="https://www.google.com/maps/preview?ie=UTF-8&q=The+Pentagon&fb=1&gl=us&hq=1400+Defense+Pentagon+Washington,+DC+20301-1400&cid=12647181945379443503&ei=qmYfU4H8LoL2oATa0IHIBg&ved=0CKwBEPwSMAo&safe=on">The Pentagon<br>
                    Washington, DC 20301</a><br>
                    Phone: XXX-XXX-XXXX<br>
                    Fax: XXX-XXX-YYYY</p>
                    </address>

                    <h3>Social</h3>
                    <li class="social"> 
                    <a href="#"><i class="fa fa-facebook-square fa-size"> </i></a>
                    <a href="#"><i class="fa  fa-twitter-square fa-size"> </i> </a> 
                    <a href="#"><i class="fa fa-google-plus-square fa-size"> </i></a>
                    <a href="#"><i class="fa fa-flickr fa-size"> </i> </a>
                    </li>
                </div>
            </div>
        </div>
    </div> -->
    
    
    
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <h3 class="footer-title">Follow Me!</h3>
            <p>Vuoi ricevere news su altri template?<br/>
              Visita Andrea Galanti.it e vedrai tutte le news riguardanti nuovi Theme!<br/>
              Go to: <a  href="http://andreagalanti.it" target="_blank">andreagalanti.it</a>
            </p>
            
            <!-- LICENSE -->
            <a rel="cc:attributionURL" href="http://www.andreagalanti.it/flatfy"
           property="dc:title">Flatfy Theme </a> by
           <a rel="dc:creator" href="http://www.andreagalanti.it"
           property="cc:attributionName">Andrea Galanti</a>
           is licensed to the public under 
           <BR>the <a rel="license"
           href="http://creativecommons.org/licenses/by-nc/3.0/it/deed.it">Creative
           Commons Attribution 3.0 License - NOT COMMERCIAL</a>.
           
       
          </div> <!-- /col-xs-7 -->

          <div class="col-md-5">
            <div class="footer-banner">
              <h3 class="footer-title">Flatfy Theme</h3>
              <ul>
                <li>12 Column Grid Bootstrap</li>
                <li>Form Contact</li>
                <li>Drag Gallery</li>
                <li>Full Responsive</li>
                <li>Lorem Ipsum</li>
              </ul>
              Go to: <a href="http://andreagalanti.it/flatfy" target="_blank">andreagalanti.it/flatfy</a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- JavaScript -->
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="../js/script.js"></script>
    <!-- StikyMenu -->
    <script src="../js/stickUp.min.js"></script>
    <script type="text/javascript">
      jQuery(function($) {
        $(document).ready( function() {
          $('.navbar-default').stickUp();
          
        });
      });
    
    </script>
    <!-- Smoothscroll -->
    <script type="text/javascript" src="../js/jquery.corner.js"></script> 
    <script src="../js/wow.min.js"></script>
    <script>
     new WOW().init();
    </script>
    <script src="../js/classie.js"></script>
    <script src="../js/uiMorphingButton_inflow.js"></script>
    <!-- Magnific Popup core JS file -->
    <script src="../js/jquery.magnific-popup.js"></script> 
</body>

</html>
