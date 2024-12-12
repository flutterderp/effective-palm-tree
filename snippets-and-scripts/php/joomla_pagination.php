<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Pagination\Pagination;

//Get the limit and limitstart values
$app        = Factory::getApplication();
$db         = Factory::getContainer()->get('DatabaseDriver');
$query      = $db->getQuery(true);
$limit      = $app->getUserStateFromRequest('limit', 'limit', $app->get('list_limit'));
$limitstart = $app->getUserStateFromRequest('$option.limitstart', 'limitstart', 0);

try
{
	//Get a total count and instantiate Pagination
	$query->select('COUNT(*)')->from( $db->qn('#__table_name'))->where('something = 1');

	$db->setQuery($query);
	$total_rows = (int) $db->loadResult();

	// Use $limitstart and $limit in the query that actually fetches your items
	$query->clear();
	$query->select('*')->from($db->qn('#__table_name'))->where('something = 1');
	// $query->setLimit($limit, $limitstart);

	$db->setQuery($query, $limitstart, $limit);
	// $db->execute();
	// $found = $db->getNumRows();
	$rows  = $db->loadObjectList();
}
catch(Exception $e)
{
	$total_rows = 0;
	// $found      = 0;
	$rows       = false;
}

$page = new Pagination($total_rows, $limitstart, $limit);
//$page->setAdditionalUrlParam('searchword', $search);

//Display pagination where desired
/* <p>Page: <?php echo '' . $page->pagesCurrent . ' / ' . $page->pagesTotal; ?><br><?php echo $page->getLimitBox(); ?></p> */
echo $page->getResultsCounter();
echo $page->getPaginationLinks('joomla.pagination.links', array('showLimitBox' => false));
// echo $page->getPaginationLinks('joomla.pagination.list');
