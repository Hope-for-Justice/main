<?php

require_once('donorfy.php');

$username = 'James';
$currency = $_POST['Currency'];

if ($currency == 'NOK') {
	$password = DONORFY_TOKEN_NORWAY;
	$tenant = 'N2SOZ58ZN2';
} else if ($currency == 'AUD') {
	$password = DONORFY_TOKEN_AU;
	$tenant = 'H63DOW9MT2';
} else {
	$password = DONORFY_TOKEN_UK;
	$tenant = 'GO66X0NEL4';
}

$email = $_POST['Email'];
$URL = 'https://data.donorfy.com/api/v1/' . $tenant . '/constituents/DuplicateCheckPerson';

$fields = [
	'EmailAddress' => "{$email}",
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
$result = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close($ch);

echo $result;
