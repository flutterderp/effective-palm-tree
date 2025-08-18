<?php
/**
 * API reference URL:
 * https://developer.ups.com/tag/Rating?loc=en_PE&tag=Rating#section/Reference
 */

use UpsPhpClientCredentialSdk\HttpClient;
use UpsPhpClientCredentialSdk\ClientCredentialService;

require_once(__DIR__ . '/src/ClientCredentialService.php');

$client_id     = '';
$client_secret = '';
$headers       = [];
$custom_claims = [];

$httpclient = new HttpClient();

$service        = new ClientCredentialService($httpclient);
$oauth          = $service->getAccessToken($client_id, $client_secret, $headers, $custom_claims);
$oauth_error    = $oauth->getError();
$oauth_response = $oauth->getResponse();

if (!is_null($oauth_response))
{
	$service         = '02'; // module sets this from the function call
	$weight          = 0.2; // module sets this from the function call
	$data            = [];
	$package         = [];
	$payment_details = [];
	$shipper         = [];
	$ship_from       = [];
	$ship_to         = [];
	// get the token from the response
	$token           = $oauth_response->getAccessToken();

	$shipper['ShipperNumber']                       = '';
	$shipper['Address']['AddressLine']              = [''];
	$shipper['Address']['City']                     = '';
	$shipper['Address']['StateProvinceCode']        = '';
	$shipper['Address']['PostalCode']               = '';
	$shipper['Address']['CountryCode']              = 'US';
	$ship_from['Address']['AddressLine']            = $shipper['Address']['AddressLine'];
	$ship_from['Address']['City']                   = $shipper['Address']['City'];
	$ship_from['Address']['StateProvinceCode']      = $shipper['Address']['StateProvinceCode'];
	$ship_from['Address']['PostalCode']             = $shipper['Address']['PostalCode'];
	$ship_from['Address']['CountryCode']            = $shipper['Address']['CountryCode'];
	$ship_to['Name']                                = '';
	$ship_to['Address']['AddressLine']              = [''];
	$ship_to['Address']['City']                     = '';
	$ship_to['Address']['StateProvinceCode']        = '';
	$ship_to['Address']['PostalCode']               = '';
	$ship_to['Address']['CountryCode']              = 'US';
	$package['PackagingType']                       = ['Code' => '02', 'Description' => 'Rate'];
	$package['Dimensions']['UnitOfMeasurement']     = ['Code' => 'IN', 'Description' => 'inches'];
	$package['Dimensions']['Length']                = '5';
	$package['Dimensions']['Width']                 = '4';
	$package['Dimensions']['Height']                = '3';
	$package['PackageWeight']['UnitOfMeasurement']  = ['Code' => 'Lbs', 'Description' => 'pounds'];
	$package['PackageWeight']['Weight']             = (string) $weight;

	$data['RateRequest']                                      = [];
	$data['RateRequest']['PickupType']['Code']                = '01';
	$data['RateRequest']['CustomerClassification']['Code']    = '01';
	$data['RateRequest']['Request']                           = ['RequestOption' => 'Rate', 'TransactionReference' => ['CustomerContext' => 'Rating and Service']];
	$data['RateRequest']['Shipment']['Shipper']               = $shipper;
	$data['RateRequest']['Shipment']['ShipTo']                = $ship_to;
	$data['RateRequest']['Shipment']['ShipFrom']              = $ship_from;
	$data['RateRequest']['Shipment']['Service']               = ['Code' => $service, 'Description' => ''];
	$data['RateRequest']['Shipment']['Package']               = $package;
	$data['RateRequest']['Shipment']['ShipmentRatingOptions'] = ['NegotiatedRatesIndicator' => ''];

	$ch_header = [];
	// $ch_header[] = 'transID';
	// $ch_header[] = 'transactionSrc :testing';
	$ch_header[] = 'Content-Type: application/json';
	$ch_header[] = 'Authorization: Bearer ' . $token;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://wwwcie.ups.com/api/rating/v2403/rate');
	curl_setopt($ch, CURLOPT_HEADER, 0); // rest
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'cache-control: no-cache'));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ch_header);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	$result = curl_exec($ch);
	$params = json_decode($result, true); // json/rest

	curl_close($ch);

	if ($params['response']['errors'])
	{
		foreach ($params['response']['errors'] as $rate_error)
		{
			echo $rate_error['code'] . ': ' . $rate_error['message'] . '<br>';
		}
	}
	else
	{
		$params['Response']['ResponseStatusDescription']          = $params['RateResponse']['Response']['ResponseStatus']['Description'];
		$params['RatedShipment']['TotalCharges']['MonetaryValue'] = $params['RateResponse']['RatedShipment']['TotalCharges']['MonetaryValue'];

		echo $params['RateResponse']['Response']['ResponseStatus']['Description'] . '<br>';
		echo $params['RateResponse']['RatedShipment']['TotalCharges']['MonetaryValue'] . '<br>';
	}

	echo '<pre>'; print_r($params); echo '</pre>';
}
else
{
	$params = json_decode($oauth_error->getMessage(), true);

	$params['Response']['Error']['ErrorDescription'] = $params['response']['errors'][0]['code'] . ': ' . $params['response']['errors'][0]['message'];

	foreach ($params['response']['errors'] as $rate_error)
	{
		echo $rate_error['code'] . ': ' . $rate_error['message'] . '<br>';
	}

	echo '<pre>'; print_r($params); echo '</pre>';
}
