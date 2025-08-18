<?php

use MailchimpMarketing\ApiClient;

// MailchimpMarketing
// https://mailchimp.com/developer/marketing/api/
require_once(__DIR__ . '/vendor/autoload.php');

$utc_tz    = new DateTimeZone('UTC');
$today     = new DateTime('', $utc_tz);
$mailchimp = new ApiClient();
$mc_config = [];

$mc_config['apiKey']      = null;
$mc_config['accessToken'] = '';
$mc_config['server']      = '';
$list_id                  = '';

$tags   = [];
$tags[] = ['', 'active'];

$mailchimp->setConfig($mc_config);

$mperms                          = new stdClass();
$mperms->marketing_permission_id = '';
$mperms->text                    = 'Email';
$mperms->enabled                 = true;

try
{
	$response = $mailchimp->ping->get();

	$email_address   = strtolower('address@example.com');
	$subscriber_hash = md5($email_address);
	$subscriber_body = [];

	$subscriber_body['email_address']    = $email_address;
	$subscriber_body['status_if_new']    = 'transactional';
	$subscriber_body['ip_signup']        = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
	$subscriber_body['timestamp_signup'] = $today->format('c');
	$subscriber_body['ip_opt']           = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
	$subscriber_body['timestamp_opt']    = $today->format('c');
	// $subscriber_body['marketing_permissions'] = $mperms;
	$subscriber_body['tags']             = ['Tag Name'];
	// $subscriber_body[] = '';

	$add_member = $mailchimp->lists->setListMember($list_id, $subscriber_hash, $subscriber_body);

	echo '<pre>'; print_r($add_member); echo '</pre>';
}
catch(Exception $e)
{
	$response               = [];
	$response['error_code'] = $e->getCode();
	$response['message']    = $e->getMessage();
}
?>
<pre><?php print_r($response); ?></pre>
