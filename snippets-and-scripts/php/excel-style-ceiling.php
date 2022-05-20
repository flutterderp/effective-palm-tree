<?php
/**
 * Returns $value, rounded to the nearest multiple of $precision
 *
 * @param float $value
 * @param int $precision
 * @return float $rounded
 */
function ceiling(float $value = 0.00, int $precision = 1)
{
	$rounded = ceil($value/$precision) * $precision;

	return (float) $rounded;
}
