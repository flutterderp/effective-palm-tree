<?php
/**
 * @link https://paypal.github.io/PayPal-PHP-SDK/sample/doc/invoice/CreateInvoice.html
 * @link https://github.com/paypal/PayPal-PHP-SDK/tree/master/sample
 */

use PayPal\Api\Address;
use PayPal\Api\BillingInfo;
use PayPal\Api\Cost;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\Phone;
use PayPal\Api\ShippingInfo;

require_once(__DIR__ . '/bootstrap.php');

$items         = array();
$invoice_items = array();
$items[]       = array('name' => 'Item 1', 'price' => 5.20, 'qty' => 50);
$items[]       = array('name' => 'Item 2', 'price' => 5, 'qty' => 75);
$invoice       = new Invoice();

$invoice
	->setMerchantInfo(new MerchantInfo())
	->setBillingInfo(array(new BillingInfo()))
	->setNote('test invoice')
	->setPaymentTerm(new PaymentTerm())
	->setShippingInfo(new ShippingInfo());

// set merchant info
$invoice->getMerchantInfo()
	->setEmail('MERCHANT_EMAIL')
	->setFirstName('Test')
	->setLastName('Business')
	->setbusinessName('Test Company, LLC')
	->setPhone(new Phone())
	->setAddress(new Address());

// set merchant's phone number
$invoice->getMerchantInfo()->getPhone()
	->setCountryCode('001')
	->setNationalNumber('1234567890');

// set merchant's address
$invoice->getMerchantInfo()->getAddress()
	->setLine1('123 Main St')
	->setCity('Sometown')
	->setState('CA')
	->setPostalCode('12345')
	->setCountryCode('US');

// set billing info
$billing = $invoice->getBillingInfo();
$billing[0]->setEmail('test@example.com');

$billing[0]->setBusinessName('Company Name')
	->setAdditionalInfo('This is the billing info')
	->setAddress(new InvoiceAddress());

$billing[0]->getAddress()
	->setLine1('123 Main St')
	->setCity('Sometown')
	->setState('CA')
	->setPostalCode('12345')
	->setCountryCode('US');

foreach($items as $k => $item)
{
	$invoice_items[$k] = new InvoiceItem();
	$invoice_items[$k]
		->setName($item['name'])
		->setQuantity($item['qty'])
		->setUnitPrice(new Currency());

	$invoice_items[$k]->getUnitPrice()
		->setCurrency('USD')
		->setValue($item['price']);
}

// add items to invoice
$invoice->setItems($invoice_items);

// set payment terms
$invoice->getPaymentTerm()
	->setTermType('NET_30');

// set shipping info
$invoice->getShippingInfo()
	->setFirstName('Test')
	->setLastName('Guy')
	->setBusinessName('Not applicable')
	->setPhone(new Phone())
	->setAddress(new InvoiceAddress());

$invoice->getShippingInfo()->getPhone()
	->setCountryCode('001')
	->setNationalNumber('1234567890');

$invoice->getShippingInfo()->getAddress()
	->setLine1('123 Main St')
	->setCity('Sometown')
	->setState('CA')
	->setPostalCode('12345')
	->setCountryCode('US');

$invoice->setLogoUrl('https://www.paypalobjects.com/webstatic/i/logo/rebrand/ppcom.svg');

$request = clone $invoice;

try
{
	$invoice->create($apiContext);

	?>
	<p>
		<b>Invoice ID:</b> <?php echo $invoice->id; ?><br>
		<b>Payment terms:</b> <?php echo $invoice->payment_term->getTermType(); ?><br>
		<b>Payment due:</b> <?php echo $invoice->payment_term->getDueDate(); ?><br>
	</p>
	<?php

	ResultPrinter::printResult('Create Invoice', 'Invoice', $invoice->getId(), $request, $invoice);
}
catch(Exception $e)
{
	ResultPrinter::printError('Create Invoice', 'Invoice', null, $request, $e);
}

try
{
	$sendStatus = $invoice->send($apiContext);

	ResultPrinter::printResult('Send Invoice', 'Invoice', $invoice->getId(), null, null);
}
catch(Exception $e)
{
	ResultPrinter::printError('Send Invoice', 'Invoice', null, null, $e);
}

// return $invoice;
?>

<?php /* <pre><?php print_r($invoice); ?></pre> */ ?>
