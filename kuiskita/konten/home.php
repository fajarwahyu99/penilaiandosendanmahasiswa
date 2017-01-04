<h1>Sistem Akademik</h1>

<?php if(isset($_SESSION['username'])) {
    echo $_SESSION['username'];?> Anda login sebagai <?php if(isset($_SESSION['status'])) echo $_SESSION['status'];
    }
?>
<p>
Selamat datang  <?php if(isset($_SESSION['username'])) {
    echo $_SESSION['username'];
        }?>
<p> Bagi dosen yang belum registrasi. Harap Registrasikan data dirinya dihalaman registrasi. Kemudian tunggu konfirmasi dari Admin, barulah dapat melakukan login.</p>
</p>
<br>
<br>
<br>