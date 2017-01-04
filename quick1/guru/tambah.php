<?php
	session_start();
	include('koneksi.php');
$_SESSION['login_id'];
	$status		= $_POST['status'];
	$id		= $_POST['id'];
	$sql = mysql_query("SELECT * FROM siswa WHERE no_urut='$id'");
	$cek = mysql_fetch_array($sql);
	$cek['no_urut'];
	if ($status == 'guru')
	{
		if (isset($cek) == 0)
		{
				mysql_query("UPDATE siswa SET tot_su='10' WHERE no_urut=$id");
mysql_query("UPDATE `discussion_topics` SET stat_us='tidak' where charac='".$_SESSION['charac']."'");
				session_destroy();
echo 'Suara Anda berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
 	 		 	echo '<a href="login.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
		}
		else
		{
			 mysql_query("UPDATE siswa SET tot_su=tot_su+10 WHERE no_urut='$id'");
mysql_query("UPDATE `discussion_topics` SET stat_us='tidak' where charac='".$_SESSION['charac']."'");
			session_destroy();
 echo 'Suara Anda berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
	 		 echo '<a href="login.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
		}
	}
	elseif ($status == 'siswa')
	{
		if (isset($cek) == 0)
		{
				mysql_query("UPDATE siswa SET tot_su = '1' WHERE no_urut=$id");
				echo 'Data berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
 	 		 	echo '<a href="index.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
		}
		else
		{
			 mysql_query("UPDATE siswa SET tot_su=tot_su+1 WHERE no_urut='$id'");
			 echo 'Data berhasil di tambahkan! ';		//Pesan jika proses tambah sukses
	 		 echo '<a href="index.php">Kembali</a>';	//membuat Link untuk kembali ke halaman tambah
		}
	}
	unset($_SESSION['id']);
?>
