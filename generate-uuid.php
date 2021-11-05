<?php
/**
 * Function to generate a UUID for this application
 *
 * Use bin2hex() if the UUID needs to be displayed to the user
 *
 * @param int $length
 */
function generateUUID(int $length = 24)
{
  if(function_exists('random_bytes'))
  {
    return random_bytes(24);
  }

  if(function_exists('openssl_random_pseudo_bytes'))
  {
    return openssl_random_pseudo_bytes(24);
  }

  throw new Exception('Cannot generate a unique ID', 500);
}
