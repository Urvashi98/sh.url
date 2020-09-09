<?php 

//functions.php
include 'includes/functions.php';

//generate a random number
$id= rand(111,999);

//get user values
$url= $_POST['url'];
$shorttext= $_POST['shorttext'];

//check url 
 $code=get_http_response_code($url);
 if($code=='200'){
    
 }else{
     echo "Please enter a valid URL";
     return false;
 }


//check if random id value exists
if(idExists($id)){
   $id= rand(111,999); 
}


//check if url is shortened
 if(getUrlId($url)){

    //check for short text
    if(getUrlText($url)){
        
      $text_of_url = getUrlText($url);

     //if any, append to resultant url.
       if(!empty($text_of_url)){
        echo "http://localhost/sh.url/" .$text_of_url; 
        return true;
       }
       
    }else{
        // if no short-text found, check for ID. 
        $id_of_url = getUrlId($url);
        echo "http://localhost/sh.url/" .$id_of_url; 
        return true;
    }

  
} 


//insert the url, if any of the above fails.
insertURL($id,$url,$shorttext);


?>