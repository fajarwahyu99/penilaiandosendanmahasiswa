<!DOCTYPE html>
<center><html>
<head>
	<title>QUICK COUNT PEMILIHAN KETUA OSIS PERIODE 2016/2017</title>
</head>
<body bgcolor="#fff666">

	<h2>QUICK COUNT SEMENTARA UNTUK PEMILIHAN KETUA OSIS PERIODE 2016/2017</h2>

	<p><a href="guru/guru.php">PILIH KETUA OSIS(UNTUK GURU)</a> / <a href="siswa/siswa.php">PILIH KETUA OSIS (UNTUK SISWA)</a>
<table cellpadding="5" cellspacing="0" border="1">
		<tr bgcolor="#CCCCCC">
			<th>No.Urut</th>
<th>Nis</th>
			<th>Nama Lengkap</th>
			<th>Kelas</th>
			<th>Total Suara</th>
			
		</tr>
		
		<?php
		//iclude file koneksi ke database
		include('koneksi.php');
		
		//query ke database dg SELECT table siswa diurutkan berdasarkan NIS paling besar
		$query = mysql_query("SELECT * FROM siswa ORDER BY siswa_nis DESC") or die(mysql_error());
		
		//cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
		if(mysql_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong
			
			//jika data kosong, maka akan menampilkan row kosong
			echo '<tr><td colspan="6">Tidak ada data!</td></tr>';
			
		}else{	//else ini artinya jika data hasil query ada (data diu database tidak kosong)
			
			//jika data tidak kosong, maka akan melakukan perulangan while
			$no = 1;	//membuat variabel $no untuk membuat nomor urut
			while($data = mysql_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database
				
				//menampilkan row dengan data di database
				echo '<tr>';
					echo '<td>'.$no.'</td>';	//menampilkan nomor urut
					echo '<td>'.$data['siswa_nis'].'</td>';	//menampilkan data nis dari database
					echo '<td>'.$data['siswa_nama'].'</td>';	//menampilkan data nama lengkap dari database
					echo '<td>'.$data['siswa_kelas'].'</td>';	//menampilkan data kelas dari database
					echo '<td>'.$data['TOT_SU'].'</td>';	//menampilkan data jurusan dari database
					
				echo '</tr>';
				
				$no++;	//menambah jumlah nomor urut setiap row
				
			}
			
		}
		?>
	</table>
</body>
</html></center>