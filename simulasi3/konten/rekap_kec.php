<a name="rekap"></a>
<div class="content-section-b">

      <div class="container">

            <div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Rekapitulasi Data KECAMATAN</h2>
                </div>
                     <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Wilayah</th>
                                            <th>Total DPT</th>
                                            <th>Pengguna Hak Pilih</th>
                                            <th>Perolehan Suara Kandidat 1</th>
                                            <th>Perolehan Suara Kandidat 2</th>
                                            <th>Perolehan Suara Kandidat 3</th>
                                            <th>Suara Sah</th>
                                            <th>Suara Tidak Sah</th>
                                            <th>Total Suara</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    
               <?php 
			   include"koneksi.php";
					$query="select * from wilayah";
					$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
			   ?>

                                    
                                    <tbody>
                                    <?php
									while($buff=mysql_fetch_array($hasil)){
									?>
                                    <tr class="odd gradeX">
                                    <td><?php echo $buff['id_wilayah'];?></td>
                                    <td><?php echo $buff['kecamatan'];?></td>
                                    <td><?php echo $buff['jml_DPT'];?></td>
                                    <td class="center"><?php echo $buff['hakpilih'];?></td>
                                    <td class="center"><?php echo $buff['s1'];?></td>
                                    <td><?php echo $buff['s2'];?></td>
                                    <td><?php echo $buff['s3'];?></td>
                                    <td><?php echo $buff['suara_sah'];?></td>
                                    <td><?php echo $buff['suara_tdksah'];?></td>
                                    <td><?php echo $buff['total_suara'];?></td>
                                    <td><a class="btn btn-primary btn-outline"href="edit.php?id=<?php echo $buff['id_wilayah'];?>">Edit</a></td>
                                    <td><a class="btn btn-danger btn-outline"href="hapus_rekap.php?id=<?php echo $buff['id_wilayah'];?>">Hapus</a></td>
                                    </tr>   
						            </tbody>
								   <?php
};
mysql_close();
?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-section-b -->

    