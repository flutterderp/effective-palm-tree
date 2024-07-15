<?php
/**
 * Webhook testing stuff…
 */
define('LOG_FILE', __DIR__ . '/test.log');

// $log           = fopen(LOG_FILE, 'w+');
$headers       = getallheaders();
$incoming      = file_get_contents('php://input');
$incoming_array = json_decode($incoming, true);
// $today         = new \DateTime(null, new \DateTimeZone('UTC'));

/**
 * Change header to 202 Accepted, in case we have to queue processing rather than
 * handling it now. (idea from comments on https://lornajane.net/posts/2017/handling-incoming-webhooks-in-php)
 * Header changes would need to occur prior to ANY output
 */
header('Accepted', true, 202);
echo 'We have received your data and will process it shortly…';

/* error_log($today->format('Y-m-d H:i:s') . PHP_EOL, 0, LOG_FILE);
error_log(json_encode($headers) . PHP_EOL, 0, LOG_FILE);
error_log($incoming . PHP_EOL, 0, LOG_FILE);
error_log('=====' . PHP_EOL, 0, LOG_FILE);
fclose($log); */
