<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$user = Factory::getApplication()->getIdentity();

if ($user->guest) {
	return;
}

// Check/define JPATH_COMPONENT if doing this outside of a component environment
defined('JPATH_COMPONENT') or define('JPATH_COMPONENT', JPATH_ROOT . '/components/com_content');
defined('JPATH_COMPONENT_ADMINISTRATOR') or define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_ROOT . '/administrator/components/com_content');

// Trigger a simple save via model so items can be assigned asset IDs
$articleFactory       = Factory::getApplication()->bootComponent('com_content')->getMVCFactory();
$articleModel         = $articleFactory->createModel('Article', 'Administrator', ['ignore_request' => true]);
$data                 = [];
$data['catid']        = 42;

// Get the item, if updating
// $item = $articleModel->getItem((int) $item_id);

// Use ReflectionClass to access AdminModel's generateNewTitle
$reflection      = new \ReflectionClass($articleModel);
$reflect_args    = [$data['catid'], $item->alias, $item->title];
$genTitle        = $reflection->getMethod('generateNewTitle');
$genTitle->setAccessible(true);
[$title, $alias] = $genTitle->invokeArgs($articleModel, $reflect_args);

$today                = new \DateTime('', new \DateTimeZone('UTC'));
$data['id']           = null;
// [$title, $alias]      = $articleModel->generateNewTitle($data['catid'], $item->alias, $item->title);
$data['title']        = $title;
$data['alias']        = $alias;
$data['introtext']    = $item->introtext;
$data['fulltext']     = $item->fulltext;
$data['images']       = $item->images;
$data['urls']         = '';
$data['attribs']      = '';
$data['metakey']      = '';
$data['metadesc']     = '';
$data['metadata']     = '';
$data['state']        = 0;
$data['created']      = $today->format('Y-m-d H:i:s');
$data['created_by']   = (int) $user->id;
$data['access']       = 1;
$data['language']     = '*';
// Include tags to maintain current tag map, if updating an item
// $data['typeAlias']    = $item->typeAlias;
// $data['tagsHelper']   = $item->tagsHelper;
// $data['tags']         = $item->tags;

// Save the item
$articleModel->save($data);
