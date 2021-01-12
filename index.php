<?php
    
    $price = "";
    $error = "";
    $stats = "";
    
    $pageHeader= file_get_contents("https://coinmarketcap.com/currencies/ethos/");
    $headerArray=explode('<div class="coin-summary-item">
<h5 class="coin-summary-item-header">
', $pageHeader);

if (sizeof($headerArray) > 1) {
                  $secondHeaderArray = explode('</h5>
<div class="coin-summary-item-detail details-text-medium">', $headerArray[1]);
                  if (sizeof($secondHeaderArray)>1){
                    $stats = $secondHeaderArray[0];
                  }
                  }


    if (array_key_exists('currency', $_GET)) {
        
        $currency = str_replace(' ', '-', $_GET['currency']);
        
        $file_headers = @get_headers("https://coinmarketcap.com/currencies/".$currency);
        
        
        if($file_headers[0] == 'HTTP request failed! HTTP/1.1 404 NOT FOUND') {
    
            $error = "That currency could not be found.";

        } else {
        
        $forecastPage = file_get_contents("https://coinmarketcap.com/currencies/".$currency);
        
        $pageArray = explode('<span class="h2 text-semi-bold details-panel-item--price__value" data-currency-value>', $forecastPage);
            
        if (sizeof($pageArray) > 1) {
        
                $secondPageArray = explode('</span>', $pageArray[1]);
            
                if (sizeof($secondPageArray) > 1) {

                    $price = $secondPageArray[0];
                    
                } else {
                    
                    $error = "That currency could not be found.";
                    
                }
            
            } else {
            
                $error = "That currency could not be found.";
            
            }
        
        
        }
        }
    


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

      <title>Crypto currency price Scraper</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
      
      <style type="text/css">
      
      html { 
          background: url(background.jpeg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
          }
        
          body {
              
              background: none;
              
          }
          
          .container {
              
              text-align: center;
              margin-top: 100px;
              width: 450px;
              
          }
          
          input {
              
              margin: 20px 0;
              
          }
          
          #weather {
              
              margin-top:15px;
              
          }

          #price{
            margin-top: 10px;
          }
          }
         
      </style>
      
  </head>
  <body>
    <header>
      <?php 
              
              if ($stats) {
                  
                  echo '<div class="alert alert-success" role="alert">
  '.$stats.'
</div>';}

else{
  echo'<div class="alert alert-danger" role="alert"> Error loading stats '.$stats.'</div> ';
}
?>

    </header>
      <div class="container">
      
          <h1>What's The price?</h1>
          
          
          
          <form>
  <fieldset class="form-group">
    <label for="currency">Enter the name of a currency.</label>
    <input type="text" class="form-control" name="currency" id="currency" placeholder="Bitcoin, Ethereum,Lisk ..." value = "<?php 
                                                       
                                                       if (array_key_exists('currency', $_GET)) {
                                                       
                                                       echo $_GET['currency']; 
                                                       
                                                       }
                                                       
                                                       ?>">
  </fieldset>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      
          <div id="price"><?php 
              
              if ($price) {
                  
                  echo '<div class="alert alert-success" role="alert">
  '.$price.'
</div>';
                  
              } else if ($error) {
                  
                  echo '<div class="alert alert-danger" role="alert">
  '.$error.'
</div>';
                  
              }
              
              ?></div>
      </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>