<?php
// Error reporting (E_ALL for development, 0 for Production)
error_reporting(0);

// Variables used for API URL
$api_key = 'ENTER_YOUR_OPEN_WEATHER_API_KEY';
$country = 'US';
$city = $_POST['city'];
$units = $_POST['unit'];

if (isset($_POST['city']))
{
	if ($units == 'imperial') {
		$unit = '&#8457;';
		$speed = 'MPH';
	}
	if ($units == 'metric') {
		$unit = '&#8451;';
		$speed = 'KPH';
	}
	
	// Hide message and show weather
	$wc = 'show';
	$mc = 'hide';

	// API URL string
	$api_url = "api.openweathermap.org/data/2.5/weather?q=$city,$country&units=$units&appid=$api_key";

	// cURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);

	// Array components
	$cityName = $data->name;
	$temp_current = $data->main->temp;
	$temp_max = $data->main->temp_max;
	$temp_min = $data->main->temp_min;
	$wind_speed = $data->wind->speed;
	$sunrise = $data->sys->sunrise;
	$sunset = $data->sys->sunset;
	$description = $data->weather[0]->description;
	$icon = $data->weather[0]->icon;
	
	// Convert temp to whole number
	$temp_current = number_format($temp_current,0);
	$temp_max = number_format($temp_max,0);
	$temp_min = number_format($temp_min,0);

	// Icon URL string
	$icon_ow = 'http://openweathermap.org/img/w/'.$icon.'.png';
}
else {
	$wc = 'hide';
	$mc = 'show';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Simple open Weather API Example">
  <meta name="author" content="">

  <title>Open Weather API</title>
  
  <style>
  	.hide {
		display:none;
	}
	.show {
		display: block;
	}
  	.weather-container {
  		overflow:auto;
		width:300px;
		margin: 0 auto;
		padding: 8px;
		border:solid #CCC 1px;
		border-radius:8px;
		box-shadow:2px 2px 4px #AAA;
		font-family:Arial, Helvetica, sans-serif;
	}
	.weather-data {
		float:left;
		width:80%;
	}
	.weather-image {
		float:right;
		width:20%;
	}
	#city_name {
		margin:0;
		font-size:32px;
		line-height:30px;
		color:#6c8ca8;
	}
	#description {
		margin:0 2px;
		font-size:16px;
		line-height:14px;
		color:#767d88;
	}
	#temp_current,#temp_high_low,#wind {
		margin:6px 2px;
		font-size:14px;
		line-height:12px;
		color:#535861;
	}
	#divider {
		margin:8px 0;
		width:100%;
		height:2px;
		background-color:#96bfdc;
	}
  </style>

</head>

<body>

<h1 class="title-text"></h1>

<div class="weather-container">
	<div class="weather-form">
		<form action="index.php" method="post">
			<input type="text" name="city" id="city_field" placeholder="Enter a city name"/>
			<select name="unit" id="unit_field">
				<option value="imperial">Fahrenheit</option>
				<option value="metric">Celcius</option>
			</select>
			<input type="submit" value="Go"/>
		</form>
	</div>
	<div id="divider"></div>
	<div class="weather-data <?php echo $wc; ?>">
		<h3 id="city_name"><?php echo $cityName; ?></h3>
		<p id="description"><?php echo ucwords($description); ?></p>
		<br/>
		<p id="temp_current">Current Temperature: <?php echo $temp_current.$unit; ?></p>
		<p id="temp_high_low">High:&nbsp;<?php echo $temp_max.$unit; ?>;&nbsp;&nbsp;Low:&nbsp;<?php echo $temp_min.$unit; ?></p>
		<p id="wind">Wind Speed: <?php echo $wind_speed.' '.$speed; ?></p>
	</div>
	<div class="weather-image <?php echo $wc; ?>">
		<img id="weather_icon" src="<?php echo $icon_ow; ?>"/>
	</div>
	<div class="message-container <?php echo $mc; ?>">
		<h3 id="message">Please select a US city</h3>
	</div>
</div>

</body>

</html>
