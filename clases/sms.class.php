<?php

$twilio_account_sid = "AC429340463ee4be91d7de15f8ca5ad07a";
$twilio_auth_token = "23ec56b6f1195a7fdfad3761082ddcf7";
$twilio_phone_number = "+15074185046";

$payload = [
    'From' => $twilio_phone_number,
    'To' => '+584247391194',
    'Body' => 'Mensaje de prueba'
];

$url = 'https://api.twilio.com/2010-04-01/Accounts/' . $twilio_account_sid . '/Messages.json';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, $twilio_account_sid . ':' . $twilio_auth_token);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close ($ch);

var_dump( $status );
var_dump( $response );

?>
