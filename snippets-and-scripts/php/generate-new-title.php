<?php
defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\String\StringHelper;

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

		while ($table->load(array($aliasField => $alias, $catidField => $categoryId))) {
			if ($title === $table->$titleField) {
				$title = StringHelper::increment($title);
			}

			$alias = StringHelper::increment($alias, 'dash');
		}

		return array($title, $alias);
}
