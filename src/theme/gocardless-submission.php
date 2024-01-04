<?php
/*
Template Name: Serve
*/
require_once(__DIR__  . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$client = new \GoCardlessPro\Client([
    // We recommend storing your access token in an
    // environment variable for security
    'access_token' => $_ENV['GoCardlessAccessToken'],
    // Change me to LIVE when you're ready to go live
    'environment' => \GoCardlessPro\Environment::SANDBOX
]);
$customers = $client->customers()->list()->records;
print_r($customers);
