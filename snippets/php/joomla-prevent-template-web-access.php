<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

Factory::getApplication()->redirect(Route::_('index.php?option=com_templates&view=styles', false));

/**
 * Save to administrator template's HTML overrides directory
 * /administrator/templates/TEMPLATE/html/com_templates/template/default.php
 */
