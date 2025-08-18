<?php
use Omnipay\Omnipay;
use \Stripe\Exception\SignatureVerificationException;
use \Stripe\Stripe;
use \Stripe\StripeClient;
use \Stripe\Util\RequestOptions;
use \Stripe\Webhook;

require_once(__DIR__ . '/omnipay/vendor/autoload.php');

$utc_tz   = new DateTimeZone('UTC');
$today    = new DateTime(null, $utc_tz);

try
{
	$gateway = Omnipay::create('Stripe');
	$gateway->setApiKey('');

	$card_data  = [];
	$order_data = [];

	$card_data['firstName']   = 'Test';
	$card_data['lastName']    = 'Guy';
	$card_data['address1']    = '123 Main St';
	$card_data['address2']    = '';
	$card_data['city']        = 'Sometown';
	$card_data['state']       = 'CA';
	$card_data['country']     = 'US';
	$card_data['phone']       = '(123) 456-7890';
	$card_data['email']       = 'support+test@hannush.com';
	$card_data['number']      = '4242424242424242';
	$card_data['expiryMonth'] = '10';
	$card_data['expiryYear']  = '2024';
	$card_data['cvv']         = '287';

	$order_data['amount']   = 13.37;
	$order_data['currency'] = 'USD';
	$order_data['card']     = $card_data;

	$omniresponse = $gateway->purchase($order_data)->send();

	// var_dump($omniresponse->isRedirect()); echo '<br>';
	// var_dump($omniresponse->isRedirect()); echo '<br>';

	if ($omniresponse->isSuccessful())
	{
		$response = $omniresponse->getData();
		echo '<p>Transaction ID: ' . $response['balance_transaction'] . '</p>';
		echo '<p>Calculated statement descriptor: ' . $response['calculated_statement_descriptor'] . '</p>';
		echo '<p>CVV Check: ' . $response['card']['cvc_check'] . '</p>';
		echo '<p>Card type: ' . $response['card']['type'] . '</p>';
		echo '<p>Failure code: ' . $response['failure_code'] . '</p>';
		echo '<p>Failure message: ' . $response['failure_message'] . '</p>';
		echo '<p>Paid: '; var_export($response['paid']); echo '</p>';
		echo '<p>Paid: ' . (int) $response['paid'] . '</p>';
		echo '<p>Live mode: '; var_export($response['livemode']); echo '</p>';
		echo '<p>Outcome – Network status: ' . $response['outcome']['network_status'] . '</p>';
		echo '<p>Outcome – Reason: ' . $response['outcome']['reason'] . '</p>';
		echo '<p>Outcome – Risk level: ' . $response['outcome']['risk_level'] . '</p>';
		echo '<p>Outcome – Risk score: ' . $response['outcome']['risk_score'] . '</p>';
		echo '<p>Outcome – Seller message: ' . $response['outcome']['seller_message'] . '</p>';
		echo '<p>Outcome – Type: ' . $response['outcome']['type'] . '</p>';
		echo '<p>Receipt URL: ' . $response['receipt_url'] . '</p>';
		echo '<p>Status: ' . $response['status'] . '</p>';

		// var_dump($response->isSuccessful()); echo '<br>';
		// echo '<pre>'; print_r($omniresponse); echo '</pre>';
	}
	else
	{
		echo $omniresponse->getCode() . ': ' . $omniresponse->getMessage();
	}
}
catch(Exception $e)
{
	// http_response_code(400);
	// echo 'Unknown error' . PHP_EOL;
	echo $e->getCode() . ': ' . $e->getMessage();
	exit;
}
