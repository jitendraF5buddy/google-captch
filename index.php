<?php

if (isset($_POST['submit'])) {
	//echo "fdsfdsfdsfdsf";exit;
	// This is captch varification start from server side. 
	$cp_check = "";
	$captcha;
	$YOUR_SECRET_KEY = "6Lf11GQUAAAAAJ35PLKOfKqBx1vXOajy9VNGLT2-";

		if(isset($_POST['g-recaptcha-response'])){
      	$captcha=$_POST['g-recaptcha-response'];
		}

    if(!$captcha){
      $cp_check = 0;
  	}
    
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$YOUR_SECRET_KEY&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);      

    $response = curl_exec($ch);
    curl_close($ch);
    
    $response = json_decode($response);
    //print_r($response);
    //print_r($data);exit;
    
    if(isset($response) && $response->success == false)
    {
      $cp_check = 0;
    }
    else
    {
      $cp_check = 1;
    }
    // This is captch varification end from server side. 

    if (isset($cp_check) && $cp_check==1){
		echo "Successfull varification from server side";
	}else{
		echo "captch varification faild";
	}
}

	?>

<style>
.msg-error {
  color: red;
 }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

<form id="mycap_form" action="" method="post">  
  <div id="recaptcha" class="g-recaptcha" data-sitekey="6Lf11GQUAAAAAGEeT237S1Gdy8-rsVB71tf6un_C" data-callback="vcc"></div>

  <span class="msg-error"></span>
  <br/>
  <input type="hidden" name="hid"/>
  <input id="sbt" type="submit" value="Submit" name="submit">
</form>

<script>
		$(document).ready(function(){

				$("#mycap_form").submit(function(){	
					
					$captcha = $( '#recaptcha' );
			      	response = grecaptcha.getResponse();

					if (response.length === 0) {
					    $( '.msg-error').text( "Please varify google captch" );
					    if( !$captcha.hasClass( "error" ) ){
					      $captcha.addClass( "error" );	
					    }
					    return false;
					} else {
					    $( '.msg-error' ).text('');
					    //Successs
					    $captcha.removeClass( "error" );
					    return true;
				  	}

		  		});
	    	
		});

</script>