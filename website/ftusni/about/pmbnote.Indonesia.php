<?php



?>
<p>Test Script Text: Program Pendaftaran Mahasiswa ini dilakukan secara online.
Walau pun demikian, Anda tetap diharuskan untuk melakukan pembayaran untuk dapat
mengikuti ujian masuk.
</p>

<center>
<form action='index.php' method=GET>
  <input type=hidden name='syxec' value='pmb'>
  <input type=submit name='agree' value='<?php echo $strAgree; ?>'>
  <input type=submit name='agree' value='<?php echo $strDisagree; ?>'>
</form>

</center>