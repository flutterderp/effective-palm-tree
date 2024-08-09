<?php
final class Keygen
{
	public function __construct() {}

	/**
	 * Function to generate random bytes, optionally from a source string
	 *
	 * @param string $string
	 *
	 * @return string $result
	 */
	public function generate(int $length = 24, string $string = ''): string
	{
		$r = new Random\Randomizer();

		if (!empty($string))
		{
			$result = $r->getBytesFromString($string, $length);
		}
		else
		{
			$result = $r->getBytes($length);
		}

		return bin2hex($result);
	}

	/**
	 * Function to generate a version 4 UUID
	 *
	 * @link https://stackoverflow.com/a/72947320/1896325
	 * @link https://stackoverflow.com/a/60653281/1896325
	 */
	public function generateUUID4()
	{
		$uuid = $this->generate(18);

		$uuid[8]  = '-';
		$uuid[13] = '-';
		$uuid[18] = '-';
		$uuid[23] = '-';

		// UUID v4
		$uuid[14] = '4';

		// variant 1- 10xx
		$uuid[19] = ['8', '9', 'a', 'b'][random_int(0, 3)];

		return $uuid;
	}

	/**
	 * Function to generate a UUID for this application
	 *
	 * Use bin2hex() if the UUID needs to be displayed to the user
	 *
	 * @param int $length
	 */
	public function generateUUID(int $length = 24): string
	{
		$uuid = false;

		if (function_exists('random_bytes'))
		{
			$uuid = random_bytes($length);
		}
		elseif (function_exists('openssl_random_pseudo_bytes'))
		{
			$uuid = openssl_random_pseudo_bytes($length);
		}

		if ($uuid !== false)
		{
			$uuid = bin2hex($uuid);

			return $uuid;
		}
		else
		{
			throw new Exception('Cannot generate a unique ID', 500);
		}
	}
}
