<?php 
    session_start();
 ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<title>UIN JAKARTA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="web/default.css" rel="stylesheet" type="text/css" title="default"/>
        
    </head>
    <body>
    
        
    <div id="WholePage">    
    <div id="Inner">
	<div id="Container">
    <div id="Head">
       	<div id="Head_left">
		<div id="Leaf_top"></div>
            <div id="Leaf_bottom"><a class="registration" href="index.php?module=register">REGISTRASI</a></div>
            </div>
            <div id="Head_right">
            <div id="Logo">
            <div id="Name"><span class="blue">S</span><span>istem</span>&nbsp;<span class="blue">a</span><span>kademik</span> </div>
            <div id="Informations"></div>
            </div>
            
    	
   
<div id="Top_menu">
     	<a class="home" href="index.php?module=home"><span>HOME</span></a>
			<?php 
            
			if(isset($_SESSION['username'])){if($_SESSION['status']=="Admin"){
			?>
			<a class="contact" href="index.php?module=daftardosen" <?php if(isset($_GET['module'])) if($_GET['module']=="daftardosen") echo "class='selected'";?>>DOSEN</a>
			<a class="contact" href="index.php?module=daftarmhs" <?php if(isset($_GET['module'])) if($_GET['module']=="daftarmhs") echo "class='selected'";?>>MAHASISWA</a>
			<a class="contact" href="index.php?module=tambahmatkul" <?php if (isset($_GET['module'])) if($_GET['module']=="lihatmatkul") echo "class='selected'";?>>MATA KULIAH</a>
            <a class="contact" href="konten/logout.php">LOGOUT</a>


			<?php
			} else if($_SESSION['status']=="Dosen"){
			?>
			<a class="contact" href="index.php?module=inputnilai" <?php if (isset($_GET['module'])) if($_GET['module']=="inputnilai") echo "class='selected'";?>>PENILAIAN</a>
            <a class="contact" href="konten/logout.php">LOGOUT</a>
                


			<?php
			}else if($_SESSION['status']=="Mahasiswa"){
			?>
			<a class="contact" href="index.php?module=lihatnilai" <?php if (isset($_GET['module'])) if($_GET['module']=="lihatnilai") echo "class='selected'";?>>LIHAT NILAI</a>
            <a class="contact" href="index.php?module=ipk" <?php if (isset($_GET['module'])) if($_GET['module']=="ipk") echo "class='selected'";?>>LIHAT ipk</a>
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
    
    <div id="CentralPart">
        <div id="LeftPart">
            <div id="Menu">
            <?php if(!isset($_SESSION['username'])) {
                ?>

                <div id="Menu_header">
                    <div class="menu_header_left"> <span class="menu_text">LOGIN</span> </div>
                    <div class="menu_header_right"> </div>
                </div>

                <div id="Menu_content">
                    <form method="post" action="konten/login.php">
                        <label>USERNAME</label><br />
                        <input class="inputfield" name="username" type="text" id="username"/><br />
                        <label>PASSWORD</label>
                        <input class="inputfield" name="password" type="password" id="password"/><br />
                        <input class="button" type="submit" name="Submit" value="Login"/>
                    </form>
                </div>
<?php
            }
            ?>

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
FAJAR NUGRAHA WAHYU DAN NURHALIMAH 2015
</div>
</div>
</div>
</div>
</body>
</html>

