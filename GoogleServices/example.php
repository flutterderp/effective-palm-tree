<?php
/**
 * Example uses of the Google API PHP client
 *
 * @link https://stackoverflow.com/a/50662714/1896325 example of pushing events to Calendar
 * @link https://github.com/googleapis/google-api-php-client-services/tree/master/src list of service names if adding to composer.json
 * @link https://developers.google.com/calendar/api/guides/push webhook setup?
 * @link https://stackoverflow.com/questions/59552209/google-calendar-webhook-test
 */

use Google\Client;
use Google\Service\Books;
use Google\Service\Calendar;

require_once(__DIR__ . '/vendor/autoload.php');

$client = new Client();
$client->setApplicationName('Client_Library_Examplees');
// $client->setAuthConfig();
$client->setDeveloperKey('APPLICATION_KEY');

// $service   = new Calendar($client);
$service   = new Books($client);
$query     = 'Henry David Thoreau';
$optParams = ['filter' => 'free-ebooks'];

try
{
	$results   = $service->volumes->listVolumes($query, $optParams);

	foreach($results->getItems() as $item)
	{
		echo $item['volumeInfo']['title'], "<br>\n";
	}
}
catch(Google\Service\Exception $e)
{
	echo '<p>' . $e->getCode() . ': ' . $e->getMessage() . '</p>';
}
catch(Exception $e)
{
	echo '<p>' . $e->getCode() . ': ' . $e->getMessage() . '</p>';
}
