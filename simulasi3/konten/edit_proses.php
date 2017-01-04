<?php
include 'koneksi.php';
if(isset($_POST['id_wilayahkel'])){
$edit="update wilayah_kel set
kelurahan = '$_POST[kelurahan]',
jml_DPTkel='$_POST[jml_DPTkel]',

hakpilih_kel='$_POST[hakpilih_kel]',
s1_kel='$_POST[s1_kel]',
s2_kel='$_POST[s2_kel]',
s3_kel='$_POST[s3_kel]',
suara_sahkel='$_POST[suara_sahkel]' ,
suara_tdksahkel='$_POST[suara_tdksahkel]',
total_suarakel='$_POST[total_suarakel]'
where id_wilayahkel='$_POST[id_wilayahkel]'";
$hasil=mysql_query($edit);


// Kelurahan

//JML_DPT
$DPT1 = mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '01%'");
$DPT2 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '02%'");
$DPT3 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '03%'");
$DPT4 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '04%'");
$DPT5 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '05%'");
$DPT6 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '06%'");
$DPT7 =  mysql_query("select sum(jml_DPTkel) from wilayah_kel where id_wilayahkel like '07%'");
$dpt1=mysql_fetch_row($DPT1);
$dpt2=mysql_fetch_row($DPT2);
$dpt3=mysql_fetch_row($DPT3);
$dpt4=mysql_fetch_row($DPT4);
$dpt5=mysql_fetch_row($DPT5);
$dpt6=mysql_fetch_row($DPT6);
$dpt7=mysql_fetch_row($DPT7);

//HakPilih
$Hak1 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '01%'");
$Hak2 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '02%'");
$Hak3 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '03%'");
$Hak4 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '04%'");
$Hak5 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '05%'");
$Hak6 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '06%'");
$Hak7 = mysql_query("select sum(hakpilih_kel) from wilayah_kel where id_wilayahkel like '07%'");
$hak1=mysql_fetch_row($Hak1);
$hak2=mysql_fetch_row($Hak2);
$hak3=mysql_fetch_row($Hak3);
$hak4=mysql_fetch_row($Hak4);
$hak5=mysql_fetch_row($Hak5);
$hak6=mysql_fetch_row($Hak6);
$hak7=mysql_fetch_row($Hak7);

//S1
$Suara1 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '01%'");
$Suara2 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '02%'");
$Suara3 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '03%'");
$Suara4 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '04%'");
$Suara5 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '05%'");
$Suara6 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '06%'");
$Suara7 = mysql_query("select sum(s1_kel) from wilayah_kel where id_wilayahkel like '07%'");
$suara1=mysql_fetch_row($Suara1);
$suara2=mysql_fetch_row($Suara2);
$suara3=mysql_fetch_row($Suara3);
$suara4=mysql_fetch_row($Suara4);
$suara5=mysql_fetch_row($Suara5);
$suara6=mysql_fetch_row($Suara6);
$suara7=mysql_fetch_row($Suara7);


//S2

$Suaraa1 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '01%'");
$Suaraa2 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '02%'");
$Suaraa3 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '03%'");
$Suaraa4 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '04%'");
$Suaraa5 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '05%'");
$Suaraa6 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '06%'");
$Suaraa7 = mysql_query("select sum(s2_kel) from wilayah_kel where id_wilayahkel like '07%'");
$suaraa1=mysql_fetch_row($Suaraa1);
$suaraa2=mysql_fetch_row($Suaraa2);
$suaraa3=mysql_fetch_row($Suaraa3);
$suaraa4=mysql_fetch_row($Suaraa4);
$suaraa5=mysql_fetch_row($Suaraa5);
$suaraa6=mysql_fetch_row($Suaraa6);
$suaraa7=mysql_fetch_row($Suaraa7);


//S3

$Suaraaa1 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '01%'");
$Suaraaa2 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '02%'");
$Suaraaa3 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '03%'");
$Suaraaa4 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '04%'");
$Suaraaa5 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '05%'");
$Suaraaa6 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '06%'");
$Suaraaa7 = mysql_query("select sum(s3_kel) from wilayah_kel where id_wilayahkel like '07%'");
$suaraaa1=mysql_fetch_row($Suaraaa1);
$suaraaa2=mysql_fetch_row($Suaraaa2);
$suaraaa3=mysql_fetch_row($Suaraaa3);
$suaraaa4=mysql_fetch_row($Suaraaa4);
$suaraaa5=mysql_fetch_row($Suaraaa5);
$suaraaa6=mysql_fetch_row($Suaraaa6);
$suaraaa7=mysql_fetch_row($Suaraaa7);


//SuaraSah
$Suarasah1 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '01%'");
$Suarasah2 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '02%'");
$Suarasah3 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '03%'");
$Suarasah4 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '04%'");
$Suarasah5 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '05%'");
$Suarasah6 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '06%'");
$Suarasah7 = mysql_query("select sum(suara_sahkel) from wilayah_kel where id_wilayahkel like '07%'");
$suarasah1=mysql_fetch_row($Suarasah1);
$suarasah2=mysql_fetch_row($Suarasah2);
$suarasah3=mysql_fetch_row($Suarasah3);
$suarasah4=mysql_fetch_row($Suarasah4);
$suarasah5=mysql_fetch_row($Suarasah5);
$suarasah6=mysql_fetch_row($Suarasah6);
$suarasah7=mysql_fetch_row($Suarasah7);


//SuaraTdkSah]

$Suaratdk1 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '01%'");
$Suaratdk2 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '02%'");
$Suaratdk3 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '03%'");
$Suaratdk4 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '04%'");
$Suaratdk5 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '05%'");
$Suaratdk6 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '06%'");
$Suaratdk7 = mysql_query("select sum(suara_tdksahkel) from wilayah_kel where id_wilayahkel like '07%'");
$suaratdk1=mysql_fetch_row($Suaratdk1);
$suaratdk2=mysql_fetch_row($Suaratdk2);
$suaratdk3=mysql_fetch_row($Suaratdk3);
$suaratdk4=mysql_fetch_row($Suaratdk4);
$suaratdk5=mysql_fetch_row($Suaratdk5);
$suaratdk6=mysql_fetch_row($Suaratdk6);
$suaratdk7=mysql_fetch_row($Suaratdk7);


//Total
$Suaratotal1 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '01%'");
$Suaratotal2 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '02%'");
$Suaratotal3 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '03%'");
$Suaratotal4 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '04%'");
$Suaratotal5 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '05%'");
$Suaratotal6 =  mysql_query( "select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '06%'");
$Suaratotal7 =  mysql_query("select sum(total_suarakel) from wilayah_kel where id_wilayahkel like '07%'");
$suaratotal1=mysql_fetch_row($Suaratotal1);
$suaratotal2=mysql_fetch_row($Suaratotal2);
$suaratotal3=mysql_fetch_row($Suaratotal3);
$suaratotal4=mysql_fetch_row($Suaratotal4);
$suaratotal5=mysql_fetch_row($Suaratotal5);
$suaratotal6=mysql_fetch_row($Suaratotal6);
$suaratotal7=mysql_fetch_row($Suaratotal7);


//Update Kecamatan
$kecamatan1 = "UPDATE wilayah 
			   SET jml_DPT='$dpt1[0]', hakpilih='$hak1[0]', s1='$suara1[0]', s2='$suaraa1[0]', s3='$suaraaa1[0]',     suara_sah='$suarasah1[0]',suara_tdksah='$suaratdk1[0]', total_suara = '$suaratotal1[0]'
			   WHERE id_wilayah = '01'";
				
$kecamatan2 = "UPDATE wilayah 
			   SET jml_DPT='$dpt2[0]', hakpilih='$hak2[0]', s1='$suara2[0]', s2='$suaraa2[0]', s3='$suaraaa2[0]',     suara_sah='$suarasah2[0]',suara_tdksah='$suaratdk2[0]', total_suara = '$suaratotal2[0]'
			   WHERE id_wilayah = '02'";
				
$kecamatan3 ="UPDATE wilayah 
			   SET jml_DPT='$dpt3[0]', hakpilih='$hak3[0]', s1='$suara3[0]', s2='$suaraa3[0]', s3='$suaraaa3[0]',     suara_sah='$suarasah3[0]',suara_tdksah='$suaratdk3[0]', total_suara = '$suaratotal3[0]'
			   WHERE id_wilayah = '03'";
			   
$kecamatan4 = "UPDATE wilayah 
			   SET jml_DPT='$dpt4[0]', hakpilih='$hak4[0]', s1='$suara4[0]', s2='$suaraa4[0]', s3='$suaraaa4[0]',     suara_sah='$suarasah4[0]',suara_tdksah='$suaratdk4[0]', total_suara = '$suaratotal4[0]'
			   WHERE id_wilayah = '04'";
			   
$kecamatan5 = "UPDATE wilayah 
			   SET jml_DPT='$dpt5[0]', hakpilih='$hak5[0]', s1='$suara5[0]', s2='$suaraa5[0]', s3='$suaraaa5[0]',     suara_sah='$suarasah5[0]',suara_tdksah='$suaratdk5[0]', total_suara = '$suaratotal5[0]'
			   WHERE id_wilayah = '05'";
				
$kecamatan6 = "UPDATE wilayah 
			   SET jml_DPT='$dpt6[0]', hakpilih='$hak6[0]', s1='$suara6[0]', s2='$suaraa6[0]', s3='$suaraaa6[0]',     suara_sah='$suarasah6[0]',suara_tdksah='$suaratdk6[0]', total_suara = '$suaratotal6[0]'
			   WHERE id_wilayah = '06'";
			   
$kecamatan7 = "UPDATE wilayah 
			   SET jml_DPT='$dpt7[0]', hakpilih='$hak7[0]', s1='$suara7[0]', s2='$suaraa7[0]', s3='$suaraaa7[0]',     suara_sah='$suarasah7[0]',suara_tdksah='$suaratdk7[0]', total_suara = '$suaratotal7[0]'
			   WHERE id_wilayah = '07'";
			   
mysql_query($kecamatan1);
mysql_query($kecamatan2);
mysql_query($kecamatan3);
mysql_query($kecamatan4);
mysql_query($kecamatan5);
mysql_query($kecamatan6);
if(!mysql_query($kecamatan7)&&!mysql_query($kecamatan1)&&!
mysql_query($kecamatan2)&&!
mysql_query($kecamatan3)&&!
mysql_query($kecamatan4)&&!
mysql_query($kecamatan5)&&!
mysql_query($kecamatan6))
die (mysql_error());

//KECAMATAN 
$TotalS1 = mysql_query("select sum(s1) from wilayah");
$TotalS2 = mysql_query("select sum(s2) from wilayah");
$TotalS3 = mysql_query("select sum(s3) from wilayah");
$totals1=mysql_fetch_row($TotalS1);
$totals2=mysql_fetch_row($TotalS2);
$totals3=mysql_fetch_row($TotalS3);
$persentases1 = ($totals1[0]/($totals1[0]+$totals2[0]+$totals3[0]))*100;
$persentases2 = ($totals2[0]/($totals1[0]+$totals2[0]+$totals3[0]))*100;
$persentases3 = ($totals3[0]/($totals1[0]+$totals2[0]+$totals3[0]))*100;

$totals1 = (string)$totals1[0];
$totals2 = (string)$totals2[0];
$totals3 = (string)$totals3[0];
$persentases1 = (string)round($persentases1,2);
$persentases2 = (string)round($persentases2,2);
$persentases3 = (string)round($persentases3,2);



$updates1 = "UPDATE hasil_hitung 
			   SET t_s1='$totals1[0]', t_s2='$totals2[0]', t_s3='$totals3[0]', p_s1='$persentases1', p_s2='$persentases2',     p_s3='$persentases3'
			   WHERE id_hasilhitung = '1'";

if(!mysql_query($updates1))
die (mysql_error());


echo "<script>alert('Data Berhasil Diubah');window.location.href='indexrelawan.php?module=home';</script>";
mysql_close();}?>