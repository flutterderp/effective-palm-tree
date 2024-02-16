<?php
// Basic app setup using Joomla 3.x CMS libraries
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

define('_JEXEC', 1);
define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT'] . '');

require_once(JPATH_BASE . '/includes/defines.php');
require_once(JPATH_BASE . '/includes/framework.php');

$jfours = array(4,5);

if(in_array(Version::MAJOR_VERSION, $jfours))
{
	// swap session.web.site for session.web.administrator for admin apps
	$container = Factory::getContainer();
	$container->alias('session.web', 'session.web.site')
		->alias('session', 'session.web.site')
		->alias('JSession', 'session.web.site')
		->alias(\Joomla\CMS\Session\Session::class, 'session.web.site')
		->alias(\Joomla\Session\Session::class, 'session.web.site')
		->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

	$app = $container->get(\Joomla\CMS\Application\SiteApplication::class);
	// $app = $container->get(\Joomla\CMS\Application\AdministratorApplication::class);
	$app->createExtensionNamespaceMap(); // https://joomla.stackexchange.com/a/32146/41
	$app->loadLanguage(); /* allows modules to render */

	// Set the application as global app
	Factory::$application = $app;
}
else
{
	$app = Factory::getApplication('site');
	$app->initialise();
}

/* Joomla\CMS\Plugin\PluginHelper::importPlugin('authentication');
Joomla\CMS\Plugin\PluginHelper::importPlugin('user');
Joomla\CMS\Plugin\PluginHelper::importPlugin('system', 'remember'); */

/* example of loading a plugin in J4 */
/* Joomla\CMS\Plugin\PluginHelper::importPlugin('system', 'seoconfig');
$app->triggerEvent('onAfterRoute', array()); */

$db       = Factory::getDbo();
$session  = Factory::getSession();
$user     = Factory::getUser();
$utc_tz   = new DateTimeZone('UTC');
$today    = new DateTime('', $utc_tz);
$sitename = $app->get('sitename');
$website  = Uri::base();
$website  = str_ireplace('/path/to/file/', '/', $website); // Get rid of unwanted path information

/* if($app->isClient('site'))
{
	// Check for a cookie if user is not logged in
	if ($user->get('guest'))
	{
		$cookieName = 'joomla_remember_me_' . JUserHelper::getShortHashedUserAgent();

		// Try with old cookieName (pre 3.6.0) if not found
		if (!$app->input->cookie->get($cookieName))
		{
			$cookieName = JUserHelper::getShortHashedUserAgent();
		}

		// Check for the cookie
		if ($app->input->cookie->get($cookieName))
		{
			$app->login(array('username' => ''), array('return' => Uri::current(), 'silent' => true));
			$app->triggerEvent('onUserAfterLogin', array('responseType' => 'Cookie'));
		}
	}
} */

/*$options = array();
$options['driver'] = 'mysqli';
$options['host'] = '';
$options['user'] = '';
$options['password'] = '';
$options['database'] = '';
$options['prefix'] = '';
JDatabaseDriver::getInstance($options);*/
/**
 * Classes unavailable without mainframe:
 * JDocument
 */
