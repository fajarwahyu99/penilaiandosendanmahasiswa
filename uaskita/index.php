<?php
include "konten/koneksi.php";
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>UAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="web/default.css" rel="stylesheet" type="text/css" title="default"/>
</head>
<body>
<div id="WholePage">
  <div id="Inner">
    <div id="Container">
      <div id="Head">
        <div id="Head_left">
          <div id="Leaf_top"></div>
          
          <div id="Leaf_bottom"> <br>
			<?php if(@$_SESSION['status']){ ?>
          <form method="post" action="index.php?module=cari">
           </label><input class="inputfield" name="username" type="text" id="username" placeholder="cari username" />
            <input class="button" type="submit" name="Search" value="Search" />
            </form> 
            <?php }?>
            </div>
          
        </div>
        <div id="Head_right">
          <div id="Logo">
            <div id="Name"><span class="blue">S</span><span>istem</span>&nbsp;<span class="blue">A</span><span>kademik</span> </div>
            
            <div id="Informations"></div>
          </div>
          
          <div id="Top_menu">
          <a class="home" href="index.php?module=home"><span>HOME</span></a>
          <?php 
			if(isset($_SESSION['username'])){if($_SESSION['status']=="Admin"){
			?>
			<a class="contact" href="index.php?module=daftardosen" <?php if(isset($_GET['module'])) if($_GET['module']=="daftardosen") echo "class='selected'";?>>DOSEN</a>
			<a class="contact" href="index.php?module=daftarmhs" <?php if (isset($_GET['module'])) if($_GET['module']=="daftarmhs") echo "class='selected'";?>>MAHASISWA</a>
            <a class="contact" href="index.php?module=daftarmatkul"<?php if(isset($_GET['module'])) if($_GET['module']=="lihatmatkul") echo "class='selected'";?>>PERKULIAHAN</a>
                        <a href="konten/logout.php">LOGOUT</a>
            
		<?php
			} else if($_SESSION['status']=="Dosen"){
			?>
			<a class="contact" href="index.php?module=inputnilai" <?php if (isset($_GET['module'])) if($_GET['module']=="inputnilai") echo "class='selected'";?>>PENILAIAN</a>
            <a class="contact" href="konten/logout.php">LOGOUT</a>
            
           <?php
			} else if($_SESSION['status']=="Mahasiswa"){
			?>
            <a class="contact" href="index.php?module=lihatnilai" <?php if(isset($_GET['module'])) if($_GET['module']=="lihatnilai") echo "class='selected'";?>>LIHAT NILAI</a>
                       <a class="contact" href="konten/logout.php">LOGOUT</a>
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
          </div>
        </div>
      </div>
      <div id="CentralPart">
        <div id="LeftPart">
          <div id="Menu">
          
          <?php
			if (!isset($_SESSION['username'])) {
				?>
			
            <div id="Menu_header">
              <div class="menu_header_left"> <span class="menu_text">LOGIN</span> </div>
              <div class="menu_header_right"> </div>
            </div>
            
            <div id="Menu_content">
            <?php if(!@$_SESSION['id']){ ?>
            <form method="post" action="konten/login.php">		
            <label>Username</label> <br />
            <input class="inputfield" name="username" type="text" id="username"/><br />
            <label>Password</label> <br />
            <input class="inputfield" name="password" type="password" id="password"/><br />
            <input class="button" type="submit" name="Submit" value="Login" />
              </form> 
              <?php }?>
              
            <?php if(@$_GET['cari']){ ?>
            
            <?php 
			
		echo "asdalskdjlasdjlaksjd"; ?>	
            <?php } ?>
            </div>
            
            <?php } ?>
            
          </div>
          <div id="Poll">
            <div id="Poll_header">
            </div>
            <div id="Poll_content">
            </div>
          </div>
          <div id="Banner"></div>
        </div>
        <div id="RightPart">
        	<?php
				if(!isset($_GET['module'])) {
				include "konten/home.php";
				} else {
				include "konten/$_GET[module].php";
				}
			?>
        <div class="cleaner"></div>
      </div>
      <div id="Bottom">
      	<marquee> FAJAR NUGRAHA WAHYU DAN NURHALIMAH 2015 </marquee>
      </div>
    </div>
  </div>
</div>
</body>
</html>
