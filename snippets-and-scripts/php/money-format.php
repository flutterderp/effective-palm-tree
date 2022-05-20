<?php
// Place near top of script
setlocale(LC_MONETARY, 'en_US');

$canFormat = class_exists('NumberFormatter');

if($canFormat === true)
{
  $money_format = new \NumberFormatter('en_US', NumberFormatter::CURRENCY);
  $money_format->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 0);
  $money_format->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 2);
}

echo $canFormat === true ? $money_format->formatCurrency($your_price, 'USD') : money_format('%.0n', $your_price);
