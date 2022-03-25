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

if(Version::MAJOR_VERSION === 4)
{
	$container = Factory::getContainer();
	$container->alias('session', 'session.cli')
		->alias('JSession', 'session.cli')
		->alias(\Joomla\CMS\Session\Session::class, 'session.cli')
		->alias(\Joomla\Session\Session::class, 'session.cli')
		->alias(\Joomla\Session\SessionInterface::class, 'session.cli');

	$app = $container->get(\Joomla\Console\Application::class);
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
$db       = Factory::getDbo();
$session  = Factory::getSession();
$user     = Factory::getUser();
$utc_tz   = new DateTimeZone('UTC');
$today    = new DateTime(null, $utc_tz);
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
