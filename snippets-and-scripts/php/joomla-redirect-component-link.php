<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$menu        = Factory::getApplication()->getMenu();
$active      = $menu->getActive();
$current_uri = Uri::current();

if((int) $active->id === 101 && preg_match('/^https:\/\/www.example.com\/\/component\/(.*)/', $current_uri) !== false)
{
	throw new Exception('Page not found', 404);
	// Factory::getApplication()->redirect('/404-page-not-found');
	// Factory::getApplication()->redirect(Route::_($active->link));
}