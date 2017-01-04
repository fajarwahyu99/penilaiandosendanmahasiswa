
<?php
$id=$_GET['id'];
include 'koneksi.php';
$select="select * from wilayah_kel where id_wilayahkel='$id'";
$hasil=mysql_query($select);
while($buff=mysql_fetch_array($hasil))
{
?>

<a name="edit"></a>
<div class="content-section-b">

      <div class="container">

            <div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Rekapitulasi Data</h2>
                </div>

<div class="panel-body">
                        <hr class="intro-divider" />
                        <h2 align="center">Input Data</h2>
                        
                        <div class="col-lg-12">  
                        <form action="edit_proses.php" method="post">
                        	
                     
                            <input type="hidden" name="id_wilayahkel" value="<?php echo $buff['id_wilayahkel'];?>"/>
                            <input type="hidden" name="kelurahan" value="<?php echo $buff['kelurahan'];?>"/>
                            
                            <div class="form-group">
                            <label>Total DPT</label>
                            <input type="text" name="jml_DPTkel"placeholder="<?php echo $buff['jml_DPTkel'];?>"/></div>
                            
                            
                            <div class="form-group">
                            <label>Pengguna Hak Pilih</label>
                            <input type="text" name="hakpilih_kel"placeholder="<?php echo $buff['hakpilih_kel'];?>"/></div>
                                                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 1</label>
                            <input type="text" name="s1_kel"placeholder="<?php echo $buff['s1_kel'];?>"/></div>
                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 2</label>
                            <input type="text" name="s2_kel"placeholder="<?php echo $buff['s2_kel'];?>"/></div>
                            
                            <div class="form-group">
                            <label>Perolehan Suara Kandidat 3</label>
                            <input type="text" name="s3_kel"placeholder="<?php echo $buff['s3_kel'];?>"/></div>
                            
                            <div class="form-group">
                            <label>Suara Sah</label>
                            <input type="text" name="suara_sahkel"placeholder="<?php echo $buff['suara_sahkel'];?>"/></div>
                            
                            <div class="form-group">
                            <label>Suara Tidak Sah</label>
                            <input type="text" name="suara_tdksahkel"placeholder="<?php echo $buff['suara_tdksahkel'];?>"/></div>
                                
                            <div class="form-group">
                            <label>Total Suara</label>
                            <input type="text" name="total_suarakel"placeholder="<?php echo $buff['total_suarakel'];?>"/></div>
                            

                            <input class="btn btn-success btn-outline" type="submit"></input>                            
                            <input class="btn btn-danger btn-outline" type="reset"></input>                            
                         </form>   
			<?php
            };
            mysql_close();
			?>
			
            </div>
            </div>
</div>
</div>