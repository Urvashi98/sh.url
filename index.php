<?php 

include 'includes/functions.php';

//if index.php is loaded with a short url, it should have get value.
if(isset($_GET) && !empty($_GET)){
  
    $id= $_GET;
    $new_id='';

    //as $_GET is an array, fetch it's id.
   foreach($id as $key =>$val){
      $new_id=$key; 
   }

   // check if it's numeric, that means no short-text is entered by user.
   if(is_numeric($new_id)){
       //fetch url based on ID
      $url =  getURLfromID($new_id);
   }else{
       //fetch url based on text
    $url =  getURLfromText($new_id);
   }
   
   //redirect to original URL.
    if($url){
      header("location:".$url);
    } 

  
    
}

?>

<!DOCTYPE html>
<head>
    <title>URL Shortner</title>
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      
		<style>
            h3{
                color:blueviolet; text-align: center;
            }
            #url{
                width: 15cm;
            }
            #shorttext{
                width: 8cm;
            }
            .body{
               margin: auto;
             display: flex;
              justify-content: center;
            
            }
            span{

                background-color:aliceblue;
                font-family:'Courier New', Courier, monospace;
                letter-spacing: 0.2px;
                font-size:small;
                
            }
            .container{
                margin: 20px;
				
            }.asterisk{
                color: red;font-weight:bold;
            }#input_result{
                font-weight: bold;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                
            }.error{
                font-size: 14px;
            }.result{
                font-size: 14px;
            }

        </style>
</head>
<body>

<h3>URL SHORTNER</h3>
<div class="container">
    <!-- URL -->
    <input type="text" name="url" id="url"  placeholder="Enter URL to shrink.."><br/><br/>
     <!-- short text -->
    <input type="text" name="url" id="shorttext"  placeholder="Keyword to append new URL">

    <span class="text-muted"> <span class="asterisk">    *</span><mark>Ignore if you want system generated.</mark></span><br/><br/>

     <!-- submit values -->
    <input type="submit" value="Shorten my URL" id="submit" class="btn btn-primary"><br/><br/>


	 <!-- new url display -->
        <input type="text" name="url" id="input_result" style="width: 10cm;" placeholder="Result will be displayed here" readonly>
         <!-- Copy the short url -->
        <button class="btn btn-success btn-sm btn-inline copy-text" >Copy here, paste anywhere!</button><br/><br/>
         <!-- result and error section -->
        <div class="result badge badge-success"></div>
        <div class="error badge badge-danger"></div>

</div>




<!-- JS -->
  <script src="jquery-3.5.1.js"></script>

<!-- Latest compiled and minified JavaScript -->
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<!-- submit click script-->
<script>
        $(document).ready(function(){
            //submit url click function
            $("#submit").click(function(e){
               e.preventDefault();

               $(".error").html('');
	 
                //fetch url value
                   var url= $("#url").val();
                   var shorttext= $("#shorttext").val();
                            
                    //If empty url
                if(url == ''){
                    $(".error").html("Please enter a URL.");
               }else{
                    $(".error").html('');	
                        //send post value                    
                    $.post('/sh.url/process.php',
                        { url:url,
                          shorttext: shorttext 
                        },
                            function(data, txtstatus,jqxhr){
                           console.log(data);
                           $("#input_result").val(data);
 
                        });             
               }    
            });   //end submit click function
 
 
            //copy button click
            $(".copy-text").click(function(e){
                        e.preventDefault();
                        $(".error").html('');
                    
                     //check if any value
                        var nurl= $("#input_result").val();
                    
                        if( nurl== ''){
                            $(".error").html("No URL found.");
                    }else{
        
                //copy the displayed value.
                        $(".error").html('');
                        $("#input_result").select();
                        document.execCommand('copy');
                        $(".result").html("Copied!!")
                    }
            });//end copy click function

        });
    </script>

</body>
</html>