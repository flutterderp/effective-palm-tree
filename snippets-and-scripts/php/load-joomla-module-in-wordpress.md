# Load Joomla module(s) in Wordpress

## Create the module loader class

Create a PHP file in your template's subdirectory with the following code (we're assuming the J! install is the main site and Wordpress is in a subdirectory). For `$root_url`, change “blog” to match your Wordpress install's subdirectory as needed.

```php
<?php
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

define('_JEXEC', 1);
define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT'] . '');

require_once(JPATH_BASE . '/includes/defines.php');
require_once(JPATH_BASE . '/includes/framework.php');

class JoomlaFunctions
{
	protected $app;
	protected $user;

	function __construct()
	{
		if(Version::MAJOR_VERSION === 4)
		{
			// swap session.web.site for session.web.administrator for admin apps
			$container = Factory::getContainer();
			$container->alias('session.web', 'session.web.site')
				->alias('session', 'session.web.site')
				->alias('JSession', 'session.web.site')
				->alias(\Joomla\CMS\Session\Session::class, 'session.web.site')
				->alias(\Joomla\Session\Session::class, 'session.web.site')
				->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

			$this->app = $container->get(\Joomla\CMS\Application\SiteApplication::class);
			// $this->app = $container->get(\Joomla\CMS\Application\AdministratorApplication::class);
			$this->app->createExtensionNamespaceMap(); // https://joomla.stackexchange.com/a/32146/41
			$this->app->loadLanguage(); /* allows modules to render */

			// Set the application as global app
			Factory::$application = $this->app;
		}
		else
		{
			$this->app = Factory::getApplication('site');
			$this->app->initialise();
		}

		$this->user = Factory::getUser();

		$root_url = Uri::root(true, '/');
		$root_url = preg_replace('/(\/blog\/)/', '/', $root_url);

		Factory::getDocument()->setBase($root_url);
	}

	function __destruct() { }

	function getSitename()
	{
		return $this->app->get('sitename');
	}

	/**
	 * Count number of modules whose content is not empty.
	 * Some modules (e.g. mod_tags_similar) don't have any content until they are actually rendered,
	 * so we render the whole set and store it in a string for later.
	 *
	 * @param string $pos
	 * @param string $style
	 * @return string $result
	 */
	function getModContent(string $pos, string $style = 'xhtml5')
	{
		$result  = '';
		$modules = ModuleHelper::getModules($pos);

		// ob_start();

		foreach($modules as $module)
		{
			// clone $module and null it to prevent duplication if the module uses loadmodule or loadposition
			$modcontent = clone $module;
			$module     = null;
			$registry   = new Registry($modcontent->params);
			$params     = $registry->toObject();
			$mod_style  = (isset($params->style) && $params->style != '0') ? $params->style : $style;

			// Some modules (e.g. mod_tags_similar) don't have any content until they are actually rendered
			// echo ModuleHelper::renderModule($modcontent, array('style' => $mod_style));
			$result .= ModuleHelper::renderModule($modcontent, array('style' => $mod_style));
		}

		// $result = ob_get_clean();

		return trim($result);
	}
}
```

## Using the module loader class

Place this code near the top of `header.php` (or whichever template file you're placing the module):

```php
include_once(__DIR__ . '/inc/joomla-functions.php');

$j          = new JoomlaFunctions();
$yourmodule = $j->getModContent('moduleName', 'optionalModuleStyle');
```

Place the module where you want it to display:

```php
<?php if($yourmodule) : ?>
	<?php echo $yourmodule; ?>
<?php endif; ?>
```
