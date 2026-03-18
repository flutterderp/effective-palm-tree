<?php
defined('_JEXEC') or die;

/**
 * At some point, Joomla's Web Links extension lost the ability to set the order that web links were displayed in,
 * so this script was thrown together to display a paginated list of web links in a more sensible order.
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Pagination\Pagination;

$app        = Factory::getApplication();
$db         = Factory::getContainer()->get('DatabaseDriver');
$prefix     = 'prefix_';
$limit      = $app->getUserStateFromRequest('limit', 'limit', $app->get('list_limit'));
$limitstart = (int) $app->getInput()->get($prefix . 'limitstart', 0, 'int');

$weblinks = getLinks($limitstart, $limit);
?>

<?php if ($weblinks['links']) : ?>
    <div class="com-weblinks-category__items category list-striped list-condensed">
        <?php foreach ($weblinks['links'] as $i => $item) : ?>
            <div class="leading-<?php echo $i; ?> cat-list-row<?php echo $i; ?>">
                    <dl class="article-info muted">
                        <dd class="published">
                            <span class="fa fa-calendar"></span> <?php echo HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC3')); ?>
                        </dd>
                    </dl>
                    <div>&nbsp;</div>
                    <h2 class="list-title">
                        <a href="<?php echo $item->url; ?>" target="_blank" class="category" rel="nofollow"><?php echo $item->title; ?></a>
                    </h2>

                <?php echo $item->description; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    $page = new Pagination($weblinks['total_rows'], $limitstart, $limit, $prefix);

    // echo $page->getResultsCounter();
    echo $page->getPagesCounter();
    echo $page->getPagesLinks('joomla.pagination.links', ['showLimitBox' => false]);
    ?>
<?php endif; ?>

<?php
function getLinks(int $offset = 0, int $limit = 50)
{
    $db     = Factory::getContainer()->get('DatabaseDriver');
    $query  = $db->getQuery(true);
    $result = [];

    $query
        ->select('a.id, a.title, a.url, a.description, a.created, a.publish_up')
        ->from($db->quoteName('#__weblinks', 'a'))
        ->where('a.state = 1')
        ->order('created DESC')
        ->setLimit($limit, $offset);

    try {
        $db->setQuery($query);

        $weblinks = $db->loadObjectList();

        $query->clear();
        $query->select('COUNT(*)')->from( $db->quoteName('#__weblinks'))->where('state = 1');

        $db->setQuery($query);

        $total_rows = $db->loadResult();

        $result['links']      = $weblinks;
        $result['total_rows'] = $total_rows;
    } catch(\Exception $e) {
        $result = false;
    }

    return $result;
}
