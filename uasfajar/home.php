<?php
include "konten/koneksi.php";
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>UAS SISTEM AKADEMIS</title>
  <meta name="robots" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="author" content="RapidxHTML" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <!--[if lte IE 7]><link href="css/iehacks.css" rel="stylesheet" type="text/css" /><![endif]-->
  <script type="text/javascript" src="js/jquery.js"></script>
  <!--[if IE 6]>
  <script type="text/javascript" src="js/ie6pngfix.js"></script>
  <script type="text/javascript">
    DD_belatedPNG.fix('img, ul, ol, li, div, p, a, h1, h2, h3, h4, h5, h6');
  </script>
  <![endif]-->
  <style type="text/css">
  .login{
  cursor:pointer;
  background-color: #B6FD0F;
  width: 50px;
  }


.reset{
  cursor:pointer;
  background:url(reset.png) no-repeat center;
  width: 50px;
  }
  </style>
</head>

<body>

<!-- wrapper -->
<div class="rapidxwpr floatholder">

  <!-- header -->
  <div id="header">
  
    <!-- logo --><div id="logo">
    <?php if(@$_SESSION['status']){ ?>
          <form method="post" action="home.php?module=cari">
           </label><input class="inputfield" name="id_user" type="text" id="id_user" placeholder="MASUKAN ID PENGGUNA" />
            <input class="button" type="submit" name="Search" value="Search" />
            </form> 
            <?php }?></div>
    <!-- / logo -->
    
    <!-- topmenu -->
    <div id="topmenu">
	<ul>
      <li><a href="home.php?module=awal"><span>HOME</span></a>
          <?php 
			if(isset($_SESSION['username'])){if($_SESSION['status']=="Admin"){
			?>
			<li><a href="home.php?module=daftardosen" <?php if(isset($_GET['module'])) if($_GET['module']=="daftardosen") echo "class='selected'";?>><span>DOSEN</span></a></li>
			<li><a href="home.php?module=daftarmhs" <?php if (isset($_GET['module'])) if($_GET['module']=="daftarmhs") echo "class='selected'";?>><span>MAHASISWA</span></a></li>
            <li><a href="home.php?module=daftarmatkul"<?php if(isset($_GET['module'])) if($_GET['module']=="lihatmatkul") echo "class='selected'";?>><span>PERKULIAHAN</span></a></li>
                        <li><a href="konten/logout.php"><span>LOGOUT</span></a></li>
            
		<?php
			} else if($_SESSION['status']=="Dosen"){
			?>
			<li><a href="home.php?module=inputnilai" <?php if (isset($_GET['module'])) if($_GET['module']=="inputnilai") echo "class='selected'";?>><span>PENILAIAN</span></a></li>
            <li><a href="konten/logout.php"><span>LOGOUT</span></a></li>
            
           <?php
			} else if($_SESSION['status']=="Mahasiswa"){
			?>
            <li><a href="home.php?module=lihatnilai" <?php if(isset($_GET['module'])) if($_GET['module']=="lihatnilai") echo "class='selected'";?>><span>LIHAT NILAI</span></a></li>
            <li><a class="contact" href="konten/logout.php"><span>LOGOUT</span></a></li>
			<?php
			}
			?>
		<?php
			}
			?>
			<?php if(!isset($_SESSION['username'])){?>
			
			<?php
			}
			?>
</ul>			
    </div>
    <!-- / topmenu -->
  
  </div>
  <!-- / header -->
  
  <!-- main body -->
  <div id="middle">
  
    <!-- main image -->
    <div class="main-image">
      <img src="images/bac.gif" alt="Image" width="850" />
    </div>
    <!-- / main image -->
    
    <div id="main" class="clearingfix">
      <div id="mainmiddle" class="floatbox">
      
        <!-- right column -->
        <div id="right" class="clearingfix">
        
          <!-- benefits box -->
          <div class="benefits">
            <div class="benefits-bg clearingfix">
            <h3>LOGIN</h3>
			<?php if(!@$_SESSION['id']){ ?>
			<ul>
            <form method="post" action="konten/login.php">		
            <li><label>Username</label> <br />
            <input class="inputfield" name="username" type="text" id="username"/></li>
            <li><label>Password</label> <br />
            <input class="inputfield" name="password" type="password" id="password"/></li>
            <li><input class="login" type="submit" name="Submit" value="Login" /></li>
              </form> 
              <?php }?>
              
            <?php if(@$_GET['cari']){ ?>
            
            <?php 
			
		echo "asdalskdjlasdjlaksjd"; ?>	
            <?php } ?>
			</ul>
            </div>
            
            
            
          </div>
          <!-- / benefits box -->
        <!-- benefits box -->
          <div class="benefits">
            <div class="benefits-bg clearingfix">
            <img src="images/abc.jpg" alt="Image" width="248" />
			<marquee> UIN SYARIFHIDAYATULLAH JAKARTA </marquee>
            </div>
            
            
            
          </div>
        </div>
        <!-- / right column -->
        
        <!-- content column -->
        <div id="content" class="clearingfix">
          <div class="floatbox">
          
            <!-- welcome -->
            <div class="box">
             <?php
				if(!isset($_GET['module'])) {
				include "konten/awal.php";
				} else {
				include "konten/$_GET[module].php";
				}
			?>
			</div>
            <!-- / welcome -->
            
            <!-- features -->
            <div class="box">
              <div class="box-bg">
                <ul class="features clearingfix">
                  <li>
                    <img src="images/icon01.png" alt="Image" class="features-icon" />
                    <div class="details">
                      <h4>Knowledge</h4>
                    DENGAN PENGETAHUAN YANG LUAS AKAN MENGUASAI DUNIA </div>
                  </li>
                  <li>
                    <img src="images/icon02.png" alt="Image" class="features-icon"  />
                    <div class="details">
                      <h4> Piety</h4>
                      DENGAN KESALEHAN KITA BISA MENGUBAH DUNIA
                    </div>
                  </li>
                  <li>
                    <img src="images/icon03.png" alt="Image" class="features-icon"  />
                    <div class="details">
                      <h4>Integrity</h4>
                      DENGAN INTEGRITAS KITA MAJUKAN INDONESIA BERSAMA
                    </div>
                  </li>
                  <li>
                    <img src="images/icon04.png" alt="Image" class="features-icon"  />
                    <div class="details">
                      <h4>Discipline</h4>
                      DENGAN KEDISIPLINAN KITA BISA MENGATUR DUNIA
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <!-- / features -->
          
          </div>
        </div>
        <!-- / content column -->
      
      </div>
    </div>
  
  </div>
  <!-- / main body -->

</div>
<!-- / wrapper -->

<!-- footer -->
<div class="rapidxwpr floatholder">
  <div id="footer" class="clearingfix">
  
    <!-- footermenu -->
    <ul class="footermenu">
      <li><a href="">SEMANGAT</a></li>
      <li><a href="">TERUS</a></li>
      <li><a href="">MENGGAPAI</a></li>
      <li><a href="">CITA - CITA</a></li>
      <li><a href="logout.php">KELUAR WEB</a></li>
    </ul>
    <!-- / footermenu -->
    
    <!-- credits -->
    <div class="credits">
      <a href="http://fajarnugraha06061996.blogspot.com">FAJAR NUGRAHA WAHYU - NURHALIMAH 2015</a>
    </div>
    <!-- / credits -->
  
  </div>
</div>				
<!-- / footer -->

</body>
</html>