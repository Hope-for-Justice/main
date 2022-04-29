<?php 

require_once('donorfy.php');

$username='James';
$password= DONORFY_TOKEN;
$URL='https://data.donorfy.com/api/v1/GO66X0NEL4/constituents/DuplicateCheckPerson';

$fields = [
    'EmailAddress' => 'james.holt@hopeforjustice.org',
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch); 

echo $result;





