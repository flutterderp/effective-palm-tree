<?php
defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;

$instance = Categories::getInstance('Content');
$root     = $instance->get('root');
$categories = $root->getChildren(false);
