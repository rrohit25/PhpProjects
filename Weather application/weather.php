<html>
	<head>
		<title>
			Weather API
		</title>
	</head>
	<body>
		<H1 align="center">Weather search</H1>
		<div align="center">
			<FORM ACTION="" METHOD=POST>
				<div style="border:1px solid; width:350px; padding:2px 2px";>
					<table style="border:1px solid";>
						<tr>
							<td> Location </td>
							<td> <INPUT  type="text" id="loc" size="35" NAME="location"> </td>
						</tr>
						<tr>		
							<td> Location Type </td>
							<td> <select name="type" >
								 <option value="city" SELECTED>City</option>
								 <option value="zip">ZIP Code</option>
								  </select>
							</td>
						</tr>
						<tr>
							<td> Temperature Unit: </td>
							<td> <input type="radio" name="tempUnit" value="f" checked="checked"> Fahrenheit
								<input type="radio" name="tempUnit" value="c"> Celsius	
							</td>
						</tr>
						<tr>
							<td></td>
							<td> <INPUT style="align:center;" TYPE=submit name="submit"> </td>
						</tr>
					</table>
				</div>
			</div>
		<?php if(isset($_POST["submit"])) 
		{ 
			    if($_POST["location"] == "") 
				{
		?>
		<script type="text/javascript">
			alert("Please enter a location");
			return ;
		</script>
			
		<?php 
		} 
		else
		 {
			$loc_value = $_POST["location"];
			$app_id = "Q3uY_QDV34GbLZLTMSgnjc.NZJg2roi2LZubhKLUd.NN6as5nB7Y2hoQgTee3J5S4A--";
			$temp_unit = $_POST["tempUnit"];
			
			if($_POST["type"] == "zip")
			{
				$match_digit = '/^[0-9][0-9][0-9][0-9][0-9]$/';
				$match = preg_match($match_digit,$_POST["location"]);

				if($match)
				{ 
					$url = "http://where.yahooapis.com/v1/concordance/usps/".$loc_value."?appid=".$app_id;
					
					$getXML = @file_get_contents($url);
					try {
                         $woeid_XML = new SimpleXMLElement($getXML);
					} catch (Exception $e) {
                      ?>
						<script type="text/javascript">
						    alert("not a valid XML");
						</script>
			    
					<?php return ;
                    }
					
					if($woeid_XML == false)
					{
					  $woeid = $woeid_XML[0]->woeid;
					}
					else
					{ ?>
						<script type="text/javascript">
						    alert("no matching records found");
						</script>
			
					<?php return ;
					}
					
					$weather_url = "http://weather.yahooapis.com/forecastrss?w=".$woeid."&u=".$temp_unit;
					
					$weather = @file_get_contents($weather_url);
					$weather_XML = new SimpleXMLElement($weather);
					
					$namespaces = $weather_XML->getNameSpaces(true);
					
					$yweather = $weather_XML->channel->item->children($namespaces['yweather']);
					
					$temperature = $weather_XML->channel->item->children($namespaces['yweather'])->condition->attributes()->text . " " . $weather_XML->channel->item->children($namespaces['yweather'])->condition->attributes()->temp . "<sup>o</sup>". $weather_XML->channel->children($namespaces['yweather'])->units->attributes()->temperature;
					
					$city = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->city;
					$region = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->region;
					$country = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->country;
					
					$lat = $weather_XML->channel->item->children($namespaces['geo'])->lat;
					$long = $weather_XML->channel->item->children($namespaces['geo'])->long;
					$description = $weather_XML->channel->item->description; 
					$regex='/http\:[\/\.a-z0-9]+.gif/'; 
					preg_match($regex,$description,$match_img);
					
					$details = $weather_XML->channel->link;
					if($temperature == "") {  $temperature = "NA"; }
					if($city == "") { $city = "NA"; }
					if($region == "") { $region = "NA"; }
					if($country == "") { $country = "NA"; }
					if($lat == "") { $lat = "NA"; }
					if($long == "") { $long = "NA"; }
					if($details == "") { $details = "NA"; }
				 ?>
				   <table border="1" align="center">
						<tr>
						    <td> Weather </td>
							<td> Temperature </td>
							<td> City </td>
							<td> Region </td>
							<td> Country </td>
							<td> Latitude </td>
							<td> Longitude </td>
							<td> Link to Details </td>
						</tr>
						<tr>
						 	<td> <a href="<?php echo $weather_url; ?>"> <img src='<?php echo $match_img[0]; ?>' /></a></td>   
							<td> <?php echo $temperature; ?> </td>
							<td> <?php echo $city; ?> </td>
							<td> <?php echo $region; ?> </td>
							<td> <?php echo $country; ?> </td>
							<td> <?php echo $lat; ?> </td>
							<td> <?php echo $long; ?> </td>	
							<td> <a href="<?php echo $details;?>">Details</a> </td>
						</tr>	
				   </table>
				
				<?php }
				else 
				{ ?>
					<script type="text/javascript">
						alert("Invalid zipcode");
						
					</script>					
				<?php return ; } 	
			}
			else
			{  ?>
		
				<script type="text/javascript">
					alert($_POST["location"]);
				</script>
			<?php	
				$loc_value = $_POST["location"];
				$url = "http://where.yahooapis.com/v1/places\$and(.q('".$loc_value."'),.type(7));start=0;count=5?appid=".$app_id;
				$woeid_XML = simplexml_load_file($url);
				if($woeid_XML || ($woeid_XML->count() == 0))
				{?>
					<script type="text/javascript">
						alert("No records found ");
						 
					</script>
				<?php  return ;} 

				$actual_count = 0;
				for($iterator=0;$iterator<$woeid_XML->count();$iterator++)
				{ 
					$weather_url = "http://weather.yahooapis.com/forecastrss?w=".$woeid_XML->place[$iterator]->woeid."&u=".$temp_unit;
					$weather = @file_get_contents($weather_url);
					
					try {
                         $weather_XML = new SimpleXMLElement($weather);
					} catch (Exception $e) {
                       continue ;
                    }
					$actual_count++;
					if($actual_count == 1){ ?>
				
				<table border="1" align="center">
						<tr>
						    <td> Weather </td>
							<td> Temperature </td>
							<td> City </td>
							<td> Region </td>
							<td> Country </td>
							<td> Latitude </td>
							<td> Longitude </td>
							<td> Link to Details </td>
						</tr>
						
				<?php }
					
					$namespaces = $weather_XML->getNameSpaces(true);
				
					$yweather = $weather_XML->channel->item->children($namespaces['yweather']);
					
					$temperature = $weather_XML->channel->item->children($namespaces['yweather'])->condition->attributes()->text . " " . $weather_XML->channel->item->children($namespaces['yweather'])->condition->attributes()->temp . "<sup>o</sup>". $weather_XML->channel->children($namespaces['yweather'])->units->attributes()->temperature;
					
					$city = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->city;
					$region = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->region;
					$country = $weather_XML->channel->children($namespaces['yweather'])->location->attributes()->country;
					
					$lat = $weather_XML->channel->item->children($namespaces['geo'])->lat;
					$long = $weather_XML->channel->item->children($namespaces['geo'])->long;
					$description = $weather_XML->channel->item->description; 
					$regex='/http\:[\/\.a-z0-9]+.gif/'; 
					preg_match($regex,$description,$match_img);
					
					$details = $weather_XML->channel->link;
					
					if($temperature == "") {  $temperature = "NA"; }
					if($city == "") { $city = "NA"; }
					if($region == "") { $region = "NA"; }
					if($country == "") { $country = "NA"; }
					if($lat == "") { $lat = "NA"; }
					if($long == "") { $long = "NA"; }
					if($details == "") { $details = "NA"; }
					?>
					<tr>
						 	<td> <a href="<?php echo $weather_url; ?>"> <img src='<?php echo $match_img[0]; ?>' /></a></td>   
							<td> <?php echo $temperature; ?> </td>
							<td> <?php echo $city; ?> </td>
							<td> <?php echo $region; ?> </td>
							<td> <?php echo $country; ?> </td>
							<td> <?php echo $lat; ?> </td>
							<td> <?php echo $long; ?> </td>	
							<td> <a href="<?php echo $details;?>">Details</a> </td>
					</tr>
				<?php 
				} 
				if($actual_count == 1) 
				{ ?> <caption> <?php echo $actual_count. " result for city ". $_POST["location"];  ?></caption>
				<?php }
				else { ?>
					<caption> <?php echo $actual_count. " result(s) for city ". $_POST["location"];  ?></caption>
				<?php } ?>
				</table>
				<?php
			}
		 } }  
		?> 
	</body>
</html>	