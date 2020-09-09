<?php


//database connection
 function connect(){
   $conn = mysqli_connect("localhost","root","","users");
    if(!$conn){
        echo "connection fail";
    }else{
        return $conn; 
    }
   }


//check the correct URL
function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}


//check if random id already exsists
function idExists($id){
    $conn = connect();
    $sql= $conn->query("SELECT * FROM shorturl WHERE id='$id'");
    if($sql->num_rows >0 ){
        return true;
    }else{
        return false;
    }
}

//get id of the short url
 function getUrlId($url){
    $conn = connect();

    $sql= $conn->query("SELECT id FROM shorturl WHERE original_url='$url'") or die("id retrieve fail");
  
    if($sql->num_rows ==1 ){
        return $sql->fetch_assoc()['id'];
    }else{
        return false;
    }
   
} 

//get url text
function getUrlText($url){
    $conn = connect();

    $sql= $conn->query("SELECT short_text FROM shorturl WHERE original_url='$url'") or die("short-text retrieve fail");
    if($sql->num_rows ==1 ){
        return $sql->fetch_assoc()['short_text'];
    }else{
        return false;
    }
}

//get original url from id
function getURLfromID($id){

    $conn = connect();
    $sql= $conn->query("SELECT original_url FROM shorturl WHERE id='$id'") or die("url retrieve fail");
    if($sql->num_rows >0 ){
        return $sql->fetch_assoc()['original_url'];
    }else{
        return false;
    }
   
}

//get original url from text
function getURLfromText($shorttext){

    $conn = connect();
    $sql= $conn->query("SELECT original_url FROM shorturl WHERE short_text='$shorttext'") or die("url retrieve fail");
    if($sql->num_rows >0 ){
        return $sql->fetch_assoc()['original_url'];
    }else{
        return false;
    }
} 


//insert new url here
function insertURL($id, $url,$shorttext){

    $conn = connect();

    //if no short text entered.
    if($shorttext==''){
        $insert =$conn->query("insert into shorturl values('$id','$url','$shorttext')"); 
            if($insert){
                return true;

            }else{
               // echo "error is ". $conn->error;
               return false;
            }
        
    }else{

        //check if entered text already exists.
        $select = $conn->query("SELECT short_text FROM shorturl WHERE short_text = '$shorttext'");
        
        $value = $select->fetch_assoc()['short_text'];

        //allow only unique text.
        if($shorttext==$value){
            echo "Try something other.";
        }
        else{

            //unique short-text
            $insert = "insert into shorturl values('$id','$url','$shorttext')";
            $result= mysqli_query($conn,$insert);
            if($result){
               return true;
            }else{
                //echo "error is ". $conn->error;
                return false;
            }
        }

    }





  /*   $select = $conn->query("SELECT short_text FROM shorturl WHERE short_text = '$shorttext'");
        $value = $select->fetch_assoc()['short_text'];
        if($value==''){
            $insert = "insert into shorturl values('$id','$url','$shorttext')";
            $result= mysqli_query($conn,$insert);
            if($result){
                echo 'isnert done'; 

            }else{
                echo "error is ". $conn->error;
            }
            
        }else{
            echo "Try something other.";
        }
 */
/* 
    $insert = "insert into shorturl values('$id','$url','$shorttext')";
    $result= mysqli_query($conn,$insert);
    if($result){
        echo 'isnert done'; 

    }else{
        echo "error is ". $conn->error;
    }
     */

}

?>