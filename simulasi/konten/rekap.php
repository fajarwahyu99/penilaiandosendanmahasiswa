<a name="rekap"></a>
<div class="content-section-b">

      <div class="container">

            <div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Rekapitulasi Data Kelurahan</h2>
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
					$query="select * from wilayah_kel";
					$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
			   ?>

                                    
                                    <tbody>
                                    <?php
									while($buff=mysql_fetch_array($hasil)){
									?>
                                    <tr class="odd gradeX">
                                    <td><?php echo $buff['id_wilayahkel'];?></td>
                                    <td><?php echo $buff['kelurahan'];?></td>
                                    <td><?php echo $buff['jml_DPTkel'];?></td>
                                    <td class="center"><?php echo $buff['hakpilih_kel'];?></td>
                                    <td class="center"><?php echo $buff['s1_kel'];?></td>
                                    <td><?php echo $buff['s2_kel'];?></td>
                                    <td><?php echo $buff['s3_kel'];?></td>
                                    <td><?php echo $buff['suara_sahkel'];?></td>
                                    <td><?php echo $buff['suara_tdksahkel'];?></td>
                                    <td><?php echo $buff['total_suarakel'];?></td>
                                    <td><a class="btn btn-primary btn-outline"href="indexrelawan.php?module=edit&id=<?php echo $buff['id_wilayahkel'];?>">Edit</a></td>
                    <!--                <td><a class="btn btn-danger btn-outline"href="hapus_rekap.php?id=<?php echo $buff['id_wilayahkel'];?>">Hapus</a></td> -->
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

    