<html>
<head>
	<?php
		function cmp($a, $b) {
		    // return strcmp($a->division, $b->division);
		    if($a->conference>$b->conference)
		    {
		    	return 1;
		    }
		    else if($a->conference<$b->conference)
		    {
		    	return -1;
		    }
		    else if(($a->division>$b->division))
		    {
		    	return 1;
		    }
		    else if(($a->division<$b->division))
		    {
		    	return -11;
		    }
		    else
		    {
		    	return strcmp($a->name, $b->name);
		    }
		}
	?>
	<style type="text/css">
		th, td{
			border: 1px solid black;
		}
		table{
			margin-left: auto;
			margin-right: auto;
		}
		.conference
		{
			width:49%;
			display: inline-block;
		}
		@media only screen and (max-width: 600px)
		{
			.conference
			{
				width:100%;
				display: block;
			}
		}
	</style>
</head>
<body>
	<?php
		$url = 'http://delivery.chalk247.com/team_list/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0';
		$ch = curl_init();
		// set the URL
		curl_setopt($ch, CURLOPT_URL, $url);
		// Return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// Fake the User Agent for this particular API endpoint
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		// $output contains the output string.
		$output = curl_exec($ch);
		// close curl resource to free up system resources.
		curl_close($ch);
		// You have your JSON response here
		// echo $output;
		$response=json_decode(($output));
		$teams=$response->results->data->team;
		usort($teams,'cmp');
		$gteams=array();

		foreach($teams as $team)
		{
			$con=$team->conference;
			$div=$team->division;

			if(!isset($gteams[$con]))
			{
				$gteams[$con]=array();
			}
			if(!isset($gteams[$con][$div]))
			{
				$gteams[$con][$div]=array();
			}
			array_push($gteams[$con][$div],$team);
		}
		
	?>
	<center>
		<?php foreach ($gteams as $conferenceName => $conference) { ?>
			<div class='conference'>
				<h1><?=$conferenceName?></h1>
				<?php foreach ($conference as $divisionName => $division) { ?>
					<h2><?=$divisionName?> Division</h2>
					<ul>
						<?php foreach ($division as $key => $team) { ?>
							<?php
								$teamName=$team->display_name. ' '.$team->nickname; 
							?>

							<li><?=$teamName?></li>
						<?php } ?>

					</ul>
				<?php } ?>

			</div>
		<?php } ?>

	</center>
</body>
</html>