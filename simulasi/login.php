<?php 
    session_start();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pilkada Kota Tangerang Selatan</title>

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
</head>

<body>
<div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>LOGIN</h1>
                        <h3></h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                          <form method="post" action="loginprocces.php">
                  <div class="form-control-static"><label>Username </label><input class="inputfield" name="username" type="text" id="username"/></div>
                    <div class="form-control-static"><label>Password </label><input class="inputfield" name="password" type="password" id="password"/></div>
                          <input class="button" type="submit" name="Submit" value="Login" />
                          </form>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
</body>
</html>