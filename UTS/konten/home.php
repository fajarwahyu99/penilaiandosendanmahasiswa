<h1>Sistem Akademik</h1>
<?php if(isset($_SESSION['username'])) {
		echo $_SESSION['username'];?> anda login sebagai <?php if(isset($_SESSION['status'])) echo $_SESSION['status'];
		}
?>
<p>
Selamat datang <?php if(isset($_SESSION['username'])) {
		echo $_SESSION['username'];
        }?>
<p>Bagi dosen yang belum pernah melakukan registrasi, silakan klik halaman registrasi. Dosen wajib mengisi username dan password untuk mendapat account. Setelah itu dosen menunggu konfirmasi dari admin. Setelah account tersebut diaktifkan, maka dosen dapat melakukan penilaian terhadap mahasiswa.</p>
</p>