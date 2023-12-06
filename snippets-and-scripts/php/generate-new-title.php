<?php
defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\String\StringHelper;

// You may need to register the class in order to use it
JLoader::register('TagsTableTag', JPATH_BASE . '/administrator/components/com_tags/tables/tag.php');
// Table::addIncludePath(JPATH_BASE . '/administrator/components/com_tags/tables/tag.php');

// Alter the title & alias
$data = $generateNewTitle($your_catid, $your_alias, $your_title);
$your_title = $data['0'];
$your_alias = $data['1'];

/**
 * Method to change the title & alias.
 *
 * @param   integer  $categoryId  The id of the category.
 * @param   string   $alias       The alias.
 * @param   string   $title       The title.
 *
 * @return  array  Contains the modified title and alias.
 *
 * @since   1.7
 */
function generateNewTitle($categoryId, $alias, $title)
{
	// Alter the title & alias
	$table      = Table::getInstance('Extension', 'ExtensionsTable');
	$aliasField = $table->getColumnAlias('alias');
	$catidField = $table->getColumnAlias('catid');
	$titleField = $table->getColumnAlias('title');

	/* if ($table->load(array($aliasField => $alias)) && ($table->id != $itemId || $itemId == 0))
	{
		$title = StringHelper::increment($title);
		$alias = StringHelper::increment($alias, 'dash');
	} */

	while ($table->load(array($aliasField => $alias, $catidField => $categoryId))) {
		if ($title === $table->$titleField) {
			$title = StringHelper::increment($title);
		}

		$alias = StringHelper::increment($alias, 'dash');
	}

	return array($title, $alias);
}
