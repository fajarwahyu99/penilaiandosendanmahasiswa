<?php 

if( !session_id() )
{
    session_start();
}

if(@$_SESSION['logged_in'] == true){
    header("Location: home.php");
}
?>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="./main.js"></script>
<script type="text/javascript" src="./llqrcode.js"></script>
<center><img src="images/abc.jpg" alt="Image" width="248" /><br>
</center>

<div style="display:none" id="result"></div>
	<div class="selector" id="webcamimg" onclick="setwebcam()" align="left" ></div>
		<div class="selector" id="qrimg" onclick="setimg()" align="right" ></div>
			<center id="mainbody"><div id="outdiv"></div></center>
				<canvas id="qr-canvas" width="800" height="600"></canvas>
<center>UNTUK KEAMANAN WEB SILAHKAN LOGIN DENGAN QRCODE YANG SUDAH DIBERIKAN</center>
<center>TERIMA KASIH</center>
<script type="text/javascript">load();</script>
<script src="./jquery-1.11.2.min.js"></script>