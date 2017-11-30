<?php
    class Instagram{
        //constructor
        public function __construct() 
        {
           
        }
        
        public function getImages($access_token, $photo_count)
        {
            $json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
            $json_link.= "access_token={$access_token}&count={$photo_count}";

            $json = file_get_contents($json_link);
            $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);  
            
            return $obj;
        }
    }
?>
