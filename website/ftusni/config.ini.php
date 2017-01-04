<?php
  $AdminEmail = 'human@usni.ac.id';
  $DefaultTheme = 'Demo';
  $DefaultNewsList = 4;
  $DefaultMaxRow = 20;
  $Max_File_Size = 1000000;
  $Max_Poll_Choice = 12;
  // Jika di server Windows gunakan ini:
  $Upload_dir = "files\\";
  // Jika di server Linux gunakan ini:
  //$Upload_dir = "files/";

  // Jika di server Windows:
  //$Download_dir = "files\\";
  $Download_dir = "download\\";
  // Jika di server Linux:
  //$Download_dir = "./download/";
  $Training_dir = "training\\";
  // $Training_dir = "training/";
  
  $PMBEmail_notification = "human@usni.ac.id"; // "pmb@usni.ac.id";
  
  $arr_Month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
    'Agustus', 'September', 'Oktober', 'November', 'Desember');
  $arr_day = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
  $arr_jam = array('06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
    '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:30', '15:00', '15:30', '16:00', '16:30',
	'17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00');
  $Student_MinYear = 1940;
  $Student_MaxYear = 1990;
  $Student_DefaultYear = 1972;
  
  $AllowableHTML = array("p"=>2,
                      "b"=>1,
                      "i"=>1,
                      "a"=>2,
                      "em"=>1,
                      "br"=>1,
                      "strong"=>1,
                      "blockquote"=>1,
                      "tt"=>1,
                      "li"=>1,
                      "ol"=>1,
                      "div"=>2,
                      "ul"=>1);  

?>
