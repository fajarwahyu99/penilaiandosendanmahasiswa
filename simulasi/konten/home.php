 <?php 
	include"koneksi.php";
	$query="select * from hasil_hitung";
	$hasil=mysql_query($query) or die("Gagal Melakukan Query.");
	while($buff=mysql_fetch_array($hasil)){
			
			   ?>
<div class="content-section-a">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-5 col-sm-6">
            	<hr class="section-heading-spacer">
                   <div class="clearfix"></div>
                   <h2 class="section-heading">Hasil Hitung TPS Kota Tangerang Selatan</h2>
                   <p class="lead">Keterangan : 
                   <br>1. Dr. Ikhsan Modjo dan Li Claudia Chandra<br>Perolehan Suara :
				   <?php echo $buff['t_s1'];?> 
                   <br>2. Drs. H. Arsid, M.Si dan dr. Elvier Ariadiannie Soedarto Poetri, MARS<br>Perolehan Suara : <?php
                   echo $buff['t_s2'];?>
                   <br>3. Hj. Airin Rachmi Diany,SH.,MH dan Drs. H.Benyamin Davnie <br>Perolehan Suara : <?php
                   echo $buff['t_s3'];?>
                   </p>
                </div>
                <?php
	}
				?>
            
<div class="col-lg-5 col-lg-offset-2 col-sm-6">
	<div class="panel panel-default">
    	<div class="panel-heading">
        <meta name="description" content="chart created using amCharts live editor" /> <!--  META YANG DIGUNAKAN PIE CHART-->
        Total Suara Kota Tangerang Selatan
        
       
        <!-- amCharts javascript sources -->
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
		<script type="text/javascript" src="http://www.amcharts.com/lib/3/themes/light.js"></script>

		<!-- amCharts javascript code -->
		<script type="text/javascript">
			AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"angle": 12,
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"depth3D": 15,
					"labelRadius":2,
					"titleField": "category",
					"valueField": "column-1",
					"theme": "light",
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"align": "center",
						"markerType": "circle"
					},
					"titles": [],
					"dataProvider": [
						{
							"category": "suara 3",
							"column-1": 8
						},
						{
							"category": "suara 2",
							"column-1": 6
						},
						{
							"category": "suara 1",
							"column-1": 2
						}
					]
				}
			);
		</script>
        
        </div>
      
<!-- /.panel-heading -->
<div class="panel-body">
	<div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
	
</div>
    	</div>
	</div>
</div>
<!-- /.container -->
    </div>
    <!-- /.content-section-a -->
    
    
    <!-- AWAL HASIL DATA REKAP -->
<a name="rekap"></a>
<div class="content-section-b">

      <div class="container">

            <div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Rekapitulasi Data Kecamatan</h2>
                </div>
            
                     <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Wilayah</th>
                                            <th>Total DPT</th>
                                            <th>Pengguna Hak Pilih</th>
                                            <th>Perolehan Suara Kandidat 1</th>
                                            <th>Perolehan Suara Kandidat 2</th>
                                            <th>Perolehan Suara Kandidat 3</th>
                                            <th>Suara Sah</th>
                                            <th>Suara Tidak Sah</th>
                                            <th>Total Suara</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    
                                   	<?php $query1="select * from wilayah";
					$hasil1=mysql_query($query1) or die("gagal melakukan query."); 
									while($buff=mysql_fetch_array($hasil1)){
									?>
                                    
                                    <tr class="odd gradeX">
                                    <td><?php echo $buff['id_wilayah'];?></td>
                                    

                                    <td><a href="indexrelawan.php?module=rekap"><?php echo $buff['kecamatan'];?></a></td>
                                    <td><?php echo $buff['jml_DPT'];?></td>
                                    <td class="center"><?php echo $buff['hakpilih'];?></td>
                                    <td class="center"><?php echo $buff['s1'];?></td>
                                    <td><?php echo $buff['s2'];?></td>
                                    <td><?php echo $buff['s3'];?></td>
                                    <td><?php echo $buff['suara_sah'];?></td>
                                    <td><?php echo $buff['suara_tdksah'];?></td>
                                    <td><?php echo $buff['total_suara'];?></td>
                                    
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
	<!-- AKHIR HASIL DATA REKAP -->
    

    
    <div class="content-section-a">

        <div class="container">

            <div class="row">
              <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Informasi</h2>
                    <p class="lead">Ini informasi untuk mengetahui data rekapitulasi .</p>
                </div>
                <div class="col-md-7">
                    <div class="panel panel-default">
                    <div class="panel-heading">
                           Pemilih dan Pengguna Hak Pilih
                        </div>
                    <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                   <?php include"koneksi.php";
			   		
					$query1=mysql_query("select sum(jml_DPT) from wilayah");
					$query2=mysql_query("select sum(hakpilih) from wilayah");
					$query3=mysql_query("select sum(total_suara) from wilayah");
					$hasil1=mysql_fetch_row($query1) ;
					$hasil2=mysql_fetch_row($query2) ;
					$hasil3=mysql_fetch_row($query3) ;
					
					
			   ?>

                                
                                    <thead>
                                        <tr>
                                            <th></th>
                                            
                                            
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Suara</td>
                                            <td><?php echo $hasil1[0];?></td>
                                        </tr>
                                        <tr>
                                            <td>Pengguna Hak Pilih</td>
                                            <td><?php echo $hasil2[0];?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Suara</td>
                                            <td><?php echo $hasil3[0];?></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                   
									mysql_close();
									?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

	<a  name="contact"></a>
    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Connect to PILKADA 2015</h2>
                </div>
                <div class="col-lg-6">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                            <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                        </li>
                        <li>
                            <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->