<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COMMUSHOLA</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/animate.css" rel="stylesheet" />
    <!-- Squad theme CSS -->
    <link href="css/style.css" rel="stylesheet">
	<link href="color/default.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
	<!-- Preloader -->
	<div id="preloader">
	  <div id="load"></div>
	</div>

    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.html">
                    <h1><img src="img/a.png" height="25"/><span>COMMUSHOLA</span></h1>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#intro">TENTANG KAMI</a></li>
        <li><a href="#about">PETA</a></li>
		<li><a href="#service">MUSHOLA DAN TOILET</a></li>
		<li><a href="#jadwal">JADWAL DAN RUTE</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">HUBUNGI <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#forum">FORUM</a></li>
            <li><a href="#contact">KONTAK</a></li>
          </ul>
        </li>
      </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<!-- Section: intro -->
    <section id="intro" class="intro">
	
		<div class="slogan">
			<h1>COMMUSHOLA</h1>
			<h4>SEBUAH WEB YANG MEMBERIKAN PETUNJUK KEBERADAAAN TOILET DAN MUSHOLA DI JALUR MAJA - TANAH ABANG</h4>
		</div>
		<div class="page-scroll">
			<a href="#service" class="btn btn-circle">
				<i class="fa fa-angle-double-down animated"></i>
			</a>
		</div>
    </section>
	<!-- /Section: intro -->

	<!-- Section: about -->
    <section id="about" class="home-section text-center">
		<div class="heading-about">
			<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow bounceInDown" data-wow-delay="0.4s">
					<div class="section-heading">
					<h2>PETA</h2>
					<i class="fa fa-2x fa-angle-down"></i>

					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container">

		<div class="map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3965.7434292111593!2d106.71052901422054!3d-6.297408395406999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1449394858083" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
		</div>
	</section>
	<!-- /Section: about -->
	

	<!-- Section: services -->
    <section id="service" class="home-section text-center bg-gray">
		
		<div class="heading-about">
			<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow bounceInDown" data-wow-delay="0.4s">
					<div class="section-heading">
					<h2>MUSHOLA DAN TOILET</h2>
					<i class="fa fa-2x fa-angle-down"></i>

					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container">
		<div class="row">
			<div class="col-lg-2 col-lg-offset-5">
				<hr class="marginbot-50">
			</div>
		</div>
		<select id="item1" name="Item 1">
				<option>PILIH STASIUN</option>
		   <option value="1">STASIUN MAJA</option>
		   <option value="2">STASIUN CIKOYA</option>
		   <option value="3">STASIUN TIGARAKSA</option>
		   <option value="4">STASIUN TENJO</option>
		   <option value="5">STASIUN DARU</option>
		   <option value="6">STASIUN CILEJIT</option>
		   <option value="7">STASIUN PARUNG PANJANG</option>
		   <option value="8">STASIUN CICAYUR</option>
		   <option value="9">STASIUN CISAUK</option>
		   <option value="10">STASIUN SERPONG</option>
		   <option value="11">STASIUN RAWA BUNTU</option>
		   <option value="12">STASIUN SUDIMARA</option>
		   <option value="13">STASIUN JURANGMANGU</option>
		   <option value="14">STASIUN PONDOK RANJI</option>
		   <option value="15">STASIUN KEBAYORAN</option>
		   <option value="16">STASIUN PALMERAH</option>
		   <option value="17">STASIUN TANAH ABANG</option>
		</select> 
<button onclick="message()">Go!</button>
<br/>
<div id="container" style="margin-top:20px;">
	<div class="row">
		<div id="show" align="center">
			<img id="gambar" src="img/logo.jpeg" class="img-responsive">
			<div id="keterangan">COMMUTERLINE INDONESIA </div>
		</div>
	</div>
</div>
<SCRIPT language = javascript>

function message() {

var s = document.getElementById('item1');
var thisOne = document.getElementById('show');
var item1 = s.options[s.selectedIndex].value;
var gambar = document.getElementById('gambar');
var text = document.getElementById('keterangan');
if (item1 == 1) {
    gambar.src="img/v.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
}
else if (item1 == 2) {
    gambar.src="img/u.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 3) {
    gambar.src="img/j.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 4) {
    gambar.src="img/t.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 5) {
    gambar.src="img/i.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 6) {
    gambar.src="img/x.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 7) {
    gambar.src="img/panjang.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 8) {
    gambar.src="img/r.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 9) {
    gambar.src="img/cisauk.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 10) {
    gambar.src="img/serpong.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 11) {
    gambar.src="img/rawa.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 12) {
    gambar.src="img/sudimara.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 13) {
    gambar.src="img/jurangmangu.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DILUAR AREA STASIUN YANG MENGHARUSKAN KELUAR DARI GERBANG ELEKTRONIK TERLEBIH DAHULU";
	}
else if (item1 == 14) {
    gambar.src="img/ranji.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 15) {
    gambar.src="img/bayoran.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
else if (item1 == 16) {
    gambar.src="img/palmerah.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
	else if (item1 == 17) {
    gambar.src="img/tanahabang.jpg";
	text.innerHTML="MUSHOLLA TERLETAK DIDALAM AREA STASIUN";
	}
}

</SCRIPT>
		</div>
	</section>
	<!-- /Section: services -->
	
<!-- Section: JADWAL DAN RUTE -->
    <section id="jadwal" class="home-section text-center">
		<div class="heading-contact">
			<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow bounceInDown" data-wow-delay="0.4s">
					<div class="section-heading">
					<h2>JADWAL DAN RUTE</h2>
					<i class="fa fa-2x fa-angle-down"></i>

					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container">

		<div class="row">
			<div class="col-lg-2 col-lg-offset-5">
				<hr class="marginbot-50">
			</div>
		</div>
    <div class="row">
        <div class="col-lg-8">
            <div class="boxed-grey">
                
                <center><strong><font size="5"> JADWAL </font></strong><br />

<div style="overflow:auto; width:95%px; height:400px; padding:10px; border:1px solid #999999;">

<table border="1">
    	<tr>
            <th>Nomor KA</th>
            <th>Keterangan</th>
			<th>Kelas KRL</th>
            <th>Relasi</th>
			<th>Stasiun Keberangkatan</th>
			<th>Stasiun Singgah</th>
			<th>Waktu Datang</th>
			<th>Waktu Berangkat</th>
			<th>LS</th>
		</tr>
<?php
	include "koneksi.php";
	$hasil=mysql_query("SELECT * FROM kereta");
	while($aray = mysql_fetch_array($hasil)){?>
		<tr>
			<td align="center"><?php echo $aray['no_ka']; ?></td>
			<td align="center"><?php echo $aray['ket']; ?></td>
			<td align="center"><?php echo $aray['kelas_krl']; ?></td>
			<td align="center"><?php echo $aray['relasi']; ?></td>
			<td align="center"><?php echo $aray['stasiun_keberangkatan']; ?></td>
            <td align="center"><?php echo $aray['stasiun_persinggahan']; ?></td>
			<td align="center"><?php echo $aray['waktu_datang']; ?></td>
			<td align="center"><?php echo $aray['waktu_berangkat']; ?></td>
			<td align="center"><?php echo $aray['ls']; ?></td>
		</tr>
	<?php }
	mysql_close();
?>
	</table>
	</center>
</div>
        </div>
		
		<div class="col-lg-4">
			<div class="widget-contact">
				<h5>RUTE</h5>
				<img src="img/a.jpg" class="img-responsive"/>			
			
			</div>	
		</div>
    </div>	

		</div>
	</section>
	<!-- /Section: jadwal dan rute -->
	
	
	
	<!-- Section: forum -->
    <section id="forum" class="home-section text-center">
		<div class="heading-contact">
			<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow bounceInDown" data-wow-delay="0.4s">
					<div class="section-heading">
					<h2>FORUM DAN JADWAL SHOLAT</h2>
					<i class="fa fa-2x fa-angle-down"></i>

					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container">

		<div class="row">
			<div class="col-lg-2 col-lg-offset-5">
				<hr class="marginbot-50">
			</div>
		</div>
    <div class="row">
        <div class="col-lg-8">
            <div class="boxed-grey">
                          <center> <H2>JADWAL SHOLAT</H2><br>
						             <img src="img/c.png" class="img-responsive"/> 
						           <!-- <p style="text-align: center;"><iframe src="https://www.jadwalsholat.org/adzan/monthly.php?id=265" width="430" height="940" frameborder="0"></iframe></p>
          --></center>
            </div>
        </div>
		
		<div class="col-lg-4">
			<div class="widget-contact">
				<h5>FORUM TWITTER</h5>
				
				             <a class="twitter-timeline"  href="https://twitter.com/hashtag/InfoLintas" data-widget-id="673670300106559488">#InfoLintas Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          		
			
			</div>	
		</div>
    </div>	

		</div>
	</section>
	<!-- /Section: contact -->

	<!-- Section: contact -->
<section id="contact" class="home-section text-center">
		<div class="heading-about">
			<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="wow bounceInDown" data-wow-delay="0.4s">
					<div class="section-heading">
					<h2>KONTAK</h2>
					<i class="fa fa-2x fa-angle-down"></i>

					</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="container">

		<div class="row">
			<div class="col-lg-2 col-lg-offset-5">
				<hr class="marginbot-50">
			</div>
		</div>
        <div class="row">
            <div class="col-xs-6 col-sm-3 col-md-3">
				<div class="wow bounceInUp" data-wow-delay="0.2s">
                <div class="team boxed-grey">
                    <div class="inner">
						<h5>Fajar Nugraha Wahyu</h5>
                        <p class="subtitle">PROGRAMMER</p>
						<p class="subtitle">088561956658 for complain</p>
						<p class="subtitle">@fajarwahyu99 for information</p>
                        <div class="avatar"><img src="img/team/1.jpg" alt="" class="img-responsive img-circle" /></div>
                    </div>
                </div>
				</div>
            </div>
			<div class="col-xs-6 col-sm-3 col-md-3">
				<div class="wow bounceInUp" data-wow-delay="0.5s">
                <div class="team boxed-grey">
                    <div class="inner">
						<h5>Nurhalimah</h5>
                        <p class="subtitle">SECRETARY </p>
						<p class="subtitle">087867663118 for complain</p>
						<p class="subtitle">@nurhalimah for information</p>
                        <div class="avatar"><img src="img/team/2.jpg" alt="" class="img-responsive img-circle" /></div>

                    </div>
                </div>
				</div>
            </div>
			<div class="col-xs-6 col-sm-3 col-md-3">
				<div class="wow bounceInUp" data-wow-delay="0.8s">
                <div class="team boxed-grey">
                    <div class="inner">
						<h5>Muhtadi</h5>
                        <p class="subtitle">DESIGNER</p>
						<p class="subtitle">082260214741 for complain</p>
						<p class="subtitle">@muh_tadi for information</p>
                        <div class="avatar"><img src="img/team/3.jpg" alt="" class="img-responsive img-circle" /></div>

                    </div>
                </div>
				</div>
            </div>
			<div class="col-xs-6 col-sm-3 col-md-3">
				<div class="wow bounceInUp" data-wow-delay="1s">
                <div class="team boxed-grey">
                    <div class="inner">
						<h5>Amin Rois</h5>
                        <p class="subtitle">PUBLIC RELATIONS</p>
						<p class="subtitle">087856306809 for complain</p>
						<p class="subtitle">@aminroisjoss for information</p>
                        <div class="avatar"><img src="img/team/4.jpg" alt="" class="img-responsive img-circle" /></div>

                    </div>
                </div>
				</div>
            </div>
			<div class="resume text-center">
	<div class="container">
		<div class="strip text-center"><a href="#"><img src="img/down.png" alt=" "/></a></div>
		<br>
		<br>
		<center> COMMUSHOLA TERSEDIA DI ANDROID </center>
		<br>
		<br>
		<div class="down"><a href="#">Download My CV</a></div>
	</div>
</div>
        </div>		
		</div>
	</section>
	<!-- /Section: contact -->

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="wow shake" data-wow-delay="0.4s">
					<div class="page-scroll marginbot-30">
						<a href="#intro" id="totop" class="btn btn-circle">
							<i class="fa fa-angle-double-up animated"></i>
						</a>
					</div>
					</div>
					<p>&copy;Copyright 2015 - Fajar NUGRAHA WAHYU. All rights reserved. Designed by <a href="http://fajarnugrahawahyu.16mb.com">Fajar Nugraha Wahyu</a></p>
                    <!-- 
                        All links in the footer should remain intact. 
                        Licenseing information is available at: http://bootstraptaste.com/license/
                        You can buy this theme without footer links online at: http://bootstraptaste.com/buy/?theme=Squadfree
                    -->
				</div>
			</div>	
		</div>
	</footer>

    <!-- Core JavaScript Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>	
	<script src="js/jquery.scrollTo.js"></script>
	<script src="js/wow.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.js"></script>

</body>

</html>
