<?php
  // Because I don't have actual control over the web server the site is hosted on
  // I had to look around for some solutions that I could do strictly in php
  // Or cUrl
  // After a bunch of looking around, I finally found something that I could put to use
  
  //Grabs the location WOEID input by the user from the weather.html page.
  $Location = $_POST['WOEID'];;  /* Jakarta */

  // Makes use of curl to call the Yahoo! Weather API
  $servcall = curl_init();
  // Call to the Yahoo! Weather API replacing the WOEID with the user input from weather.html
  // Makes the "u"nits "f"ahrenheit
  curl_setopt($servcall, CURLOPT_URL, 'http://weather.yahooapis.com/forecastrss?w='.$Location.'&u=f');
  // API request coming back
  curl_setopt($servcall, CURLOPT_RETURNTRANSFER, 1);
  // Returned XML information stored
  $weather_xml = curl_exec($servcall);
  // Closes the call
  curl_close($servcall);

  // Creates an object that we can manipulate from the returned XML code
  // Called, simply, weather
  $weather = new SimpleXMLElement($weather_xml);
  
  // The API call to Yahoo!'s weather data sends back an image
  // We can use this to display the current weather conditions
  // Just have to search through the xml to find the image
  $weather_contents = $weather->channel->item->description;
  preg_match_all('/<img[^>]+>/i',$weather_contents, $img);
  $weather_img = $img[0][0];

  // Get the weather bits we're interested in
  // Just the weather condition and temperature
  // There's a ton of other stuff the API spits back at us
  // For what I wanted to do, these seemed like the most logical to use
  $weather_unit = $weather->channel->xpath('yweather:units');
  $weather_cond = $weather->channel->item->xpath('yweather:condition');
?>
 
<style>
  .left{float: left;overflow:hidden;}.right{float:right;}
  .weather_block{overflow:hidden;width: 220px;font-family: Arial, sans-serif; color: #6a6a6a;}
  .temp{font-weight:bold;font-size:17px;margin-right: 10px;}
  .wcond{font-size:14px;} 
</style>
<div class="weather_block">
  <div class="left">
    <?php print $weather_img; ?>
  </div>
  <div class="left">
    <div class="temp left">
      Currently<br /><?php print $weather_cond[0]->attributes()->temp; ?>&deg; <?php print $weather_unit[0]->attributes()->temperature; ?>
    </div>
    <div class="right">
      <div class="wcond">
        <?php print $weather_cond[0]->attributes()->text; ?><br /><br />
      </div>
    </div>
  </div>
</div>