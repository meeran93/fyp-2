
<?php

function shortenUrl($inputUri)
	{

	// declare variables
	// login ID for bit.ly

	$login = "siduzair";

	// API KEY From bit.ly for developer account

	$apiKey = "R_2912dd2fe3744886b50b256c13f6ab3d";

	// url to shorten
	// format

	$format = "txt";
	$query = urlencode('where={"steps":9243}');
	$inputUriEncoded = $inputUri . $query;

	// string to be sent

	$data = 'login=' . $login . '&apiKey=' . $apiKey . '&uri=' . $inputUriEncoded . '&format=' . $format;

	// url for api that will be hit

	$url = "http://api.bit.ly/v3/shorten";
	$ch = curl_init($url);

	// set the url, number of POST vars, POST data

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, count($data));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// execute post

	$result = curl_exec($ch);

	// check if result is received or not

	if (!$result)
		{
			$result = "link could not be created";
			return $result;
		}
	  else
		{

		return $result;
		}
	}

?>
