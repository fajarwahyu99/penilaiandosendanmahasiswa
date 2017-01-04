<?php 
    session_start();
 ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    	<title>UIN JAKARTA</title>
        <link href="music_548/templatemo_style.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
    <div id="templatemo_container">
        
        <div id="templatemo_header">
        	<div id="templatemo_title">
            	<div id="templatemo_sitetitle">SISTEM <span>AKADEMIK</span></div>
          	</div>
            
        <div id="templatemo_login">
        	<form method="post" action="konten/cari.php">
            <label>Search:</label><input class="inputfield" name="username" type="text" id="username" placeholder="masukan username" />
            <input class="button" type="submit" name="Search" value="Search" />
            </form>
       	</div>
    </div>
    
    <div id="templatemo_banner">
       	<div id="templatemo_banner_text">
            <div id="banner_title">Selamat Datang Di Sistem Akademik</div>
            <p>
            Sistem akademik merupakan sistem penilaian mahasiswa oleh dosen.
            </p>
    	</div>
	</div>
    
    <div id="templatemo_menu">
     	<ul>
			<li><a href="index.php" class="current">MAIN PAGE</a></li>
            <?php
			if(!isset($_SESSION['username'])){
			?>
			<li><a href="index.php?module=register">REGISTRASI</a></li>
        
			<?php 
            }
			if(isset($_SESSION['username'])){if($_SESSION['status']=="Admin"){
			?>
			<li><a href="index.php?module=daftardosen" <?php if(isset($_GET['module'])) if($_GET['module']=="daftardosen") echo "class='selected'";?>>DOSEN</a></li>
			<li><a href="index.php?module=matkul" <?php if (isset($_GET['module'])) if($_GET['module']=="matkul") echo "class='selected'";?>>MATA KULIAH</a></li>
            <li><a href="index.php?module=lihatmatkul"<?php if(isset($_GET['module'])) if($_GET['module']=="lihatmatkul") echo "class='selected'";?>>DAFTAR MATA KULIAH</a></li>
			<?php
			} else if($_SESSION['status']=="Dosen"){
			?>
			<li><a href="index.php?module=inputnilai" <?php if (isset($_GET['module'])) if($_GET['module']=="inputnilai") echo "class='selected'";?>>PENILAIAN</a></li>
            <li><a href="index.php?module=lihatnilai" <?php if(isset($_GET['module'])) if($_GET['module']=="lihatnilai") echo "class='selected'";?>>DAFTAR NILAI</a></li>
			<?php
			}
			?>
			<li><a href="konten/logout.php">LOGOUT</a><li>	          
        </ul> 
        <?php
			}
			?>
			<?php if(!isset($_SESSION['username'])){?>
			
			<?php
			}
			?>   
    </div>
    
    <div id="templatemo_content">
    	<div id="templatemo_left_column">
        <?php
		if (!isset($_SESSION['username'])){
		?>
        <h2>Login</h2>
            <div class="left_col_box">
                <form method="post" action="konten/login.php">
                  <div class="form_row"><label>Username</label><input class="inputfield" name="username" type="text" id="username"/></div>
                    <div class="form_row"><label>Password</label><input class="inputfield" name="password" type="password" id="password"/></div>
                    <input class="button" type="submit" name="Submit" value="Login" />
                </form>
			</div>
        <?php
		}
		?>
        
        <ul>
			</div>
            
     	
            
			<div id="templatemo_right_column">
			<?php
				if(!isset($_GET['module'])) {
				include "konten/home.php";
				} else {
				include "konten/$_GET[module].php";
				}
			?>
            </div>
            </div>
            <div id="clear"></div>
            <div id="templatemo_footer">
                <p>&copy; FAJAR NUGRAHA WAHYU 2015</p>
            </div>
        </div>
    </body>
</html>